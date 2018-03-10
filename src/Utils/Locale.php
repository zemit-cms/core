<?php

namespace Zemit\Core\Utils;

use Phalcon\Di\Injectable;

class Locale extends Injectable
{
    /**
     */
    const MODE_DEFAULT = 'default';
    
    /**
     */
    const MODE_SESSION = 'session';
    
    /**
     */
    const MODE_GEOIP = 'geoip';
    
    /**
     */
    const MODE_SESSION_GEOIP = 'session_geoip';
    
    /**
     * Locale mode
     * Locale::MODE_DEFAULT
     * Locale::MODE_SESSION
     * @var int
     */
    public $mode = self::MODE_DEFAULT;
    
    /**
     * The actual locale that was picked
     * @var string|null
     */
    public $locale = null;
    
    
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
    public $list = ['en'];
    
    /**
     * List of possible locale for your app
     * @var array
     */
    public $options = [];
    
    public function __construct($options = [])
    {
        $this->setOptions($options);
        $this->sessionKey = $this->getOption('sessionKey', $this->sessionKey);
        $this->setList($this->getOption('list', $this->list));
        $this->setDefault($this->getOption('default', $this->default));
        $this->setMode($this->getOption('mode', $this->mode)); // @TODO
        $this->prepare($this->getDefault());
    }
    
    public function setOptions($options = [])
    {
        return $this->options = $options;
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
     * @return null|string Return the locale itself
     */
    public function setLocale($locale = null)
    {
        return $this->locale = $this->lookup($locale);
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
     * @return null|string Return the default locale
     */
    public function setDefault($locale = null)
    {
        return $this->default = $locale;
    }
    
    /**
     * Get the list of possible locale
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }
    
    /**
     * Set the list of possible locale
     *
     * @param $list
     *
     * @return array
     */
    public function setList($list)
    {
        if (!is_array($list)) {
            $list = array($list);
        }
        return $this->list = $list;
    }
    
    public function getMode() {
        return $this->mode;
    }
    
    public function setMode($mode) {
        return $this->mode = $mode;
    }
    
    /**
     * Prepare the locale from the different possibilities
     * @param null|string $default
     * @return null|string
     */
    public function prepare($default = null)
    {
        switch($this->mode) {
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
        $this->session->set($this->sessionKey, $this->getLocale());
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
     * @param null|array $list List of allowed locale
     *
     * @return null|string Return null if locale isn't allowed
     */
    public function lookup($locale, $list = null, $canonicalize = false, $default = null)
    {
        if (empty($locale)) {
            return $default;
        }
        
        if (!isset($list)) {
            $list = $this->getList();
        }
        
        // lookup first
        $lookup = \Locale::lookup($list, $locale, $canonicalize, null);
    
        // base locale found without the region
        $refetch = false;
        if ($locale === $lookup || strlen($lookup) === 2) {
            $locale = $lookup;
            $refetch = true;
        }
        
        // lookup for the first configured region based on the locale without region
        if (empty($lookup) || $refetch) {
            
            // matches all the possible regions from thie locale
            $matches = array_filter($list, function ($haystack) use ($locale) {
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