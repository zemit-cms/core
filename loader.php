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

const APP_NAMESPACE = 'Zemit';
const ROOT_PATH = __DIR__;
const VENDOR_PATH = ROOT_PATH . '/vendor';
const APP_PATH = ROOT_PATH . '/src';

$loader = new Loader();
$loader->registerFiles([VENDOR_PATH . '/autoload.php']);
$loader->registerNamespaces([APP_NAMESPACE => APP_PATH]);
$loader->register();

return $loader;
