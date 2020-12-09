#!/bin/bash
./vendor/bin/phalcon migration list --config=./src/Config/Migration.php --directory=./ --migrations=./src/Migrations/ --log-in-db
