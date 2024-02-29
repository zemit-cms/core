<?php

namespace Zemit\Mvc\Model;

use Phalcon\Messages\Message;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\RelationInterface;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Support\Collection\CollectionInterface;

/**
 * Interface for model relationship management
 */
interface RelationshipInterface
{
    public function setKeepMissingRelated(array $keepMissingRelated): void;
    
    public function getKeepMissingRelated(): array;
    
    public function getKeepMissingRelatedAlias(string $alias): bool;
    
    public function setKeepMissingRelatedAlias(string $alias, bool $keepMissing): void;
    
    public function getRelationshipContext(): string;
    
    public function setRelationshipContext(string $context): void;
    
    public function getDirtyRelated(): ?array;
    
    public function setDirtyRelated(?array $dirtyRelated = null): void;
    
    public function getDirtyRelatedAlias(string $alias): mixed;
    
    public function setDirtyRelatedAlias(string $alias, mixed $value): void;
    
    public function hasDirtyRelated(): bool;
    
    public function hasDirtyRelatedAlias(string $alias): bool;
    
    public function assignRelated(array $data, ?array $whiteList = null, ?array $dataColumnMap = null): ModelInterface;
    
    public function postSaveRelatedRecordsAfter(RelationInterface $relation, $relatedRecords, CollectionInterface $visited): ?bool;
    
    public function postSaveRelatedThroughAfter(RelationInterface $relation, $relatedRecords, CollectionInterface $visited): ?bool;
    
    public function getEntityFromData(array $data, array $configuration = []): ModelInterface;
    
    public function appendMessages(array $messages = [], ?string $context = null, ?int $index = 0): void;
    
    public function appendMessagesFromRecord($record, string $context = null, ?int $index = 0): void;
    
    public function appendMessagesFromResultset(?ResultsetInterface $resultset = null, ?string $context = null, ?int $index = 0): void;
    
    public function appendMessagesFromRecordList(?iterable $recordList = null, ?string $context = null, ?int $index = 0): void;
    
    public function rebuildMessageContext(Message $message, string $context): ?string;
    
    public function rebuildMessageIndex(Message $message, ?int $index): ?string;
    
    public function relatedToArray(?array $columns = null, bool $useGetter = true): array;
}
