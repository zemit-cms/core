<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Captcha\Adapters;

use Zemit\Di\Injectable;
use Phalcon\Config\Config;
use ReCaptcha\ReCaptcha as GoogleCaptcha;
use Zemit\Tag;

/**
 * Class ReCaptcha
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\Captcha\Adapters
 */
class ReCaptcha extends Injectable
{
    /**
     * @var GoogleCaptcha
     */
    protected $captcha;
    
    /**
     * @var bool
     */
    protected $enabled = false;

    public function __construct()
    {
        /** @var Config $config */
        $config = $this->getDI()->get('config')->reCaptcha;
        if ($config instanceof Config && $config->offsetGet('secret') && $config->offsetGet('siteKey')) {
            $this->enabled = true;
            $this->captcha = new GoogleCaptcha($config->offsetGet('secret'));
        }
    }

    public function isEnabled()
    {
        return (bool) $this->enabled;
    }

    public function getCaptcha()
    {
        return $this->captcha;
    }

    public function getJs()
    {
        return Tag::javascriptInclude('https://www.google.com/recaptcha/api.js', false);
    }
}
