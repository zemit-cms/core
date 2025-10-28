<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Phalcon\Config\Exception;
use Zemit\Bootstrap\Deployment;
use Zemit\Modules\Cli\Task;
use Zemit\Modules\Cli\Tasks\Traits\DatabaseTrait;
use Zemit\Support\Utils;

class DatabaseTask extends Task
{
    use DatabaseTrait;
    
    public string $cliDoc = <<<DOC
Usage:
  zemit cli database main
  zemit cli database drop
  zemit cli database truncate
  zemit cli database fix-engine
  zemit cli database optimize
  zemit cli database analyze
  zemit cli database insert

Options:
  main:         truncate, drop, fix-engine, insert, optimize, analyze
  drop:         Drop deprecated tables
  truncate:     Truncate tables
  fix-engine:   Force table engines to `InnoDB`
  optimize:     Run `OPTIMIZE TABLE`
  analyze:      Run `ANALYZE TABLE`
  insert:       Insert records
DOC;
    
    /**
     * @throws Exception
     */
    public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
        
        $deploymentConfig = new Deployment();
        $this->drop = $deploymentConfig->pathToArray('drop') ?? [];
        $this->truncate = $deploymentConfig->pathToArray('truncate') ?? [];
        $this->engine = $deploymentConfig->pathToArray('engine') ?? [];
        $this->insert = $deploymentConfig->pathToArray('insert') ?? [];
        $this->optimize = $deploymentConfig->pathToArray('optimize') ?? [];
        $this->analyze = $deploymentConfig->pathToArray('analyze') ?? [];
        
        $this->addModelsPermissions();
    }
}
