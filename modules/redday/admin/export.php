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
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;

$catid = $nv_Request->get_absint('catid', 'get', 0);
$keep_html = (int) $nv_Request->get_bool('html', 'get', false);
if (!isset($global_array_cats[$catid])) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'], 404);
}

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

// Xuất dữ liệu
$spreadsheet = IOFactory::load(NV_ROOTDIR . '/modules/' . $module_file . '/excel/template-events.xlsx');
$sheet = $spreadsheet->getActiveSheet();

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE catid=" . $catid . " ORDER BY id ASC";
$result = $db->query($sql);

$stt = 1;
$start_row = 2;
$date = new DateTime();

while ($row = $result->fetch()) {
    $sheet->setCellValue('A' . $start_row, $stt);
    $sheet->setCellValue('B' . $start_row, $row['id']);

    $timestamp = mktime(0, 0, 0, intval($row['month']), intval($row['day']), intval(date('Y', NV_CURRENTTIME)));
    $sheet->setCellValue('C' . $start_row, Date::PHPToExcel($date->setTimestamp($timestamp)));
    $sheet->getStyle('C' . $start_row)->getNumberFormat()->setFormatCode('dd/mm');

    if (!$keep_html) {
        $row['content'] = strip_tags(nv_br2nl($row['content']));
    }
    $sheet->setCellValueExplicit('D' . $start_row, str_replace('&nbsp;', ' ', nv_unhtmlspecialchars($row['content'])), DataType::TYPE_STRING);

    $stt++;
    $start_row++;
}
$result->closeCursor();

$file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/export-' . $module_name . '-' . NV_CHECK_SESSION . '.xlsx';
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
if (is_file($file)) {
    nv_deletefile($file);
}
$writer->save($file);

$download = new Download($file, NV_ROOTDIR . '/' . NV_TEMP_DIR, change_alias($global_array_cats[$catid]['title']) . '.xlsx');
$download->download_file();
exit();
