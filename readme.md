# Sysfeedback

Tool to use with Laravel Framework to facilitate sending messages from controllers to the views.


## Usage

We use the Session component from Laravel to store messages, so works with redirects too.

Multiple messages from the same type are grouped into one message, separated by `<br />`.

We have 4 type of messages:

 - Success;
 - Info;
 - Error;
 - Warning.

You specify the type of the message to send by calling a static method named with the type name.


```php
use Beeblebrox3\Sysfeedback;

Sysfeedback::success('this is a success message!');

sysfeedback::info('this is a information message');

Sysfeedback::error('this is a error message!');

Sysfeedback::warning('this is a warning message!');

```

To display the messages, use the `render` method:


```php
use Beeblebrox3\Sysfeedback;

Sysfeedback::success('this is a success message!');

Sysfeedback::render();

/*
This method will print something like this:
<div class="message-success">this is a success message!</div>
*/
```

You can customize the format of the output passing the new format to the render method.

```php
use Beeblebrox3\Sysfeedback;

Sysfeedback::success('this is a success message!');

Sysfeedback::render('<div class=":type">:message</div>');

/*
This method will print something like this:
<div class="success">this is a success message!</div>
*/
```

**:message** indicates where put the message text.

**:type** indicates where put the type of the message, usually to use as a class name to apply stylesheet.


## Changelog

- **1.2.0**: the format now use `:type` placeholder to put the type of the message instead of `:class`;
- **1.1.0**: allow curtomize the output format;