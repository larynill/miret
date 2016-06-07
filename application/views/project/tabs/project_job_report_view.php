<?php
$url = current_url();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$url .= $id ? '?id=' . $id .'' : '';
echo form_open($url)
?>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label">Report Conclusion</label>
            <textarea class="form-control input-sm" name="report_conclusion" rows="20"><?php echo @$conclusion->report_conclusion;?></textarea>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-sm btn-primary generate-report"><i class="glyphicon glyphicon-print"></i> Generate Report</button>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <div class="pdf-view" style="overflow-y:auto;padding:5px;width: 100%;height: 800px;border: 1px solid #000000"></div>
        </div>
    </div>
</div>
<?php
echo form_close();
?>
<script>
    $(function(e){
        var url = '<?php echo base_url().'generateJobReport/'.$id.'?v=1'?>';
        $('.pdf-view').load(url);
        $('.generate-report').click(function(e){
            e.preventDefault();
            $(this).newForm.addLoadingForm();
            $.post(bu + 'generateJobReport/<?php echo $id;?>',{submit:1,report_conclusion:$('textarea[name="report_conclusion"]').val()},function(res){
                window.open(
                    bu + 'generateJobReport/<?php echo $id;?>'
                );
                $(this).newForm.removeLoadingForm();
            });
        });
        $('textarea[name="report_conclusion"]')
            .on('keyup',function(e){
                var pdf_view = $('.pdf-view');
                var _value = $(this).val();
                pdf_view.find('.conclusion').html(_value.replace(/\n/g, "<br />"));
            })
            .on('focusout',function(e){
                $.post(bu + 'generateJobReport/<?php echo $id;?>',{submit:1,report_conclusion:$(this).val()},function(res){});
            })

    });
</script>