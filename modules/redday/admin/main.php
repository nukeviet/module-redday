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

// Thay đổi hoạt động
if ($nv_Request->get_title('changestatus', 'post', '') === NV_CHECK_SESSION) {
    $id = $nv_Request->get_int('id', 'post', 0);

    // Kiểm tra tồn tại
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id=" . $id;
    $array = $db->query($sql)->fetch();
    if (empty($array)) {
        nv_htmlOutput('NO_' . $id);
    }

    $status = empty($array['status']) ? 1 : 0;

    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET status = " . $status . " WHERE id = " . $id;
    $db->query($sql);

    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_CHANGE_STATUS_CONTENT', json_encode($array), $admin_info['admin_id']);
    $nv_Cache->delMod($module_name);

    nv_htmlOutput("OK");
}

// Xóa bỏ 1 hoặc nhiều
if ($nv_Request->get_title('delete', 'post', '') === NV_CHECK_SESSION) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $listid = $nv_Request->get_title('listid', 'post', '');
    $listid = $listid . ',' . $id;
    $listid = array_filter(array_unique(array_map('intval', explode(',', $listid))));

    foreach ($listid as $id) {
        // Kiểm tra tồn tại
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id=" . $id;
        $array = $db->query($sql)->fetch();
        if (!empty($array)) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_DELETE_CONTENT', json_encode($array), $admin_info['admin_id']);

            // Xóa
            $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id=" . $id;
            $db->query($sql);
        }
    }

    $nv_Cache->delMod($module_name);
    nv_htmlOutput("OK");
}

$page_title = $nv_Lang->getModule('main');

$per_page = 20;
$page = $nv_Request->get_absint('page', 'get', 1);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

// Phần tìm kiếm
$array_search = [];
$array_search['q'] = $nv_Request->get_title('q', 'get', '');
$array_search['from'] = $nv_Request->get_title('f', 'get', '');
$array_search['to'] = $nv_Request->get_title('t', 'get', '');
$array_search['day'] = $nv_Request->get_absint('d', 'get', 0);
$array_search['month'] = $nv_Request->get_absint('m', 'get', 0);
$array_search['catid'] = $nv_Request->get_absint('c', 'get', 0);

// Xử lý dữ liệu tìm kiếm
if (preg_match('/^([0-9]{1,2})\-([0-9]{1,2})\-([0-9]{4})$/', $array_search['from'], $m)) {
    $array_search['from'] = mktime(0, 0, 0, intval($m[2]), intval($m[1]), intval($m[3]));
} else {
    $array_search['from'] = 0;
}
if (preg_match('/^([0-9]{1,2})\-([0-9]{1,2})\-([0-9]{4})$/', $array_search['to'], $m)) {
    $array_search['to'] = mktime(23, 59, 59, intval($m[2]), intval($m[1]), intval($m[3]));
} else {
    $array_search['to'] = 0;
}
if ($array_search['day'] > 31) {
    $array_search['day'] = 0;
}
if ($array_search['month'] > 12) {
    $array_search['month'] = 0;
}
if (!isset($global_array_cats[$array_search['catid']])) {
    $array_search['catid'] = 0;
}

$db->sqlreset()->select('COUNT(*)')->from(NV_PREFIXLANG . '_' . $module_data . '_rows');

$where = [];
if (!empty($array_search['q'])) {
    $base_url .= '&amp;q=' . urlencode($array_search['q']);
    $dblikekey = $db->dblikeescape($array_search['q']);
    $where[] = "content LIKE '%" . $dblikekey . "%'";
}
if (!empty($array_search['from'])) {
    $base_url .= '&amp;f=' . nv_date('d-m-Y', $array_search['from']);
    $where[] = "add_time>=" . $array_search['from'];
}
if (!empty($array_search['to'])) {
    $base_url .= '&amp;t=' . nv_date('d-m-Y', $array_search['to']);
    $where[] = "add_time<=" . $array_search['to'];
}
if (!empty($array_search['day'])) {
    $base_url .= '&amp;d=' . $array_search['day'];
    $where[] = "day=" . $array_search['day'];
}
if (!empty($array_search['month'])) {
    $base_url .= '&amp;m=' . $array_search['month'];
    $where[] = "month=" . $array_search['month'];
}
if (!empty($array_search['catid'])) {
    $base_url .= '&amp;c=' . $array_search['catid'];
    $where[] = "catid=" . $array_search['catid'];
}

