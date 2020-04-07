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

use Phalcon\Di\Injectable;

class Identity extends Injectable
{
    /**
     * Without encryption
     */
    const MODE_DEFAULT = self::MODE_JWT;
    
    /**
     * Without encryption (raw string into the session)
     */
    const MODE_STRING = 'string';
    
    /**
     * Store using JWT (jwt encrypted into the session)
     */
    const MODE_JWT = 'jwt';
    
    /**
     * Locale mode for the prepare fonction
     * @var string
     */
    public $mode = self::MODE_DEFAULT;
    
    /**
     * @var mixed|string|null
     */
    public $sessionKey = 'zemit-identity';
    
    /**
     * @var array
     */
    public $options = [];
    
    /**
     * @var string|int|bool|null
     */
    public $identity;
    
    public function __construct($options = [])
    {
        $this->setOptions($options);
        $this->sessionKey = $this->getOption('sessionKey', $this->sessionKey);
        $this->setMode($this->getOption('mode', $this->mode));
        $this->set($this->getFromSession());
    }
    
    /**
     * Set default options
     *
     * @param array $options
     */
    public function setOptions($options = [])
    {
        $this->options = $options;
    }
    
    /**
     * Getting an option value from the key, allowing to specify a default value
     *
     * @param $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function getOption($key, $default = null)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }
        
        return $default;
    }
    
    /**
     * Get the current mode
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
    
    /**
     * Set the mode
     *
     * @param string $mode
     *
     * @throws \Exception Throw an exception if the mode is not supported
     */
    public function setMode($mode)
    {
        switch($mode) {
            case self::MODE_STRING:
            case self::MODE_JWT:
                $this->mode = $mode;
                break;
            default:
                throw new \Exception('Identity mode `' . $mode . '` is not supported.');
                break;
        }
    }
    
    /**
     * @return bool|mixed
     */
    public function getFromSession()
    {
        $ret = $this->session->has($this->sessionKey) ? $ret = $this->session->get($this->sessionKey) : null;
        
        if ($ret) {
            switch($this->mode) {
                case self::MODE_DEFAULT:
                    break;
                case self::MODE_JWT:
                    $ret = $this->jwt->parseToken($ret)->getClaim('identity');
                    break;
            }
        }
        
        return json_decode($ret);
    }
    
    /**
     * Save an identity into the session
     *
     * @param int|string|null $identity
     */
    public function setIntoSession($identity)
    {
        
        $identity = json_encode($identity);
        
        $token = null;
        switch($this->mode) {
            case self::MODE_JWT:
                $token = $this->jwt->getToken(['identity' => $identity]);
                break;
        }
        
        $this->session->set($this->sessionKey, $token ? : $identity);
    }
    
    /**
     * Set an identity
     *
     * @param int|string|null $identity
     */
    public function set($identity)
    {
        $this->setIntoSession($identity);
        $this->identity = $identity;
    }
    
    /**
     * Get the current identity
     * @return int|string|null
     */
    public function get()
    {
        $this->identity ??= $this->getFromSession();
        
        return $this->identity;
    }
    
    /**
     * @param null $roles
     *
     * @return bool
     */
    public function hasRole($roles = null, $or = false) {
        return $this->has($roles, $this->getUser()->getSlugs(), $or);
    }
    
    /**
     * Check if the needles meet the haystack using nested arrays
     * Reversing ANDs and ORs within each nested subarray
     *
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), true); // 'dev' OR 'admin'
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), false); // 'dev' ADN 'admin'
     *
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles()); // 'dev' AND 'admin'
     * $this->has([['dev', 'admin']], $this->getUser()->getRoles()); // 'dev' OR 'admin'
     * $this->has([[['dev', 'admin']]], $this->getUser()->getRoles()); // 'dev' AND 'admin'
     *
     * @param array|string|null $needles Needles to match and meet the rules
     * @param array $haystack Haystack array to search into
     * @param bool $or True to force with "OR" , false to force "AND" condition
     *
     * @return bool Return true or false if the needles rules are being met
     */
    public function has($needles = null, array $haystack = [], $or = false)
    {
        $result = [];
        foreach ([...$needles] as $needle) {
            if (is_array($needle)) {
                $result [] = $this->has($needle, $haystack, !$or);
            } else {
                $result [] = in_array($needle, $haystack, true);
            }
        }
        
        return $or ?
            !in_array(false, $result, true) :
            in_array(true, $result, true);
    }
}
