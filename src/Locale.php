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
use Zemit\Support\Options\Options;
use Zemit\Support\Options\OptionsInterface;

/**
 * Allow to manage and lookup the locale for the localisation
 */
class Locale extends Injectable implements OptionsInterface
{
    use Options;
    
    /**
     * Default (router only)
     */
    public const MODE_DEFAULT = 'default';
    
    /**
     * Router
     */
    public const MODE_ROUTE = 'route';
    
    /**
     * Router -> http
     */
    public const MODE_HTTP = 'http';
    
    /**
     * Router -> session -> http
     */
    public const MODE_SESSION = 'session';
    
    /**
     * Locale mode
     * Locale::MODE_DEFAULT 'default' (Router -> http)
     * Locale::MODE_SESSION 'session' (Router -> session -> http)
     */
    public string $mode = self::MODE_DEFAULT;
    
    /**
     * The actual locale that was picked
     * @var string|null
     */
    public $locale = null;
    
    /**
     * @var mixed|null|string
     */
    public string $sessionKey = 'zemit-locale';
    
    /**
     * Default locale to fall back
     */
    public string $default = 'en';
    
    /**
     * List of allowed locale
     */
    public array $allowed = ['en'];
    
    /**
     * Set options and prepare locale
     */
    public function initialize(): void
    {
        $this->sessionKey = $this->getOption('sessionKey', $this->sessionKey);
        $this->setAllowed($this->getOption('allowed', $this->allowed));
        $this->setDefault($this->getOption('default', $this->default));
        $this->setMode($this->getOption('mode', $this->mode));
        $this->prepare($this->getDefault());
    }
    
    /**
     * Alias of the getLocale() method
     */
    public function get(): ?string
    {
        return $this->getLocale();
    }
    
    /**
     * Get the locale directly from the variable
     * without processing the defined mode
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }
    
    /**
     * Set the current locale value
     */
    public function setLocale(?string $locale = null): void
    {
        $this->locale = $this->lookup($locale);
    }
    
    /**
     * Get the default locale
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }
    
    /**
     * Set the default locale value
     */
    public function setDefault(?string $locale = null): void
    {
        $this->default = $locale;
    }
    
    /**
     * Get the list of possible locale
     */
    public function getAllowed(): array
    {
        return $this->allowed ?? [];
    }
    
    /**
     * Set the allowed locale
     */
    public function setAllowed(array $allowed): void
    {
        $this->allowed = array_values(array_unique($allowed));
    }
    
    /**
     * Get the defined mode
     */
    public function getMode(): string
    {
        return $this->mode;
    }
    
    /**
     * Set the mode
     */
    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }
    
    /**
     * Prepare and set and return the locale based on the defined mode
     */
    public function prepare(?string $default = null): ?string
    {
        $locale = match ($this->mode) {
            self::MODE_SESSION =>
                $this->getFromRoute() ??
                $this->getFromSession() ??
                $this->getFromHttp() ??
                $default,
            self::MODE_HTTP =>
                $this->getFromRoute() ??
                $this->getFromHttp() ??
                $default,
            default =>
                $this->getFromRoute() ??
                $default,
        };
        
        $locale ??= $this->locale;
        $this->setLocale($locale);
        $this->saveIntoSession($locale);
        return $this->getLocale();
    }
    
    /**
     * Retrieves the locale from the route
     */
    public function getFromRoute(?string $default = null): ?string
    {
        return $this->lookup($this->router->getParams()['locale'] ?? $default);
    }
    
    /**
     * Retrieves the locale from the dispatcher
     */
    public function getFromDispatcher(?string $default = null): ?string
    {
        return $this->lookup($this->dispatcher->getParams()['locale'] ?? $default);
    }
    
    /**
     * Retrieves the locale from the session
     */
    public function getFromSession(?string $default = null): ?string
    {
        return $this->lookup($this->session->get($this->sessionKey, $default));
    }
    
    /**
     * Retrieves the locale from the request
     * of getBestLanguage() header
     * or HTTP_ACCEPT_LANGUAGE header
     */
    public function getFromHttp(?String $default = null): ?string
    {
        return
            $this->lookup($this->request->getBestLanguage()) ??
            \Locale::acceptFromHttp($this->request->getHeader('HTTP_ACCEPT_LANGUAGE')) ??
            $default;
    }
    
    /**
     * Save locale into session if mode contain session handling
     */
    public function saveIntoSession(?string $locale = null, ?bool $force = null): void
    {
        $locale ??= $this->getLocale();
        
        // save into session
        $force = $force || $this->mode === self::MODE_SESSION;
        if ($force) {
            $this->session->set($this->sessionKey, $locale);
        }
    }
    
    /**
     * @param string|null $locale The locale to use as the language range when matching.
     * @param array|null $allowed An array containing a list of language tags to compare to locale. Maximum 100 items allowed.
     * @param bool $canonicalize If true, the arguments will be converted to canonical form before matching.
     * @param string|null $default The locale to use if no match is found.
     * @return string|null The closest matching language tag or default value.
     */
    public function lookup(?string $locale = null, ?array $allowed = null, bool $canonicalize = false, ?string $default = null): ?string
    {
        if (is_null($locale)) {
            return null;
        }
        
        $allowed ??= $this->getAllowed();
        
        // lookup first
        $lookup = \Locale::lookup($allowed, $locale, $canonicalize, $default);
        
        // base locale found without the region
        $force = false;
        if ($locale === $lookup || strlen($lookup) === 2) {
            $locale = $lookup;
            $force = true;
        }
        
        // lookup for the first configured region based on the locale without region
        if (empty($lookup) || $force) {
            
            // matches all the possible regions from the locale
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
                $lookup = empty($lookup) ? $default : $lookup;
            }
        }
        
        return empty($lookup) ? null : $lookup;
    }
}
