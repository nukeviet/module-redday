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

/**
 * @param array $array_data
 * @param int $day
 * @param int $month
 * @param string $link_submit
 * @param array $structured_data
 * @return string
 */
function nv_theme_redday_main($array_data, $day, $month, $link_submit, $structured_data)
{
    global $op, $global_array_cats, $arr_allow_date, $page_title, $nv_Lang;

    $xtpl = new XTemplate($op . '.tpl', get_module_tpl_dir($op . '.tpl'));
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('JSON_DAYINMONTH', json_encode($arr_allow_date));
    $xtpl->assign('PAGE_TITLE', $page_title);
    $xtpl->assign('DAY', $day);
    $xtpl->assign('LINK_SUBMIT', $link_submit);

    // Xuất tháng
    for ($i = 1; $i <= 12; $i++) {
        $xtpl->assign('MONTH', [
            'key' => $i,
            'title' => $i,
            'selected' => $i == $month ? ' selected="selected"' : '',
        ]);
        $xtpl->parse('main.month');
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