// Phần sắp xếp
$array_order = [];
$array_order['field'] = $nv_Request->get_title('of', 'get', '');
$array_order['value'] = $nv_Request->get_title('ov', 'get', '');
$base_url_order = $base_url;
if ($page > 1) {
    $base_url_order .= '&amp;page=' . $page;
}

// Định nghĩa các field và các value được phép sắp xếp
$order_fields = ['add_time', 'edit_time'];
$order_values = ['asc', 'desc'];

if (!in_array($array_order['field'], $order_fields)) {
    $array_order['field'] = '';
}
if (!in_array($array_order['value'], $order_values)) {
    $array_order['value'] = '';
}

if (!empty($where)) {
    $db->where(implode(' AND ', $where));
}

$num_items = $db->query($db->sql())->fetchColumn();

if (!empty($array_order['field']) and !empty($array_order['value'])) {
    $order = $array_order['field'] . ' ' . $array_order['value'];
} else {
    $order = 'id DESC';
}
$db->select('*')->order($order)->limit($per_page)->offset(($page - 1) * $per_page);
$result = $db->query($db->sql());

$xtpl = new XTemplate('main.tpl', get_module_tpl_dir('main.tpl'));
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('OP', $op);

$xtpl->assign('LINK_ADD_NEW', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content');
$xtpl->assign('LINK_IMPORT', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=import');

// Chuyển tìm kiếm sang ngày tháng
$array_search['from'] = empty($array_search['from']) ? '' : nv_date('d-m-Y', $array_search['from']);
$array_search['to'] = empty($array_search['to']) ? '' : nv_date('d-m-Y', $array_search['to']);

$xtpl->assign('SEARCH', $array_search);

while ($row = $result->fetch()) {
    $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $row['id'];
    $row['status_render'] = $row['status'] ? ' checked="checked"' : '';
    $row['add_time'] = nv_date('d/m/Y H:i', $row['add_time']);
    $row['edit_time'] = $row['edit_time'] ? nv_date('d/m/Y H:i', $row['edit_time']) : '';
    $row['cat_name'] = isset($global_array_cats[$row['catid']]) ? $global_array_cats[$row['catid']]['title'] : ('#' . $row['catid']);
    $row['event_day'] = str_pad($row['day'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($row['month'], 2, '0', STR_PAD_LEFT);

    $row['title'] = nv_clean60(nv_unhtmlspecialchars(strip_tags($row['content'])), 120);

    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

// Xuất phân trang
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

// Xuất các phần sắp xếp
foreach ($order_fields as $field) {
    $url = $base_url_order;
    if ($array_order['field'] == $field) {
        if (empty($array_order['value'])) {
            $url .= '&amp;of=' . $field . '&amp;ov=asc';
            $icon = '<i class="fa fa-sort" aria-hidden="true"></i>';
        } elseif ($array_order['value'] == 'asc') {
            $url .= '&amp;of=' . $field . '&amp;ov=desc';
            $icon = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
        } else {
            $icon = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
        }
    } else {
        $url .= '&amp;of=' . $field . '&amp;ov=asc';
        $icon = '<i class="fa fa-sort" aria-hidden="true"></i>';
    }

    $xtpl->assign(strtoupper('URL_ORDER_' . $field), $url);
    $xtpl->assign(strtoupper('ICON_ORDER_' . $field), $icon);
}

// Xuất ngày
for ($i = 1; $i < 32; $i++) {
    $xtpl->assign('DAY', [
        'key' => $i,
        'title' => $i,
        'selected' => $i == $array_search['day'] ? ' selected="selected"' : '',
    ]);
    $xtpl->parse('main.day');
}

// Xuất tháng
for ($i = 1; $i < 13; $i++) {
    $xtpl->assign('MONTH', [
        'key' => $i,
        'title' => $i,
        'selected' => $i == $array_search['month'] ? ' selected="selected"' : '',
    ]);
    $xtpl->parse('main.month');
}

// Xuất danh mục
foreach ($global_array_cats as $cat) {
    $cat['selected'] = $array_search['catid'] == $cat['id'] ? ' selected="selected"' : '';
    $xtpl->assign('CAT', $cat);
    $xtpl->parse('main.cat');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
