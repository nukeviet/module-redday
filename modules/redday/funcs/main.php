<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 21 Jan 2014 01:32:02 GMT
 */

if(!defined('NV_IS_MOD_REDDAY'))
    die('Stop!!!');

global $day, $month;
$day = $nv_Request->get_int('day', 'post', date( 'd', NV_CURRENTTIME));
$month = $nv_Request->get_int('month', 'post', date('m', NV_CURRENTTIME));

$error = array();
if($day <= 0 or $day > 31 or $month <= 0 or $month > 12) {
    $error[] = sprintf($lang_module['error_month'], $month, $day);
}
$error = array();
if($day <= 0 or $day > 31 or $month <= 0 or $month > 12) {
    $error[] = sprintf($lang_module['error_month'], $month, $day);
}
if(in_array( $month, array( 4, 6, 9, 11 ) ) and $day == 31 ) {
    $error[] = sprintf($lang_module['error_month'], $month, $day);
}
if( $month == 2 and $day > 29 ) {
    $error[] = sprintf($lang_module['error_month2'], $day);
}
if(!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}
else {
    $mday = str_pad($day, 2, '0', STR_PAD_LEFT);
    $mmonth = str_pad($month, 2, '0', STR_PAD_LEFT);
    $filename = NV_ROOTDIR . '/modules/redday/data/' . $mday . $mmonth . '_vietnamese.txt';
    $array_data = array();
    if(file_exists($filename)) {
        $content_file = file_get_contents($filename);
        if(!empty($content_file)) {
            $array_data = unserialize($content_file);
        }
    }
}

$contents = nv_theme_redday_main ($array_data, $error);

$page_title = sprintf($lang_module['main_title_redday'], $day, $month);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
