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

// Set your default path and namespace
const VENDOR_PATH = __DIR__ . '/../vendor/';
const APP_PATH = __DIR__ . '/../src/';

// Register autoloader and run bootstrap
$composer = require_once VENDOR_PATH . 'autoload.php';
echo (new Bootstrap(Bootstrap::MODE_MVC))->run();
