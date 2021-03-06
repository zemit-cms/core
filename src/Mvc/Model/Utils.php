<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

/**
 * Trait Utils
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait Utils
{
    
    public static function _jsonEncode(&$object, $default = array(), $options = null)
    {

        // Encodage normal
        if (is_array($object) || is_object($object)) {
            $object = json_encode($object, $options);
        } else {
            // field is empty, default encode
            if (empty($object)) {
                $object = json_encode($default, $options);
            }
        }

        return $object;
    }
    
    /**
     * Encode en format JSON une variable passé par référence
     * seulement si c'est un objet ou un array
     * @param mixed array|object $objects
     * @param mixed array|object $default
     * @return mixed array|object du JSON de la variable $objects
     */
    public static function _jsonDecode(&$objects, $default = array(), $assoc = true)
    {

        // normal decode
        if (!empty($objects) && !(is_array($objects) || is_object($objects))) {
            $objects = json_decode($objects, $assoc);
        }

        // fix for double json encoding
        if (!empty($objects) && is_string($objects)) {
            $objects = json_decode($objects);
        }

        // default if decode is empty
        if (empty($objects)) {
            $objects = $default;
        }
        return $objects;
    }
    
    public static function _emptyNull(&$object, $default = null)
    {
        if (empty($object)) {
            $object = $default;
        }
        return $object;
    }
}
