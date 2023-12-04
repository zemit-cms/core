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

namespace Zemit\Tests\Unit;

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
        ];
        foreach ($functions as $function) {
            $this->assertTrue(function_exists($function), 'function_exists : ' . $function);
        }
    }
}
