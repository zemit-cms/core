<?php


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
        $providers = $this->bootstrap->config->path('providers', []);
        foreach ($providers as $assumption => $concrete) {
            $provider = new $concrete();
            $this->assertInstanceOf(ServiceProviderInterface::class, $provider);
        }
    }
    
}
