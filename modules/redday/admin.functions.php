<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 2:29
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

define('NV_IS_FILE_ADMIN', true);

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cats ORDER BY weight ASC";
$global_array_cats = $nv_Cache->db($sql, 'id', $module_name);

// Số ngày tối đa cho phép trong tháng
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
