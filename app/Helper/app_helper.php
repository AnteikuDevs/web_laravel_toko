<?php 
if (!function_exists('strip_slash')) {
    function strip_slash($text)
    {
        return preg_replace('/([^:])(\/{2,})/', '$1/', $text);
    }
}

include 'UploadFile_helper.php';