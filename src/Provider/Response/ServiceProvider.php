<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Response;

use Phalcon\Di\DiInterface;
use Phalcon\Http\Response;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\Response
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'response';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $response = new Response();
            $response->setDI($di);
            
            $config = $di->get('config');
            $headers = $config->path('response.headers', []);
            if (!empty($headers)) {
                foreach ($headers as $name => $value) {
                    $response->setHeader($name, $value);
                }
            }
            
            return $response;
        });
    }
}
