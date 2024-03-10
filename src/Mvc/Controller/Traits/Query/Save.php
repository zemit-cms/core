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
     * Saving model automagically
     *
     * Note:
     * If a newly created entity can't be retrieved using the ->getSingle
     * method after it's creation, the entity will be returned directly
     *
     * @TODO Support Composite Primary Key*
     */
    protected function save(?int $id = null, ?ModelInterface $entity = null, ?array $post = null, ?string $modelName = null, ?array $whiteList = null, ?array $columnMap = null, ?array $with = null): array
    {
        $single = false;
        $retList = [];
        
        // Get the model name to play with
        $modelName ??= $this->getModelName();
        $post ??= $this->getParams();
        $whiteList ??= $this->getAllowedSaveFields();
        $columnMap ??= $this->getColumnMap();
        $with ??= $this->getWith();
        $id = (int)$id;
        
        // Check if multi-d post
        if (!empty($id) || !isset($post[0]) || !is_array($post[0])) {
            $single = true;
            $post = [$post];
        }
        
        // Save each posts
        foreach ($post as $key => $singlePost) {
            $singlePostId = (!$single || empty($id)) ? $this->getParam('id', 'int', $this->getParam('int', 'int', $singlePost['id'] ?? null)) : $id;
            if (isset($singlePost['id'])) {
                unset($singlePost['id']);
            }
            
            /** @var \Zemit\Mvc\Model $singlePostEntity */
            $singlePostEntity = (!$single || !isset($entity)) ? $this->getSingle($singlePostId, $modelName, []) : $entity;
            
            // Create entity if not exists
            if (!$singlePostEntity && empty($singlePostId)) {
                $singlePostEntity = new $modelName();
            }
            
            if (!$singlePostEntity) {
                $ret = [
                    'saved' => false,
                    'messages' => [new Message('Entity id `' . $singlePostId . '` not found.', $modelName, 'NotFound', 404)],
                    'model' => $modelName,
                    'source' => (new $modelName())->getSource(),
                ];
            }
            else {
                // allow custom manipulations
                // @todo move this using events
                $this->beforeAssign($singlePostEntity, $singlePost, $whiteList, $columnMap);
                
                // assign & save
                $singlePostEntity->assign($singlePost, $whiteList, $columnMap);
                $ret = $this->saveEntity($singlePostEntity);
                
                // refetch & expose
//                $fetchWith = $this->getSingle($singlePostEntity->getId(), $modelName, $with);
//                $ret['single'] = $this->expose($fetchWith);
                $fetchWith = $singlePostEntity->load($with ?? []);
                $ret['single'] = $this->expose($fetchWith);
            }
            
            if ($single) {
                return $ret;
            }
            else {
                $retList [] = $ret;
            }
        }
        
        return $retList;
    }
    
    /**
     * Performs pre-assignment operations before assigning values to the entity properties.
     *
     * @param ModelInterface $entity The entity object to assign values to. Passed by reference.
     * @param array $post The array of values to assign to the entity properties. Passed by reference.
     * @param array|null $whiteList An optional array of property names that are allowed to be assigned. Passed by reference.
     * @param array|null $columnMap An optional array mapping the POST array keys to entity property names. Passed by reference.
     *
     * @return void
     */
    public function beforeAssign(ModelInterface &$entity, array &$post, ?array &$whiteList, ?array &$columnMap): void
    {
    }
    
    /**
     * Saves an entity and returns an array of information about the saved entity.
     *
     * @param ModelInterface $entity The entity to save.
     *
     * @return array An array containing information about the saved entity. The array includes the following keys:
     *               - 'saved': A boolean indicating whether the entity was successfully saved.
     *               - 'messages': An array of messages generated during the save process.
     *               - 'model': The class name of the entity.
     *               - 'source': The database table associated with the entity.
     *               - 'entity': The saved entity. (Note: This field is meant to fix a Phalcon internal bug and may be removed in the future.)
     *               - 'single': The exposed data of the saved entity.
     *
     * @throws \Exception if an error occurs during the save process.
     */
    public function saveEntity(ModelInterface $entity): array
    {
        $ret = [];
        
        $ret['saved'] = $entity->save();
        $ret['messages'] = $entity->getMessages();
        $ret['model'] = get_class($entity);
        $ret['source'] = $entity->getSource();
        $ret['entity'] = $entity; // @todo this is to fix a phalcon internal bug (503 segfault during eagerload)
        $ret['single'] = $this->expose($entity, $this->getExpose());
        
        return $ret;
    }
}
