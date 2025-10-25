#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

php -d xdebug.mode=off ~/.config/composer/vendor/bin/psalm --config=psalm.xml --threads=16 --report=results.sarif "$@"
