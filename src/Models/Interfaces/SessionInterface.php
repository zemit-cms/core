<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models\Interfaces;

use Phalcon\Mvc\ModelInterface;
use Phalcon\Session\ManagerInterface;

interface SessionInterface extends AbstractInterface
{
    public static function findFirstByKey(?string $key = null): ?ModelInterface;
    
    public static function getSessionManager(): ManagerInterface;
    
    public static function isSessionAdapter(): bool;
    
    public function saveIntoSession(): bool;
    
    public function removeFromSession(): bool;
}
