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

namespace Zemit\Identity\Traits;

use Zemit\Di\AbstractInjectable;

trait Role
{
    use AbstractInjectable;
    
    /**
     * Check whether the current identity has roles
     */
    public function hasRole(?array $roles = null, bool $or = false, bool $inherit = true): bool
    {
        $roleList = array_keys($this->getRoleList());
        return $this->has($roles, $inherit? $this->getInheritedRoleList($roleList) : $roleList, $or);
    }
    
    /**
     * Check if the needles meet the haystack using nested arrays
     * Reversing ANDs and ORs within each nested subarray
     *
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), true); // 'dev' OR 'admin'
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), false); // 'dev' AND 'admin'
     *
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles()); // 'dev' AND 'admin'
     * $this->has([['dev', 'admin']], $this->getUser()->getRoles()); // 'dev' OR 'admin'
     * $this->has([[['dev', 'admin']]], $this->getUser()->getRoles()); // 'dev' AND 'admin'
     *
     * @param array|string|null $needles Needles to match and meet the rules
     * @param array $haystack Haystack array to search into
     * @param bool $or True to force with "OR" , false to force "AND" condition
     *
     * @return bool Return true or false if the needles rules are being met
     */
    public function has(array|string|null $needles = null, array $haystack = [], bool $or = false): bool
    {
        if (!is_array($needles)) {
            $needles = isset($needles) ? [$needles] : [];
        }
        
        $result = [];
        foreach ($needles as $needle) {
            if (is_array($needle)) {
                $result [] = $this->has($needle, $haystack, !$or);
            }
            else {
                $result [] = in_array($needle, $haystack, true);
            }
        }
        
        return $or ?
            !in_array(false, $result, true) :
            in_array(true, $result, true);
    }
    
    /**
     * Return the list of inherited role list (recursively)
     */
    public function getInheritedRoleList(array $roleIndexList = []): array
    {
        $inheritedRoleList = [];
        $processedRoleIndexList = [];
        
        // While we still have role index list to process
        while (!empty($roleIndexList)) {
            
            // Process role index list
            foreach ($roleIndexList as $roleIndex) {
                // Get inherited roles from config service
                
                $configRoleList = $this->config->path('permissions.roles.' . $roleIndex . '.inherit', false);
                
                if ($configRoleList) {
                    
                    // Append inherited role to process list
                    $roleList = $configRoleList->toArray();
                    $roleIndexList = array_merge($roleIndexList, $roleList);
                    $inheritedRoleList = array_merge($inheritedRoleList, $roleList);
                }
                
                // Add role index to processed list
                $processedRoleIndexList [] = $roleIndex;
            }
            
            // Keep the unprocessed role index list
            $roleIndexList = array_filter(array_unique(array_diff($roleIndexList, $processedRoleIndexList)));
        }
        
        // Return the list of inherited role list (recursively)
        return array_values(array_filter(array_unique($inheritedRoleList)));
    }
    
    
}
