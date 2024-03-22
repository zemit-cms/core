#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

php -d xdebug.mode=off ./vendor/bin/psalm --config=psalm.xml --threads=4 --taint-analysis --dump-taint-graph=taints.dot "$@"
