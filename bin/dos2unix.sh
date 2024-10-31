#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#
BASE_DIR="${1:-./}"
find "$BASE_DIR" -type f -name "*.php" | while read -r file; do
    if file "$file" | grep -q "CRLF"; then
        echo "Converting $file to Unix line endings..."
        dos2unix "$file"
    fi
done
