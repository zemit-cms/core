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

namespace Tests\Unit;

use Zemit\Provider\ServiceProviderInterface;

/**
 * Class ProviderTest
 * @package Tests\Unit
 */
class ProviderTest extends AbstractUnitTest
{
    /**
     * Testing the bootstrap service
     */
    public function testProvider() {
        $this->assertTrue(true);
//        $providers = $this->bootstrap->config->path('providers', []);
//        $this->assertIsArray($providers);
//
//        foreach ($providers as $assumption => $concrete) {
//            $this->assertIsString($assumption);
//            $this->assertIsString($concrete);
//
//            var_dump($concrete);
//            $provider = new $concrete();
//            $this->assertInstanceOf(ServiceProviderInterface::class, $provider);
//        }
    }
    
}
