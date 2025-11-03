#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

# Path to mkdocs.yml
mkdocs_yml="./../docs/mkdocs.yml"

# Path to the Home.md file
home_md_file="docs/Home.md"

# Final output file for the mkdoc menu
mkdocs_menu_file="docs/mkdocs_menu.yml"

# Clear the mkdoc menu file
rm $mkdocs_menu_file

# Function to escape special characters for use in awk regex
escape_awk() {
    echo "$1" | sed -e 's/[]\/$*.^|[]/\\&/g'
}

# Read the Home.md file line by line
while IFS= read -r line; do
    if [[ $line == '### '* ]]; then
        # Extract the section name (removing '###')
        section_name=${line/#"### "/}

        # Write the section header to the mkdoc menu file
        echo "      - $section_name:" >> "$mkdocs_menu_file"
    elif [[ $line =~ \[\`(.*)\`\]\((.*)\.md\) ]]; then
        # Extract the link text and URL from the table
        link_text="${BASH_REMATCH[1]}"
        url="${BASH_REMATCH[2]}"

        # Replace ": ./" with ": api/" in the URL
        url=${url/.\//api/}

        # Write the link to the mkdoc menu file
        echo "          - $link_text: $url.md" >> "$mkdocs_menu_file"
    fi
done < "$home_md_file"

echo "Mkdoc menu created: $mkdocs_menu_file"

sed -i '/^  - API:/Q' "$mkdocs_yml"
{
    echo "  - API:";
    echo "      - Home: api/Home.md";
    cat "$mkdocs_menu_file";
} >> "$mkdocs_yml"

echo "API section replaced successfully."
