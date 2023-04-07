<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

use Phalcon\Loader;

// Set your default path and namespace
const VENDOR_PATH = __DIR__ . '/../vendor/';
const APP_PATH = __DIR__ . '/../src/';

$loader = new Loader();
$loader->registerFiles([VENDOR_PATH . 'autoload.php']);
$loader->registerNamespaces(['Zemit' => APP_PATH]);
$loader->register();

echo (new Zemit\Bootstrap(Zemit\Bootstrap::MODE_MVC))->run();
