<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_REDDAY')) {
    die('Stop!!!');
}

$key_words = $module_info['keywords'];
$page_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

$day = $current_day = date('j', NV_CURRENTTIME);
$month = $current_month = date('n', NV_CURRENTTIME);
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

if (!empty($array_op[0]) and preg_match('/^[a-z]+\-([0-9]+)\-[a-z]+\-([0-9]+)$/', $array_op[0], $m)) {
    // Chọn ngày tháng cụ thể
    $day = intval($m[1]);
    $month = intval($m[2]);
    if ($month < 1 or $month > 12 or $day < 1 or $day > $arr_allow_date[$month]) {
        nv_redirect_location($page_url);
    }
    $page_title = sprintf($nv_Lang->getModule('main_title_redday'), $day, $month);
    $page_url .= '&amp;' . NV_OP_VARIABLE . '=' . $nv_Lang->getModule('op_day') . '-' . $day . '-' . $nv_Lang->getModule('op_month') . '-' . $month . $global_config['rewrite_exturl'];
    $description = sprintf($nv_Lang->getModule('main_description_redday'), $day, $month);
} else {
    // Mặc định main của trang chủ
    $page_title = $module_info['site_title'];
    $description = $module_info['description'];
}

$canonicalUrl = getCanonicalUrl($page_url);
$link_submit = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $nv_Lang->getModule('op_day') . '-DDDD-' . $nv_Lang->getModule('op_month') . '-MMMM' . $global_config['rewrite_exturl'];
$link_submit = nv_url_rewrite($link_submit, true);

$structured_data = [];

// Lấy các sự kiện
$db->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . "_" . $module_data . "_rows")
    ->where('day=' . $day . ' AND month = ' . $month)
    ->order('id DESC');
$result = $db->query($db->sql());
while ($row = $result->fetch(2)) {
    if (empty($data[$row['catid']])) {
        $data[$row['catid']] = [];
    }
    $data[$row['catid']][] = $row;
}

$contents = nv_theme_redday_main($data, $day, $month, $link_submit, $structured_data);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
