<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Markdown;

use Zemit\Provider\AbstractServiceProvider;
use Zemit\Markdown\Markdown;

/**
 * Zemit\Provider\Markdown\ServiceProvider
 *
 * @package Zemit\Provider\Markdown
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'markdown';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di) : void
    {
        $di->setShared(
            $this->getName(),
            function () use ($di) {
                return new Markdown();
            }
        );
    }
}
