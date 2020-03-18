<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Captcha;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Captcha\ServiceProvider
 *
 * @package Zemit\Provider\Captcha
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'recaptcha';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), Adapters\ReCaptcha::class);
    }
}
