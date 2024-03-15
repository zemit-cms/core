#!/bin/bash
find ./src/ -type f -name "*.php" -exec grep -LZ "This file is part of the Zemit Framework." {} + | xargs -0 -n1 echo
