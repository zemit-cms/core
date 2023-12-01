<?php

namespace Zemit\Mvc\Controller\Rest;

trait Allowed
{
    protected ?array $allowedSearchFields;
    
    protected ?array $allowedSaveFields;
    
    protected ?array $allowedFilterFields;
}
