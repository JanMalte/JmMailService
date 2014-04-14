<?php
/**
 * Basic/Default configuration for the JmMailService module
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
return array(
    // Configuration for the mail service
    'jm-mail-service' => array(

        /*
         * Mail Transport
         */
        'mail_transport_key' => 'JanMalte\JmMailService\Service\MailTransport',

        /*
         * Mail service options
         */
        'mail_service' => array(
            /*
             * Defaul from email address if no one ist set
             */
            //'default_from' => '',

            /*
             * Defaul from display name to use, if no one ist set.
             */
            //'default_from_name' => '',
        ),
    ),
);
