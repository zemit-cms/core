# Zemit Core
[![Build Status](https://scrutinizer-ci.com/g/zemit-cms/core/badges/build.png?b=master)](https://scrutinizer-ci.com/g/zemit-cms/core/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zemit-cms/core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zemit-cms/core/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/zemit-cms/core/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Code Coverage](https://scrutinizer-ci.com/g/zemit-cms/core/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/zemit-cms/core/?branch=master)

[![Latest Stable Version](https://poser.pugx.org/zemit-cms/core/v/stable)](https://packagist.org/packages/zemit-cms/core)
[![Latest Unstable Version](https://poser.pugx.org/zemit-cms/core/v/unstable)](https://packagist.org/packages/zemit-cms/core)
[![License](https://poser.pugx.org/zemit-cms/core/license)](https://packagist.org/packages/zemit-cms/core)

[![Daily Downloads](https://poser.pugx.org/zemit-cms/core/d/daily)](https://packagist.org/packages/zemit-cms/core)
[![Monthly Downloads](https://poser.pugx.org/zemit-cms/core/d/monthly)](https://packagist.org/packages/zemit-cms/core)
[![Total Downloads](https://poser.pugx.org/zemit-cms/core/downloads)](https://packagist.org/packages/zemit-cms/core)

Zemit Core is an open source headless CMS built on top of [Phalcon](https://github.com/phalcon/cphalcon), an open source web framework delivered as a C extension for the PHP language providing high performance and lower resource consumption

## Contents
- [Getting Started](#getting-started)
- [Requirements](#requirements)
- [External Links](#external-links)
- [Contributing](#contributing)
- [License](#license)
  
## Getting Started
Zemit is using the [Phalcon Framework](https://phalconphp.com). You can use [composer](https://getcomposer.org/) in order to add Zemit core to an existing project. If you want to create a new project from scratch, we invite you to visit the [Zemit App](https://github.com/zemit-cms/app) repository for more informations.
```shell
composer require zemit-cms/core
```

If you want to play around directly with the core, you can create a new project from itself and follow the configuration below.
```shell
composer create-project zemit-cms/core <your_project_name>
```

### Configuration
Add the database config, note that we use dotenv to load the .env config. Simply add .env file to the root of your project.
```dotenv
# Database
DATABASE_HOST=<your_db_host>
DATABASE_DBNAME=<your_db_schema>
DATABASE_USERNAME=<your_db_username>
DATABASE_PASSWORD=<your_password>
```

### Initialize Database
We are using phalcon cli to run & generate database migration.
```shell
./vendor/bin/phalcon migration run --config=./src/Config/Migration.php --directory=./ --migrations=./src/Migrations/ --no-auto-increment --force --verbose --log-in-db
```

### Serve Application
To use Web MVC modules of Zemit Core locally, you can use PHP's built-in web server,
note that this web server is designed to aid application development.
It may also be useful for testing purposes or for application demonstrations
that are run in controlled environments. It is not intended to be a full-featured web server.
```shell
php -S 0.0.0.0:8000 /public/index.php
```
You should now be able to access Zemit Core Frontend module from http://localhost:8000

This web server runs only one single-threaded process, so PHP applications will stall if a request is blocked.
For more information about the CLI SAPI built-in web server, refer to the official documentation:
https://www.php.net/manual/en/features.commandline.webserver.php

### Full-featured Web Server
If you want to expose the application to the public world wide web,
you can use apache or nginx to serve this purpose securely.
You will need a Web server service to point to the /public/ folder of your new project.
Here is virtual host example using apache 2.4 + php-fpm 7.4 from remi repository on Centos Stream.
```apacheconf
<VirtualHost *:80>
    ServerName core.zemit.com
    ServerAlias www.core.zemit.com
    DocumentRoot /mnt/hgfs/dev/zemit/core/public/
    
    <Directory /mnt/hgfs/dev/zemit/core/public/>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
    </Directory>
    
    <FilesMatch \.(php|phar)$>
        SetHandler "proxy:unix:/var/opt/remi/php74/run/php-fpm/www.sock|fcgi://localhost"
    </FilesMatch>
</VirtualHost>

<VirtualHost *:443>
    ServerName core.zemit.com
    ServerAlias www.core.zemit.com
    DocumentRoot /mnt/hgfs/dev/zemit/core/public/
    
    <Directory /mnt/hgfs/dev/zemit/core/public/>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
    </Directory>
    
    <FilesMatch \.(php|phar)$>
        SetHandler "proxy:unix:/var/opt/remi/php74/run/php-fpm/www.sock|fcgi://localhost"
    </FilesMatch>
    
    SetEnv HTTPS on
    SetEnv HTTP_X_FORWARDED_PROTO https
</VirtualHost>
```


## Requirements
Zemit Core requires multiple PHP extensions. Please use `composer` to make sure that you meet the requirements.

#### Languages & compatibilities
- [PHP](https://secure.php.net/) ~7.4
- [MySQL](https://www.mysql.com/) ~5.7
- [MariaDB](https://mariadb.com/) ~10.4
- [PhalconPHP](https://phalconphp.com/) ~4.1

## External Links
* [Website](https://www.zemit.com)
* [Documentation](https://docs.zemit.com)
* [Support](https://forum.zemit.com)
* [Twitter](https://twitter.zemit.com)
* [Facebook](https://facebook.zemit.com)

## Contributing
See [CONTRIBUTING.md](https://github.com/zemit-cms/core/blob/master/CONTRIBUTING.md) for details.

## License
Zemit is open source software licensed under the BSD 3-Clause License.

Copyright © 2017-present, Zemit Team.

See the [LICENSE.txt](https://github.com/zemit-cms/core/blob/master/LICENSE.txt) file for more.
