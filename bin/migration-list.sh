#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

./vendor/bin/phalcon migration list --config=./devtools.php --directory=./ --migrations=./resources/migrations/ --log-in-db "$@"
