<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger"><strong>{ERROR}</strong></div>
<!-- END: error -->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="text-center">
            <form class="form-inline" method="get" action="{ACTION}">
                <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}">
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}">
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}">
                <div class="form-group">
                    <label for="sl-day">{LANG.rdselectday}:</label>
                    <select class="form-control" name="day" id="sl-day">
                        <!-- BEGIN: loop_day -->
                        <option{DAY.sl} {DAY.value}>{DAY.value}</option>
                            <!-- END: loop_day -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="sl-month">{LANG.rdselectmonth}:</label>
                    <select class="form-control" name="month" id="sl-month">
                        <!-- BEGIN: loop_month -->
                        <option{MONTH.sl} {MONTH.value}>{MONTH.value}</option>
                            <!-- END: loop_month -->
                    </select>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{LANG.rdsubmit}" />
                </div>
            </form>
        </div>
    </div>
</div>
<h1 class="text-center m-bottom"><strong>{LANG.redday_time}</strong></h1>
<!-- BEGIN: cats -->
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>{CAT.title}</strong>
    </div>
    <div class="panel-body">
        <!-- BEGIN: loop -->
        <div class="alert alert-info">
            <div class="content m-bottom">
                {LOOP.content}
            </div>
            <div class="action text-right">
                <a class="btn btn-sm btn-default" href="{LOOP.url_edit}"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="nv_delele_content('{LOOP.id}', '{NV_CHECK_SESSION}');"><i class="fa fa-trash"></i> {GLANG.delete}</a>
            </div>
        </div>
        <!-- END: loop -->
    </div>
</div>
<!-- END: cats -->
<!-- END: main -->
