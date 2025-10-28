# Zemit Core
[![Zemit CI](https://github.com/zemit-cms/core/actions/workflows/main.yml/badge.svg)](https://github.com/zemit-cms/core/actions/workflows/main.yml)
[![Latest Stable Version](https://poser.pugx.org/zemit-cms/core/v/stable)](https://packagist.org/packages/zemit-cms/core)
[![Latest Unstable Version](https://poser.pugx.org/zemit-cms/core/v/unstable)](https://packagist.org/packages/zemit-cms/core)
[![License](https://poser.pugx.org/zemit-cms/core/license)](https://packagist.org/packages/zemit-cms/core)

[![Daily Downloads](https://poser.pugx.org/zemit-cms/core/d/daily)](https://packagist.org/packages/zemit-cms/core)
[![Monthly Downloads](https://poser.pugx.org/zemit-cms/core/d/monthly)](https://packagist.org/packages/zemit-cms/core)
[![Total Downloads](https://poser.pugx.org/zemit-cms/core/downloads)](https://packagist.org/packages/zemit-cms/core)

Welcome to [Zemit Core](https://zemit.com), an innovative enhancement for the [Phalcon PHP Framework](https://phalcon.io) designed to supercharge your web development process. Zemit Core is not just an add-on; it's a comprehensive toolset that transforms the way you build and manage web applications.

At its heart, Zemit Core is about simplicity, efficiency, and scalability. Whether you're developing a complex enterprise application or a simple website, Zemit provides a robust, flexible foundation that adapts to your needs. Built on top of Phalcon, one of the fastest PHP frameworks available, Zemit Core leverages its performance while tweaking and existing components and introducing an array of new features and functionalities.

#### Key Highlights:

- **Extensive Service Providers**: From authentication to asset management, Zemit Core enriches your development experience with a vast array of customizable service providers and core features.
- **Modular Architecture**: With base modules like **Frontend**, **CLI**, **CMS**, **Admin**, **Rest** and **Restful API**, Zemit is versatile enough to let you be the maestro of your own architecture and efficiently handle various aspects of web development.
- **Enhanced Productivity**: By automating common tasks and reducing repetitive coding, Zemit lets you focus on what's unique about your project: the **business logic**.
- **Community Driven**: As an open-source project, Zemit is constantly evolving with contributions from a vibrant community of developers.

Whether you're a seasoned Phalcon developer or new to the framework, Zemit Core offers a seamless, intuitive experience, empowering you to create exceptional web applications with speed and ease.

Let's dive in and explore what Zemit Core has in store for your development journey!
  
## Getting Started

### Creating a new project using Zemit
If you want to create a new project from scratch, we invite you to visit the [Zemit App](https://github.com/zemit-cms/app) repository for more informations.
The `composer create-project` will be helpful for a brand new project, it will create all the necessary and recommended files and default configurations to save you time and effort.

```shell
# Replace <new-project-name> by your project name
composer create-project zemit-cms/app <new-project-name>
```

### Adding Zemit to your existing project
The `composer require` will be helpful for an existing project. 
```shell
composer require zemit-cms/core
```

There you go, you can already start using Zemit classes simply by loading the composer autoloader within your application.

If you want to benefit the full potential of Zemit, you can bootstrap your application using `\Zemit\Bootstrap`. Here is a minimalstic example of how to achieve this using [`\Phalcon\Autoload\Loader`](https://docs.phalcon.io/5.8/autoload/).

```php
// index.php
<?php

use Phalcon\Autoload\Loader;
use Zemit\Bootstrap;

$loader = new Loader();
$loader->setFiles(['vendor/autoload.php']);
$loader->setNamespaces(['MyApp' => 'src/']);
$loader->register();

echo (new Bootstrap())->run();
```

### Configuration
Zemit will automatically look for the `.env` from the root of your project. There you can add your own custom variables for your custom application or set the ones that are natively supported by Zemit.

Add the database config, note that we use dotenv to load the .env config. Simply add .env file to the root of your project.
```ini
# My App Config
MY_APP_VARIABLE="my-app-value"

# Example: Database Config
DATABASE_HOST=<my-db-host>
DATABASE_DBNAME=<my-db-name>
DATABASE_USERNAME=<my-db-user>
DATABASE_PASSWORD=<my-db-pass>
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
you can use apache, nginx or any similar production ready web servers.

You will need a Web server service to point to the `/public/` folder of your new project.
Here is virtual host example using apache 2.4 + php-fpm 8.4 from remi repository on Redhat.

```apacheconf
<VirtualHost *:80>
    ServerName domain.tld
    ServerAlias www.domain.tld
    DocumentRoot /mnt/hgfs/dev/zemit/core/public/
    
    <Directory /mnt/hgfs/dev/zemit/core/public/>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
    </Directory>
    
    <FilesMatch \.(php|phar)$>
        SetHandler "proxy:unix:/var/opt/remi/php84/run/php-fpm/www.sock|fcgi://localhost"
    </FilesMatch>
</VirtualHost>

<VirtualHost *:443>
    ServerName domain.tld
    ServerAlias www.domain.tld
    DocumentRoot /mnt/hgfs/dev/zemit/core/public/
    
    <Directory /mnt/hgfs/dev/zemit/core/public/>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
    </Directory>
    
    <FilesMatch \.(php|phar)$>
        SetHandler "proxy:unix:/var/opt/remi/php84/run/php-fpm/www.sock|fcgi://localhost"
    </FilesMatch>
    
    SetEnv HTTPS on
    SetEnv HTTP_X_FORWARDED_PROTO https
</VirtualHost>
```

## Requirements
Zemit Core is designed to work seamlessly with a specific set of technologies and PHP extensions to ensure optimal performance and functionality.

To check and install the necessary PHP extensions and manage Zemit’s dependencies, use Composer:

```bash
composer require zemit-cms/core
```

This command will automatically verify if your environment meets the requirements for running Zemit Core and install any missing dependencies.

By meeting these requirements, you can ensure a smooth and efficient experience with Zemit Core.

### Languages & Compatibilities

Zemit is built to be flexible and powerful, supporting a wide range of technologies and components. While we have certain core requirements, you have the freedom to integrate additional tools as per your project's needs.

- **[Composer](https://getcomposer.org/)**: Required for managing dependencies in Zemit. Composer simplifies the installation and update process of PHP packages, making it a vital tool for managing Zemit’s components.
- **[PHP](https://secure.php.net/) >= 8.4**: Essential for Zemit, PHP 8.4+ brings modern features and improved performance.
- **[PhalconPHP](https://phalconphp.com/) >= 5.9.3**: Our core framework. Phalcon's efficiency and rich feature set are crucial for Zemit's performance.
- **Database Flexibility**: While we recommend [MySQL](https://www.mysql.com/) >= 8.0 for its robustness, Zemit is compatible with other databases supported by Phalcon. This flexibility allows you to choose the database that best fits your project's requirements.
- **PSR Standards**: Compliance with PSR standards is mandatory, ensuring interoperability and standard coding practices.

Additionally, while not mandatory, the following are highly recommended for enhancing performance and functionality:

- **[Redis](https://redis.io/)**: Excellent for advanced caching mechanisms, session storage, and more.
- **[APCu](https://www.php.net/manual/en/book.apcu.php)**: Useful for opcode caching, reducing runtime for PHP scripts.
- **[Opcache](https://www.php.net/manual/en/book.opcache.php)**: Improves PHP performance by storing precompiled script bytecode.

By utilizing these technologies, Zemit offers a scalable, robust platform for developing web applications, giving you the flexibility to tailor the environment to your needs.

## Contact Information
Got questions, feedback, or need assistance with Zemit? We're here to help!

- **General Inquiries & Live Support**: If you have general questions or seek immediate assistance regarding Zemit, feel free to join our vibrant community on [Discord](https://discord.zemit.com). It’s the perfect place for real-time discussions, support, and advice from both the Zemit team and fellow users.
- **Community Support**: Join our community on [GitHub Discussions](https://discussions.zemit.com). It's a great place to seek help, share your Zemit experiences, and connect with fellow users and the development team.
- **Issue Reporting**: Encounter a bug or have a feature request? Please file a detailed report on our [GitHub Issues](https://github.com/zemit-cms/core/issues) page.
- **Social Media**: Follow us on [Twitter](https://twitter.zemit.com) and [Facebook](https://facebook.zemit.com) for the latest news, updates, and community discussions.

Your input and interactions are invaluable to Zemit’s ongoing development and success. Don't hesitate to reach out - we're always eager to hear from you!

## Contributing
We warmly welcome contributions to the Zemit project! Whether you're skilled in coding, documentation, design, or testing, your input can make a significant difference.

Here are some ways you can contribute:

- **Code Contributions**: Submit bug fixes, add new features, or enhance existing ones.
- **Documentation**: Improve or update the documentation to make Zemit more accessible to users.
- **Issue Reporting**: Report bugs or propose new ideas and enhancements.
- **Community Support**: Help new users by answering questions on our forums or social media channels.

To get started, please review our [CONTRIBUTING.md](https://github.com/zemit-cms/core/blob/master/CONTRIBUTING.md) guide. It covers everything you need to know about contributing to Zemit, including how to submit your changes and our coding standards.

Join us in shaping Zemit into an even more powerful and user-friendly CMS!

## License
Zemit is dedicated to open-source and community-driven development, proudly licensed under the BSD 3-Clause License. This license grants you broad freedom to use, modify, and distribute the software, ensuring that Zemit remains a community asset accessible to all.

We respect intellectual property and the efforts of contributors. As such, all use of Zemit should adhere to the conditions outlined in the license.

For the complete terms and conditions of the BSD 3-Clause License, please refer to our [LICENSE.txt](https://github.com/zemit-cms/core/blob/master/LICENSE.txt) file.

© 2017-present, Zemit Team. All rights reserved.
