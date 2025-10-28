#!/bin/bash
#
# Ultra-safe strict_types injector:
# - In-place only (no mv, no tmp files, no inode replacement)
# - Skips files that already have declare(strict_types=1);
# - Only touches files that start with <?php on the first line
# - Idempotent
#
set -euo pipefail
export LC_ALL=C

ROOT="./src"

# find with -print0 so we handle weird filenames safely
find "$ROOT" -type f -name "*.php" -print0 | while IFS= read -r -d '' file; do
    # Read first line literally (strip CR if present, strip BOM if present)
    first_line="$(head -n 1 "$file" \
        | tr -d '\r' \
        | sed 's/^\xEF\xBB\xBF//')"

    # If first line is not exactly "<?php", skip it
    if [[ "$first_line" != "<?php" ]]; then
        echo "skipping $file (doesn't start with <?php)"
        continue
    fi

    # If file already has strict_types (in any spaced variant), skip it
    if grep -Eq 'declare\s*\(\s*strict_types\s*=\s*1\s*\)\s*;' "$file"; then
        # already strict
        continue
    fi

    echo "injecting strict_types into $file (in-place, no perms touched)"

    # Use ed to insert lines after line 1.
    # This modifies the file's content IN PLACE. No temp inode.
    # We insert:
    #   blank line
    #   declare(strict_types=1);
    #   blank line
    ed -s "$file" <<'EOF'
1a

declare(strict_types=1);

.
w
q
EOF

done

echo "strict_types injection complete"
