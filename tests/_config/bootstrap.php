<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

use Zemit\Bootstrap;

// Get the fallback root, vendor, app path and default app namespace
defined('VENDOR_PATH') || define('VENDOR_PATH', (getenv('VENDOR_PATH') ? getenv('VENDOR_PATH') : dirname(dirname(__DIR__)) . '/vendor'));
defined('APP_NAMESPACE') || define('APP_NAMESPACE', (getenv('APP_NAMESPACE') ? getenv('APP_NAMESPACE') : 'Zemit'));
defined('APP_PATH') || define('APP_PATH', (getenv('APP_PATH') ? getenv('APP_PATH') : dirname(dirname(__DIR__))  . '/src'));

// Register Composer Autoloader
var_dump(VENDOR_PATH . '/autoload.php');

$composer = require_once VENDOR_PATH . '/autoload.php';
$bootstrap = new Bootstrap();

// Run Zemit CMS
return $bootstrap->application;