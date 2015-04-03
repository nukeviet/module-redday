<!-- BEGIN: main -->
<div>
    <!-- BEGIN: error -->
    <div style="text-align:center;color:#f00;font-weight:bold;">{ERROR}</div>
	<!-- END: error -->
    <form class="form-inline" method="post" action="{ACTION}">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
                <tr>
                    <td>
                    {LANG.rdselectday}: &nbsp;
                        <select class="form-control" name="day">
                            <!-- BEGIN: loop_day -->
                            <option{DAY.sl} {DAY.value}>{DAY.value}</option>
                            <!-- END: loop_day -->
                        </select>
                        {LANG.rdselectmonth}: &nbsp;
                        <select class="form-control" name="month">
                            <!-- BEGIN: loop_month -->
                            <option{MONTH.sl} {MONTH.value}>{MONTH.value}</option>
                            <!-- END: loop_month -->
                        </select>
                        <input class="btn btn-primary" type="submit" value="{LANG.rdsubmit}" name="submit1" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <!-- BEGIN: content -->
    <div class="redday-title">
        <a title="{LANG.main_title}" href="{ACTION}">
            <img height="70" width="70" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/redday/redday.gif" alt="{LANG.main_title}" />
        </a>
        {LANG.main_title}
    </div>
    <div style="text-align:center;">{main_title_redday}</div>
    <div class="redday-event0">{reddayevent0}</div>
    <!-- BEGIN: stateevents -->
    <div class="redday-event">{LANG.stateevents}</div>
    <div>
        <ul>
            <!-- BEGIN: loop_stateevents -->
            <li>{stateevents}</li>
            <!-- END: loop_stateevents -->
        </ul>
    </div>
    <!-- END: stateevents -->
    <!-- BEGIN: interevents -->
    <div class="redday-event">{LANG.interevents}</div>
    <div>
        <ul>
            <!-- BEGIN: loop_interevents -->
            <li>{interevents}</li>
            <!-- END: loop_interevents -->
        </ul>
    </div>
    <!-- END: interevents -->
    <!-- BEGIN: otherevents -->
    <div class="redday-event">{LANG.otherevents}</div>
    <div>
        <ul>
            <!-- BEGIN: loop_otherevents -->
            <li>{otherevents}</li>
            <!-- END: loop_otherevents -->
        </ul>
    </div>
    <!-- END: otherevents -->
    <!-- END: content -->
</div>
<!-- END: main -->