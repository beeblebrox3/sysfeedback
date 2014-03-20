<?php

namespace Beeblebrox3\Sysfeedback;

/*
    On Controller, use
    Sysfeedback::success("mensagem"); // store a success message

    On view/layout, use
    Sysfeedback::render(); // show all existing messages
*/

class Sysfeedback
{
    private static $types = array(
        'success',
        'error',
        'warning',
    );

    private static $format = '<div class="alert alert-:class">:message</div>';

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

    private static function addMessage($type, $message)
    {
        $messages = (array) \Session::get($type);
        $messages[] = $message;
        \Session::put($type, $messages);
    }

    private static function html($class, $messages, $format = '')
    {
        $format = ($format) ?: self::$format;
        $messages = implode('<br />', $messages);

        $output = str_replace(array(
            ':message',
            ':class',
        ), array (
            $messages,
            $class
        ), $format);

        // echo '<div class="alert alert-'.$class.'">';
        // foreach ($messages as $msg) {
        //     echo $msg.'<br />';
        // }
        // echo '</div>';
        
        echo $output;
    }

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
