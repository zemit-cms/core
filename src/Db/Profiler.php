<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db;

/**
 * {@inheritdoc}
 */
class Profiler extends \Phalcon\Db\Profiler
{
    public function toArray(): array
    {
        $profiles = [];
        $profilerProfiles = $this->getProfiles();
        if (!empty($profilerProfiles)) {
            foreach ($profilerProfiles as $profile) {
                $profiles [] = [
                    'sqlStatement' => $profile->getSqlStatement(),
                    'sqlVariables' => $profile->getSqlVariables(),
                    'sqlBindTypes' => $profile->getSqlBindTypes(),
                    'initialTime' => $profile->getInitialTime(),
                    'finalTime' => $profile->getFinalTime(),
                    'elapsedSeconds' => $profile->getTotalElapsedSeconds() / 1000000000,
                ];
            }
        }

        return [
            'profiles' => $profiles,
            'numberTotalStatements' => $this->getNumberTotalStatements(),
            'totalElapsedSeconds' => $this->getTotalElapsedSeconds() / 1000000000,
        ];
    }
}
