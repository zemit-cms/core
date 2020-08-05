<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli;

/**
 * Class Task
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Cli
 */
class Task extends \Phalcon\Cli\Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli <task> <action> [<params> ...]

Options:
  task: build,cache,cron,errors,help


DOC;
    
    public function helpAction()
    {
        echo $this->consoleDoc;
    }
    
    public function mainAction()
    {
        $this->helpAction();
    }
}
