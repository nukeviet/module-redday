<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 2:29
 */

if (!defined('NV_IS_MOD_REDDAY')) die('Stop!!!');

$day = $nv_Request->get_int('day', 'post', date('d', NV_CURRENTTIME));
$month = $nv_Request->get_int('month', 'post', date('m', NV_CURRENTTIME));
$error = [];
$arr_allow_date = [
    1 => 31,
    2 => 29,
    3 => 31,
    4 => 30,
    5 => 31,
    6 => 30,
    7 => 31,
    8 => 31,
    9 => 30,
    10 => 31,
    11 => 30,
    12 => 31,
];

if (!in_array($month, array_keys($arr_allow_date))) {
    $error[] = $lang_module['main_error_month_match'];
}
if (!(($day >= 1) && ($day <= $arr_allow_date[$month]))) {
    $error[] = sprintf($lang_module['error_month'], $month, $day);
}

$data = [];

if (empty($error)) {
    $db->sqlreset()
        ->select('*')
        ->from(NV_PREFIXLANG . "_" . $module_data . "_rows")
        ->where('day=' . $day . ' AND month = ' . $month)
        ->order('catid');
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        if (empty($data[$row['catid']])) {
            $data[$row['catid']] = [];
        }
        $data[$row['catid']][] = $row;
    }
}

$contents = nv_theme_redday_main($data, $error);
$page_title = sprintf($lang_module['main_title_redday'], $day, $month);
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
