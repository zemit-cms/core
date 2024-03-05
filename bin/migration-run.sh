#!/bin/bash
./vendor/bin/phalcon migration run --config=./devtools.php --directory=./ --migrations=./resources/migrations/ --no-auto-increment --force --verbose --log-in-db "$@"
