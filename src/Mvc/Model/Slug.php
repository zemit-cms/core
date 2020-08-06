<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Zemit\Utils\Slug as PhalconSlug;

/**
 * Trait Slug
 * @deprecated @todo to be removed
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait Slug
{
    protected function _setSlug($slugField = 'slug', $fromField = 'name')
    {
        if (property_exists($this, $slugField) && property_exists($this, $fromField)) {
            $this->getEventsManager()->attach('model', function ($event, $entity) use ($slugField, $fromField) {
                switch ($event->getType()) {
                    case 'beforeValidation':
                        if (property_exists($entity, $slugField) && property_exists($entity, $fromField) && !empty($entity->$fromField) && is_null($entity->$slugField)) {
                            $entity->$slugField = PhalconSlug::generate($entity->$fromField);
                        }
                        break;
                }
                return true;
            });
        }
    }
}
