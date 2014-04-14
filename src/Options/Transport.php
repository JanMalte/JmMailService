<?php
/**
 * Mail transport options
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
 * @since      2014-04-14
 */

namespace JanMalte\JmMailService\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Mail transport options
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-14
 */
class Transport extends AbstractOptions
{

    /**
     * Transport type
     *
     * @var string
     */
    protected $type = 'sendmail';

    /**
     * Transport class configuration
     *
     * @var array
     */
    protected $config = array();

    /**
     * Get the transport type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the transport configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the transport type
     *
     * @param string $type Transport type/class
     *
     * @return Transport Provides a fluent interface
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the transport configuration
     *
     * @param array $config Transport configuration
     *
     * @return Transport Provides a fluent interface
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }
}
