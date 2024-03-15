#!/bin/bash
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#
rm -rf ./src/Models/Abstracts/Abstract*.php && ./vendor/bin/phalcon all-models --config=./devtools.php --get-set --camelize --mapcolumn --abstract --doc --directory=./ --output=./src/Models/Abstracts --relations --fk --force --namespace=Zemit\\Models\\Abstracts --extends=\\Zemit\\Models\\AbstractModel "$@"
find ./src/Models/Abstracts/ -type f -exec sed -i -e '/$this->setSchema/i \        parent::initialize();' {} \;
find ./src/Models/Abstracts/ -type f -exec sed -i -e 's/ $this->setSchema/ \/\/ $this->setSchema/g' {} \;
find ./src/Models/Abstracts/ -type f -exec sed -i -e 's/public function initialize()/public function initialize() :void/g' {} \;
