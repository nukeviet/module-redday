<!-- BEGIN: main -->
<link type="text/css" href="{NV_STATIC_URL}themes/default/images/{MODULE_FILE}/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<link type="text/css" href="{NV_STATIC_URL}themes/default/images/{MODULE_FILE}/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_STATIC_URL}themes/default/images/{MODULE_FILE}/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="{NV_STATIC_URL}themes/default/images/{MODULE_FILE}/bootstrap-datepicker/locales/bootstrap-datepicker.{NV_LANG_INTERFACE}.min.js"></script>
<form method="get" action="{NV_BASE_ADMINURL}index.php">
    <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}">
    <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="element_q">{LANG.search_keywords}:</label>
                <input type="text" class="form-control" id="element_q" name="q" value="{SEARCH.q}" placeholder="{LANG.enter_search_key}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="element_from">{LANG.main_search_from}:</label>
                <input type="text" class="form-control datepicker" id="element_from" name="f" value="{SEARCH.from}" placeholder="dd/mm/yyyy" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="element_to">{LANG.main_search_to}:</label>
                <input type="text" class="form-control datepicker" id="element_to" name="t" value="{SEARCH.to}" placeholder="dd/mm/yyyy" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="element_day">{LANG.main_search_d}:</label>
                <select class="form-control" name="d" id="element_day">
                    <option value="0">{LANG.all}</option>
                    <!-- BEGIN: day -->
                    <option value="{DAY.key}"{DAY.selected}>{DAY.title}</option>
                    <!-- END: day -->
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="element_month">{LANG.main_search_m}:</label>
                <select class="form-control" name="m" id="element_month">
                    <option value="0">{LANG.all}</option>
                    <!-- BEGIN: month -->
                    <option value="{MONTH.key}"{MONTH.selected}>{MONTH.title}</option>
                    <!-- END: month -->
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="element_cat">{LANG.main_cat}:</label>
                <select class="form-control" name="c" id="element_cat">
                    <option value="0">{LANG.all}</option>
                    <!-- BEGIN: cat -->
                    <option value="{CAT.id}"{CAT.selected}>{CAT.title}</option>
                    <!-- END: cat -->
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> {GLANG.search}</button>
                <a href="{LINK_ADD_NEW}" class="btn btn-success"><i class="fa fa-plus"></i> {LANG.main_add}</a>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $('.datepicker').datepicker({
        language: '{NV_LANG_INTERFACE}',
        format: 'dd-mm-yyyy',
        weekStart: 1,
        todayBtn: 'linked',
        autoclose: true,
        todayHighlight: true,
        zIndexOffset: 1000
    });
});
</script>
<form>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 1%" class="text-center">
                        <input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);">
                    </th>
                    <th style="width: 40%" class="text-nowrap">
                        {LANG.main_bodyhtml}
                    </th>
                    <th style="width: 15%" class="text-nowrap">
                        <a href="{URL_ORDER_ADD_TIME}">{ICON_ORDER_ADD_TIME} {LANG.addtime}</a>
                    </th>
                    <th style="width: 15%" class="text-nowrap">
                        <a href="{URL_ORDER_EDIT_TIME}">{ICON_ORDER_EDIT_TIME} {LANG.edittime}</a>
                    </th>
                    <th style="width: 15%" class="text-nowrap text-center">{LANG.status}</th>
                    <th style="width: 14%" class="text-nowrap text-center">{LANG.function}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">
                        <input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]">
                    </td>
                    <td>
                        <div class="mb-1">
                            <span class="label label-primary">{ROW.event_day}</span>
                            <span class="label label-info">{ROW.cat_name}</span>
                        </div>
                        <a href="#md-content-{ROW.id}" data-toggle="modal">{ROW.title}</a>
                        <!-- START FORFOOTER -->
                        <div class="modal fade" tabindex="-1" role="dialog" id="md-content-{ROW.id}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        {ROW.content}
                                    </div>
                                    <div class="modal-footer">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times text-danger"></i> {LANG.close}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORFOOTER -->
                    </td>
                    <td class="text-nowrap">{ROW.add_time}</td>
                    <td class="text-nowrap">{ROW.edit_time}</td>
                    <td class="text-center">
                        <input name="status" id="change_status{ROW.id}" value="1" type="checkbox"{ROW.status_render} onclick="nv_change_content_status('{ROW.id}', '{NV_CHECK_SESSION}');">
                    </td>
                    <td class="text-center text-nowrap">
                        <a href="{ROW.url_edit}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                        <a href="javascript:void(0);" onclick="nv_delele_content('{ROW.id}', '{NV_CHECK_SESSION}');" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> {GLANG.delete}</a>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td colspan="6">
                        {GENERATE_PAGE}
                    </td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
        </table>
    </div>
    <div class="form-group form-inline">
        <div class="form-group">
            <select class="form-control" id="action-of-content">
                <option value="delete">{GLANG.delete}</option>
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="nv_content_action(this.form, '{NV_CHECK_SESSION}', '{LANG.msgnocheck}')">{GLANG.submit}</button>
    </div>
</form>
<!-- END: main -->
