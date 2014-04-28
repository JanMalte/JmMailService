JmMailService
=======

Created by Malte Gerth


Introduction
------------

Mail service to ease the use of the ZF2 mail component. It supports adding
attachments and sending HTML messages. The Zend Mail coponents can be used
to modify the message before sending.


Requirements
------------

* [Zend Framework 2](https://github.com/zendframework/zf2) (2.2.*)


Features
----------------

* Use Zend View Scripts with view helpers as message template
* Use Zend Mail components without modifications
* Ease the handling of sending multipart messages
* Add attachments easily by calling one single method
* Use of native Zend Mail Transport classes


Installation
------------

1. Add this project and [JmMailService](https://github.com/JanMalte/JmMailService) in your composer.json:

    ```json
    "require": {
        "janmalte/jm-mail-service": "dev-master"
    }
    ```

2. Now tell composer to download JmMailService by running the command:

    ```bash
    $ php composer.phar update
    ```

3. Enable the module in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'JanMalte\JmMailService',
        ),
        // ...
    );
    ```


Options
-------

The JmMailService module has some options to allow you to customize the
functionality. After installing JmMailService, create a new config file in 
`./config/autoload/` or change an existing one to set the values as need.

The following options are available under the configuration key
`jm-mail-service`:

- **mail_transport_key** - Service manager key of the transport service to use.
- **mail_service** - Options for the mail service. Have a look at the next section.


### Options for the Mail Service

The following options are available under the configuration key
`mail_service` of the JmMailService options:

- **default_from** - Default mail address to use as sender for the mail service.
- **default_from_name** - Default name to use as sender for the mail service.


Usage
-------

The Mail Service is registered at the Service Manager and can be retrieved from
it by calling `get('JanMalte\JmMailService\Service\Mail')`

    ```php
    <?php
    // Get the mail service
    $mailService = $serviceLocator->get('JanMalte\JmMailService\Service\Mail');
    ```

To send a mail message you need only a few commands.

    ```php
    <?php
    // Reset the mail service
    $mailService->reset();

    // Set the mail template
    $mailService->setTemplate($templateFile);

    // Parse the template
    $mailService->parseTemplate($templateValues);

    // Add a recipient for the message
    $mailMessage = $mailService->getMailMessage();
    $mailMessage->setTo($recipientEmail, $recipientName);

    // Send the mail message
    $mailService->send();
    ```

Method chaning is provided, so you can shorten the commands to the following:

    ```php
    <?php
    // Use the mail service with method chaining
    $mailService->reset()
        ->setTemplate($templateFile)
        ->parseTemplate($templateValues);

    // Add a recipient for the message
    $mailService->getMailMessage()
        ->setTo($recipientEmail, $recipientName);

    // Send the mail message
    $mailService->send();
    ```

The template files have to be under the same path as the other view scripts.
Typically this would be `<vendor>/<module>/view/`
