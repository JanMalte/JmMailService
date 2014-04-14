<?php
/**
 * JmMailService module options
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

namespace JanMalte\JmMailService\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * JmMailService module options
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-13
 */
class Module extends AbstractOptions
{

    /**
     * Mail service options
     *
     * @var MailService
     */
    protected $mailService;

    /**
     * Mail transport options
     *
     * @var Transport
     */
    protected $transport;

    /**
     * Mail transport key
     *
     * @var string
     */
    protected $mailTransportKey;

    /**
     * Get the mail service options
     *
     * @return MailService
     */
    public function getMailService()
    {
        if (null == $this->mailService) {
            $this->mailService = new MailService();
        }

        return $this->mailService;
    }

    /**
     * Get the mail transport options
     *
     * @return Transport
     */
    public function getTransport()
    {
        if (null == $this->transport) {
            $this->transport = new Transport();
        }

        return $this->transport;
    }

    /**
     * Get the mail transport key
     *
     * @return string
     */
    public function getMailTransportKey()
    {
        return $this->mailTransportKey;
    }

    /**
     * Set the mail service options
     *
     * @param MailService|array $mailService Mail service options
     *
     * @return Module Provides a fluent interface
     */
    public function setMailService($mailService)
    {
        if ($mailService instanceof MailService) {
            $this->mailService = $mailService;
        } else {
            $this->mailService = new MailService($mailService);
        }

        return $this;
    }

    /**
     * Set the mail service options
     *
     * @param Transport|array $transportOptions Mail transport options
     *
     * @return Module Provides a fluent interface
     */
    public function setTransport($transportOptions)
    {
        if ($transportOptions instanceof Transport) {
            $this->transport = $transportOptions;
        } else {
            $this->transport = new Transport($transportOptions);
        }

        return $this;
    }

    /**
     * Set the mail transport key
     *
     * @param string $mailTransportKey Mail transport key
     *
     * @return Module Provides a fluent interface
     */
    public function setMailTransportKey($mailTransportKey)
    {
        $this->mailTransportKey = $mailTransportKey;

        return $this;
    }
}
