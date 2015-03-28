<!-- BEGIN: main -->
<div style="text-align:center;">
    <!-- BEGIN: error -->
    <div style="color:#f00;font-weight:bold;">{ERROR}</div>
	<!-- END: error -->
    <form method="post" action="{ACTION}main">
        <table class="tab1">
            <tbody>
                <tr>
                    <td>
                    {LANG.rdselectday}: &nbsp;
                        <select name="day">
                            <!-- BEGIN: loop_day -->
                            <option{DAY.sl} {DAY.value}>{DAY.value}</option>
                            <!-- END: loop_day -->
                        </select>
                        {LANG.rdselectmonth}: &nbsp;
                        <select name="month">
                            <!-- BEGIN: loop_month -->
                            <option{MONTH.sl} {MONTH.value}>{MONTH.value}</option>
                            <!-- END: loop_month -->
                        </select>
                        <input type="submit" value="{LANG.rdsubmit}" name="submit1" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<!-- BEGIN: content -->
<div align="center">
<form action="{ACTION}reddaysave" method="post">
<table class="tab1">
    <thead>
        <tr>
            <td colspan="2">
                <div >{LANG.rdeditday}</div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{LANG.rdholydays}:</td>
            <td><input type="text" style="width: 100%" value="{rdholydays}" name="a0" /></td>
        </tr>
    </tbody>
    <tbody class="second">
        <tr>
            <td>{LANG.stateevents}:</td>
            <td>
                <!-- BEGIN: loop_stateevents -->
                <textarea style="width: 100%" rows="5" name="a1[]">{stateevents}</textarea>
                <!-- END: loop_stateevents -->
                <textarea style="width: 100%" rows="5" name="a1[]"></textarea>
            </td>
        </tr>
    </tbody>   
    <tbody>
        <tr>
            <td>{LANG.interevents}:</td>
            <td>
                <!-- BEGIN: loop_interevents -->
                <textarea style="width: 100%" rows="5" name="a2[]">{interevents}</textarea>
                <!-- END: loop_interevents -->
                <textarea style="width: 100%" rows="5" name="a2[]"></textarea>
            </td>
        </tr>
    </tbody>  
    <tbody class="second">     
        <tr>
        <td>{LANG.otherevents}:</td>
        <td><textarea style="width: 100%" rows="5" cols="20" name="a3">{otherevents}</textarea></td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td align="left">
                <input type="hidden" value="{day}" name="day" />
                <input type="hidden" value="{month}" name="month" />
                <input type="submit" value="&nbsp;Save&nbsp;" name="Submit1" />&nbsp;
                <input type="reset" value="&nbsp;Reset&nbsp;" name="Reset1" />
            </td>
        </tr>
    </tbody>
</table>
</form>
</div>
<!-- END: content -->

<!-- END: main -->