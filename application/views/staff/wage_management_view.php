<link href='<?php echo base_url();?>plugins/css/addForm.css' rel='stylesheet' />
<script src='<?php echo base_url();?>plugins/js/addForm.js'></script>

<script language="javascript">
$(function(e){
	//region Wage Type Area Here
	var bu = '<?php echo base_url();?>';
	var addWageType = $('.addWageType');
	var editWageType = $('.editWageType');
	var deleteWageType = $('.deleteWageType');

	addWageType.click(function(e){
		$(this).newForm.addNewForm({
			title: 'Add Wage Type',
			url: bu + 'addWageType',
			toFind: '.addWageTable'
		});
	});
	editWageType.click(function(e){
		var thisId = this.id;

		$(this).newForm.addNewForm({
			title: 'Edit Wage Type',
			url: bu + 'editWageType/' + thisId,
			toFind: '.addWageTable'
		});
	});
	deleteWageType.click(function(e){
		var thisId = this.id;

		$(this).newForm.formDeleteQuery();
		$('.yesBtn').unbind().on('click', function(e){
			$.post(
				bu + 'deleteWageType',
				{
					id: thisId
				},
				function(e){
					location.reload();
				}
			);
		});
		$('.noBtn').unbind().on('click', function(e){
			$(this).newForm.forceClose();
		});
	});
	var detailForm = $('#detailForm');
	$('.hover_to_view').hover(function(e){
		var thisId = this.id;
		var desc = $(this).find('.detailsTxt').html();

		$('#detailFormContent').html(desc);
		var xPos = $(this).offset().left + $(this).innerWidth() + 5;
		var yPos = $(this).offset().top + 2;
		detailForm
			.show()
			.css({
				'top': yPos + 'px',
				'left': xPos + 'px'
			});
	},function(e){
		detailForm.hide();
	});

	//region Frequency Area
	var addFrequency = $('.addFrequency');
	var editFrequency = $('.editFrequency');
	var deleteFrequency = $('.deleteFrequency');

	addFrequency.click(function(e){
		$(this).newForm.addNewForm({
			title: 'Add Frequency',
			url: bu + 'addFrequency',
			toFind: '.frequencyTable'
		})
	});
	editFrequency.click(function(e){
		var thisId = this.id;

		$(this).newForm.addNewForm({
			title: 'Edit Frequency',
			url: bu + 'editFrequency/' + thisId,
			toFind: '.frequencyTable'
		})
	});
	deleteFrequency.click(function(e){
		var thisId = this.id;

		$(this).newForm.formDeleteQuery();
		$('.yesBtn').unbind().on('click', function(e){
			$.post(
				bu + 'deleteFrequency',
				{
					id: thisId
				},
				function(e){
					location.reload();
				}
			);
		});
		$('.noBtn').unbind().on('click', function(e){
			$(this).newForm.forceClose();
		});
	});
	//endregion

	//region Type Area
	var addType = $('.addType');
	var editType = $('.editType');
	var deleteType = $('.deleteType');

	addType.click(function(e){
		$(this).newForm.addNewForm({
			title: 'Add Type',
			url: bu + 'addType',
			toFind: '.typeTable'
		})
	});
	editType.click(function(e){
		var thisId = this.id;

		$(this).newForm.addNewForm({
			title: 'Edit Type',
			url: bu + 'editType/' + thisId,
			toFind: '.typeTable'
		})
	});
	deleteType.click(function(e){
		var thisId = this.id;

		$(this).newForm.formDeleteQuery();
		$('.yesBtn').unbind().on('click', function(e){
			$.post(
				bu + 'deleteType',
				{
					id: thisId
				},
				function(e){
					location.reload();
				}
			);
		});
		$('.noBtn').unbind().on('click', function(e){
			$(this).newForm.forceClose();
		});
	});
	//endregion

	//region Tax Code Area
	var addTaxCode = $('.addTaxCode');
	var editTaxCode = $('.editTaxCode');
	var deleteTaxCode = $('.deleteTaxCode');

	addTaxCode.click(function(e){
		$(this).newForm.addNewForm({
			title: 'Add Tax Code',
			url: bu + 'addTaxCode',
			toFind: '.taxCodeTable'
		})
	});
	editTaxCode.click(function(e){
		var thisId = this.id;

		$(this).newForm.addNewForm({
			title: 'Edit Tax Code',
			url: bu + 'editTaxCode/' + thisId,
			toFind: '.taxCodeTable'
		})
	});
	deleteTaxCode.click(function(e){
		var thisId = this.id;

		$(this).newForm.formDeleteQuery();
		$('.yesBtn').unbind().on('click', function(e){
			$.post(
				bu + 'deleteTaxCode',
				{
					id: thisId
				},
				function(e){
					location.reload();
				}
			);
		});
		$('.noBtn').unbind().on('click', function(e){
			$(this).newForm.forceClose();
		});
	});
	//endregion

	//region Kiwi Save Area
	var addKiwi = $('.addKiwi');
	var editKiwi = $('.editKiwi');
	var deleteKiwi = $('.deleteKiwi');

	addKiwi.click(function(e){
		$(this).newForm.addNewForm({
			title: 'Add Kiwi',
			url: bu + 'addKiwi',
			toFind: '.kiwiTable'
		})
	});
	editKiwi.click(function(e){
		var thisId = this.id;

		$(this).newForm.addNewForm({
			title: 'Edit Kiwi',
			url: bu + 'editKiwi/' + thisId,
			toFind: '.kiwiTable'
		})
	});
	deleteKiwi.click(function(e){
		var thisId = this.id;

		$(this).newForm.formDeleteQuery();
		$('.yesBtn').unbind().on('click', function(e){
			$.post(
				bu + 'deleteKiwi',
				{
					id: thisId
				},
				function(e){
					location.reload();
				}
			);
		});
		$('.noBtn').unbind().on('click', function(e){
			$(this).newForm.forceClose();
		});
	});
	//endregion

	var editDP = $('.editDP');
	editDP.click(function(e){
		var thisId = this.id;

		$(this).newForm.addNewForm({
			title: 'Edit Default',
			url: bu + 'editDefaultPercentage/' + thisId,
			toFind: '.dpTable'
		})
	});
});
</script>
<style>
	.wage-management{
		font-size: 13px;
		margin: 10px 0;
	}
	.wage-management>tbody>tr>td{
		padding: 10px 10px 0 0;
	}
	.wageTable{
		margin: ;
		border-collapse: collapse;
	}
	.wageTable>tbody>tr>td{
		border: 1px solid #000000;
		padding: 3px 5px;
	}
	.wageTable>tbody>.headerTr>td{
		background: #000000;
		color: #ffffff;
		text-align: center;
		padding: 5px 10px;
	}
	.pure_white{
		float: right;
		margin-bottom: 5px;
		background: #000000;
		color: #ffffff!important;
		padding: 5px;
	}
	.pure_white:hover{
		background: #505050;
	}
	.hover_to_view{
		cursor: pointer;
	}
	.detailsTxt{
		display: none;
	}

	#detailForm{
		position: absolute;
		z-index: 99;
		display: none;
		border: 1px solid #000000;
		font-size: 12px;
		width: 200px;
	}
	#detailFormHeader{
		background: #000000;
		color: #ffffff;
		padding: 5px 10px;
	}
	#detailFormContent{
		background: #dedede;
		padding: 3px 5px;
		word-wrap: break-word;
		min-height: 10px;
		text-indent: 30px;
		text-align: left;
	}
