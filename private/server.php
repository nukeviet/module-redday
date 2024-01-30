<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 31/05/2010, 00:36
 */

if (!defined('NV_IS_CONSOLE')) {
    die('Stop!!!');
}

$_SERVER['HTTP_HOST'] = 'redday.my';
$_SERVER['HTTPS'] = 'on';

$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PROTOCOL'] = 'http';
$_SERVER['REQUEST_URI'] = '';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['PHP_SELF'] = '';
$_SERVER['HTTP_CLIENT_IP'] = '127.0.0.1';

// Dùng để tùy chỉnh giờ
//$_SERVER['REQUEST_TIME'] = 1589907600;

$_GET['language'] = 'vi';

define('NV_IS_LOCAL_CONSOLE', true);

/**
 * @param double $start
 * @param double $end
 * @return string
 */
function getConsoleExecuteTime($start, $end)
{
    $times = ($end - $start) * 1000;
    if ($times < 1000) {
        return (intval($times) . 'ms');
    }
    $times = intval($times / 1000);
    return nv_convertfromSec($times);
}
