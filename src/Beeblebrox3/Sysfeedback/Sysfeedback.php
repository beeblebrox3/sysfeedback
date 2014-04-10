<?php

namespace Beeblebrox3\Sysfeedback;

class Sysfeedback
{
    /**
     * types of messages
     * @var array
     */
    private static $types = array (
        'success',
        'error',
        'warning',
        'info',
    );

    /**
     * format to display messages
     * @var string
     */
    private static $format = '<div class="message-:type">:message</div>';

    /**
     * print all messages
     * @param  string $format format to display
     * @return  null
     */
    public static function render($format = '')
    {
        foreach (self::$types as $type) {
            $_type = 'sys-'.$type;
            if (\Session::has($_type)) {
                self::html($type, \Session::get($_type), $format);
                \Session::forget($_type);
            }
        }
    }

    /**
     * add a message to session
     * @param string $type
     * @param string $message
     */
    private static function addMessage($type, $message)
    {
        // get current messages as array
        $messages = (array) \Session::get($type);
        $messages[] = $message;

        \Session::put($type, $messages);
    }

    /**
     * format the message
     * Multiple messages from the same type are grouped into one message,
     * separated by `<br />`.
     * 
     * @param  string $type type of message
     * @param  array  $messages array with all messages
     * @param  string $format template
     * @return null
     */
    private static function html($type, $messages, $format = '')
    {
        $format = ($format) ?: self::$format;
        $messages = implode('<br />', $messages);

        $output = str_replace(array(
            ':message',
            ':type',
        ), array (
            $messages,
            $type
        ), $format);

        echo $output;
    }

    /**
     * shortcut to addMessage
     */
    public static function __callStatic($type, $args)
    {
        if (!in_array($type, self::$types)) {
            return false;
        }

        $type = 'sys-'.$type;
        $message = $args[0];
        self::addMessage($type, $message);
    }
}
