#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

php ./zemit cli database drop
php ./zemit cli database truncate
php ./zemit cli database fix-engine
php ./zemit cli database insert
php ./zemit cli database analyze
php ./zemit cli database optimize
