<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\VoltTemplate;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewBaseInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Utils\Env;

/**
 * Zemit\Provider\VoltTemplate\ServiceProvider
 *
 * @package Zemit\Provider\VoltTemplate
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'volt';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $view = $di->get('view');
            $volt = new Volt($view, $di);
            $volt->setOptions([]); // @todo ?
            $volt->getCompiler()->addExtension(new VoltFunctions());
            return $volt;
        });
    }
}
