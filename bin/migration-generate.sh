#!/bin/bash
./vendor/bin/phalcon migration generate --config=./devtools.php --directory=./ --migrations=./src/Migrations/ --no-auto-increment --force --verbose --log-in-db "$@"
./vendor/bin/phpcbf --standard=phpcs-eol.xml ./src/Migrations/
