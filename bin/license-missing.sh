#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

find ./src/ -type f -name "*.php" -exec grep -LZ "This file is part of the Zemit Framework." {} + | xargs -0 -n1 echo
