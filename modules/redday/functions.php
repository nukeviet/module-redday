<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM')) {
    die('Stop!!!');
}

define('NV_IS_MOD_REDDAY', true);

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cats WHERE status=1 ORDER BY weight ASC";
$global_array_cats = $nv_Cache->db($sql, 'id', $module_name);
