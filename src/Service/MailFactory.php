<?php
/**
 * Factory for the mail service
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
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Renderer\RendererInterface;

/**
 * Factory for the mail service
 *
 * @author     Malte Gerth <mail@malte-gerth.de>
 * @copyright  2014 Malte Gerth
 * @license    Apache-2.0
 * @link       https://github.com/JanMalte/JmMailService
 * @since      2014-04-13
 */
class MailFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator Service Locator instance
     *
     * @return Mail
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Get the mail module options
        /* @var $moduleOptions ModuleOptions */
        $moduleOptions = $serviceLocator->get('JanMalte\JmMailService\Options\Module');

        // Get the mail transport
        $transport = $serviceLocator->get($moduleOptions->getMailTransportKey());

        // Get the renderer for the templates
        $renderer = $this->getRenderer($serviceLocator);

        // Get the mail service options
        $mailServiceOptions = $moduleOptions->getMailService();

        // Create new mail service
        $mailService = new Mail($mailServiceOptions, $transport, $renderer);

        return $mailService;
    }

    /**
     * Get the renderer.
     *
     * If no renderer is registered, create a new PhpRenderer
     *
     * @param ServiceLocatorInterface $serviceLocator Service Locator instance
     *
     * @return RendererInterface
     */
    protected function getRenderer(ServiceLocatorInterface $serviceLocator)
    {
        // Check if a view renderer is available and return it
        if ($serviceLocator->has('viewrenderer')) {
            return $serviceLocator->get('viewrenderer');
        }

        /*
         * Create a new PhpRenderer and return it if no view renderer was found
         */

        // Create new PhpRenderer
        $renderer = new PhpRenderer();

        // Set the view script resolver if available
        if ($serviceLocator->has('Zend\View\Resolver\AggregateResolver')) {
            $renderer->setResolver(
                $serviceLocator->get('Zend\View\Resolver\AggregateResolver')
            );
        }

        // Set the view helper manager if available
        if ($serviceLocator->has('viewhelpermanager')) {
            $renderer->setHelperPluginManager(
                $serviceLocator->get('viewhelpermanager')
            );
        }

        // Return the new PhpRenderer
        return $renderer;
    }
}
