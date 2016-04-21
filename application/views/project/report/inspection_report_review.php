<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <a href="#" class="btn btn-sm btn-success send-report"><i class="glyphicon glyphicon-send"></i> Send Report</a>
        </div>
    </div>
</div><br/>
<div class="row">
    <div class="col-sm-12">
        <iframe src="<?php echo base_url('pdf/inspection_report/' . $_id . '/' . $_file);?>" width="100%" height="600"></iframe>
    </div>
</div>
<script>
    $(function(e){
       $('.send-report').click(function(){
            $(this).modifiedModal({
                url: bu + 'inspectionReport?email=1',
                title: 'Setup Email',
                type: 'small'
            });
       });
    });
</script>