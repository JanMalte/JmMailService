<?php
/**
 * Mail service
 *
 * PHP version 5.3
 *
 * Copyright 2014 Malte Gerth
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-13
 */

namespace JanMalte\JmMailService\Service;

use JanMalte\JmMailService\Options\MailService as MailServiceOptions;
use Zend\Mail\Message as MailMessage;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime as Mime;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Transport\Exception\RuntimeException as TransportRuntimeException;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Model\ViewModel;

/**
 * Mail service
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-13
 */
class Mail implements MailInterface
{

    /**
     * Mail service options
     *
     * @var MailServiceOptions
     */
    protected $mailServiceOptions;

    /**
     * Mail transport
     *
     * @var TransportInterface
     */
    protected $transport;

    /**
     * Renderer for the templates
     *
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * Mail message
     *
     * @var MailMessage
     */
    protected $mailMessage;

    /**
     * Mail message body
     *
     * @var MimeMessage
     */
    protected $mailBody;

    /**
     * Path to the view script to use as template for the mail message
     *
     * @var string
     */
    protected $template;

    /**
     * List of attachments
     *
     * @var array
     */
    protected $attachments = array();

    /**
     * Constructor
     *
     * @param MailServiceOptions $mailServiceOptions Mail service options
     * @param TransportInterface $transport          Mail transport to send mail message
     * @param RendererInterface  $renderer           Renderer instance to render the template
     */
    public function __construct(
        MailServiceOptions $mailServiceOptions,
        TransportInterface $transport,
        RendererInterface $renderer
    ) {
        $this->mailServiceOptions = $mailServiceOptions;
        $this->transport = $transport;
        $this->renderer = $renderer;
    }

    /**
     * Get the mail service options.
     *
     * @return MailServiceOptions
     */
    public function getMailServiceOptions()
    {
        return $this->mailServiceOptions;
    }

    /**
     * Get the mail transport.
     *
     * @return TransportInterface
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Get the view renderer.
     *
     * @return RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Get the mail message.
     *
     * CAUTION! The mail message body with be overwritten by the MimeMessage
     * returned from getMailBody(). Do not set the body yourself, it will break
     * the headers and lead to misfunction of the service.
     *
     * @return MailMessage
     */
    public function getMailMessage()
    {
        if (null == $this->mailMessage) {
            $mailMessage = new MailMessage();
            $mailMessage->setEncoding('UTF-8');
            $this->setMailMessage($mailMessage);
        }

        return $this->mailMessage;
    }

    /**
     * Get the mail body.
     *
     * @return MimeMessage
     */
    public function getMailBody()
    {
        if (null == $this->mailBody) {
            $this->setMailBody(new MimeMessage());
        }

        return $this->mailBody;
    }

    /**
     * Get the template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Get the attachments.
     *
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set the mail message.
     *
     * @param MailMessage $mailMessage Mail message
     *
     * @return Mail Provides a fluent interface
     */
    public function setMailMessage(MailMessage $mailMessage)
    {
        $this->mailMessage = $mailMessage;

        return $this;
    }

    /**
     * Set the mail body.
     *
     * @param MimeMessage $mailBody Mail body
     *
     * @return Mail Provides a fluent interface
     */
    public function setMailBody(MimeMessage $mailBody)
    {
        $this->mailBody = $mailBody;

        return $this;
    }

    /**
     * Set the template.
     *
     * @param string $template Template path
     *
     * @return Mail Provides a fluent interface
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Parse the template with the variables
     *
     * @param array   $variables (optional) Variables for the template
     * @param boolean $isHtml    (optional) Flag if the template contains HTML
     *
     * @return Mail Provides a fluent interface
     */
    public function parseTemplate($variables = array(), $isHtml = true)
    {
        // Create a new view model to render the template
        $view = new ViewModel();

        // Set the template and parameters
        $view->setTemplate($this->getTemplate())
             ->setVariables($variables);

        // Create a new MimeMessage part
        $messagePart = new MimePart($this->getRenderer()->render($view));
        $messagePart->charset = 'UTF-8';
        $messagePart->type = 'text/plain';
        if ($isHtml == true) {
            $messagePart->type = 'text/html';
        }

        // Set the message body
        $this->getMailBody()->addPart($messagePart);

        return $this;
    }

