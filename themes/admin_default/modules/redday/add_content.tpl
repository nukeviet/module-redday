<!-- BEGIN: main -->
<p class="text-info"><span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span> {LANG.is_required}</p>
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<link rel="stylesheet" href="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>

<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{FORM_ACTION}" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-6 control-label" for="sl-day">{LANG.rdselectday}:</label>
                <div class="col-sm-18 col-lg-10">
                    <select class="form-control" name="day" id="sl-day">
                        <!-- BEGIN: loop_day -->
                        <option {DAY.sl} {DAY.value}>{DAY.value}</option>
                        <!-- END: loop_day -->
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label" for="sl-month">{LANG.rdselectmonth}:</label>
                <div class="col-sm-18 col-lg-10">
                    <select class="form-control" name="month" id="sl-month">
                        <!-- BEGIN: loop_month -->
                        <option{MONTH.sl} {MONTH.value}>{MONTH.value}</option>
                            <!-- END: loop_month -->
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label" for="element_cfg_cat">{LANG.main_cat} <span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span>:</label>
                <div class="col-sm-18 col-lg-10">
                    <select id="element_cfg_cat" name="catid" class="form-control">
                        <!-- BEGIN: cfg_cat -->
                        <option value="{CFG_CAT.id}" selected="selected">{CFG_CAT.title}</option>
                        <!-- END: cfg_cat -->
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label" for="element_image">{LANG.illustrating_images}:</label>
                <div class="col-sm-18 col-lg-10">
                    <div class="input-group">
                        <input type="text" id="element_image" name="image" value="{DATA.image}" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="element_image_pick"><i class="fa fa-file-image-o"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">{LANG.main_bodyhtml} <span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span>:</label>
                <div class="col-xs-24">
                    <div class="mt-1">
                        {DATA.content}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-18 col-sm-offset-6">
                    <input type="hidden" name="save" value="{NV_CHECK_SESSION}">
                    <button type="submit" class="btn btn-primary">{GLANG.submit}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Xử lý chọn ảnh
        $('#element_image_pick').on('click', function(e) {
            e.preventDefault();
            nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=element_image&path={UPLOAD_PATH}&type=image&currentpath={UPLOAD_CURRENT}", "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        });
        $('#element_cfg_cat').select2({
            width: '100%',
            language: '{NV_LANG_INTERFACE}',
            ajax: {
                delay: 250,
                cache: false,
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&nocache=' + new Date().getTime(),
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term,
                        ajax_check_cat: '{NV_CHECK_SESSION}',
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            },
            placeholder: '{LANG.select2_pick}',
            minimumInputLength: 2
        });
    });
</script>
<!-- END: main -->
