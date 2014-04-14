<?php
/**
 * Factory for the mail transport
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

use JanMalte\JmMailService\Options\Module as ModuleOptions;
use JanMalte\JmMailService\Options\Transport as TransportOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions as FileTransportOptions;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions as SmtpTransportOptions;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Transport\Exception\InvalidArgumentException;

/**
 * Factory for the mail transport
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-13
 */
class MailTransportFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator Service Locator instance
     *
     * @return TransportInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get the mail module options
        /* @var $moduleOptions ModuleOptions */
        $moduleOptions = $serviceLocator->get('JanMalte\JmMailService\Options\Module');

        // Get the transport options
        /* @var $transportOptions TransportOptions */
        $transportOptions = $moduleOptions->getTransport();

        // Create a new transport based on the type
        $transportType = strtolower($transportOptions->getType());
        switch ($transportType) {
            case 'smtp':
                return $this->createSmtpTransport($transportOptions);
            case 'sendmail':
                return $this->createSendmailTransport($transportOptions);
            case 'file':
                return $this->createFileTransport($transportOptions);
            default:
                throw new InvalidArgumentException(
                    'Unsupported mail transport type "' . $transportType . '"'
                );
        }
    }

    /**
     * Create a new SMTP mail transport
     *
     * @param TransportOptions $transportOptions Mail transport options
     *
     * @return SmtpTransport
     */
    protected function createSmtpTransport(TransportOptions $transportOptions)
    {
        $smptOptions = $transportOptions->getConfig();

        return new SmtpTransport(new SmtpTransportOptions($smptOptions));
    }

    /**
     * Create a new sendmail mail transport
     *
     * @param TransportOptions $transportOptions Mail transport options
     *
     * @return SendmailTransport
     */
    protected function createSendmailTransport(TransportOptions $transportOptions)
    {
        $sendmailParameter = $transportOptions->getConfig();

        return new SendmailTransport($sendmailParameter);
    }

    /**
     * Create a new file mail transport
     *
     * @param TransportOptions $transportOptions Mail transport options
     *
     * @return FileTransport
     */
    protected function createFileTransport(TransportOptions $transportOptions)
    {
        $fileTransportOptions = $transportOptions->getConfig();

        return new FileTransport(new FileTransportOptions($fileTransportOptions));
    }
}
