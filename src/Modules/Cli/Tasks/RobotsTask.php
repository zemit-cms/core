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

use Phalcon\Cli\Console\Exception;
use Zemit\Console\AbstractTask;

/**
 * Zemit\Modules\Cli\Tasks\Robots
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class RobotsTask extends AbstractTask
{
    /**
     * @Doc("Generate the robots.txt")
     */
    public function generate()
    {
        /** @var \League\Flysystem\Filesystem $filesystem */
        $filesystem = container('filesystem', [$this->basePath . DIRECTORY_SEPARATOR . 'public']);

        /** @var \Phalcon\Config $config */
        $config  = container('config');
        $baseUrl = rtrim($config->get('site')->url, '/');
        $robots  = $this->getRobotsTemplate($baseUrl);

        if ($filesystem->has('robots.txt')) {
            $result = $filesystem->update('robots.txt', $robots);
        } else {
            $result = $filesystem->write('robots.txt', $robots);
        }

        if ($result) {
            $this->output('The robots.txt was successfully updated');
        } else {
            throw new Exception('Failed to update the robots.txt file');
        }
    }

    /**
     * Gets robots.txt template.
     *
     * @param  string $baseUrl
     * @return string
     */
    protected function getRobotsTemplate($baseUrl)
    {
        $content=<<<EOL
User-agent: *
Disallow: /400
Disallow: /401
Disallow: /403
Disallow: /404
Disallow: /500
Disallow: /503
Allow: /
Sitemap: $baseUrl/sitemap.xml
EOL;
        return $content;
    }
}
