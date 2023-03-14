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
use Zemit\Bootstrap\Config;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Imap\ServiceProvider
 *
 * @package Zemit\Provider\Imap
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'imap';

    /**
     * {@inheritdoc}
     *
     * Register the Flash Service with the Twitter Bootstrap classes.
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            /** @var Config $config */
            $config = $di->get('config');

            $defaults = $config->path('imap')->toArray();

            return new \PhpImap\Mailbox(
                $defaults['path'] ?? '',
                $defaults['login'] ?? '',
                $defaults['password'] ?? '',
                $defaults['attachmentsDir'] ?? '',
                $defaults['serverEncoding'] ?? 'UTF-8',
                $defaults['trimImapPath'] ?? true,
                $defaults['attachmentFilenameMode'] ?? false,
            );
        });
    }
}
