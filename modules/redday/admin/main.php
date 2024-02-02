<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}
$page_title = 'Redday';
$error = [];
$day = $nv_Request->get_int('day', 'get', nv_date('j', NV_CURRENTTIME));
$month = $nv_Request->get_int('month', 'get', nv_date('n', NV_CURRENTTIME));
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

// Xóa
if ($nv_Request->get_title('delete', 'post', '') === NV_CHECK_SESSION) {
    $id = $nv_Request->get_absint('id', 'post', 0);

    // Kiểm tra tồn tại
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id=" . $id;
    $array = $db->query($sql)->fetch();
    if (empty($array)) {
        nv_htmlOutput('NO_' . $id);
    }

    // Xóa
    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id=" . $id;
    $db->query($sql);

    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_DELETE_CONTENT' . strtoupper($module_name), json_encode($array), $admin_info['admin_id']);
    $nv_Cache->delMod($module_name);

    nv_htmlOutput("OK");
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

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

$lang_module['redday_time'] = sprintf($lang_module['redday_time'], $day, $month);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
// Hiển thị lỗi
if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

for ($i = 1; $i <= 31; $i++) {
    $array_day = [];
    $array_day['value'] = $i;
    $array_day['sl'] = ($i == $day) ? " selected=\"selected\"" : "";
    $xtpl->assign('DAY', $array_day);
    $xtpl->parse('main.loop_day');
}
for ($i = 1; $i <= 12; $i++) {
    $array_month = [];
    $array_month['value'] = $i;
    $array_month['sl'] = ($i == $month) ? " selected=\"selected\"" : "";
    $xtpl->assign('MONTH', $array_month);
    $xtpl->parse('main.loop_month');
}

foreach ($data as $catid => $rows) {
    $xtpl->assign('CAT', $global_array_cats[$catid]);
    foreach ($rows as $row) {
        $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=add_content' . '&amp;id=' . $row['id'];
        $xtpl->assign('LOOP', $row);
        $xtpl->parse('main.cats.loop');
    }
    $xtpl->parse('main.cats');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['main'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
