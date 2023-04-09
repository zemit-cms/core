#!/bin/bash
./vendor/bin/phalcon migration list --config=./devtools.php --directory=./ --migrations=./src/Migrations/ --log-in-db "$@"
