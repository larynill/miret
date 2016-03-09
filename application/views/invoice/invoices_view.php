<script>
	$(function(e){
		var invoice = $('.invoice-view');
		invoice.click(function(e){
			window.location.href = '<?php echo base_url()?>job_invoice/' + this.id;
		});
	});
</script>

<?php
echo form_open('');
?>
<table class="table table-colored-header">
    <thead>
    <tr>
        <th>Client</th>
        <th style="width: 20%;">Invoice</th>
        <th style="width: 20%;">Invoice Summary</th>
        <th style="width: 20%;">Statement</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($clients)>0){
        foreach($clients as $k=>$v){
            ?>
            <tr>
                <td style="text-align: left;width: 20%;padding-left: 10px;"><?php echo $v->CompanyName.' <strong>('. $v->invoice_count .')</strong>';?></td>
                <td><a href="#" class="invoice-view" id="<?php echo $v->ID;?>">view</a></td>
                <td><a href="<?php echo base_url().'invoiceSummary/'.$v->ID;?>">view</a></td>
                <td><a href="<?php echo base_url().'statement?cID='.$v->ID.'&pageType=statement';?>">view</a></td>
            </tr>
        <?php }
    }else{
        ?>
        <tr>
            <td colspan="12">No data was found.</td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
<?php
echo form_close();
?>