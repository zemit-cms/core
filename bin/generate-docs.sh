#!/bin/bash
#
# This file is part of the Phalcon Kit.
#
# (c) Phalcon Kit Team
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

# wipe the docs folder first
rm -rf ./docs/
mkdir ./docs/

phpdoc -c phpdoc.xml "$@"

# Add Missing Native Classes
touch ./docs/classes/RuntimeException.md
touch ./docs/classes/InvalidArgumentException.md
touch ./docs/classes/ArrayAccess.md
touch ./docs/classes/LogicException.md
touch ./docs/classes/Exception.md
touch ./docs/classes/Throwable.md
touch ./docs/classes/AssertionError.md

# Fix Phalcon classes
find ./docs -type f -name "*.md" -exec sed -i 's|\(([^)]*/Phalcon/[^)]*\.md)\)|\(https://docs.phalcon.io/latest/api/\){:target="_blank"}|g' {} +
find ./docs -type f -name "*.md" -exec sed -i 's|https://docs.phalcon.io/[0-9]\+\.[0-9]\+|https://docs.phalcon.io/latest|g' {} +

# Fix League classes
find ./docs -type f -name "*.md" -exec sed -i 's|\(([^)]*/League/Csv/[^)]*\.md)\)|\(https://csv.thephpleague.com/\){:target="_blank"}|g' {} +
find ./docs -type f -name "*.md" -exec sed -i 's|\(([^)]*/League/OAuth2/Client/[^)]*\.md)\)|\(https://oauth2-client.thephpleague.com/\){:target="_blank"}|g' {} +
find ./docs -type f -name "*.md" -exec sed -i 's|\(([^)]*/League/Fractal/[^)]*\.md)\)|\(https://fractal.thephpleague.com/\){:target="_blank"}|g' {} +

# Remove the "> Automatically generated on xxxx-xx-xx" line from each file
find ./docs -type f -name "*.md" -exec sed -i '/> Automatically generated on/d' {} +

# Fix dotenv classes

# Decode HTML
decode_html_entities() {
    php -r "echo html_entity_decode(file_get_contents('$1'), ENT_QUOTES | ENT_HTML5, 'UTF-8');" > "$1.tmp" && mv -f "$1.tmp" "$1"
}
export -f decode_html_entities
find ./docs/ -type f -name "*.md" -exec bash -c 'decode_html_entities "$0"' {} \;

# delete this invalid utf8 line
sed -i '/^public __invoke(string \$string, string \$invalidUtf8Regex = .*/d' ./docs/classes/PhalconKit/Support/Helper/Str/SanitizeUTF8.md

# Generate Menu for Mkdoc
./bin/generate-docs-menu.sh

# Remove 4th level titles from Home.md
sed -i '/^#### /d' docs/Home.md

# Deploy to docs
rsync -av ./docs/* ../docs/docs/api/
