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

use Phalcon\Di;
use Phalcon\Config\ConfigInterface;

/**
 * {@inheritDoc}
 */
class Filter extends \Phalcon\Filter
{
    public ?ConfigInterface $config;
    
    
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
        $this->setConfig($config);
    }
    
    protected function init(array $mapper): void
    {
        parent::init($mapper);
    
        $this->set(self::FILTER_MD5, function ($value) {
            return (new Filters\Md5())->filter($value);
        });
    
        $this->set(self::FILTER_JSON, function ($value) {
            return (new Filters\Json())->filter($value);
        });
    
        $this->set(self::FILTER_IPV4, function ($value) {
            return (new Filters\IPv4())->filter($value);
        });
    
        $this->set(self::FILTER_IPV6, function ($value) {
            return (new Filters\IPv6())->filter($value);
        });
    
        // Adding App Filters defined from the user config
        $config = $this->getConfig();
        $configFilters = $config->get('filters')->toArray() ?? [];
        foreach ($configFilters as $key => $filter) {
    
            $this->set($key, function ($value) use ($filter) {
                return (new $filter())->filter($value);
            });
        }
    }
    
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }
    
    public function setConfig(?ConfigInterface $config = null): void
    {
        $this->config = $config ?? Di::getDefault()->get('config');
    }
}
