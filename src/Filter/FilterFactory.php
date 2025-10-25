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

use Phalcon\Filter\FilterInterface;
use Zemit\Filter\Sanitize\IPv4;
use Zemit\Filter\Sanitize\IPv6;
use Zemit\Filter\Sanitize\Json;
use Zemit\Filter\Sanitize\Md5;

class FilterFactory extends \Phalcon\Filter\FilterFactory
{
    #[\Override]
    public function newInstance(): FilterInterface
    {
        return new Filter($this->getServices());
    }
    
    #[\Override]
    protected function getServices(): array
    {
        return array_merge(parent::getServices(), [
            Filter::FILTER_MD5 => Md5::class,
            Filter::FILTER_JSON => Json::class,
            Filter::FILTER_IPV4 => IPv4::class,
            Filter::FILTER_IPV6 => IPv6::class,
        ]);
    }
}
