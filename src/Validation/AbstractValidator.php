<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Validation;

/**
 * Class AbstractValidator
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Validation
 */
abstract class AbstractValidator extends \Phalcon\Filter\Validation\AbstractValidator
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->setOptions($options);
    }
    
    public function setOptions(array $options = [])
    {
        foreach ($options as $key => $option) {
            $this->setOption($key, $option);
        }
    }
}
