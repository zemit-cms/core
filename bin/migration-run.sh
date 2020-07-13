#!/bin/bash
./vendor/bin/phalcon migration run --config=./src/Config/Migration.php --directory=./ --migrations=./src/Migrations/ --no-auto-increment --force --verbose
