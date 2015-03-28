<!-- BEGIN: main -->
<div style="text-align:center;">
    <!-- BEGIN: error -->
    <div style="color:#f00;font-weight:bold;">{ERROR}</div>
	<!-- END: error -->
    <form class="form-inline" method="post" action="{ACTION}main">
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
</div>
<!-- BEGIN: content -->
<div class="text-center">
<form class="form-inline" action="{ACTION}reddaysave" method="post">
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
	        <tr>
	            <th colspan="2">
	                <div >{LANG.rdeditday}</div>
	            </th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr>
	            <td>{LANG.rdholydays}:</td>
	            <td><input class="form-control" type="text" style="width: 100%" value="{rdholydays}" name="a0" /></td>
	        </tr>
	        <tr>
	            <td>{LANG.stateevents}:</td>
	            <td>
	                <!-- BEGIN: loop_stateevents --><textarea style="width: 100%" rows="5" name="a1[]">{stateevents}</textarea>
	                <!-- END: loop_stateevents --><textarea style="width: 100%" rows="5" name="a1[]"></textarea>
	            </td>
	        </tr>
	        <tr>
	            <td>{LANG.interevents}:</td>
	            <td>
	                <!-- BEGIN: loop_interevents --><textarea style="width: 100%" rows="5" name="a2[]">{interevents}</textarea>
	                <!-- END: loop_interevents --><textarea style="width: 100%" rows="5" name="a2[]"></textarea>
	            </td>
	        </tr>     
	        <tr>
	        <td>{LANG.otherevents}:</td>
	        <td><textarea style="width: 100%" rows="5" cols="20" name="a3">{otherevents}</textarea></td>
	        </tr>
	        <tr>
	            <td>&nbsp;</td>
	            <td align="left">
	                <input type="hidden" value="{day}" name="day" />
	                <input type="hidden" value="{month}" name="month" />
	                <input class="btn btn-primary" type="submit" value="&nbsp;Save&nbsp;" name="Submit1" />&nbsp;
	                <input type="reset" value="&nbsp;Reset&nbsp;" name="Reset1" />
	            </td>
	        </tr>
	    </tbody>
	</table>
</div>
</form>
</div>
<!-- END: content -->

<!-- END: main -->