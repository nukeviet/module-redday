/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(document).ready(function() {
    // Chọn ngày phụ thuộc tháng
    $('#sl-month').on('change', function() {
        var $this = $(this);
        var html = '';
        for (var d = 1; d <= reddayDayInMonth[$this.val()]; d++) {
            html += '<option value="' + d + '"' + (d == $('#sl-day').data('current') ? ' selected="selected"' : '') + '>' + d + '</option>';
        }
        $('#sl-day').html(html);
    });
    $('#sl-month').trigger('change');

    // Submit xem theo ngày tháng
    $('#redday-form').on('submit', function(e) {
        e.preventDefault();
        var link = $(this).data('link');
        link = link.replace('DDDD', $('#sl-day').val());
        link = link.replace('MMMM', $('#sl-month').val());
        window.location.href = link;
    });
});
