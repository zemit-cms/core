<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Autoload;

use Phalcon\Autoload\Exception;

/**
 * Class Loader
 *
 * This class extends the \Phalcon\Autoload\Loader class and disable file checking callback for better performance.
 *
 * @throws Exception Throws an exception if initialization fails.
 */
class Loader extends \Phalcon\Autoload\Loader
{
    /**
     * @throws Exception
     */
    public function __construct(bool $isDebug = false)
    {
        parent::__construct($isDebug);
        
        // Do not check file existence.
        $this->setFileCheckingCallback(null);
    }
}
