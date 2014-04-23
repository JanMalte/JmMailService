<?php
/**
 * Mail service interface
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
use Zend\Mail\Transport\TransportInterface;
use Zend\View\Renderer\RendererInterface;

/**
 * Mail service interface
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-13
 */
interface MailInterface
{

    /**
     * Get the mail service options.
     *
     * @return MailServiceOptions
     */
    public function getMailServiceOptions();

    /**
     * Get the mail transport.
     *
     * @return TransportInterface
     */
    public function getTransport();

    /**
     * Get the view renderer.
     *
     * @return RendererInterface
     */
    public function getRenderer();

    /**
     * Get the mail message.
     *
     * CAUTION! The mail message body with be overwritten by the MimeMessage
     * returned from getMailBody(). Do not set the body yourself, it will break
     * the headers and lead to misfunction of the service.
     *
     * @return MailMessage
     */
    public function getMailMessage();

    /**
     * Get the mail body.
     *
     * @return MimeMessage
     */
    public function getMailBody();

    /**
     * Get the template.
     *
     * @return string
     */
    public function getTemplate();

    /**
     * Get the attachments.
     *
     * @return array
     */
    public function getAttachments();

    /**
     * Set the mail message.
     *
     * @param MailMessage $mailMessage Mail message
     *
     * @return Mail Provides a fluent interface
     */
    public function setMailMessage(MailMessage $mailMessage);

    /**
     * Set the mail body.
     *
     * @param MimeMessage $mailBody Mail body
     *
     * @return Mail Provides a fluent interface
     */
    public function setMailBody(MimeMessage $mailBody);

    /**
     * Set the template.
     *
     * @param string $template Template path
     *
     * @return Mail Provides a fluent interface
     */
    public function setTemplate($template);

    /**
     * Parse the template with the variables
     *
     * @param array   $variables (optional) Variables for the template
     * @param boolean $isHtml    (optional) Flag if the template contains HTML
     *
     * @return Mail Provides a fluent interface
     */
    public function parseTemplate($variables = array(), $isHtml = true);

    /**
     * Add an attachment
     *
     * Attachments are added as an array with the file path as key and some
     * optional values as an array for the value.
     * The attachments are added to the message just before sending to reduce
     * memory usage.
     *
     * @param string $filePath
     * @param array $options
     *
     * @return Mail Provides a fluent interface
     */
    public function addAttachment($filePath, array $options = array());

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
    public function send(TransportInterface $transport = null);

    /**
     * Reset the mail service to compose and send a new mail message.
     *
     * This method is NOT called after calling send(), as you may want to
     * change just some values instead of creating a complete new message
     *
     * @return Mail Provides a fluent interface
     */
    public function reset();
}
