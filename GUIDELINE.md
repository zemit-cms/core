# Guidelines

## PHP Standard Recommendation 
Zemit recommends following and using the PHP-FIG PSR (PHP Standard Recommendation)
- https://www.php-fig.org/psr/

## Zemit Documentation
Zemit uses Phalcon 4 and is just an extension to add new features. Everything can be bypassed if required.

## Phalcon 4 Documentation
- https://docs.phalcon.io/4.0/en/introduction

## Zemit Specific Standard Recommendation
- Never use "Transaction" as an alias for the Model Relationships
- Never use "WriteConnection" as an alias or property inside a Model
- Never use "ReadConnection" as an alias or property inside a Model
- Never allow primary key modification "ID" within the whitelist
- UserID allow for admin and dev only and force UserID using the identity service

## Phalcon Specific Standard Recommendation
- Never use the same name for an alias and a property
- Always add "List" at the end of the Relation alias (many)
- Always add "Entity" at the end of the Relation alias (single)
