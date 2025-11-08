<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc;

use Phalcon\Mvc\ModelInterface as PhalconModelInterface;
use PhalconKit\Mvc\Model\Interfaces\AttributeInterface;
use PhalconKit\Mvc\Model\Interfaces\BehaviorInterface;
use PhalconKit\Mvc\Model\Interfaces\BlameableInterface;
use PhalconKit\Mvc\Model\Interfaces\EagerLoadInterface;
use PhalconKit\Mvc\Model\Interfaces\ExposeInterface;
use PhalconKit\Mvc\Model\Interfaces\HashInterface;
use PhalconKit\Mvc\Model\Interfaces\IdentityInterface;
use PhalconKit\Mvc\Model\Interfaces\InstanceInterface;
use PhalconKit\Mvc\Model\Interfaces\JsonInterface;
use PhalconKit\Mvc\Model\Interfaces\LocaleInterface;
use PhalconKit\Mvc\Model\Interfaces\MetaDataInterface;
use PhalconKit\Mvc\Model\Interfaces\OptionsInterface;
use PhalconKit\Mvc\Model\Interfaces\PositionInterface;
use PhalconKit\Mvc\Model\Interfaces\RelationshipInterface;
use PhalconKit\Mvc\Model\Interfaces\ReplicationInterface;
use PhalconKit\Mvc\Model\Interfaces\SecurityInterface;
use PhalconKit\Mvc\Model\Interfaces\SlugInterface;
use PhalconKit\Mvc\Model\Interfaces\SnapshotInterface;
use PhalconKit\Mvc\Model\Interfaces\SoftDeleteInterface;
use PhalconKit\Mvc\Model\Interfaces\ValidateInterface;

interface ModelInterface extends
    AttributeInterface,
    BehaviorInterface,
    BlameableInterface,
    EagerLoadInterface,
    ExposeInterface,
    HashInterface,
    IdentityInterface,
    InstanceInterface,
    JsonInterface,
    LocaleInterface,
    MetaDataInterface,
    OptionsInterface,
    PositionInterface,
    RelationshipInterface,
    ReplicationInterface,
    SecurityInterface,
    SlugInterface,
    SnapshotInterface,
    SoftDeleteInterface,
    ValidateInterface,
    PhalconModelInterface
{
}
