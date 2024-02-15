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

function nv_theme_redday_main($array_data, $error)
{
    global $module_name, $module_file, $lang_module, $module_info, $op, $day, $month, $global_array_cats;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('ACTION', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);
    $xtpl->assign('main_title_redday', sprintf($lang_module['main_title_redday'], $day, $month));

    if (!empty($error)) {
        $xtpl->assign('ERROR', implode('<br />', $error));
        $xtpl->parse('main.error');
    }

    for ($i = 1; $i <= 31; $i++) {
        $array['value'] = $i;
        $array['sl'] = ($i == $day) ? " selected=\"selected\"" : "";
        $xtpl->assign('DAY', $array);
        $xtpl->parse('main.loop_day');
    }
    for ($i = 1; $i <= 12; $i++) {
        $array['value'] = $i;
        $array['sl'] = ($i == $month) ? " selected=\"selected\"" : "";
        $xtpl->assign('MONTH', $array);
        $xtpl->parse('main.loop_month');
    }

    foreach ($array_data as $catid => $rows) {
        $xtpl->assign('CAT', $global_array_cats[$catid]);
        foreach ($rows as $row) {
            $xtpl->assign('LOOP', $row);
            $xtpl->parse('main.cats.loop');
        }
        $xtpl->parse('main.cats');
    }
    $xtpl->parse('main');
    return $xtpl->text('main');
}
