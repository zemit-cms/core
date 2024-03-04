#!/bin/bash
./vendor/bin/phalcon migration list --config=./devtools.php --directory=./ --migrations=./resources/migrations/ --log-in-db "$@"
