<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

use Zemit\Di\Injectable;

/**
 * Class Locale
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit
 */
class Locale extends Injectable
{
    /**
     * Router, http
     */
    const MODE_DEFAULT = 'default';
    
    /**
     * Router, session, http
     */
    const MODE_SESSION = 'session';
    
    /**
     * Router, geoip, http
     */
    const MODE_GEOIP = 'geoip';
    
    /**
     * Router, session, geoip, http
     */
    const MODE_SESSION_GEOIP = 'session_geoip';
    
    /**
     * Locale mode for the prepare fonction
     * Locale::MODE_DEFAULT 'default' (Router, http)
     * Locale::MODE_SESSION 'session' (Router, session, http)
     * Locale::MODE_GEOIP 'geoip' (Router, geoip, http)
     * Locale::MODE_SESSION_GEOIP 'session_geoip' (Router, session, geoip, http)
     * @var int
     */
    public $mode = self::MODE_DEFAULT;
    
    /**
     * The actual locale that was picked
     * @var string|null
     */
    public $locale = null;
    
    /**
     * @var mixed|null|string
     */
    public $sessionKey = 'zemit-locale';
    
    /**
     * Default locale to fallback no matter what
     * @var string
     */
    public $default = 'en';
    
    /**
     * List of possible locale for your app
     * @var array
     */
    public $allowed = ['en'];
    
    /**
     * List of possible locale for your app
     * @var array
     */
    public $options = [];
    
    public function __construct($options = [])
    {
        $this->setOptions($options);
        $this->sessionKey = $this->getOption('sessionKey', $this->sessionKey);
        $this->setAllowed($this->getOption('allowed', $this->allowed));
        $this->setDefault($this->getOption('default', $this->default));
        $this->setMode($this->getOption('mode', $this->mode)); // @TODO
        $this->prepare($this->getDefault());
    }
    
    public function setOptions($options = [])
    {
        $this->options = $options;
    }
    
    public function getOption($key, $default = null)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }
        return $default;
    }
    
    public function get()
    {
        return $this->getLocale();
    }
    
    /**
     * Get the locale directly from the variable
     * @return null|string Return the chosen locale
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Set the current locale value
     * @param null|string $locale
     * @return void
     */
    public function setLocale($locale = null)
    {
        $this->locale = $this->lookup($locale);
    }
    
    /**
     * Get the default locale
     * @return null|string Return the default locale
     */
    public function getDefault()
    {
        return $this->default;
    }
    
    /**
     * Set the default locale value
     * @param null|string $locale
     * @return void
     */
    public function setDefault($locale = null)
    {
        $this->default = $locale;
    }
    
    /**
     * Get the list of possible locale
     * @return array
     */
    public function getAllowed()
    {
        return $this->allowed;
    }
    
    /**
     * Set the allowed of possible locale
     * @param null|string|array $allowed List of allowed locale
     * @return void
     */
    public function setAllowed($allowed)
    {
        $this->allowed = is_array($allowed)? $allowed : [$allowed];
    }
    
    public function getMode()
    {
        return $this->mode;
    }
    
    /**
     * Set the mode for the prepare function
     * @see $this->mode
     * @param mixed|string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }
    
    /**
     * Prepare the locale from the different possibilities
     * @param null|string $default
     * @return null|string
     */
    public function prepare($default = null)
    {
        switch ($this->mode) {
            default:
            case self::MODE_DEFAULT:
                $locale =
                    $this->getFromRoute() ??
                    $this->getFromHttp() ??
                    $default;
                break;
            case self::MODE_SESSION:
                $locale =
                    $this->getFromRoute() ??
                    $this->getFromSession() ??
                    $this->getFromHttp() ??
                    $default;
                break;
            case self::MODE_GEOIP:
                $locale =
                    $this->getFromRoute() ??
                    $this->getFromGeoIP() ??
                    $this->getFromHttp() ??
                    $default;
                break;
            case self::MODE_SESSION_GEOIP:
                $locale =
                    $this->getFromRoute() ??
                    $this->getFromSession() ??
                    $this->getFromGeoIP() ??
                    $this->getFromHttp() ??
                    $default;
                break;
        }
        $this->setLocale($locale, $this->locale);
//        $this->session->set($this->sessionKey, $this->getLocale());
        return $this->getLocale();
    }
    
    /**
     * Retrieves the locale from the route
     * @param null|string $default
     * @return null|string
     */
    public function getFromRoute($default = null)
    {
        return $this->lookup($this->router->getParams()['locale'] ?? $default);
    }
    
    /**
     * Retrieves the locale from the dispatcher
     * @param null|string $default
     * @return null|string
     */
    public function getFromDispatcher($default = null)
    {
        return $this->lookup($this->router->getParams()['locale'] ?? $default);
    }
    
    /**
     * Retrieves the locale from the session
     *
     * @param null $default
     *
     * @return mixed
     */
    public function getFromSession($default = null)
    {
        return $this->lookup($default);
        return $this->lookup($this->session->get($this->sessionKey, $default));
    }
    
    /**
     * Retrieves the locale from the geolocalisation
     * @param null $default
     * @return null
     */
    public function getFromGeoIP($default = null)
    {
        //@TODO
        return $this->lookup($default);
    }
    
    /**
     * Retrieves the locale from the request
     * @param null $default
     * @return null
     */
    public function getFromHttp($default = null)
    {
        return
            $this->lookup($this->request->getBestLanguage()) ??
            \Locale::acceptFromHttp($this->request->getHeader('HTTP_ACCEPT_LANGUAGE')) ??
            $default;
    }
    
    /**
     * Parse a locale to see if its allowed, return null if not
     *
     * @param null|string $locale Current locale to compare
     * @param null|array $allowed List of allowed locale
     *
     * @return null|string Return null if locale isn't allowed
     */
    public function lookup($locale, $allowed = null, $canonicalize = false, $default = null)
    {
        if (empty($locale)) {
            return $default;
        }
        
        if (!isset($allowed)) {
            $allowed = $this->getAllowed();
        }
        
        // lookup first
        $lookup = \Locale::lookup($allowed, $locale, $canonicalize, null);
    
        // base locale found without the region
        $refetch = false;
        if ($locale === $lookup || strlen($lookup) === 2) {
            $locale = $lookup;
            $refetch = true;
        }
        
        // lookup for the first configured region based on the locale without region
        if (empty($lookup) || $refetch) {
            // matches all the possible regions from thie locale
            $matches = array_filter($allowed, function ($haystack) use ($locale) {
                $needle = $locale . '_';
                return stripos($haystack, $needle) === 0;
            });
            
            // some matches
            if (count($matches)) {
                
                // lookup again with the first match
                $lookup = \Locale::lookup($matches, array_shift($matches), $canonicalize, $default);
            }
            else {
                
                // otherwise keep the lookup if set or set the default if not
                $lookup = empty($lookup)? $default : $lookup;
            }
        }
        
        return empty($lookup)? null : $lookup;
    }
}
