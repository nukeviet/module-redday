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
