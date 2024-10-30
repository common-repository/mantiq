<?php

namespace Mantiq\Support;

class Utils
{
    public static function getRequestHeaders()
    {
        $headers = [];

        $server = [
            'CONTENT_TYPE'   => 'Content-Type',
            'CONTENT_LENGTH' => 'Content-Length',
            'CONTENT_MD5'    => 'Content-Md5',
        ];

        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $key = substr($key, 5);
                if (!isset($server[$key], $_SERVER[$key])) {
                    $key           = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                    $headers[$key] = $value;
                }
            } elseif (isset($server[$key])) {
                $headers[$server[$key]] = $value;
            }
        }

        if (!isset($headers['Authorization'])) {
            if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
                $basic_pass               = $_SERVER['PHP_AUTH_PW'] ?? '';
                $headers['Authorization'] = 'Basic '.base64_encode($_SERVER['PHP_AUTH_USER'].':'.$basic_pass);
            } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
                $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
            }
        }

        return $headers;
    }

    public static function captureFileContent($file)
    {
        if (!file_exists($file)) {
            return '';
        }

        ob_start();

        try {
            include $file;
        } catch (\Exception $exception) {
            printf('Error: %s', $exception->getMessage());
        }

        return ob_get_clean();
    }
}