</style>
<table class="wage-management">
	<tr>
		<td>
			<strong>WAGE TYPE TABLE</strong>
			<a href="#" class="addWageType pure_white" title="Add Wage Type">Add Wage Type</a>
		</td>
		<td>
			<strong>TAX CODE</strong>
			<a href="#" class="addTaxCode pure_white" title="Add Tax Code" >Add Tax Code</a>
			<br style="clear: both;" />
		</td>
		<td>
			<strong>Kiwi Save</strong>
			<a href="#" class="addKiwi pure_white" title="Add Kiwi Save" >Add Kiwi Save</a>
			<br style="clear: both;" />
		</td>
		<td>
			<strong>Default Percentage</strong>
		</td>
	</tr>
	<tr style="vertical-align: top;">
		<td>
			<table class="wageTable">

				<tr class="headerTr">
					<td>Description</td>
					<td>Frequency</td>
					<td>Type</td>
					<td></td>
				</tr>
				<?php
				if(count($category)>0){
					foreach($category as $ck=>$cv){
						?>
						<tr>
							<td class="hover_to_view" id="<?php echo $cv->id?>">
								<?php echo $cv->description; ?>
								<span class="detailsTxt"><?php echo $cv->details; ?></span>
							</td>
							<td>
								<?php echo $cv->frequency; ?>
							</td>
							<td>
								<?php echo $cv->type; ?>
							</td>
							<td>
								<a href="#" id="<?php echo $cv->id?>" class="editWageType">edit</a> |
								<a href="#" id="<?php echo $cv->id?>" class="deleteWageType">delete</a>
							</td>
						</tr>
					<?php
					}
				}else{
					?>
					<tr>
						<td colspan="4" style="text-align: center;">No Data</td>
					</tr>
				<?php
				}
				?>
			</table>
		</td>
		<td>
			<table style="width: 100%;">
				<tr>
					<td>
						<table class="wageTable" style="width: 100%;">
							<tr class="headerTr">
								<td>Code</td>
								<td></td>
							</tr>
							<?php
							if(count($tax_codes)>0){
								foreach($tax_codes as $tcv){
									?>
									<tr>
										<td style="text-align: center;"><?php echo $tcv->tax_code?></td>
										<td style="width: 50px;white-space: nowrap;">
											<a href="#" id="<?php echo $tcv->id?>" class="editTaxCode">edit</a> |
											<a href="#" id="<?php echo $tcv->id?>" class="deleteTaxCode">delete</a>
										</td>
									</tr>
								<?php
								}
							}else{
								?>
								<tr>
									<td colspan="4" style="text-align: center;">No Tax Code</td>
								</tr>
							<?php
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td>
						<table class="wageTable" style="width: 100%;">
							<tr class="headerTr">
								<td>Percentage</td>
								<td></td>
							</tr>
							<?php
							if(count($kiwi)>0){
								foreach($kiwi as $kv){
									?>
									<tr>
										<td style="text-align: center;"><?php echo $kv->kiwi?></td>
										<td style="width: 50px;white-space: nowrap;">
											<a href="#" id="<?php echo $kv->id?>" class="editKiwi">edit</a> |
											<a href="#" id="<?php echo $kv->id?>" class="deleteKiwi">delete</a>
										</td>
									</tr>
								<?php
								}
							}else{
								?>
								<tr>
									<td colspan="4" style="text-align: center;">No Kiwi Save</td>
								</tr>
							<?php
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td>
						<table class="wageTable" style="width: 100%;">
							<tr class="headerTr">
								<td>Type</td>
								<td>Percentage</td>
								<td></td>
							</tr>
							<?php
							if(count($default_percentage)>0){
								foreach($default_percentage as $dpv){
									?>
									<tr>
										<td><?php echo $dpv->type?></td>
										<td style="text-align: center;"><?php echo $dpv->percentage?></td>
										<td style="white-space: nowrap;">
											<a href="#" id="<?php echo $dpv->id?>" class="editDP">edit</a>
										</td>
									</tr>
								<?php
								}
							}else{
								?>
								<tr>
									<td colspan="4" style="text-align: center;">Default Percentage</td>
								</tr>
							<?php
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />

<table class="wage-management">
	<tr style="vertical-align: top;">
		<td>
			<table class="table-class">
				<tr>
					<td>
						<strong>FREQUENCY TABLE</strong>
						<a href="#" class="addFrequency pure_white" title="Add Frequency" >Add Frequency</a>
						<br style="clear: both;" />
					</td>
				</tr>
				<tr>
					<td>
						<table class="wageTable table-class" style="width: 100%;">
							<tr class="headerTr">
								<td>Frequency</td>
								<td></td>
							</tr>
							<?php
							if(count($salary_frequency)>0){
								foreach($salary_frequency as $sfv){
									?>
									<tr>
										<td><?php echo $sfv->frequency?></td>
										<td style="width: 50px;white-space: nowrap;">
											<a href="#" id="<?php echo $sfv->id?>" class="editFrequency">edit</a> |
											<a href="#" id="<?php echo $sfv->id?>" class="deleteFrequency">delete</a>
										</td>
									</tr>
								<?php
								}
							}else{
								?>
								<tr>
									<td colspan="4" style="text-align: center;">No Salary Frequency</td>
								</tr>
							<?php
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table class="table-class">
				<tr>
					<td>
						<strong>TYPE TABLE</strong>
						<a href="#" class="addType pure_white" title="Add Type" >Add Type</a>
						<br style="clear: both;" />
					</td>
				</tr>
				<tr>
					<td>
						<table class="wageTable" style="width: 100%;">
							<tr class="headerTr">
								<td>Frequency</td>
								<td></td>
							</tr>
							<?php
							if(count($salary_type)>0){
								foreach($salary_type as $stv){
									?>
									<tr>
										<td><?php echo $stv->type?></td>
										<td style="width: 50px;white-space: nowrap;">
											<a href="#" id="<?php echo $stv->id?>" class="editType">edit</a> |
											<a href="#" id="<?php echo $stv->id?>" class="deleteType">delete</a>
										</td>
									</tr>
								<?php
								}
							}else{
								?>
								<tr>
									<td colspan="4" style="text-align: center;">No Salary Type</td>
								</tr>
							<?php
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />