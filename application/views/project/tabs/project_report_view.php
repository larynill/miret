<?php
$url = current_url();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$url .= $id ? '?id=' . $id .'' : '';
echo form_open($url)
?>
<div class="row">
    <div class="col-sm-4">
        <!--<div class="form-group">
            <label class="control-label">Estimate <span class="text-danger">(Leave empty if you want to use the Estimate tab)</span></label>
            <textarea class="form-control input-sm" name="estimate" rows="7"></textarea>
        </div>-->
        <div class="form-group">
            <label class="control-label">Report Conclusion</label>
            <textarea class="form-control input-sm" name="report_conclusion" rows="20"></textarea>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-print"></i> Generate Report</button>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <iframe src="<?php echo base_url().'generateJobReport/'.$id?>" style="width: 100%;height: 800px;border: 1px solid #000000">No data </iframe>
        </div>
    </div>
</div>
<?php
echo form_close();
?>