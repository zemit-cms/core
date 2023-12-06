<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Zemit\Db\Column;
use Zemit\Models\Abstracts\AbstractEmail;
use Phalcon\Mailer\Manager;
use Phalcon\Messages\Message;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\Numericality;
use Zemit\Models\Interfaces\EmailInterface;

/**
 * @property Template $TemplateEntity
 * @property EmailFile $FileNode
 * @property File $FileList
 *
 * @method Template getTemplateEntity(?array $params = null)
 * @method EmailFile getFileNode(?array $params = null)
 * @method File getFileList(?array $params = null)
 */
class Email extends AbstractEmail implements EmailInterface
{
    protected $deleted = self::NO;
    protected $sent = self::NO;

    /**
     * @return mixed
     */
    public function setTemplateByIndex(?string $index = null)
    {
        $template = Template::findFirstByIndex($index);
        if ($template) {
            $this->setTemplateId((int)$template->getId());
            $this->syncTemplate($template);
        }

        return $template;
    }

    /**
     * Get Subject
     * - Interpolation
     *
     * @param array|null $meta
     */
    public function getSubject(array $meta = null)
    {
        $meta ??= $this->getMeta();

        return $this->cleanEmptyParameters($this->interpolate(parent::getSubject(), $meta));
    }

    /**
     * Get Content
     * - Interpolation
     *
     * @param array|null $meta
     */
    public function getContent(array $meta = null)
    {
        $meta ??= $this->getMeta();

        return $this->cleanEmptyParameters($this->interpolate(parent::getContent(), $meta));
    }

    /**
     * Method to set the value of field meta
     * - Json Encode Meta
     *
     * @param null $meta
     *
     * @return $this|Email
     */
    public function setMeta($meta = null)
    {
        return parent::setMeta($this->jsonEncode($meta));
    }

    /**
     * Returns the value of field meta
     * - Json Decode Meta
     */
    public function getMeta()
    {
        return $this->jsonDecode(parent::getMeta());
    }

    /**
     * Method to set the value of field bcc
     * - Json Encode Bcc
     *
     * @param null $bcc
     *
     * @return $this|Email
     */
    public function setBcc($bcc = null)
    {
        return parent::setBcc($this->jsonEncode($bcc));
    }

    /**
     * Returns the value of field bcc
     * - Json Decode Bcc
     */
    public function getBcc()
    {
        return $this->jsonDecode(parent::getBcc());
    }

    /**
     * Method to set the value of field cc
     * - Json Encode Cc
     *
     * @param null $cc
     *
     * @return $this|Email
     */
    public function setCc($cc = null)
    {
        return parent::setCc($this->jsonEncode($cc));
    }

    /**
     * Returns the value of field cc
     * - Json Decode Cc
     */
    public function getCc()
    {
        return $this->jsonDecode(parent::getCc());
    }

    /**
     * Method to set the value of field to
     * - Json Encode To
     *
     * @param null $to
     *
     * @return $this|Email
     */
    public function setTo($to = null)
    {
        return parent::setTo($this->jsonEncode($to));
    }

    /**
     * Returns the value of field to
     * - Json Decode To
     */
    public function getTo()
    {
        return $this->jsonDecode(parent::getTo());
    }

    /**
     * Method to set the value of field `from`
     * - Json Encode From
     *
     * @param null $from
     *
     * @return $this|Email
     */
    public function setFrom($from = null)
    {
        return parent::setFrom($this->jsonEncode($from));
    }

    /**
     * Returns the value of field `from`
     * - Json Decode From
     */
    public function getFrom()
    {
        return $this->jsonDecode(parent::getFrom());
    }

    /**
     * Method to set the value of field `read_receipt_to`
     * - Json Encode `ReadReceiptTo`
     *
     * @param null $readReceiptTo
     *
     * @return $this|Email
     */
    public function setReadReceiptTo($readReceiptTo = null)
    {
        return parent::setReadReceiptTo($this->jsonEncode($readReceiptTo));
    }

    /**
     * Returns the value of field `read_receipt_to`
     * - Json Decode `ReadReceiptTo`
     */
    public function getReadReceiptTo()
    {
        return $this->jsonDecode(parent::getReadReceiptTo());
    }

