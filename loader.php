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

const APP_NAMESPACE = 'App';
const ROOT_PATH = __DIR__;
const VENDOR_PATH = ROOT_PATH . '/vendor';
const APP_PATH = ROOT_PATH . '/app';

$loader = new Loader();
$loader->setFiles([VENDOR_PATH . '/autoload.php']);
$loader->setNamespaces([APP_NAMESPACE => APP_PATH]);
$loader->setFileCheckingCallback(null);
$loader->register();

return $loader;
