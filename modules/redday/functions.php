<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 2:29
 */

if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_REDDAY', true );
// Danh mục đa cấp. Ngoài site chỉ lấy status=1 admin lấy hết
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cats " . (defined('NV_ADMIN') ? '' : ' WHERE status=1') . " ORDER BY weight ASC";
$global_array_cats = $nv_Cache->db($sql, 'id', $module_name);
