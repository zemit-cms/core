<?php

namespace Zemit\Core\Bootstrap;

// phalcon
use Phalcon\DI\FactoryDefault;
use Phalcon\Di\Injectable;
use Phalcon\Mvc\View\Simple;
use Phalcon\Security;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mailer\Manager as MailerManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as FlashSession;

// zemit
use Zemit\Core\Assets\Manager as AssetsManager;
use Zemit\Core\Db\Profiler as DbProfiler;
use Zemit\Core\Db\Logger as DbLogger;
use Zemit\Core\Mvc\View;
use Zemit\Core\Mvc\View\Error as ViewError;
use Zemit\Core\Mvc\Dispatcher\Error as DispatchError;
use Zemit\Core\Mvc\Dispatcher\Security as DispatchSecurity;
use Zemit\Core\Mvc\Dispatcher\Camelize as DispatchCamelize;
use Zemit\Core\Mvc\Dispatcher\Rest as DispatchRest;
//use Zemit\Core\Filter;
//use Zemit\Core\Tag;
//use Zemit\Core\Zemit;

class Services extends Injectable {
    
    public function __construct(FactoryDefault $di, Config $config = null)
    {
        parent::__construct();
        
        /**
         * Configuration objet pour récupérer certaines configuration
         * @var \Phalcon\Config
         */
        $di->setShared('config', $config);
    
        /**
         * Registering a router
         */
        $di->setShared('router', function () {
            $router = new Router();
            $router->setDefaultModule('frontend');
            $router->setDefaultNamespace('Zemit\\Frontend\\Controllers');
            return $router;
        });
        
        /**
         * URL component utilisé pour générer les URL dans l'application
         * - Configuration du baseUri par défaut
         * (au cas ou l'application serait dans un path spécifique /zemit/sports/)
         * @var \Phalcon\Mvc\Url
         */
        $di->setShared('url', function () use ($config) {
            $url = new Url();
            $url->setBaseUri($config->application->baseUri);
            return $url;
        });
        
        /**
         * View component utilisé pour générer les vues dans l'application avec un engin spécifique
         * @var \Phalcon\Mvc\View
         */
        $di->setShared('view', function () use ($di, $config) {
            // Get the events manager
            $eventsManager = $di->getShared('eventsManager');
            
            $error = new ViewError($di);
            $eventsManager->attach('view', $error);
            
            $view = new View();
            $view->setMinify(true);
            $view->setViewsDir($config->application->viewsDir);
            $view->registerEngines(array(
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
            ));
            
            $view->setEventsManager($eventsManager);
            
            return $view;
        });
        
        /**
         * Enregistrement du dispatcher
         * - Camelize l'action
         * - Gestion de la Securité
         * - Gestion des erreurs
         * - Valeurs par défaut
         *
         * @var \Phalcon\Mvc\Dispatcher
         */
        $di->setShared('dispatcher', function() use ($di, $config) {
            
            // Get the events manager
            $eventsManager = $di->getShared('eventsManager');
            
            /**
             * Camelize dispatcher
             */
            $camelize = new DispatchCamelize($di);
            $eventsManager->attach('dispatch', $camelize);
            
            /**
             * Security dispatcher
             */
//            $security = new DispatchSecurity($di);
//            $eventsManager->attach('dispatch', $security);
            
            /**
             * Rest dispatcher
             */
            $rest = new DispatchRest($di);
            $eventsManager->attach('dispatch', $rest);
            
            /**
             * Error dispatcher
             */
//            $error = new DispatchError($di);
//            $eventsManager->attach('dispatch', $error);
            
            // Setup the dispatcher
            $dispatcher = new Dispatcher();
            
            // Attach the events manager
            $dispatcher->setEventsManager($eventsManager);
            
            // Setup the default namespace
            $dispatcher->setDefaultNamespace('Zemit\\Controllers');
            
            return $dispatcher;
        });
        
        /**
         * Profilage de certaines requêtes (SQL et APIs Google dans notre cas)
         * @var \Phalcon\Db\Profiler
         */
        $di->setShared('profiler', function() {
            return new \Phalcon\Db\Profiler();
        });
        
        /**
         * Enregistrement de l'adapteur de base de données
         * @var Phalcon\Db\Adapter\Pdo\Mysql
         */
        $di->setShared('db', function() use ($config, $di) {
            
            // Récupère le gestionnaire d'évennement
            $eventsManager = $di->getShared('eventsManager');
            
            /**
             * DB Profiler
             */
            $profiler = new DbProfiler();
            $eventsManager->attach('db', $profiler);
            
            /**
             * DB Logger
             */
//            $logger = new DbLogger();
//            $eventsManager->attach('db', $logger);
            
            
            // Configure l'adapteur de la BD
            $connection = new DbAdapter($config->database->toArray());
            
            // Attache le gestionnaire d'évennement à l'adapteur de la BD
            $connection->setEventsManager($eventsManager);
            
            return $connection;
        });
    
        $di->setShared('cookies', function () {
            $cookies = new Cookies();
            $cookies->useEncryption(true);
            return $cookies;
        });
        
        /**
         * Session component pour gérer les sessions à partir de l'adapteur de session par fichier
         * @var \Phalcon\Session\Adapter\Files
         */
        $di->setShared('session', function () {
            $session = new SessionAdapter();
            if (!$session->isStarted()) {
                $session->start();
            }
            return $session;
        });
        
        /**
         * Enregistrer le service de filtres
         * @var \Zemit\FilterBase
         */
        $di->setShared('filter', function() {
            return new Filter();
        });
        
        /**
         * Enregistrer le service de tags
         * @var \Zemit\Tag
         */
        $di->setShared('tag', function() {
            return new Tag();
        });
        
        /**
         * Enregistre le service d'assets
         * @var \Zemit\Assets\Manager
         */
        $di->setShared('assets', function () {
            return new AssetsManager();
        });
        
        /**
         * Swift Mailer Manager
         * @link http://swiftmailer.org/
         */
        $di->setShared('mailer', function() use ($config) {
            new SwiftLoader();
            return new MailerManager($config->mail->toArray());
        });
        
        /**
         * Security service
         */
        $di->setShared('security', function () use ($config) {
            $security = new Security();
            if (!empty($config->security->workfactor)) {
                $security->setWorkFactor($config->security->workfactor);
            }
            return $security;
        });
    
        /**
         * Cache service
         */
        $di->setShared('cache', function () {
        
            // cache for 2 days
            $frontCache = new \Phalcon\Cache\Frontend\Data(array(
                'lifetime' => 172800
            ));
        
            if (class_exists('\Memcached')) {
                return new \Phalcon\Cache\Backend\Libmemcached($frontCache, [
                    'servers' => [[
                        'host' => '172.19.0.24',
                        'port' => 11211,
                        'weight' => 1
                    ]],
                    "statsKey" => "_PHCM"
                ]);
            }
            elseif (class_exists('\Memcache')) {
                return new \Phalcon\Cache\Backend\Memcache($frontCache, ["statsKey" => "_PHCM"]);
            }
            elseif (class_exists('\APCIterator')) {
                return new \Phalcon\Cache\Backend\Apc($frontCache);
            }
            elseif (class_exists('\APCUIterator')) {
                //@TODO APCU Phalcon Cache Backend
            }
        
        });
        
//        /**
//         * Zemit service
//         */
//        $di->setShared('zemit', function () {
//            $zemit = new Zemit();
//            return $zemit;
//        });
        
        
        /**
         * SimplePie service
         */
        $di->setShared('rss', function () use ($config) {
            $rss = new \SimplePie();
//            $rss->set_cache_location($config->application->cacheDir);
            $rss->enable_cache(false);
            return $rss;
        });
        
        
    }
}