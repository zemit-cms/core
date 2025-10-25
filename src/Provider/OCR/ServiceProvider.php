<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\OCR;

use Phalcon\Di\DiInterface;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'ocr';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), TesseractOCR::class);
    }
}
