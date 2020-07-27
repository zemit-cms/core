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

use Zemit\Models\Base\AbstractEmail;
use Phalcon\Mailer\Manager;
use Phalcon\Messages\Message;
use Phalcon\Text;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Email
 *
 * @package Zemit\Models
 */
class Email extends AbstractEmail
{
    protected $deleted = self::NO;
    protected $sent = self::NO;

    /**
     * @param string|null $index
     *
     * @return mixed
     */
    public function setTemplateByIndex(string $index = null)
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
        return $this->interpolate(parent::getSubject(), $meta);
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
        return $this->interpolate(parent::getContent(), $meta);
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
     * Initialize
     * - Relationships
     */
    public function initialize()
    {
        parent::initialize();
        
        $this->hasOne('templateId', Template::class, 'id', ['alias' => 'Template']);
    }
    
    /**
     * Basic default validation
     * @return bool
     */
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $validator->add('template_id', new PresenceOf(['message' => $this->_('templateIdRequired')]));
        $validator->add('to', new PresenceOf(['message' => $this->_('toRequired')]));
        $validator->add('subject', new PresenceOf(['message' => $this->_('subjectRequired')]));
        $validator->add('subject', new Max(['max' => 240, 'message' => $this->_('subjectLengthExceeded'), 'included' => true]));
        $validator->add('content', new PresenceOf(['message' => $this->_('contentRequired')]));
        $validator->add('from', new PresenceOf(['message' => $this->_('fromRequired')]));
        
        return $this->validate($validator);
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
        $template ??= $this->getTemplate();
        
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
     * Interpolation
     *
     * @param $subject
     * @param $meta
     *
     * @return array|string|string[]
     */
    public function interpolate($subject, $meta)
    {
        $meta ??= $this->getMeta();
        
        if (is_string($subject)) {
            $from = [];
            $to = [];
            self::loopMeta($from, $to, $meta);
            
            return str_replace($from, $to, $subject);
        }
        if (is_array($subject)) {
            foreach ($subject as $key => $value) {
                $subject[$key] = $this->interpolate($value, $meta);
            }
        }
        
        return $subject;
    }
    
    /**
     * Prépare les array $from et $to pour remplacer les champs par référence
     *
     * @param array &$from
     * @param array &$to
     * @param array|object $meta
     * @param array $metaIndex
     *
     * @access private
     */
    public static function loopMeta(&$from, &$to, $meta, $metaIndex = [])
    {
        if (is_array($meta) || is_object($meta)) {
            foreach ($meta as $key => $value) {
                $newMetaIndex = array_merge($metaIndex, [$key]);
                if (is_array($key) || is_object($key)) {
                    self::loopMeta($from, $to, $value, $newMetaIndex);
                }
                else {
                    $from [] = '{' . mb_strtolower(Text::uncamelize(implode('.', $newMetaIndex))) . '}';
                    $to [] = empty($meta_valeur) ? null : $value;
                }
            }
        }
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
        $message = empty($viewPath) ? $mailer->createMessage()->content($this->getContent()) : $mailer->createMessageFromView($viewPath, ['email' => $this]);
        
        $emails = [];
        foreach (['readReceiptTo', 'from', 'to', 'cc', 'bcc'] as $key) {
            $emails[$key] = array_values(array_filter(array_unique(explode(',', $this->{'get' . ucfirst($key)}())))) ? : null;
        }
        
        // If from is empty, build it from the config
        if (empty($emails['from'])) {
            $from = $this->getDI()->get('config')->mailer->from;
            $this->setFrom("'{$from->name}' <{$from->email}>");
            $emails['from'] = [$from->email => $from->name];
        }
        
        // Build the message
        $message->getMessage()
            ->setSubject($this->getSubject())
            ->setReadReceiptTo($emails['readReceiptTo'])
            ->setFrom($emails['from'])
            ->setCc($emails['cc'])
            ->setBcc($emails['bcc'])
            ->setTo($emails['to'])
            ->setCharset('utf-8');
        
        // Sending message
        $this->setSent($message->send());
        
        // Message not sent, append an error message
        if (!$this->getSent()) {
            $this->appendMessage(new Message('Message not sent', 'sent', 'NotSent', 400));
        }
        
        // Message sent, update time and sender identity
        else {
            $this->setSentAt(date(self::DATETIME_FORMAT));
            $this->setSentBy($this->getCurrentUserId());
        }
        
        return !$this->hasSnapshotData() || $this->hasChanged() ? $this->save() : false;
    }
}
