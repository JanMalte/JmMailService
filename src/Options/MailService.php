<?php
/**
 * JmMailService mail service options
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
 * JmMailService mail service options
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-13
 */
class MailService extends AbstractOptions
{

    /**
     * Default from mail address
     *
     * @var string
     */
    protected $defaultFrom;

    /**
     * Default from display name
     *
     * @var string
     */
    protected $defaultFromName;

    /**
     * Get the default from mail address
     *
     * @return string
     */
    public function getDefaultFrom()
    {
        return $this->defaultFrom;
    }

    /**
     * Get the default from name
     *
     * @return string
     */
    public function getDefaultFromName()
    {
        return $this->defaultFromName;
    }

    /**
     * Set the default from mail address
     *
     * @param string $defaultFrom
     *
     * @return MailService Provides a fluent interface
     */
    public function setDefaultFrom($defaultFrom)
    {
        $this->defaultFrom = $defaultFrom;

        return $this;
    }

    /**
     * Set the default from name
     *
     * @param string $defaultFromName
     *
     * @return MailService Provides a fluent interface
     */
    public function setDefaultFromName($defaultFromName)
    {
        $this->defaultFromName = $defaultFromName;

        return $this;
    }
}
