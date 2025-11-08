<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Tests\Unit\Functions;

use PhalconKit\Tests\Unit\AbstractUnit;

class FunctionsTest extends AbstractUnit
{
    public function testFunctions(): void
    {
        $functions = [
            'vdd',
            'dd',
            'dump',
            'exit_500',
            'array_unset_recursive',
            'implode_sprintf',
            'implode_mb_sprintf',
            'sprintfn',
            'mb_sprintf',
            'mb_vsprintf',
            'json_validate',
        ];
        foreach ($functions as $function) {
            $this->assertTrue(function_exists($function), 'function_exists : ' . $function);
        }
    }
}
