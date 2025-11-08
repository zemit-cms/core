#!/bin/bash
#
# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit Team
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

phpcs --standard=phpcs.xml --parallel=16 --cache --colors -p -s -w "$@"
