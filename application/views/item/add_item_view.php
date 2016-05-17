<?php
echo form_open('','class="form-horizontal"');
?>
<div class="modal-body">
    <div class="row-fluid">

        <div class="col-sm-8">
            <div class="form-group">
                <label class="control-label">Report Text</label>
                <textarea class="form-control input-sm" name="report_text"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancel</button>
    <button class="btn btn-sm btn-primary" type="submit" name="submit">Submit</button>
</div>
<?php
echo form_close();
?>