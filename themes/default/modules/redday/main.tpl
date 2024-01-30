<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger"><strong>{ERROR}</strong></div>
<!-- END: error -->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="text-center">
            <form class="form-inline" method="post" action="{ACTION}">
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
                    <input class="btn btn-primary" type="submit" value="{LANG.rdsubmit}" name="submit1" />
                </div>
            </form>
        </div>
    </div>
</div>
<div class="redday-title">
    <a title="{LANG.main_title}" href="{ACTION}">
        <img height="70" width="70" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/redday/redday.gif" alt="{LANG.main_title}" />
    </a>
    {LANG.main_title}
    <div class="text-center">{main_title_redday}</div>
    <div class="redday-event0">{reddayevent0}</div>
</div>
<!-- BEGIN: cats -->
<div class="redday-event">{CAT.title}</div>
<div class="redday-content">
    <ul>
        <!-- BEGIN: loop -->
        <li>{LOOP.content}</li>
        <!-- END: loop -->
    </ul>
</div>
<!-- END: cats -->
<!-- END: main -->
