<?php

namespace Zemit\Config;

use Zemit\Bootstrap\Config;

/**
 * Class Config
 * - fix for phalcon migration script
 *
 * @package App\Config
 */
class Migration extends Config
{
    public function __construct($config = [])
    {
        $config = parent::__construct($config);
        $this->database = $this->database->drivers->{$this->database->default};
        unset($this->database->options);
    }
}

return new Migration();
