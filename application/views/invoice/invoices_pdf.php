<?php
require_once(realpath(APPPATH ."../plugins/dompdf/dompdf_config.inc.php"));
ini_set("upload_max_filesize","1024M");
ini_set("memory_limit","1024M");
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 900000000);
ini_set('max_execution_time', 900000000);
set_time_limit(900000000);
ob_start();
?>
	<html>
	<head>
		<style>
			body{
				font-family:Helvetica;
				font-size:12px;
				margin:0;
				padding:0;
			}
			table{
				page-break-inside: auto;
			}
			#invoicetable{
				border-spacing: 0;
				max-height:2400px;
			}

			#invoicetable tr{
				border:2px #000 solid;
			}

			#invoicetable tr th{
				border:2px #000 solid;
				border-right:none;
				background:#c9c9c9;
				padding:3px 5px;
			}

			#invoicetable tr th:last-child{
				border-right:2px #000 solid;
			}

			#invoicetable tr td{
				border: 2px none #000;
				border-left-style: solid;
				padding:3px 5px;
				text-align:center;
				vertical-align: top;
			}

			#invoicetable tr:last-child td{
				border-top:2px #000 solid;
				border-bottom:2px #000 solid;
			}

			#invoicetable tr td:last-child{
				border-right:2px #000 solid;
			}

			.pagenum:before { content: counter(page); }
		</style>
	</head>

	<body>
	<div id="wrap">
		<div id="content">
			<script type="text/php">
				if ( isset($pdf) ) {
				$font = Font_Metrics::get_font("verdana");;
				$size = 6;
				$color = array(0,0,0);
				$text_height = Font_Metrics::get_font_height($font, $size);

				$foot = $pdf->open_object();

				$w = $pdf->get_width();
				$h = $pdf->get_height();

				// Draw a line along the bottom
				$y = $h - $text_height - 24;
				$pdf->line(16, $y, $w - 16, $y, $color, 0.5);

				$pdf->close_object();
				$pdf->add_object($foot, "all");

				$text = "Page {PAGE_NUM} of {PAGE_COUNT}";
				// Center the text
				$width = Font_Metrics::get_text_width("Page 1 of 2", $font, $size);
				$pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
				}
			</script>

			<table width="850" style="margin-bottom: 50px;">
				<tr valign="top">
					<td width="400">
						<?php
						$maxLine = 17;
						$totalLine = $maxLine - count($clientInvoice);
						?>
						<strong style="text-transform: uppercase;"><?php echo $companyName;?></strong><br/>
						<strong style="text-transform: capitalize;"><?php echo $address;?></strong>
					</td>
					<td align="right" width="250" style="font-size:12px;">
						<div style="text-align:left;">
							<img src="<?php echo base_url();?>plugins/img/sample-logo.png" width="250" /><br />
							<strong style="text-transform: uppercase;font-size: 16px;">Universal Inspectors</strong><br/>
							<strong>Long Street, Auckland</strong><br/>
							<strong>New Zealand</strong><br/>
							<strong>P.O Box</strong><br />
							email:  <strong>admin@internationalinspectors.com</strong><br />
						</div>
					</td>
				</tr>
			</table>
			<table id="invoicetable">
				<tr id="invoiceTitle">
					<td colspan="9" style="border:none;">
						<table width="100%" style="border:none;margin-left:-5px;padding:0;">
							<tr>
								<td align="left" style="text-align:left;border:none;">
									<strong>
										<?php echo 'DATE: '?>
										<?php
										echo date('d-F-y');
										?>
										<span style="margin-left:250px;">TAX INVOICE: <strong ><?php echo $taxInvoice;?></strong></span>
									</strong>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table id="invoicetable" width="770">
				<tr style="font-size:10px;">
					<th width="80">Date</th>
					<th width="60">Order No.</th>
					<th width="80">Job No.</th>
					<th>Job Name</th>
					<th width="90">No. of Units/Hrs/Km</th>
					<th width="80">Unit Price</th>
					<th width="50">Extra</th>
					<th width="60">Total</th>
				</tr>
				<?php
				if(count($clientInvoice)>0){
					foreach($clientInvoice as $k=>$v){
						?>
						<tr>
							<td style="border-bottom:none;border-top:none;"><?php echo $v->InspectionDate;?></td>
							<td style="border-bottom:none;border-top:none;"><?php echo $v->OrderNumber;?></td>
							<td style="border-bottom:none;border-top:none;white-space: nowrap"><?php echo $v->JobNumber;?></td>
							<td style="border-bottom:none;border-top:none;"><?php echo $v->CompanyName;?></td>
							<td style="border-bottom:none;border-top:none;white-space: nowrap">
								<?php
								echo $v->totalUnitPrice.'/ ';
								echo $v->totalTravelTime.'/ ';
								echo $v->totalTravelCost;
								?>
							</td>
							<td style="border-bottom:none;border-top:none;white-space: nowrap">
								<?php
								echo '$ '.$unitrate.'/ ';
								echo '$ '.$hourrate.'/ ';
								echo '$ '.$kmrate;
								;?>
							</td>
							<td style="border-bottom:none;border-top:none;">
								<?php
								echo '$ '.number_format($v->extra,2,'.',',');
								?>
							</td>
							<td style="border-bottom:none;border-top:none;">
								<?php
								echo '$ '.number_format($v->subTotal,2,'.',',');
								?>
							</td>
						</tr>
					<?php }
				}
				for($i=0;$i<=$totalLine;$i++){?>
					<tr align="center" style="font-size:10px;">
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
						<td style="border-bottom:none;border-top:none;">&nbsp;</td>
					</tr>
				<?php }
				?>
				<tr valign="top" style="font-size:11px;">
					<td colspan="5" style="border-right:none;text-align:left;"></td>
					<td colspan="2" align="right" style="border-left:none;text-align: right;" id="subtable">
						<table width="100%">
							<tr>
								<td style="border:none;text-align:right;">Sub Total</td>
								<td style="border:none;text-align:right;width: 50%;"><?php echo '$ '.number_format($totalExtra,2,'.',',');?></td>
							</tr>
							<tr>
								<td style="border:none;">&nbsp;</td>
								<td style="border:none;">&nbsp;</td>
							</tr>
							<tr>
								<td style="border:none;text-align:right;">GST Rate</td>
								<td style="border:none;">&nbsp;</td>
							</tr>
							<tr>
								<td style="border:none;text-align:right;">GST Total</td>
								<td style="border:none;">&nbsp;</td>
							</tr>
							<tr>
								<td style="border:none;text-align:right;"><strong>TOTAL</strong></td>
								<td style="border:none;">&nbsp;</td>
							</tr>
						</table>
					</td>
					<td id="subtable" align="left">
						<table width="100%" align="left">

							<tr>
								<td align="left" style="border:none;text-align:right;">
									<?php echo '$ '.number_format($subTotal,2,'.',',');?>
								</td>
							</tr>
							<tr>
								<td style="border:none;text-align: right;">
									<?php
									echo '$ '.number_format($overAllsubTotal,2,'.',',');
									?>
								</td>
							</tr>
							<tr><td align="left" style="border:none;text-align:right;">15.00%</td></tr>
							<tr>
								<td align="left" style="border:none;text-align:right;">
									<?php
									echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal * 0.15),2,'.',',') : '$ 0';
									?>
								</td>
							</tr>
							<tr>
								<td align="left" style="border:none;text-align:right;">
									<strong>
										<?php
										echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal - ($overAllsubTotal * 0.15)),2,'.',',') : '$ 0';
										?>
									</strong>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			Please enter you payment date and reference.
			Please use your order number as your reference when you make your payment.
		</div>
	</div>
	</body>
	</html>
<?php
$html = ob_get_clean();

$domPdf = new DOMPDF();
$domPdf->load_html($html);
$domPdf->set_paper("A4", "landscape");

$domPdf->render();

// The next call will store the entire PDF as a string in $pdf
$pdf = $domPdf->output();

// You can now write $pdf to disk, store it in a database or stream it
// to the client.
$pdfName = $this->uri->segment(2).'_'.$taxInvoice.'_'.date('d-F-y');
@ $domPdf->stream($pdfName.".pdf", array("Attachment" => 0));

$file_to_save = $dir.'/'.$pdfName.'.pdf';
//save the pdf file on the server
file_put_contents($file_to_save, $domPdf->output());
//print the pdf file to the screen for saving
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="'.$pdfName.'.pdf"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file_to_save));
header('Accept-Ranges: bytes');
readfile($file_to_save);
?>