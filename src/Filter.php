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

use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Di\DiInterface;

/**
 * Zemit\Filter
 * {@inheritdoc}
 * @package Zemit
 */
class Filter extends \Phalcon\Filter
{
    const FILTER_MD5 = 'md5';
    const FILTER_JSON = 'json';
    const FILTER_IPV4 = 'ipv4';
    const FILTER_IPV6 = 'ipv6';
    
    /**
     * Key value pairs with name as the key and a callable as the value for
     * the service object
     *
     * @param array $mapper
     */
    public function __construct(array $mapper = array())
    {
        parent::__construct($mapper);

        // Default Filters
        $this->set(self::FILTER_MD5, function ($value) { return (new Filters\Md5())->filter($value); });
        $this->set(self::FILTER_JSON, function ($value) { return (new Filters\Json())->filter($value); });
        $this->set(self::FILTER_IPV4, function ($value) { return (new Filters\IPv4())->filter($value); });
        $this->set(self::FILTER_IPV6, function ($value) { return (new Filters\IPv6())->filter($value); });
        
        // Adding App Filters defined from the user config
        $di = isset($di)? $di : Di::getDefault();
        if ($di instanceof DiInterface) {
            $config = $di->get('config');
            if ($config instanceof Config && isset($config->filters)) {
                foreach ($config->filters as $key => $filter) {
                    $this->set($key, function ($value) use ($filter) { return (new $filter())->filter($value); });
                }
            }
        }
    }
    
}
