<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Interfaces;

use Zemit\Db\Column;
use Zemit\Filter\Validation;

interface ValidateInterface
{
    public function genericValidation(?Validation $validator = null): Validation;
    
    public function addNotEmptyValidation(Validation $validator, array|string $field, bool $allowEmpty = false): Validation;
    
    public function addPresenceValidation(Validation $validator, array|string $field, bool $allowEmpty = true): Validation;
    
    public function addUnsignedIntValidation(Validation $validator, array|string $field = 'id', bool $allowEmpty = true): Validation;
    
    public function addUnsignedBigIntValidation(Validation $validator, array|string $field = 'id', bool $allowEmpty = true): Validation;
    
    public function addNumberValidation(Validation $validator, array|string $field, int $min, int $max, bool $allowEmpty = true): Validation;
    
    public function addStringLengthValidation(Validation $validator, array|string $field, int $minChar = 0, int $maxChar = 255, bool $allowEmpty = true): Validation;
    
    public function addInclusionInValidation(Validation $validator, array|string $field, array $domainList = [], bool $allowEmpty = true): Validation;
    
    public function addBooleanValidation(Validation $validator, array|string $field, bool $allowEmpty = true): Validation;
    
    public function addInclusionValidation(Validation $validator, array|string $field, array $domain = [], bool $allowEmpty = true, bool $strict = true): Validation;
    
    public function addUniquenessValidation(Validation $validator, string|array $field, bool $allowEmpty = true): Validation;
    
    public function addEmailValidation(Validation $validator, array|string $field, bool $allowEmpty = true): Validation;
    
    public function addDateValidation(Validation $validator, array|string $field, bool $allowEmpty = true, string $format = Column::DATE_FORMAT): Validation;
    
    public function addDateTimeValidation(Validation $validator, array|string $field, bool $allowEmpty = true, string $format = Column::DATETIME_FORMAT): Validation;
    
    public function addJsonValidation(Validation $validator, array|string $field, bool $allowEmpty = true, int $depth = 512, int $flags = 0): Validation;
    
    public function addColorValidation(Validation $validator, array|string $field, bool $allowEmpty = true): Validation;
    
    public function addIdValidation(Validation $validator, string $field = 'id'): Validation;
    
    public function addPositionValidation(Validation $validator, string $field = 'position', bool $allowEmpty = true): Validation;
    
    public function addSoftDeleteValidation(Validation $validator, string $field = 'deleted', bool $allowEmpty = true): Validation;
    
    public function addUuidValidation(Validation $validator, string $field = 'uuid', bool $allowEmpty = false): Validation;
    
    public function addCrudValidation(Validation $validator, string $userIdField, string $dateField, bool $allowEmpty = true): Validation;
    
    public function addCreatedValidation(Validation $validator, string $createdByField = 'createdBy', string $createdAtField = 'createdAt', bool $allowEmpty = true): Validation;
    
    public function addUpdatedValidation(Validation $validator, string $updatedByField = 'updatedBy', string $updatedAtField = 'updatedAt', bool $allowEmpty = true): Validation;
    
    public function addDeletedValidation(Validation $validator, string $deletedField = 'deletedBy', string $dateField = 'deletedAt', bool $allowEmpty = true): Validation;
    
    public function addRestoredValidation(Validation $validator, string $restoredByField = 'restoredBy', string $restoredAtField = 'restoredAt', bool $allowEmpty = true): Validation;
}
