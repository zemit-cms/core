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

use Zemit\Mvc\Model;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Model\Behavior\Transformable;

trait Slug
{
    use AbstractInjectable;
    use AbstractBehavior;
    use Options;
    
    /**
     * Initializing Slug
     */
    public function initializeSlug(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('slug') ?? [];
        
        $field = $options['field'] ?? 'slug';
        
        $this->setSlugBehavior(new Transformable([
            'beforeValidation' => [
                $field => function (Model $model, $field) {
                    $value = $model->readAttribute($field);
                    return $value && is_string($value) ? \Zemit\Support\Slug::generate($value) : $value;
                },
            ],
        ]));
    }
    
    /**
     * Set Slug Behavior
     */
    public function setSlugBehavior(Transformable $slugBehavior): void
    {
        $this->setBehavior('slug', $slugBehavior);
    }
    
    /**
     * Get Slug Behavior
     */
    public function getSlugBehavior(): Transformable
    {
        $slugBehavior = $this->getBehavior('slug');
        assert($slugBehavior instanceof Transformable);
        return $slugBehavior;
    }
}
