<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-body">
        <p>{LANG.excel_note_template}</p>
        <a class="btn btn-success" download href="{LINK_TEMPLATE}"><i class="fa fa-file-excel-o"></i> {LANG.excel_download_template}</a>
    </div>
</div>

<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<!-- BEGIN: import_data -->
<div class="alert alert-success">
    <p><strong>{LANG.excel_success}:</strong></p>
    <ul>
        <li>{LANG.excel_success_add}: <strong>{IMPORT_DATA.add}</strong></li>
        <li>{LANG.excel_success_update}: <strong>{IMPORT_DATA.update}</strong></li>
        <li>{LANG.excel_success_skip}: <strong>{IMPORT_DATA.skip}</strong></li>
    </ul>
</div>
<!-- END: import_data -->

<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{FORM_ACTION}" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <label for="element_import_file"><strong>{LANG.excel_file_label}:</strong></label>
                <input type="file" name="import_file" id="element_import_file">
            </div>
            <div class="form-group">
                <label for="element_catid"><strong>{LANG.excel_pickcat}:</strong></label>
                <div class="form-inline">
                   <select id="element_catid" name="catid" class="form-control">
                        <option value="0">----</option>
                        <!-- BEGIN: cat -->
                        <option value="{CAT.id}"{CAT.selected}>{CAT.title}</option>
                        <!-- END: cat -->
                    </select>
               </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="truncate_data" value="1"{DATA.truncate_data}> <strong class="text-danger">{LANG.excel_truncate}</strong></label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="skip_cat" value="1"{DATA.skip_cat}> <strong>{LANG.excel_skipcat}</strong></label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="skip_error" value="1"{DATA.skip_error}> <strong>{LANG.excel_skip_error}</strong></label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="nl2br" value="1"{DATA.nl2br}> <strong>{LANG.excel_nl2br}</strong></label>
                </div>
            </div>
            <input type="hidden" name="save" value="{NV_CHECK_SESSION}">
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> {GLANG.submit}</button>
        </form>
    </div>
</div>
<!-- BEGIN: warning -->
<div class="alert alert-danger">{WARNING}</div>
<!-- END: warning -->
<!-- END: main -->
