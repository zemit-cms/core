#!/bin/bash
#
# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit Team
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

find ./src/ -type f -name "*.php" -exec grep -LZ "declare(strict_types=1);" {} + | xargs -0 -n1 echo
