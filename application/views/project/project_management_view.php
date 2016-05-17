<!-- Nav tabs -->
<?php
$reg_links = array(
    'details' => 'Details',
    'notes' => 'Notes',
);
$_links = array(
    'inspection' => 'Inspection',
    'photos' => 'Photos',
    /*'estimates' => 'Estimates',*/
    'report' => 'Report',
    'expenses' => 'Expenses',
    'invoices' => 'Invoices',
    'dossiers' => 'Dossiers'
);

$has_id = isset($_GET['id']) ? 1 : 0;
$links = $has_id ? array_merge($reg_links,$_links) : $reg_links;
reset($links);
$first_key = key($links);
$df_link = $this->session->userdata('_link');

$df_link = $df_link ? (array_key_exists($df_link,$links) ? $df_link : $first_key) : $first_key;

echo '<span class="df_link" link="' . $df_link . '"></span>';
?>
<ul class="nav nav-tabs" role="tablist">
    <?php
    $ref = 1;
    foreach($links as $key=>$val){
        $active = $df_link == $key ? 'class="active"' : '';
        echo '<li role="presentation" ' . $active . '><a href="#' . $key . '" aria-controls="' . $key . '" role="tab" data-toggle="tab">' . $val . '</a></li>';
        $ref++;
    }
    ?>
</ul>
<!-- Tab panels -->
<?php
$url = current_url();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$url .= $id ? '?id=' . $id .'' : '';

echo form_open($url,'role="form"');
$job_num = str_pad(@$job->id,5,'0',STR_PAD_LEFT);
?>
<div class="tab-content">
    <?php
    $ref = 1;
    foreach($links as $key=>$val){
        $active = $df_link == $key ? 'active' : '';
        echo '<div role="tabpanel" class="tab-pane ' . $active . '" id="' . $key . '"></div>';
        $ref++;
    }
    ?>
</div>
<div class="row" style="border-top: 1px solid #808080;padding: 5px;">
    <div class="form-group">
        <div class="pull-right">
            <?php
            $enable = false;
            if(count($_userData) > 0){
                foreach($_userData as $data){
                    $enable = $data->isCanAddJob;
                }
            }
            if($enable) {
                if ($id) {
                    ?>
                    <a href="<?php echo base_url('trackingLog')?>" class="btn btn-sm btn-default">Cancel</a>
                    <button type="submit" name="submit_details" class="btn btn-sm btn-primary submit-value">Update
                    </button>
                <?php
                } else {
                    ?>
                    <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" name="submit_details" class="btn btn-sm btn-primary submit-value">Submit
                    </button>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php
echo form_close();
?>
<style>
    .tab-pane{
        padding: 15px 0;
        min-height: 500px;
    }
    .nav-tabs li{
        margin-left: 0;
    }
    .nav-tabs > li.active > a,
    .nav-tabs > li.active > a:hover,
    .nav-tabs > li.active > a:focus{
        background: #3468b2;
        color: #ffffff;
    }
    .nav-tabs > li > a,
    .nav-tabs > li > a:hover,
    .nav-tabs > li > a:focus{
        background: #b4b9bc;
        color: #ffffff;
    }
</style>
<script>
    $(function(e){
        var unlock_btn = $('.unlock-btn');
        var job_type_dp = $('.job_type_dp');
        var enable_add_job = <?php echo $enable;?>;
        var df_link = $('.df_link').attr('link');
        var id = <?php echo isset($_GET['id']) ? $_GET['id'] : 0;?>;
        var url = bu + 'jobRegistration/' + df_link + (id ? '?id=' + id : '');
        var tab_panel = $('.tab-pane');
        //tab_panel.html('');
        var _has_link = function(){
            var _df_link = $('#' + df_link);
            if(_df_link.text().length == 0){
                _df_link.load(url);
            }

        };

        _has_link();

        unlock_btn.click(function(){
            job_type_dp.removeAttr('disabled');
        });

        job_type_dp.change(function(){
            var hidden_job_type_id = $('.tab-content').find('.job_type_id');
            hidden_job_type_id.val($(this).val());
            if ( unlock_btn.length ) {
                $(this).attr('disabled', 'disabled');
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var link = $(this).attr('aria-controls');
            var url = bu + 'jobRegistration/' + link + (id ? '?id=' + id : '');
            //tab_panel.html('');
            var _link = $('#' + link);
            if(_link.text().length == 0){
                _link.load(url);
            }

        });

        var disableFormChanges = function(){

        };
        disableFormChanges();
    });
</script>