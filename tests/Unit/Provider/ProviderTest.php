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

namespace Zemit\Tests\Unit\Provider;

use League\Flysystem\Filesystem;
use Zemit\Provider\ServiceProviderInterface;
use Zemit\Tests\Unit\AbstractUnit;

class ProviderTest extends AbstractUnit
{
    public function testProvider(): void
    {
        $providers = $this->bootstrap->config->pathToArray('providers') ?? [];
        $this->assertIsArray($providers);
        
        foreach ($providers as $assumption => $concrete) {
            $this->assertIsString($assumption);
            $this->assertIsString($concrete);
            
            $provider = new $concrete($this->di);
            $this->assertInstanceOf(ServiceProviderInterface::class, $provider);
        }
    }
    
    public function testFileSystemProvider(): void
    {
        $fileSystem = $this->di->get('fileSystem');
        assert($fileSystem instanceof Filesystem);
        
        $this->assertInstanceOf(Filesystem::class, $fileSystem);
        $contents = $fileSystem->listContents('.');
        $this->assertIsArray($contents->toArray());
    }
}
