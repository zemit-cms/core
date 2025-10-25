<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Filter;

use Zemit\Filter\Sanitize\IPv4;
use Zemit\Filter\Sanitize\IPv6;
use Zemit\Filter\Sanitize\Json;
use Zemit\Filter\Sanitize\Md5;

/**
 * Filter class extends the \Phalcon\Filter\Filter class and provides additional methods for filtering data.
 * {@inheritDoc}
 * 
 * @method string md5(string $input)
 * @method string json(string $input)
 * @method string ipv4(string $input)
 * @method string ipv6(string $input)
 */
class Filter extends \Phalcon\Filter\Filter
{
    public const string FILTER_MD5 = 'md5';
    
    public const string FILTER_JSON = 'json';
    
    public const string FILTER_IPV4 = 'ipv4';
    
    public const string FILTER_IPV6 = 'ipv6';
    
    #[\Override]
    protected function init(array $mapper): void
    {
        parent::init($mapper);
        
        $this->set(self::FILTER_MD5, Md5::class);
        $this->set(self::FILTER_JSON, Json::class);
        $this->set(self::FILTER_IPV4, IPv4::class);
        $this->set(self::FILTER_IPV6, IPv6::class);
    }
}
