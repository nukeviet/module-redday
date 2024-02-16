<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-body pb-0">
        <div class="text-center">
            <form class="form-inline redday-form-inline" id="redday-form" data-link="{LINK_SUBMIT}">
                <div class="form-group">
                    <label for="sl-month">{LANG.rdselectmonth}:</label>
                    <select class="form-control redday-input" name="month" id="sl-month">
                        <!-- BEGIN: month -->
                        <option value="{MONTH.key}"{MONTH.selected}>{MONTH.title}</option>
                        <!-- END: month -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="sl-day">{LANG.rdselectday}:</label>
                    <select class="form-control redday-input" name="day" id="sl-day" data-current="{DAY}">
                        <option value="0">--</option>
                    </select>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{LANG.rdsubmit}">
                </div>
            </form>
        </div>
    </div>
</div>

<h1 class="margin-bottom">{PAGE_TITLE}</h1>

<!-- BEGIN: cats -->
<h2 class="margin-bottom"><i class="fa fa-calendar-o text-success" aria-hidden="true"></i> {CAT.title}</h2>
<!-- BEGIN: loop -->
<div class="panel panel-primary">
    <div class="panel-body">
        {LOOP.content}
    </div>
</div>
<!-- END: loop -->
<!-- END: cats -->

<script>
window.reddayDayInMonth = {JSON_DAYINMONTH};
</script>
<!-- END: main -->
