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

use Phalcon\Di;

/**
 * Class Profiler
 * {@inheritdoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Db
 */
class Profiler extends \Phalcon\Db\Profiler
{
    /**
     * @return array
     */
    public function toArray()
    {
        $config = Di::getDefault()->get('config');
        if (!$config->app->profiler) {
            return false;
        }
    
        $profiles = [];
        $profilerProfiles = $this->getProfiles();
        if ($profilerProfiles) {
            foreach ($profilerProfiles as $profile) {
                $profiles [] = [
                    'sqlStatement' => $profile->getSqlStatement(),
                    'sqlVariables' => $profile->getSqlVariables(),
                    'sqlBindTypes' => $profile->getSqlBindTypes(),
                    'initialTime' => $profile->getInitialTime(),
                    'finalTime' => $profile->getFinalTime(),
                    'elapsedSeconds' => $profile->getTotalElapsedSeconds(),
                ];
            }
        }
    
        return [
            'profiles' => $profiles,
            'numberTotalStatements' => $this->getNumberTotalStatements(),
            'totalElapsedSeconds' => $this->getTotalElapsedSeconds(),
        ];
    }
}
