#!/bin/bash
#
# Auto-add declare(strict_types=1); to PHP source files missing it.
#

#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

set -euo pipefail

find ./src -type f -name "*.php" | while IFS= read -r file; do
  if ! grep -q "declare(strict_types=1);" "$file"; then
    echo "Adding strict_types to $file"

    # Insert after the first line containing '<?php'
    # Use a temp file to avoid in-place sed portability issues
    tmp="$(mktemp)"
    awk '
      NR == 1 && /^<\?php/ {
        print $0 "\n\ndeclare(strict_types=1);\n"
        next
      }
      { print }
    ' "$file" > "$tmp" && mv "$tmp" "$file"
  fi
done

echo "Done. Added strict_types where missing."

