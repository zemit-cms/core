<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query;

use Phalcon\Messages\Message;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExpose;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractSave;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractWith;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractMapFields;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractSaveFields;
use Zemit\Mvc\Model\Interfaces\EagerLoadInterface;

trait Save
{
    use AbstractSave;
    
    use AbstractExpose;
    use AbstractInjectable;
    use AbstractModel;
    use AbstractParams;
    use AbstractQuery;
    use AbstractWith;
    use AbstractMapFields;
    use AbstractSaveFields;
    
    /**
     * Saves the entity and returns the result as an array.
     * @todo handle dynamic and/or composed primary keys, handle multiple entities, segregate create vs update vs save
     *
     * @return array The result of the save operation, including the saved status, messages,
     *               and optionally the saved entity data if the save was successful.
     */
    public function save(): array
    {
        $post = $this->getParams();
        $saveFields = $this->getSaveFields()?->toArray();
        $mapFields = $this->getMapFields()?->toArray();
        
        // @todo find what we should do here to handle: 1. dynamic and/or composed primary keys
        if (isset($post['id'])) {
            $model = $this->findFirst();
            if (!isset($model)) {
                return [
                    'saved' => false,
                    'messages' => [new Message('Entity id `' . $post['id'] . '` not found.', 'id', 'NotFound', 404)],
                ];
            }
            unset($post['id']);
        }
        
        $model ??= $this->loadModel();
        assert($model instanceof ModelInterface);
        
        // before assign event
        $this->eventsManager->fire('rest:beforeAssign', $this, [&$model, &$post, &$saveFields, &$mapFields], false);
        $model->assign($post, $saveFields, $mapFields);
        
        if ($this->eventsManager->fire('rest:beforeSave', $this, [&$model]) === false) {
            return [
                'saved' => false,
                'messages' => $model->getMessages(),
            ];
        } 
        $saved = $model->save();
        $this->eventsManager->fire('rest:afterSave', $this, [&$model], false);
        
        $ret = [
            'saved' => $saved,
            'messages' => $model->getMessages()
        ];
        
        if ($saved) {
            // load relationship
            $with = $this->getWith()?->toArray();
            if (isset($with) && $model instanceof EagerLoadInterface) {
                $model = $model->load($with);
            }
            
            // expose the model data
            $ret['data'] = $this->expose($model);
        }
        
        return $ret;
    }
}
