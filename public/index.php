<?php

//function getLang($default)
//{
//    return (isset($_GET['lang']) && !empty($_GET['lang'])) ? $_GET['lang'] :
//        (isset($_COOKIE['lang']) && !empty($_COOKIE['lang'])) ? $_COOKIE['lang'] :
//            (isset($_SESSION['lang']) && !empty($_SESSION['lang'])) ? $_SESSION['lang'] :
//                (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) :
//                    $default;
//}

//function getLang($default) {
//
//    if (isset($_GET['lang']) && !empty($_GET['lang'])) {
//        return $_GET['lang'];
//    } elseif (isset($_COOKIE['lang']) && !empty($_COOKIE['lang'])) {
//        return $_COOKIE['lang'];
//    } elseif (isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
//        return $_SESSION['lang'];
//    } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
//        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
//    } else {
//        return $default;
//    }
//}

function getLang(Request $request, $default)
{
    if (isset($request->getQueryParams()['lang']) && !empty($request->getQueryParams()['lang'])) {
        return $request->getQueryParams()['lang'];
    } elseif (isset($request->getCookies()['lang']) && !empty($request->getCookies()['lang'])) {
        return $request->getCookies()['lang'];
    } elseif (isset($request->getSessionData()['lang']) && !empty($request->getSessionData()['lang'])) {
        return $request->getSessionData()['lang'];
    } elseif (isset($request->getServerData()['HTTP_ACCEPT_LANGUAGE']) && !empty($request->getServerData()['HTTP_ACCEPT_LANGUAGE'])) {
        return substr($request->getServerData()['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    } else {
        return $default;
    }
}

class Request
{
    public function getQueryParams(): array
    {
        return $_GET;
    }

    public function getCookies(): array
    {
        return $_COOKIE;
    }

    public function getSessionData(): array
    {
        return $_SESSION;
    }

    public function getServerData(): array
    {
        return $_SERVER;
    }
}

session_start();

$name = $_GET['name'] ?? 'Guest';
$lang = getLang(new Request(), 'en');

header('X-Developer: livalex');
echo "Hello, " . $name . "! Your language is " . $lang . PHP_EOL;

