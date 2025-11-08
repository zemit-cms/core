#!/bin/bash
#
# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit Team
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

php ./phalcon-kit cli database drop
php ./phalcon-kit cli database truncate
php ./phalcon-kit cli database fix-engine
php ./phalcon-kit cli database insert
php ./phalcon-kit cli database analyze
php ./phalcon-kit cli database optimize
