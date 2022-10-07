<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Phalcon\Filter\Validation\Validator\Between;
use Zemit\Models\Base\AbstractPage;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

/**
 * Class Page
 *
 * @package Zemit\Models
 */
class Page extends AbstractPage
{
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();
        // @todo relationships
    }

    public function validation()
    {
        $validator = $this->genericValidation();
    
        $validator->add('siteId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('siteId', new Between([
            'minimum' => 0,
            'maximum' => self::MAX_UNSIGNED_INT,
            'message' => $this->_('not an unsigned integer'),
            'allowEmpty' => false,
        ]));
        
        $validator->add('label', new PresenceOf(['message' => $this->_('required')]));
    
        /**
         * We recommend keeping your headline at under or approximately 60 characters to fit Google results that have a
         * 600-pixel word limit and avoid truncation. Additionally, here are some other SEO best practices:
         * Always describe the page's content accurately.
         */
        $validator->add('title', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));
    
        /**
         * Meta descriptions can technically be any length, but Google generally truncates snippets to ~155-160 characters.
         * It's best to keep meta descriptions long enough that they're sufficiently descriptive,
         * so we recommend descriptions between 50 and 160 characters.
         */
        $validator->add('description', new Max(['max' => 200, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
