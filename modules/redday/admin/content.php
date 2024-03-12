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
    die('Stop!!!');
}

$error = [];

// Lấy id sự kiện cần sửa nếu có
$id = $nv_Request->get_int('id', 'get', 0);

if (!empty($id)) {
    // Kiểm tra sự kiện
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id = " . $id;
    $result = $db->query($sql);
    $array = $result->fetch();

    if (empty($array)) {
        nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content'));
    }

    $page_title = $nv_Lang->getModule('main_edit');
    $form_action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $id;
} else {
    $array = [
        'catid' => 0,
        'day' => nv_date('j', NV_CURRENTTIME),
        'month' => nv_date('n', NV_CURRENTTIME),
        'image' => '',
        'content' => ''
    ];

    $page_title = $nv_Lang->getModule('main_add');
    $form_action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
}

if ($nv_Request->get_title('save', 'post', '') === NV_CHECK_SESSION) {
    // Lấy dữ liệu
    $array['catid'] = $nv_Request->get_absint('catid', 'post', 0);
    $array['day'] = $nv_Request->get_absint('day', 'post', nv_date('j', NV_CURRENTTIME));
    $array['month'] = $nv_Request->get_absint('month', 'post', nv_date('n', NV_CURRENTTIME));
    $array['image'] = nv_substr($nv_Request->get_title('image', 'post', ''), 0, 255);
    $array['content'] = $nv_Request->get_editor('content', '', NV_ALLOWED_HTML_TAGS);
    $array['content'] = nv_editor_nl2br($array['content']);

    // Xử lý dữ liệu
    if (empty($array['catid'])) {
        $error[] = $nv_Lang->getModule('main_error_catids');
    } elseif (!in_array($array['catid'], array_keys($global_array_cats))) {
        $error[] = $nv_Lang->getModule('main_error_exits_cat');
    }
    if (empty($array['content'])) {
        $error[] = $nv_Lang->getModule('main_error_bodyhtml');
    }
    if (!nv_is_file($array['image'], NV_UPLOADS_DIR . '/' . $module_upload)) {
        $array['image'] = '';
    }

    if (!in_array($array['month'], array_keys($arr_allow_date))) {
        $error[] = $nv_Lang->getModule('main_error_month_match');
    }
    if (!(($array['day'] >= 1) && ($array['day'] <= $arr_allow_date[$array['month']]))) {
        $error[] = sprintf($nv_Lang->getModule('error_month'), $array['month'], $array['day']);
    }

    if (empty($error)) {
        if (!$id) {
            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_rows (
                catid, day, month, image, content, add_time
            ) VALUES (
                " . $array['catid'] . ", " . $array['day'] . ",  " . $array['month'] . ",
                :image, :content, " . NV_CURRENTTIME . "
            )";
        } else {
            $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET
                catid=" . $array['catid'] . ",
                day=" . $array['day'] . ",
                month=" . $array['month'] . ",
                image=:image,
                content=:content,
                edit_time=" . NV_CURRENTTIME . "
            WHERE id = " . $id;
        }

        try {
            $sth = $db->prepare($sql);
            $sth->bindParam(':image', $array['image'], PDO::PARAM_STR);
            $sth->bindParam(':content', $array['content'], PDO::PARAM_STR, strlen($array['content']));
            $sth->execute();

            if ($id) {
                nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_EDIT_CONTENT', $id, $admin_info['userid']);
            } else {
                nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_ADD_CONTENT', '', $admin_info['userid']);
            }

            $nv_Cache->delMod($module_name);
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&day=' . $array['day'] . '&month=' . $array['month']);
        } catch (PDOException $e) {
            trigger_error(print_r($e, true));
            $error[] = $nv_Lang->getModule('errorsave');
        }
    }
}

// Dùng đoạn này nếu dùng trình soạn thảo
if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$array['content'] = nv_htmlspecialchars(nv_editor_br2nl($array['content']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $array['content'] = nv_aleditor('content', '100%', '300px', $array['content']);
} else {
    $array['content'] = '<textarea class="form-control" rows="10" name="content">' . $array['content'] . '</textarea>';
}

$xtpl = new XTemplate($op . '.tpl', get_module_tpl_dir($op . '.tpl'));
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('OP', $op);
$xtpl->assign('DATA', $array);
$xtpl->assign('UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_upload);
$xtpl->assign('UPLOAD_PATH', NV_UPLOADS_DIR . '/' . $module_upload);

// Hiển thị lỗi
if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

for ($i = 1; $i <= 31; $i++) {
    $array_day = [];
    $array_day['value'] = $i;
    $array_day['sl'] = ($i == $array['day']) ? " selected=\"selected\"" : "";
    $xtpl->assign('DAY', $array_day);
    $xtpl->parse('main.loop_day');
}

for ($i = 1; $i <= 12; $i++) {
    $array_month = [];
    $array_month['value'] = $i;
    $array_month['sl'] = ($i == $array['month']) ? " selected=\"selected\"" : "";
    $xtpl->assign('MONTH', $array_month);
    $xtpl->parse('main.loop_month');
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
