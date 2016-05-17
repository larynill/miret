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
			.inspection-certificate-table{
				width: 100%;
				border-collapse: collapse;
			}
			.inspection-certificate-table tr .inspectionBorder{
				border: 1px solid #d2d2d2;
				font-size: 14px;
			}
			.inspection-certificate-table>tbody>tr>td{
				padding: 5px;
			}
			.static-name{
				text-transform: uppercase;
				width: 20%;
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
			<?php
			$ref = count($printcertificate);
			if(count($printcertificate)>0){
				foreach($printcertificate as $ck=>$cv){
					?>
					<table class="inspection-certificate-table" style="margin-bottom: 70px;">
						<tr>
							<td style="text-align: right;font-style: italic;padding: 10px 0;border-top:1px solid #d2d2d2;" colspan="4">
								Accredited by International Accreditation New Zealand
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
						</tr>
						<tr>
							<th style="text-transform: uppercase;font-size: 24px;padding: 10px;" colspan="4">
								Pressure Vessel<br/>
								<span style="font-size: 20px;">Certification</span>
							</th>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">Job No:</td>
							<td class="inspectionBorder"><strong><?php echo $cv->JobNumber?></strong></td>
							<td class="inspectionBorder static-name">Expiry Date:</td>
							<td class="inspectionBorder">
								<strong><?php echo date('m/d/Y',strtotime($cv->ExpectationDate))?></strong>
							</td>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">Client/Controller:</td>
							<td class="inspectionBorder">
								<strong><?php echo $cv->CompanyName?></strong>
							</td>
							<td class="inspectionBorder static-name">Contact Person:</td>
							<td class="inspectionBorder">
								<strong><?php echo $cv->ContactPerson?></strong>
							</td>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">Address:</td>
							<td class="inspectionBorder" colspan="3">
								<strong><?php echo $cv->PostalAdress?></strong>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">Official No:</td>
							<td class="inspectionBorder"><strong><?php echo $cv->OfficialNo?></strong></td>
							<td class="inspectionBorder static-name">Capacity:</td>
							<td class="inspectionBorder"><strong><?php echo $cv->Capacity?></strong></td>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">Client Id:</td>
							<td class="inspectionBorder">
								<strong><?php echo $cv->PlantDescription?></strong>
							</td>
							<td class="inspectionBorder static-name">Manufacturer:</td>
							<td class="inspectionBorder">
								<strong><?php echo $cv->Manufacturer?></strong>
							</td>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">
								<span>Pressure:</span>
							</td>
							<td class="inspectionBorder">
								<?php
								echo $cv->Pressure;
								?>
							</td>
							<td class="inspectionBorder static-name">
								<span>Temperature:</span>
							</td>
							<td class="inspectionBorder">
								<?php
								echo $cv->Temperature;
								?>
							</td>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">
								<span>Contents:</span>
							</td>
							<td class="inspectionBorder">
								<?php
								echo $cv->Contents;
								?>
							</td>
							<td class="inspectionBorder static-name">
								<span>Inspection Date:</span>
							</td>
							<td class="inspectionBorder">
								<strong>
									<?php echo date('m/d/Y',strtotime($inspectionDate))?>
								</strong>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
						</tr>
						<tr>
							<td class="inspectionBorder static-name">Purpose and Location:</td>
							<td class="inspectionBorder" colspan="3">
								<?php
								echo $cv->Purpose;
								?>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="font-style: italic;">
								On Inspection, the equipment was found in safe condition, and subject to normal operation and ongoing
								maintenance by the controller, may remain in use, for the period specified in this certificate.
							</td>
						</tr>
						<tr>
							<td style="font-size: 18px;">Equipment Inspector:</td>
							<td colspan="3" style="font-size: 18px;font-weight: bold;font-style: italic;"><?php echo $accountName;?></td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 10px;">Copyright - All Rights Reserved</td>
							<td colspan="2" style="font-size: 10px;">STAT Pressure Vessel Cert - Rev 3</td>
						</tr>
					</table>
				<?php
					$ref--;
				}
			}
			?>
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
@ $domPdf->stream("Sample.pdf", array("Attachment" => 0));
?>