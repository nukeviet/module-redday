<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC (contact@vinades.vn)';
$lang_translator['createdate'] = '04/03/2010, 15:22';
$lang_translator['copyright'] = '@Copyright (C) 2012 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['op_day'] = 'ngay';
$lang_module['op_month'] = 'thang';

$lang_module['main_title'] = 'Ngày này năm xưa';
$lang_module['main_title_redday'] = 'Ngày %s tháng %s năm xưa';
$lang_module['main_description_redday'] = 'Những ngày lễ và sự kiện trong ngoài nước diễn ra trong ngày %s tháng %s năm xưa';
$lang_module['rdselectday'] = 'Chọn ngày';
$lang_module['rdselectmonth'] = 'Chọn tháng';
$lang_module['rdsubmit'] = 'Hiển thị';
$lang_module['rdday'] = 'Ngày';
$lang_module['rdmonth'] = 'tháng';

$lang_module['all'] = 'Tất cả';
$lang_module['add'] = 'Thêm';
$lang_module['close'] = 'Đóng';
$lang_module['title'] = 'Tiêu đề';
$lang_module['alias'] = 'Liên kết tĩnh';
$lang_module['errorsave'] = 'Vì một lý do nào đó mà dữ liệu không thể lưu lại được';
$lang_module['function'] = 'Chức năng';
$lang_module['order'] = 'Thứ tự';
$lang_module['status'] = 'Hoạt động';
$lang_module['status1'] = 'Kích hoạt';
$lang_module['keywords'] = 'Từ khóa';
$lang_module['search_keywords'] = 'Từ khóa tìm kiếm';
$lang_module['description'] = 'Mô tả';
$lang_module['illustrating_images'] = 'Ảnh minh họa';
$lang_module['note'] = 'Chú ý';
$lang_module['enter_search_key'] = 'Nhập từ khóa';
$lang_module['select2_pick'] = 'Nhập từ khóa để tìm và chọn';
$lang_module['addtime'] = 'Tạo lúc';
$lang_module['edittime'] = 'Cập nhật lúc';
$lang_module['approval'] = 'Duyệt bài đăng';
$lang_module['msgnocheck'] = 'Vui lòng chọn ít nhất một dòng để thực hiện';
$lang_module['to'] = 'đến';
$lang_module['from_day'] = 'Từ ngày';
$lang_module['to_day'] = 'Đến ngày';
$lang_module['is_required'] = 'là mục bắt buộc';
$lang_module['tools'] = 'Công cụ';

$lang_module['main'] = 'Danh sách sự kiện';
$lang_module['main_add'] = 'Thêm sự kiện';
$lang_module['main_edit'] = 'Sửa sự kiện';
$lang_module['main_cat'] = 'Thuộc danh mục';
$lang_module['main_cat1'] = 'Danh mục';
$lang_module['main_cat2'] = 'Danh mục chính';
$lang_module['main_bodyhtml'] = 'Nội dung sự kiện';
$lang_module['main_error_catids'] = 'Chưa chọn danh mục';
$lang_module['main_error_catid'] = 'Chưa chọn danh mục chính';
$lang_module['main_error_title'] = 'Chưa nhập tiêu đề';
$lang_module['main_error_exists'] = 'Liên kết tĩnh bị trùng, mời nhập giá trị khác';
$lang_module['main_error_bodyhtml'] = 'Chưa nhập nội dung sự kiện';
$lang_module['main_error_exits_cat'] = 'Không tồn tại danh mục';
$lang_module['main_error_month_match'] = 'Tháng không phù hợp';
$lang_module['main_error_day_match'] = 'Ngày không phù hợp';
$lang_module['main_search_from'] = 'Tạo từ ngày';
$lang_module['main_search_to'] = 'Tạo đến ngày';
$lang_module['main_search_d'] = 'Sự kiện vào ngày';
$lang_module['main_search_m'] = 'Sự kiện vào tháng';

$lang_module['excel_export_html'] = 'Xuất excel sự kiện đầy đủ mã HTML';
$lang_module['excel_export_plaintext'] = 'Xuất excel sự kiện dạng text thuần';
$lang_module['excel_import'] = 'Nhập sự kiện từ excel';
$lang_module['excel_import_alt'] = 'Nhập từ excel';
$lang_module['excel_download_template'] = 'Tải mẫu';
$lang_module['excel_note_template'] = 'Nhấp nút bên dưới để tải về mẫu excel, nhập liệu đúng theo mẫu đó. Yêu cầu không được thêm bớt, thay đổi thứ tự các cột';
$lang_module['excel_file_label'] = 'Chọn file Excel sau khi đã điền đầy đủ các dòng';
$lang_module['excel_pickcat'] = 'Nhập vào danh mục';
$lang_module['excel_skipcat'] = 'Không cập nhật danh mục của những dữ liệu đã có';
$lang_module['excel_truncate'] = 'Xóa toàn bộ sự kiện của danh mục trước khi nhập';
$lang_module['excel_error_nofile'] = 'Chưa chọn file excel';
$lang_module['import_error_readexcel'] = 'Không thể đọc file, kiểm tra lại định dạng excel';
$lang_module['excel_skip_error'] = 'Bỏ qua các dòng lỗi';
$lang_module['excel_nl2br'] = 'Chuyển ngắt dòng trong excel dòng thành thẻ xuống dòng trong HTML';
$lang_module['excel_error_time'] = 'Ngày tháng không hợp lệ tại dòng';
$lang_module['excel_error_content'] = 'Nội dung còn trống tại dòng';
$lang_module['excel_success'] = 'Import thành công, thông tin như sau';
$lang_module['excel_success_add'] = 'Số sự kiện thêm mới';
$lang_module['excel_success_update'] = 'Số sự kiện cập nhật';
$lang_module['excel_success_skip'] = 'Số dòng bị bỏ qua';

$lang_module['cat'] = 'Chủ đề';
$lang_module['add_content'] = 'Thêm sự kiện';
$lang_module['cat'] = 'Danh mục';
$lang_module['cat_title'] = 'Tên danh mục';
$lang_module['cat_description'] = 'Giới thiệu';
$lang_module['cat_add'] = 'Thêm danh mục';
$lang_module['cat_edit'] = 'Sửa danh mục';
$lang_module['cat_error_title'] = 'Tiêu đề không được để trống';
$lang_module['cat_error_exists'] = 'Tiêu đề bị trùng';

$lang_module['main'] = 'Ngày này năm xưa';
$lang_module['rderrdate'] = 'Hãy chọn ngày tháng để sửa';
$lang_module['rdeditday'] = 'Sửa ghi chép ngày %s tháng %s';
$lang_module['rdeditmonth'] = 'tháng';
$lang_module['rdholydays'] = 'Ngày lễ quốc gia';
$lang_module['stateevents'] = 'Sự kiện trong nước';
$lang_module['interevents'] = 'Sự kiện ngoài nước';
$lang_module['otherevents'] = 'Sự kiện khác';
$lang_module['reddayadmin'] = 'Ngày này năm xưa';
$lang_module['notauthorized'] = 'Bạn không có quyền truy cập vào khu vực này';
$lang_module['save_ok'] = 'Lưu dữ liệu thành công !';
$lang_module['redirect_to_home'] = 'Click để chuyển về trang chủ';
$lang_module['redday_time'] = 'Những sự kiện ngày %s tháng %s năm xưa';

$lang_module['error_month2'] = 'Lỗi: Tháng 2 không có ngày thứ %s';
$lang_module['error_month'] = 'Lỗi: Tháng %s không có ngày thứ %s';
