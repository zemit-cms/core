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

/**
 * Zemit\Filter
 * @inheritdoc
 * @package Zemit
 */
class Filter extends \Phalcon\Filter
{
    const FILTER_MD5 = 'md5';
    const FILTER_JSON = 'json';
    const FILTER_IPV4 = 'ipv4';
    const FILTER_IPV6 = 'ipv6';
    
    public function __construct()
    {
        // Adding Zemit Filters
        $this->add(self::FILTER_MD5, new Filters\Md5());
        $this->add(self::FILTER_JSON, new Filters\Json());
        $this->add(self::FILTER_IPV4, new Filters\IPv4());
        $this->add(self::FILTER_IPV6, new Filters\IPv6());
        
        // Adding App Filters defined from the user config
        foreach (Di::getDefault()->get('config')->filters as $key => $filter) {
            $this->add($key, new $filter());
        }
    }
    
}