<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

use NukeViet\Files\Download;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

// Tải về mẫu
if ($nv_Request->get_title('template', 'get', '') === NV_CHECK_SESSION) {
    $file = NV_ROOTDIR . '/modules/' . $module_file . '/excel/template-events.xlsx';
    $download = new Download($file, dirname($file), basename($file));
    $download->download_file();
    exit();
}

$page_title = $lang_module['excel_import'];

$array = [
    'catid' => $nv_Request->get_absint('catid', 'get', 0),
    'truncate_data' => 0,
    'skip_error' => 0,
    'skip_cat' => 1,
    'nl2br' => 1
];
$warning = $error = [];
$import_data = [
    'add' => 0,
    'update' => 0,
    'skip' => 0
];
$is_submit = 0;

if ($nv_Request->get_title('save', 'post', '') === NV_CHECK_SESSION) {
    $is_submit = 1;
    // Kiểm tra thư viện tồn tại
    if (!is_dir(NV_ROOTDIR . '/vendor/phpoffice/phpspreadsheet')) {
        trigger_error('No phpspreadsheet lib. Run command &quot;composer require phpoffice/phpspreadsheet&quot; to install phpspreadsheet', 256);
    }

    // Tăng giới hạn bộ nhớ lên để có chỗ xử lý dữ liệu
    if ($sys_info['allowed_set_time_limit']) {
        set_time_limit(0);
    }
    if ($sys_info['ini_set_support']) {
        $memoryLimitMB = (integer)ini_get('memory_limit');
        if ($memoryLimitMB < 4000) {
            ini_set('memory_limit', '4000M');
        }
    }

    $array['catid'] = $nv_Request->get_absint('catid', 'post', 0);
    if (empty($array['catid'])) {
        $error[] = $lang_module['main_error_catids'];
    } elseif (!in_array($array['catid'], array_keys($global_array_cats))) {
        $error[] = $lang_module['main_error_exits_cat'];
    }
    $array['truncate_data'] = (int) $nv_Request->get_bool('truncate_data', 'post', false);
    $array['skip_error'] = (int) $nv_Request->get_bool('skip_error', 'post', false);
    $array['skip_cat'] = (int) $nv_Request->get_bool('skip_cat', 'post', false);
    $array['nl2br'] = (int) $nv_Request->get_bool('nl2br', 'post', false);

    // Upload
    if (isset($_FILES['import_file']) and is_uploaded_file($_FILES['import_file']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload(['documents'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], $global_config['nv_max_size'], NV_MAX_WIDTH, NV_MAX_HEIGHT);
        $upload->setLanguage($lang_global);
        $upload_info = $upload->save_file($_FILES['import_file'], NV_ROOTDIR . '/' . NV_TEMP_DIR, false);

        @unlink($_FILES['import_file']['tmp_name']);
        if (!empty($upload_info['error'])) {
            $error[] = $upload_info['error'];
        }
    } else {
        $error[] = $lang_module['excel_error_nofile'];
    }

    // Đọc file excel
    if (empty($error)) {
        try {
            $spreadsheet = IOFactory::load($upload_info['name']);
            $sheet = $spreadsheet->getActiveSheet();
        } catch (Exception $e) {
            $error[] = $lang_module['import_error_readexcel'];
        }
    }

    $array_read = [];
    if (empty($error)) {
        $highest_row = $sheet->getHighestDataRow();
        $start_row = 2;

        for ($read_row = $start_row; $read_row <= $highest_row; ++$read_row) {
            $item = [];
            $item['id'] = intval($sheet->getCell('B' . $read_row)->getCalculatedValue());
            $item['day'] = $item['month'] = 0;

            // Ngày tháng
            $cell = $sheet->getCell('C' . $read_row);
            $item['time'] = $cell->getCalculatedValue();
            if (Date::isDateTime($cell)) {
                $item['time'] = Date::excelToTimestamp($item['time']);
                $item['day'] = date('j', $item['time']);
                $item['month'] = date('n', $item['time']);
            } elseif (preg_match('/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{1,4})/', strval($item['time']), $m)) {
                $item['day'] = intval($m[1]);
                $item['month'] = intval($m[2]);
            } elseif (preg_match('/([0-9]{1,2})\/([0-9]{1,2})/', strval($item['time']), $m)) {
                $item['day'] = intval($m[1]);
                $item['month'] = intval($m[2]);
            }

            $item['content'] = trim($sheet->getCell('D' . $read_row)->getCalculatedValue());
            if ($array['nl2br']) {
                $item['content'] = nv_nl2br($item['content']);
            }

            $line_error = [];
            if ($item['day'] <= 0 or !isset($arr_allow_date[$item['month']]) or $item['day'] > $arr_allow_date[$item['month']]) {
                $line_error[] = $lang_module['excel_error_time'] . ' ' . number_format($read_row);
            }
            if (empty($item['content'])) {
                $line_error[] = $lang_module['excel_error_content'] . ' ' . number_format($read_row);
            }

            if (empty($line_error)) {
                $array_read[] = $item;
            } else {
                if ($array['skip_error']) {
                    $import_data['skip']++;
                    $warning = array_merge($warning, $line_error);
                } else {
                    $error = array_merge($error, $line_error);
                }
            }
        }
    }

    if (empty($error)) {
        if ($array['truncate_data']) {
            $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE catid=" . $array['catid'];
            $db->query($sql);
        }

        foreach ($array_read as $row) {
            $insert = 0;

            if ($row['id'] > 0) {
                // Cập nhật lại dữ liệu đã có
                $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET
                day=" . $row['day'] . ",
                month=" . $row['month'] . ",
                content=" . $db->quote($row['content']) . ",
                edit_time=" . NV_CURRENTTIME;
                if (!$array['skip_cat']) {
                    $sql .= ", catid=" . $array['catid'];
                }
                $sql .= " WHERE id=" . $row['id'];
                if (!$db->exec($sql)) {
                    $insert = 1;
                } else {
                    $import_data['update']++;
                }
            } else {
                $insert = 1;
            }
            if ($insert) {
                $import_data['add']++;
                $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_rows (
                    catid, day, month, content, add_time
                ) VALUES (
                    " . $array['catid'] . ", " . $row['day'] . ", " . $row['month'] . ",
                    " . $db->quote($row['content']) . ", " . NV_CURRENTTIME . "
                )";
                $db->query($sql);
            }
        }

        nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_IMPORT', json_encode($import_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $admin_info['userid']);
        $nv_Cache->delMod($module_name);
    }
}

$array['truncate_data'] = empty($array['truncate_data']) ? '' : ' checked="checked"';
$array['skip_error'] = empty($array['skip_error']) ? '' : ' checked="checked"';
$array['skip_cat'] = empty($array['skip_cat']) ? '' : ' checked="checked"';
$array['nl2br'] = empty($array['nl2br']) ? '' : ' checked="checked"';

$xtpl = new XTemplate('import.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('OP', $op);
$xtpl->assign('DATA', $array);

$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('LINK_TEMPLATE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;template=' . NV_CHECK_SESSION);

// Hiển thị lỗi
if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

// Hiển thị cảnh báo
if (!empty($warning)) {
    $xtpl->assign('WARNING', implode('<br />', $warning));
    $xtpl->parse('main.warning');
}

// Kiển thị kết quả đọc
if (empty($error) and $is_submit) {
    $xtpl->assign('IMPORT_DATA', array_map('number_format', $import_data));
    $xtpl->parse('main.import_data');
}

// Xuất danh mục
foreach ($global_array_cats as $cat) {
    $cat['selected'] = $array['catid'] == $cat['id'] ? ' selected="selected"' : '';
    $xtpl->assign('CAT', $cat);
    $xtpl->parse('main.cat');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
