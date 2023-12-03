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

use Phalcon\Di\Di;
use Phalcon\Config\ConfigInterface;
use Zemit\Filter\Sanitize\Json;
use Zemit\Filter\Sanitize\Md5;
use Zemit\Filter\Sanitize\IPv4;
use Zemit\Filter\Sanitize\IPv6;

/**
 * {@inheritDoc}
 */
class Filter extends \Phalcon\Filter
{
    public ConfigInterface $config;
    
    public const FILTER_MD5 = 'md5';
    
    public const FILTER_JSON = 'json';
    
    public const FILTER_IPV4 = 'ipv4';
    
    public const FILTER_IPV6 = 'ipv6';
    
    /**
     * Key value pairs with name as the key and a callable as the value for
     * the service object
     *
     * @param array $mapper
     * @param ConfigInterface|null $config
     */
    public function __construct(array $mapper = [], ?ConfigInterface $config = null)
    {
        parent::__construct($mapper);
        $this->setConfig($config ?? Di::getDefault()->get('config'));
    }
    
    protected function init(array $mapper): void
    {
        parent::init($mapper);
    
        $this->set(self::FILTER_MD5, Md5::class);
        $this->set(self::FILTER_JSON, Json::class);
        $this->set(self::FILTER_IPV4, IPv4::class);
        $this->set(self::FILTER_IPV6, IPv6::class);
        
        // Adding App Filters defined from the user config
        $config = $this->getConfig();
        $configFilters = $config->get('filters')->toArray() ?? [];
        foreach ($configFilters as $key => $filter) {
            $this->set($key, $filter);
        }
    }
    
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }
    
    public function setConfig(ConfigInterface $config): void
    {
        $this->config = $config;
    }
}
