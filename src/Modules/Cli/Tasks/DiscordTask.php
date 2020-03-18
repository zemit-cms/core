<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Phalcon\Queue\Beanstalk;
use Zemit\Console\AbstractTask;
use Zemit\Discord\DiscordComponent;

class DiscordTask extends AbstractTask
{
    /**
     * @Doc("Send notifications to the Discord")
     */
    public function send()
    {
        $queue = container('queue');
        if (!$queue instanceof Beanstalk) {
            $this->output('This task does not works with Fake queue adapter.');
            $this->output('Exit...');
            return;
        }

        $queue->watch('discord');

        /** @var DiscordComponent $discordService */
        $discordService = container('discord');

        $discord = new \Discord\Discord(
            [
                'token' => $discordService->getToken(),
            ]
        );

        $discord->loop->addPeriodicTimer(
            5,
            function () use ($queue, $discord, $discordService) {
                $guild = $discord->guilds->get('id', $discordService->getGuildId());

                if (!is_object($guild)) {
                    throw new \RuntimeException("Looks like you didn't add bot to your guild.");
                }

                $channel = $guild->channels->get('id', $discordService->getChannelId());

                while ($queue->statsTube('discord')["current-jobs-ready"] > 0 && ($job = $queue->reserve())) {
                    $body = $job->getBody();

                    if (empty($body['message']) || empty($body['embed'])) {
                        container('logger', ['discord'])->error('Looks like response is broken. Message: {message}', [
                            'message' => json_encode($body)
                        ]);
                        $job->delete();
                        continue;
                    }

                    $channel->sendMessage($body['message'], false, $body['embed']);
                    $job->delete();
                }
            }
        ); // each 5 seconds get jobs from queue and send to channel

        $discord->on(
            'ready',
            function () {
                // we don't listen anything so we don't need it
            }
        );

        $discord->run();
    }
}
