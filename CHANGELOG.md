## ZEMIT CORE CHANGELOG

### TODO
- Adding @property in comments for injected services
- Adding multi-module support
- Stop relying on the Incubator or embracing it
- Implementing the Service Providers correctly
- Zemit version feature compatibility grid
- Zemit model wrappers for virtual databases
- Zemit Role-Based Access Control (RBAC)
- Zemit database Migration system
  - Structure
  - Data
  - Versionning
- Javascript server-side parser
  - Validators wrapper
  - Filters wrapper
  - Events wrapper
  - Exposing DI during js parsing
- API Module
  - Default endpoints and models
  - JS parser
- CLI Module
  - Default parameters and methods
  - Adding compatibility for phalcon 4+

### 0.4.0
- Changing library name to `Zemit Core`
- Supports for [PHP 7.2+](http://php.net/ChangeLog-7.php) and [Phalcon 4.0.x](https://github.com/phalcon/cphalcon/blob/master/CHANGELOG-4.0.md)
- Refactoring some class names and directories
- Changing namespace becomes `Zemit\` from `Zemit\Core\`
- Cleaning `composer.json`
- Adding Zemit Exception
  - Adding `Zemit\Exception` for generic exception
  - Adding `Zemit\Exception\HttpException` for http request exception
  - Adding `Zemit\Exception\Cli` for console exception
  - Adding `Zemit\Exception\Handler\ErrorPageHandler` to wrap Whoop error handling
  - Adding `Zemit\Exception\Handler\LoggerHandler` to wrap Whoop error handling
- Adding Zemit\Utils Functions
  - Adding `dd()` & `dump()`
  - Adding `getNamespace($class)` to get the current namespace of a class instance
- Implementing some Service Providers correctly
- Adding some part of the incubator inside the project
- Updating licenses for Zemit, Phalcon, PHP, Zend
- Adding support for custom app filters

### 0.3.0
- Adding new `Zemit\Events\EventsAwareTrait` trait
- Adding new `Zemit\Utils\Sprintf` class to use sprint functions using multibytes and arrays
- Adding new `Zemit\Utils\Slug` class to based on the incubator, generate slug for friendly url
- Adding new `Zemit\Utils\Env` class to manage the dotenv variables with magic calls
   * SET: `$this->SET_APPLICATION_ENV('production');`
   * SET: `self::SET_APPLICATION_ENV('production');`
   * SET: `Env::SET_APPLICATION_ENV('production');`
   * SET: `Env::set('APPLICATION_ENV', 'development')`
   * GET: `$this->GET_APPLICATION_ENV('development');`
   * GET: `self::GET_APPLICATION_ENV('development');`
   * GET: `Env::GET_APPLICATION_ENV('development');`
   * GET: `Env::get('APPLICATION_ENV', 'development')`

### 0.2.0
- Adding localization support with examples
- Adding attr support from in the Zemit\Tag service
- Adding features for the Assets manager Zemit\Assets\Manager
  - Version & FileTime stamper for the file name to handle client caching efficiently
  - Minifying support for JS & CSS so you can define which collection is minified
- Adding minifying support for the asset manager
- Adding `md5`, `ipv4`, `ipv6`, and `json` filters
  - `Zemit\Filters\Json` return null or the valid json
  - `Zemit\Filters\Md5` return md5 valid string
  - `Zemit\Filters\IPv4` filter using `filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);`
  - `Zemit\Filters\IPv6` filter using `filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);`
- Adding recursive iterator filters
  - `Zemit\Utils\RecursiveIterator\Filter\Files` to filter files only
  - `Zemit\Utils\RecursiveIterator\Filter\Folders` to filter folders only
  - `Zemit\Utils\RecursiveIterator\Filter\Visible` to filter visible files or folders only


### 0.1.0
- Preparing different core Modules (Backend, Frontend, Cli, Api)
- Bootstrapping App, Config, Modules, Router and Services
- Overriding some Phalcon classes to add the Zemit layer
- Allowing overrides for the bootstrap of the app
- Allowing custom classes to be used for the bootstrap
- Adding initialize method for the bootstrap
- Adding new events (before & after for the bootstrap methods)
  - `bootstrap:beforeDi` - `bootstrap:afterDi`
  - `bootstrap:beforeDotenv` - `bootstrap:afterDotenv`
  - `bootstrap:beforeApp` - `bootstrap:afterApp`
  - `bootstrap:beforeDebug` - `bootstrap:afterDebug`
  - `bootstrap:beforeConfig` - `bootstrap:afterConfig`
  - `bootstrap:beforeService` - `bootstrap:afterService`
  - `bootstrap:beforeApplication` - `bootstrap:afterApplication`
  - `bootstrap:beforeModule` - `bootstrap:afterModule`
  - `bootstrap:beforeRouter` - `bootstrap:afterRouter`
  - `bootstrap:beforeRun` - `bootstrap:afterRun`

### 0.0.0
- Adding licenses & useless stuff
- Preparing & planning stuff
- Creating domains, websites & plateformes
- Doing stuff