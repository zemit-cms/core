<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Zemit\Bootstrap\Deployment;
use Zemit\Modules\Cli\Task;
use Zemit\Modules\Cli\Tasks\Traits\DatabaseTrait;
use Zemit\Utils;

class DatabaseTask extends Task
{
    use DatabaseTrait;
    
    public string $cliDoc = <<<DOC
Usage:
  php zemit cli database <action> [<params> ...]

Options:
  task: database
  action: drop, truncate, fixEngine, insert, optimize, analyze


DOC;
    
    public ?array $drop = null;
    public ?array $truncate = null;
    public ?array $engine = null;
    public ?array $insert = null;
    public ?array $optimize = null;
    public ?array $analyze = null;
    
    public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
        
        $deploymentConfig = new Deployment();
        $this->drop ??= $deploymentConfig->pathToArray('drop');
        $this->truncate ??= $deploymentConfig->pathToArray('truncate');
        $this->engine ??= $deploymentConfig->pathToArray('engine');
        $this->insert ??= $deploymentConfig->pathToArray('insert');
        $this->optimize ??= $deploymentConfig->pathToArray('optimize');
        $this->analyze ??= $deploymentConfig->pathToArray('analyze');
        
        $this->addModelsPermissions();
    }
}
