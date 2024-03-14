<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

use Phalcon\Autoload\Loader;

const APP_NAMESPACE = 'Zemit';
const ROOT_PATH = __DIR__ . '/';
const VENDOR_PATH = ROOT_PATH . 'vendor/';
const APP_PATH = ROOT_PATH . 'src/';
const CORE_PATH = ROOT_PATH . 'src/';
const STORAGE_PATH = ROOT_PATH . 'storage/';
const RESOURCES_PATH = ROOT_PATH . 'resources/';
const PUBLIC_PATH = ROOT_PATH . 'public/';

$loader = new Loader();
$loader->setFiles([VENDOR_PATH . '/autoload.php']);
$loader->setNamespaces([APP_NAMESPACE => APP_PATH]);
$loader->setFileCheckingCallback(null);
$loader->register();

return $loader;
