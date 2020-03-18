<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Elasticsearch\Client;
use Zemit\Model\Posts;
use Zemit\Console\AbstractTask;

/**
 * Zemit\Modules\Cli\Tasks\SearchEngine
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class SearchengineTask extends AbstractTask
{
    /**
     * Elasticsearch client
     * @var Client
     */
    protected $client;

    /**
     * @Doc("Index all existing posts in the Forum to elastic search")
     */
    public function index()
    {
        $this->client = container('elastic');

        $this->output('Start');

        $this->output('Clear old indexes...');
        $this->deleteOldIndexes();

        $this->output('Reindex posts...');
        $this->reIndex();

        $this->output('Done');
    }

    protected function deleteOldIndexes()
    {
        $index = container('config')->path('elasticsearch.index', 'Zemit');

        if (!$this->client->indices()->exists(['index' => $index])) {
            // The index does not exist yet or got corrupted
            return;
        }

        $this->client->indices()->delete(['index' => $index]);
    }

    protected function reIndex()
    {
        $posts = Posts::find([
            'conditions' => 'deleted != :deleted:',
            'bind'       => [
                'deleted' => Posts::IS_DELETED
            ],
        ]);

        if (empty($posts)) {
            return;
        }

        $total = 0;
        foreach ($posts as $post) {
            $this->doIndex($post);
            $total++;
        }

        $this->output('Reindexed {total} posts', ['total' => $total]);
    }

    /**
     * Index a single document
     *
     * @param Posts $post
     */
    protected function doIndex(Posts $post)
    {
        $params = [];

        $karma  = $post->number_views + (($post->votes_up - $post->votes_down) * 10) + $post->number_replies;
        $index = container('config')->path('elasticsearch.index', 'Zemit');

        if ($karma > 0) {
            $params['body']  = [
                'id'       => $post->id,
                'title'    => $post->title,
                'category' => $post->categories_id,
                'content'  => $post->content,
                'karma'    => $karma
            ];
            $params['index'] = $index;
            $params['type']  = 'post';
            $params['id']    = 'post-' . $post->id;

            $this->client->index($params);
        }
    }
}
