<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Translate\Adapter;

use Phalcon\Translate\Adapter\AbstractAdapter;
use Phalcon\Translate\Exception;
use Phalcon\Translate\InterpolatorFactory;

class NestedNativeArray extends AbstractAdapter implements \ArrayAccess
{
    private array $translate = [];
    
    private bool $triggerError = false;
    
    protected string $delimiter = '.';
    
    /**
     * Zemit\Translate\Adapter\NestedNativeArray constructor
     *
     * @param InterpolatorFactory $interpolator
     * @param array $options [
     *     'content' => '',
     *     'triggerError' => false,
     *     'delimiter' => '.',
     * ]
     */
    public function __construct(InterpolatorFactory $interpolator, array $options)
    {
        parent::__construct($interpolator, $options);
        $this->delimiter = $options['delimiter'] ?? $this->delimiter;
        $this->triggerError = $options['triggerError'] ?? $this->triggerError;
        $this->translate = $options['content'] ?? $this->translate;
    }
    
    /**
     * Check whether is defined a translation key in the internal array
     * @deprecated
     */
    public function exists(string $index): bool
    {
        return $this->has($index);
    }
    
    /**
     * Check whether is defined a translation key in the internal array
     */
    public function has(string $index): bool
    {
        $translate = $this->translate;
        
        if (isset($translate[$index])) {
            return $translate[$index];
        }
        
        foreach (explode($this->delimiter, $index) as $nestedIndex) {
            
            if (is_array($translate) && array_key_exists($nestedIndex, $translate)) {
                $translate = $translate[$nestedIndex];
            }
            else {
                return false;
            }
        }
        
        return true;
    }
    
    public function notFound(string $index): string
    {
        if ($this->triggerError) {
            throw new Exception('Cannot find translation key: ' . $index);
        }
    
        return $index;
    }
    
    /**
     * Returns the translation related to the given key
     */
    public function query(string $translateKey, array $placeholders = []): string
    {
        $translate = $this->translate;
        
        if (isset($translate[$translateKey])) {
            return $translate[$translateKey];
        }
        
        foreach (explode($this->delimiter, $translateKey) as $nestedIndex) {
            
            if (is_array($translate) && array_key_exists($nestedIndex, $translate)) {
                $translate = $translate[$nestedIndex];
            }
            else {
                return $this->notFound($translateKey);
            }
        }
        
        return $this->replacePlaceholders($translate, $placeholders);
    }
}
