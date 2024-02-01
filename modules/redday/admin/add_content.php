<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( !defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['add_content'];
$per_page = 10;
$error = [];

if ($nv_Request->get_title('ajax_cfg_cat', 'post', '') === NV_CHECK_SESSION) {
    $respon = [];
    $q = $nv_Request->get_title('q', 'post', '');
    if (!empty($q)) {
        $db->sqlreset()->select('COUNT(id)')->from(NV_PREFIXLANG . '_' . $module_data . '_cats');
        $db->where("title LIKE '%" . $db->dblikeescape($q) . "%'");
        $db->limit(10);
        $db->select('id, title text')->order('title ASC')->limit($per_page);
        $respon = $db->query($db->sql())->fetchAll() ?: [];
    }
    nv_jsonOutput($respon);
}

// Lấy id bài viết cần sửa nếu có
$id = $nv_Request->get_int('id', 'get', 0);
$array = [];
if (!empty($id)) {
    // Kiểm tra bài viết sửa
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id = " . $id;
    $result = $db->query($sql);
    $array = $result->fetch();

    if (empty($array)) {
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
    }

    $page_title = $lang_module['main_edit'];
    $form_action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $id;
} else {
    $array = [
        'catid' => 0,
        'day' => nv_date('j', NV_CURRENTTIME),
        'month' => nv_date('n', NV_CURRENTTIME),
        'image' => '',
        'content' => ''
    ];

    $page_title = $lang_module['main_add'];
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

    // Xử lý dữ liệu
    if (empty($array['catid'])) {
        $error[] = $lang_module['main_error_catids'];
    } elseif (!in_array($array['catid'], array_keys($global_array_cats))) {
        $error[] = $lang_module['main_error_exits_cat'];
    }
    if (empty($array['content'])) {
        $error[] = $lang_module['main_error_bodyhtml'];
    }
    if (!nv_is_file($array['image'], NV_UPLOADS_DIR . '/' . $module_upload)) {
        $array['image'] = '';
    } 

    if (!in_array($array['month'], array_keys($arr_allow_date))) {
        $error[] = $lang_module['main_error_month_match'];
    }
    if (!(($array['day'] >= 1) && ($array['day'] <= $arr_allow_date[$array['month']]))) {
        $error[] = sprintf($lang_module['error_month'], $array['month'], $array['day']);
    }

    if (empty($error)) {
        if (!$id) {
            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_rows (
                catid, day, month, image, content
            ) VALUES (
                " . $array['catid'] . ", " . $array['day'] . ",  " . $array['month'] . ",
                :image, :content)";
        } else {
            $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET
                catid=" . $array['catid'] . ",
                day=" . $array['day'] . ",
                month=" . $array['month'] . ",
                image=:image, 
                content=:content
            WHERE id = " . $id;
        }

        try {
            $sth = $db->prepare($sql);
            $sth->bindParam(':image', $array['image'], PDO::PARAM_STR);
            $sth->bindParam(':content', $array['content'], PDO::PARAM_STR, strlen($array['content']));
            $sth->execute();

            if ($id) {
                nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_EDIT_CONTENT', $id , $admin_info['userid']);
            } else {
                nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_ADD_CONTENT', '', $admin_info['userid']);
            }

            $nv_Cache->delMod($module_name);
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&day=' . $array['day'] . '&month=' . $array['month']);
        } catch (PDOException $e) {
            trigger_error(print_r($e, true));
            $error[] = $lang_module['errorsave'];
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

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('OP', $op);
$xtpl->assign('NV_CHECK_SESSION', NV_CHECK_SESSION);
$xtpl->assign('DATA', $array);
$xtpl->assign('UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_upload);
$xtpl->assign('UPLOAD_PATH', NV_UPLOADS_DIR . '/' . $module_upload);
// Hiển thị lỗi
if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

for( $i = 1; $i <= 31; $i++ )
{
    $array_day = [];
	$array_day['value'] = $i;
	$array_day['sl'] = ($i == $array['day']) ? " selected=\"selected\"" : "";
	$xtpl->assign( 'DAY', $array_day );
	$xtpl->parse( 'main.loop_day' );
}
for( $i = 1; $i <= 12; $i++ )
{
    $array_month = [];
	$array_month['value'] = $i;
	$array_month['sl'] = ($i == $array['month']) ? " selected=\"selected\"" : "";
	$xtpl->assign( 'MONTH', $array_month );
	$xtpl->parse( 'main.loop_month' );
}

if (!empty($array['catid'])) {
    $xtpl->assign('CFG_CAT', $global_array_cats[$array['catid']]);
    $xtpl->parse('main.cfg_cat');
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
