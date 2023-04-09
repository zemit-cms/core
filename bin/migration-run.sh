#!/bin/bash
./vendor/bin/phalcon migration run --config=./devtools.php --directory=./ --migrations=./src/Migrations/ --no-auto-increment --force --verbose --log-in-db "$@"
