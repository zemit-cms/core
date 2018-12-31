# Zemit Core

[![Travis Build Status](https://secure.travis-ci.org/zemit-official/cms.png)](http://travis-ci.org/zemit-official/cms-core?branch=master)
[![CircleCI Build Status](https://circleci.com/gh/zemit-official/cms.png)](https://circleci.com/gh/zemit-official/cms-core)
[![Coverage Status](https://coveralls.io/repos/zemit-official/cms/badge.png)](https://coveralls.io/r/zemit-official/cms-core)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zemit-official/cms/badges/quality-score.png)](https://scrutinizer-ci.com/g/zemit-official/cms-core/)
[![Latest Stable Version](https://poser.pugx.org/zemit-official/cms/v/stable.png)](https://packagist.org/packages/zemit-official/cms-core)
[![Total Downloads](https://poser.pugx.org/zemit-official/cms/downloads.png)](https://packagist.org/packages/zemit-official/cms-core)

Core library of the Zemit application that mostly handle the backend part.
This library is using modules and a generic routing system but also allows the application to be highly customized.

## Contents

- [Get Started](#get-started)
- [Requirements](#requirements)
- [External Links](#external-links)
- [Contributing](#contributing)
- [Sponsors](#sponsors)
- [Backers](#backers)
- [License](#license)
  
## Get Started

Zemit is using the [Phalcon Framework](https://phalconphp.com) which is written in [Zephir/C](https://zephir-lang.com/) with platform independence in mind.
As a result, Phalcon is available on Microsoft Windows, GNU/Linux, FreeBSD and MacOS.
You can either download a binary package for the system of your choice or build it from source.

You can use [composer](https://getcomposer.org/) `composer require zemit-official/cms-core` in order to add Zemit core to an existing project. If you want to create a new project from srtach, we invite you to visit the [Zemit App](https://github.com/zemit-official/cms) repository for more informations.
    
tldr; `composer create-project zemit-official/cms` will include the core and more tools

## Requirements

In order to run Zemit Core, you have to use multiple PHP extensions. We strongly suggest to use `composer` as it will check the requirements in order to run Zemit Core correctly.

#### Languages & compatibilities
- [PHP](https://secure.php.net/) >=7.2
- [MySQL](https://www.mysql.com/) >=5.7
- [PhalconPHP](https://phalconphp.com/) ~4.0
- [V8JS (PHP)](https://github.com/phpv8/v8js/) ~2.1

## Contributing

See [CONTRIBUTING.md](https://github.com/zemit-official/zemit/blob/master/CONTRIBUTING.md) for details.

## External Links

* [Zemit Website](https://www.zemit.com)
* [Zemit Documentation](https://docs.zemit.com)
* [Zemit Support](https://forum.zemit.com)
* [Phalcon Framework](https://phalconphp.com)
* [Zephir Language](https://zephir-lang.com)
* [Twitter](https://twitter.zemit.com)
* [Facebook](https://facebook.zemit.com)


## License

Zemit is open source software licensed under the BSD 3-Clause License.
Copyright © 2017-present, Zemit Team.<br>
See the [LICENSE.txt](https://github.com/zemit-official/zemit/blob/master/LICENSE.txt) file for more.