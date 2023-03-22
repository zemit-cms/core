<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Tests\Unit;

use Zemit\Provider\ServiceProviderInterface;

/**
 * Class ProviderTest
 * @package Tests\Unit
 */
class ProviderTest extends AbstractUnit
{
    /**
     * Testing the bootstrap service
     */
    public function testProvider() {
        $this->assertTrue(true);
        $providers = $this->bootstrap->config->providers->toArray();
        $this->assertIsArray($providers);

        foreach ($providers as $assumption => $concrete) {
            $this->assertIsString($assumption);
            $this->assertIsString($concrete);
            
            $provider = new $concrete($this->di);
            $this->assertInstanceOf(ServiceProviderInterface::class, $provider);
        }
    }
    
}
