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
use Zemit\Modules\Cli\Tasks\Traits\DeploymentTrait;
use Zemit\Utils;

class DeploymentTask extends Task
{
    use DeploymentTrait;
    
    public string $cliDoc = <<<DOC
Usage:
  php zemit cli deployment <action> [<params> ...]

Options:
  task: cache
  action: clear


DOC;
    
    public ?array $drop = null;
    public ?array $truncate = null;
    public ?array $engine = null;
    public ?array $insert = null;
    
    public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
        
        $deploymentConfig = new Deployment();
        $this->drop ??= $deploymentConfig->pathToArray('drop');
        $this->truncate ??= $deploymentConfig->pathToArray('truncate');
        $this->engine ??= $deploymentConfig->pathToArray('engine');
        $this->insert ??= $deploymentConfig->pathToArray('insert');
        
        $this->addModelsPermissions();
    }
}