    /**
     * Initialize
     * - Relationships
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('templateId', Template::class, 'id', ['alias' => 'TemplateEntity']);
        $this->hasMany('id', EmailFile::class, 'emailId', ['alias' => 'FileNode']);

        $this->hasManyToMany('id', EmailFile::class, 'emailId',
            'fieldId', File::class, 'id', ['alias' => 'FileList']);
    }

    /**
     * Basic default validation
     * @return bool
     */
    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('templateId', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('uuid', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('uuid', new Uniqueness(['message' => $this->_('not-unique')]));
        $validator->add('uuid', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        $validator->add('from', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('from', new Max(['max' => 500, 'message' => $this->_('length-exceeded')]));
        $validator->add('to', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('subject', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('subject', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        $validator->add('content', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('sent', new Numericality(['message' => $this->_('not-numeric')]));

        $validator->add('viewPath ', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }

    /**
     * @TODO
     */
    public function prepareSave()
    {
        $this->setFrom(is_array($this->getFrom()) ? $this->jsonEncode($this->getFrom()) : $this->getFrom());
    }


    /**
     * Sync template data into this model
     * - Subject
     * - Content
     *
     * @param null $template
     */
    public function syncTemplate($template = null)
    {
        $template ??= $this->getTemplateEntity();

        $subject = $this->getSubject();
        $content = $this->getContent();

        if ($template) {
            if (empty($subject)) {
                $this->setSubject($template->getSubject());
            }
            if (empty($content)) {
                $this->setContent($template->getContent());
            }
        }
    }

    /**
     * Remove un-replaced {}
     *
     * @param $string
     *
     * @return array|mixed|string|string[]|\Traversable|null
     */
    public function cleanEmptyParameters($string, $regex = '/\{+([^\}]|)+\}+/im')
    {
        if (is_string($string)) {
            $string = preg_replace($regex, null, $string);
        }
        else if (is_array($string) || $string instanceof \Traversable) {
            foreach ($string as $key => $value) {
                $string[$key] = $this->cleanEmptyParameters($value);
            }
        }

        return $string;
    }

    /**
     * Interpolation
     *
     * @param $string
     * @param $meta
     *
     * @return array|string|string[]
     */
    public function interpolate($string, $meta)
    {
        $meta ??= $this->getMeta();

        if (is_string($string)) {
            $from = [];
            $to = [];
            self::loopMeta($from, $to, $meta);

            return str_replace($from, $to, $string);
        }
        if (is_array($string) || $string instanceof \Traversable) {
            foreach ($string as $key => $value) {
                $string[$key] = $this->interpolate($value, $meta);
            }
        }

        return $string;
    }

    /**
     * Send the email
     *
     * @return bool
     */
    public function send($force = false)
    {
        // skip or force resend
        if (!$force && $this->getSent()) {
            return false;
        }

        // Preparing message
        /** @var Manager $mailer */
        $mailer = $this->getDI()->get('mailer');
        $viewPath = $this->getViewPath();

        $config = $this->getDI()->get('config');
        $frontendPath = dirname($config->modules->frontend->path);
        $frontendViewPath = $frontendPath . '/Views/';

        // Set email entity into view parameter
        $params = ['email' => $this, 't' => $this->getTranslate()];

        // Append meta to view parameters
        $meta = $this->getMeta() ?: [];
        if (is_array($meta)) {
            foreach ($meta as $param => $object) {
                $params[$param] = $object;
            }
        }

        // Retrieve the message raw content
        $message = empty($viewPath) ? $mailer->createMessage()->content($this->getContent()) : $mailer->createMessageFromView('template/layout', $params, $frontendViewPath);

        $emails = [];
        foreach (['readReceiptTo', 'from', 'to', 'cc', 'bcc'] as $key) {
            $tmp = $this->{'get' . ucfirst($key)}();
            $tmp = is_array($tmp) ? $tmp : [$tmp];
            $emails[$key] = array_values(array_filter(array_unique($tmp))) ? : null;
        }

        // If from is empty, build it from the config
        if (empty($emails['from'])) {
            $from = $this->getDI()->get('config')->mailer->from;
            $this->setFrom([$from->email => $from->name]);
        }

        // Build the message
        $message->getMessage()
            ->setSubject($this->getSubject())
            ->setReadReceiptTo($this->getReadReceiptTo())
            ->setFrom($this->getFrom())
            ->setCc($this->getCc())
            ->setBcc($this->getBcc())
            ->setTo($this->getTo())
            ->setCharset('utf-8');

        //Attach file to email
        $emailFileNode = $this->getFileNode();
        foreach ($emailFileNode as $node) {
            /** @var File $file */
            $file = $node->getFile();

            if ($file) {
                if (file_exists($file->getFilePath())) {
                    $attachFile = \Swift_Attachment::fromPath($file->getFilePath());
                    $attachFile->setFilename($file->getName());
                    $message->getMessage()->attach($attachFile);
                }
            }
        }

        // Sending message
        $this->setSent($message->send());

        // Message not sent, append an error message
        if (!$this->getSent()) {
            $this->appendMessage(new Message('Message not sent', 'sent', 'NotSent', 400));
        }

        // Message sent, update time and sender identity
        else {
            $this->setSentAt(date(Column::DATETIME_FORMAT));
            $this->setSentBy($this->getCurrentUserId());
        }

        return (!$this->hasSnapshotData() || $this->hasChanged()) && $this->save();
    }
}
