<script src="<?php echo base_url();?>plugins/js/select.country.js"></script>
<script src="<?php echo base_url();?>plugins/js/firebugx.js"></script>
<script src="<?php echo base_url();?>plugins/js/jquery.event.drag-2.0.min.js"></script>
<script src="<?php echo base_url();?>plugins/js/slick.core.js"></script>
<script src="<?php echo base_url();?>plugins/js/slickgrid.formatters.js"></script>
<script src="<?php echo base_url();?>plugins/js/slick.grid.js"></script>
<script src="<?php echo base_url();?>plugins/js/slick.dataview.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>plugins/css/slick.grid.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/css/custom-theme/jquery-ui-1.8.13.custom.css" type="text/css"/>
<style>
	.payeTableGrid{
		height: 350px;
		border: 1px solid #000000;
		font-size: 11px!important;
	}

	.slick-row, .slick-column, .alt_drop_div{
		font-size: 11px!important;
	}

	.slick-cell{
		font-size: 11px!important;
		cursor: pointer;
		text-align: center;
	}
	.slick-header-column{
		background: #000000!important;
		padding:3px 5px!important;
		color:#FFF!important;
		text-align: center!important;
		font-size: 11px!important;
	}
	.slick-row:hover {
		background: #44a7cc!important;
	}
	.slick-row.active{
		background: #ff8f47!important;
	}
	.drop-down{
		width: 10%;
	}
</style>

<div style="font-size: 12px;margin-bottom: 5px;margin-top:10px;">
	<?php
	echo '<strong>Frequency:</strong> ' . form_dropdown('frequency', $salary_freq, '', 'class="salary_frequency drop-down"') . ' &nbsp;';
	echo '<strong>Tax Code:</strong> ' . form_dropdown('tax_codes', $tax_codes, '', 'class="tax_codes drop-down"');
	?>
</div>
<div class="payeTableGrid"></div>

<script language="JavaScript">
	var payeTableGrid, payeTableData = [], payeTableDataView,
		payeTableCurrentSortCol = { id: "description" },
		payeTableGridColumns = [
			{id: "earning", name: "Earning", field: "earning", width: 50},
			{id: "paye", name: "PAYE", field: "paye", width: 40},
			{id: "sl", name: "SL", field: "sl", width: 40},
			{id: "kiwi_save_0_03", name: "KS 3%", field: "kiwi_save_0_03", width: 60},
			{id: "kiwi_save_0_04", name: "KS 4%", field: "kiwi_save_0_04", width: 60},
			{id: "kiwi_save_0_08", name: "KS 8%", field: "kiwi_save_0_08", width: 60},
			{id: "cec_0_105", name: "CEC", field: "cec_0_105", width: 60},
			{id: "esct_0_105", name: "10.5%", field: "esct_0_105", width: 60},
			{id: "cec_0_175", name: "CEC", field: "cec_0_175", width: 60},
			{id: "esct_0_175", name: "17.5%", field: "esct_0_175", width: 60},
			{id: "cec_0_3", name: "CEC", field: "cec_0_3", width: 60},
			{id: "esct_0_3", name: "30%", field: "esct_0_3", width: 60},
			{id: "cec_0_33", name: "CEC", field: "cec_0_33", width: 60},
			{id: "esct_0_33", name: "33%", field: "esct_0_33", width: 60}
		],
		payeTableGridOptions = {
			enableCellNavigation: true,
			enableColumnReorder: false,
			multiColumnSort: true,
			forceFitColumns: true
		},
		payeTableGridActiveId = "";

	$(function(e){
		var salary_frequency = $('.salary_frequency');
		var tax_codes = $('.tax_codes');

		loadPaye();
		$('.salary_frequency, .tax_codes').change(function(e){
			loadPaye();
		});

		function loadPaye(){
			$.fancybox.showLoading();
			$.post(
				'<?php echo base_url();?>payeJson',
				{
					frequency_id: salary_frequency.val(),
					tax_code_id: tax_codes.val()
				},
				function(json){
					payeTableData = json;

					payeTableExecutePlease();
					$.fancybox.hideLoading();
				}
			);
		}

		function payeTableExecutePlease(){
			payeTableDataView = new Slick.Data.DataView();
			payeTableGrid = new Slick.Grid(".payeTableGrid", payeTableDataView, payeTableGridColumns, payeTableGridOptions);

			//start
			// wire up model events to drive the grid
			payeTableDataView.onRowCountChanged.subscribe(function (e, args) {
				payeTableGrid.updateRowCount();
				payeTableGrid.render();
			});

			payeTableDataView.onRowsChanged.subscribe(function (e, args) {
				payeTableGrid.invalidateRows(args.rows);
				payeTableGrid.render();
			});
			//end

			payeTableDataView.beginUpdate();
			payeTableDataView.setItems(payeTableData);
			payeTableDataView.endUpdate();
		}
	});
</script>