    /**
     * Add an attachment
     *
     * Attachments are added as an array with the file path as key and some
     * optional values as an array for the value.
     * The attachments are added to the message just before sending to reduce
     * memory usage.
     *
     * @param string $filePath
     * @param array  $options
     *
     * @return Mail Provides a fluent interface
     */
    public function addAttachment($filePath, array $options = array())
    {
        $this->attachments[$filePath] = $options;

        return $this;
    }

    /**
     * Send the message with the transport.
     *
     * The optional $transport parameter provides an easy way to use an other
     * transport for just one message.
     *
     * The method returns true if the mail could be send without an exception.
     * It doesn't mean the message could be delivered to the recipients.
     *
     * @param TransportInterface $transport (optional) Transport to use
     *
     * @return boolean
     */
    public function send(TransportInterface $transport = null)
    {
        // Prepare the mail message
        $this->prepareMailMessage();

        // Get the mail transport
        if (null == $transport) {
            $transport = $this->getTransport();
        }

        // Try to send the mail. Catch the transport runtime exception and
        // just return false, if sending the message failed.
        try {
            $transport->send($this->getMailMessage());
        } catch (TransportRuntimeException $exc) {
            // unused $exc
            return false;
        }

        return true;
    }

    /**
     * Reset the mail service to compose and send a new mail message.
     *
     * This method is NOT called after calling send(), as you may want to
     * change just some values instead of creating a complete new message
     *
     * @return Mail Provides a fluent interface
     */
    public function reset()
    {
        $this->mailBody = null;
        $this->mailMessage = null;
        $this->template = null;

        return $this;
    }

    /**
     * Prepare the mail message
     *
     * Set the mail body to the mail message
     *
     * @return void
     */
    protected function prepareMailMessage()
    {
        $this->loadAttachments();

        $this->getMailMessage()->setBody(
            $this->getMailBody()
        );

        // Set the default from address if not already set
        if (0 == $this->getMailMessage()->getFrom()->count()) {
            $this->getMailMessage()->setFrom(
                $this->getMailServiceOptions()->getDefaultFrom(),
                $this->getMailServiceOptions()->getDefaultFromName()
            );
        }
    }

    /**
     * Load the attachments
     *
     * @return void
     */
    protected function loadAttachments()
    {
        foreach ($this->getAttachments() as $filePath => $options) {
            // Create the attachment
            $attachment = new MimePart(file_get_contents($filePath));

            // Detect the attachments information
            $fileName = basename($filePath);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $filePath);

            // Set the attachment options
            if (!array_key_exists('type', $options)) {
                $options['type'] = $mimeType . '; name="' . $fileName . '"';
            }
            if (!array_key_exists('filename', $options)) {
                $options['filename'] = $fileName;
            }
            $this->setAttachmentOptions($attachment, $options);

            // Add the attachment
            $this->getMailBody()->addPart($attachment);
        }
    }

    /**
     * Set the options for an attachments
     *
     * @param MimePart $attachment Attachment
     * @param array    $options    Options to set
     *
     * @return void
     */
    protected function setAttachmentOptions(MimePart $attachment, array $options)
    {
        $attachment->filename = $options['filename'];
        $attachment->type = $options['type'];

        $attachment->encoding = Mime::ENCODING_BASE64;
        if (isset($options['encoding'])
            && is_string($options['encoding'])
        ) {
            $attachment->encoding = $options['encoding'];
        }

        $attachment->disposition = Mime::DISPOSITION_ATTACHMENT;
        if (isset($options['disposition'])
            && is_string($options['disposition'])
        ) {
            $attachment->disposition = $options['disposition'];
        }
    }
}
