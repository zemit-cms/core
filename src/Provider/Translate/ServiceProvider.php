<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Translate;

use Phalcon\Di\DiInterface;
use Phalcon\Translate\Adapter\Gettext;
use Phalcon\Translate\InterpolatorFactory;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Flash\ServiceProvider
 *
 * @package Zemit\Provider\Translate
 */
class ServiceProvider extends AbstractServiceProvider
{
    
    // @todo
    const DEFAULT_OPTIONS = [
    
    ];
    
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'translate';
    
    /**
     * {@inheritdoc}
     *
     * Register the Flash Service with the Twitter Bootstrap classes.
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $config = $di->get('config');
            if ($config && $config->has('translate')) {
                $options = $config->translate->toArray();
            }
            
            $translate = new Gettext(new InterpolatorFactory(), $options ?? self::DEFAULT_OPTIONS);
            $translate->setLocale(LC_MESSAGES, $di->get('locale')->get() . '.utf8');
            
            return $translate;
        });
    }
}
