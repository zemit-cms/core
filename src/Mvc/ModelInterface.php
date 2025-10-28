<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Phalcon\Mvc\ModelInterface as PhalconModelInterface;
use Zemit\Mvc\Model\Interfaces\AttributeInterface;
use Zemit\Mvc\Model\Interfaces\BehaviorInterface;
use Zemit\Mvc\Model\Interfaces\BlameableInterface;
use Zemit\Mvc\Model\Interfaces\EagerLoadInterface;
use Zemit\Mvc\Model\Interfaces\ExposeInterface;
use Zemit\Mvc\Model\Interfaces\HashInterface;
use Zemit\Mvc\Model\Interfaces\IdentityInterface;
use Zemit\Mvc\Model\Interfaces\InstanceInterface;
use Zemit\Mvc\Model\Interfaces\JsonInterface;
use Zemit\Mvc\Model\Interfaces\LocaleInterface;
use Zemit\Mvc\Model\Interfaces\MetaDataInterface;
use Zemit\Mvc\Model\Interfaces\OptionsInterface;
use Zemit\Mvc\Model\Interfaces\PositionInterface;
use Zemit\Mvc\Model\Interfaces\RelationshipInterface;
use Zemit\Mvc\Model\Interfaces\ReplicationInterface;
use Zemit\Mvc\Model\Interfaces\SecurityInterface;
use Zemit\Mvc\Model\Interfaces\SlugInterface;
use Zemit\Mvc\Model\Interfaces\SnapshotInterface;
use Zemit\Mvc\Model\Interfaces\SoftDeleteInterface;
use Zemit\Mvc\Model\Interfaces\ValidateInterface;

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
