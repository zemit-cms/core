<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Imap;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'imap';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?array $options = null) use ($di) {
    
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
    
            $options ??= $config->pathToArray('imap', []);

            return new \PhpImap\Mailbox(
                $options['path'] ?? '',
                $options['login'] ?? '',
                $options['password'] ?? '',
                $options['attachmentsDir'] ?? '',
                $options['serverEncoding'] ?? 'UTF-8',
                $options['trimImapPath'] ?? true,
                $options['attachmentFilenameMode'] ?? false,
            );
        });
    }
}
