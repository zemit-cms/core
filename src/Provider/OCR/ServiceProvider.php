<?php

namespace App\Provider\OCR;

use Phalcon\Di\DiInterface;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\OCR\ServiceProvider
 *
 * @link https://github.com/thiagoalessio/tesseract-ocr-for-php
 *
 * @package Zemit\Provider\OCR
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'ocr';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(DiInterface $di) : void
    {
        $di->setShared($this->getName(), TesseractOCR::class);
    }
}
