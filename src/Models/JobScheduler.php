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

namespace Zemit\Models;

use Zemit\Models\Abstracts\JobSchedulerAbstract;
use Zemit\Models\Interfaces\JobSchedulerInterface;

/**
 * Class JobScheduler
 *
 * This class represents a JobScheduler object.
 * It extends the JobSchedulerAbstract class and implements the JobSchedulerInterface.
 */
class JobScheduler extends JobSchedulerAbstract implements JobSchedulerInterface
{
    #[\Override]
    public function initialize(): void
    {
        parent::initialize();
        $this->addDefaultRelationships();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $this->addDefaultValidations($validator);
        return $this->validate($validator);
    }
}
