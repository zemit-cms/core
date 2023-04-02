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

interface AuditInterface extends AbstractInterface
{
    public function setId($id);
    public function getId();

    public function setParentId($parentId);
    public function getParentId();

    public function setModel($model);
    public function getModel();

    public function setTable($table);
    public function getTable();

    public function setPrimary($primary);
    public function getPrimary();

    public function setEvent($event);
    public function getEvent();

    public function setColumns($columns);
    public function getColumns();

    public function setBefore($before);
    public function getBefore();

    public function setAfter($after);
    public function getAfter();
}
