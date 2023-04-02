#!/bin/bash
./vendor/bin/phalcon migration generate --config=./src/Config/Migration.php --directory=./ --migrations=./src/Migrations/ --no-auto-increment --force --verbose --log-in-db "$@"
