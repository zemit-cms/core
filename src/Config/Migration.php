<?php

namespace Zemit\Config;

use Zemit\Bootstrap\Config;

/**
 * Class Config
 * Configuration collection extending the base config
 * Added a fix for the phalcon migration commands
 * Presetting the database driver and removing options
 *
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package App\Config
 */
class Migration extends Config
{
    /**
     * Migration constructor.
     * {@inheritDoc}
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->fixDatabaseForPhalconScripts();
    }
    
    /**
     * Fix the current config to be supported by native Phalcon scripts
     */
    public function fixDatabaseForPhalconScripts() {
        if ($this->has('database.default')) {
            $default = $this->get('database.default');
        
            if ($this->has('database.drivers.' . $default)) {
                $database = $this->get('database.drivers' . $default);
            
                $this->set('database', $database);
            }
        }
    
        $this->remove('database.options');
    
        // @todo test and remove this part
//        $this->database = $this->database->drivers->{$this->database->default};
//        unset($this->database->options);
    }
}

return new Migration();
