#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

# License text
LICENSE_TEXT=$(cat <<'EOF'
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */
EOF
)

# Function to process files in a given path
process_path() {
    local path="$1"
    find "$path" -type f -name "*.php" | while IFS= read -r file; do
        if ! grep -qF "This file is part of the Zemit Framework." "$file"; then
            awk -v lic="$LICENSE_TEXT" '
            /<?php/ { print; print ""; print lic; lic_inserted=1; next }
            { print }
            END { if (!lic_inserted) print lic }
            ' "$file" > tmpfile && mv tmpfile "$file"
        fi
    done
}

# Check if any path is provided, otherwise use ./src/
if [ $# -eq 0 ]; then
    process_path "./src"
else
    # Loop over each argument
    for path in "$@"; do
        if [ -d "$path" ]; then
            process_path "$path"
        else
            echo "Warning: '$path' is not a directory. Skipping."
        fi
    done
fi
