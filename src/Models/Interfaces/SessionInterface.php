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
use Zemit\Models\Behaviors\BlameableInterface;

interface SessionInterface extends AbstractInterface, BlameableInterface
{
    public static function getSessionManager(): ManagerInterface;
    
    public static function useSessionManager(bool $useSessionManager): void;
    public static function isUsingSessionManager(): bool;
    
    public function setUserId($userId);
    public function getUserId();
    
    public function setAsUserId($asUserId);
    public function getAsUserId();
    
    public function setKey($key);
    public function getKey();
    
    public function setToken($token);
    public function getToken();
    
    public function setJwt($jwt);
    public function getJwt();
    
    public function setMeta($meta);
    public function getMeta();
    
    public function setDate($date);
    public function getDate();
    
    public static function findFirstByKey(?string $key = null): ?ModelInterface;
    
    public function saveToSession(): bool;
    public function removeFromSession(): bool;
}
