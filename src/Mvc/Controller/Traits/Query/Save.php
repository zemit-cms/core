<?php

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

trait Save
{
    /**
     * Saves the entity and returns the result as an array.
     *
     * @return array The result of the save operation, including the saved status, messages,
     *               and optionally the saved entity data if the save was successful.
     */
    public function save(): array
    {
        $post = $this->getParams();
        $model = $this->findFirst();
        $saveFields = $this->getSaveFields()?->toArray();
        $mapFields = $this->getMapFields()?->toArray();
        
        if (isset($post['id']) && !isset($model)) {
            return [
                'saved' => false,
                'messages' => [new Message('Entity id `' . $post['id'] . '` not found.', 'id', 'NotFound', 404)],
            ];
        }
        unset($post['id']);
        
        $model ??= $this->loadModel();
        assert($model instanceof ModelInterface);
        
        // before assign event
        $this->beforeAssign($model, $post, $saveFields, $mapFields);
        $model->assign($post, $saveFields, $mapFields);
        $saved = $model->save();
        
        $ret = [
            'saved' => $saved,
            'messages' => $model->getMessages()
        ];
        
        if ($saved) {
            // load relationship
            $with = $this->getWith()?->toArray();
            if (isset($with)) {
                $model = $model->load($with);
            }
            
            // expose the model data
            $ret['data'] = $this->expose($model);
        }
        
        return $ret;
    }
    
    /**
     * Performs pre-assignment operations before assigning values to the entity properties.
     *
     * @param ModelInterface $entity The entity object to assign values to. Passed by reference.
     * @param array $assign The array of values to assign to the entity properties. Passed by reference.
     * @param array|null $whiteList An optional array of property names that are allowed to be assigned. Passed by reference.
     * @param array|null $columnMap An optional array mapping the POST array keys to entity property names. Passed by reference.
     *
     * @return void
     */
    public function beforeAssign(ModelInterface &$entity, array &$assign, ?array &$whiteList, ?array &$columnMap): void
    {
    }
}
