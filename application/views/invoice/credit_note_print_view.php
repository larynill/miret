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
            .pagenum:before { content: counter(page); }
            .statement-header,.statement-content{
                border-collapse: collapse;
                width: 100%;
                margin: 5px auto;
            }
            .statement-header > tbody > tr > td{
                padding: 5px;
            }
            .bold-text{
                font-weight: bold;
            }
            .title-text{
                background: #c4c4c4;
                padding: 5px 15px;
                text-transform: uppercase;
                font-weight: bold;
                font-size: 18px;
            }
            .statement-content > thead > tr > th{
                background: #d0d0d0;
                padding: 5px;
                border: 2px solid #000000;
            }
            .statement-content > tbody > tr > td{
                border-left: 2px solid #000000;
                padding: 3px;
                text-align: center;
            }
            .statement-content > tbody > tr > td:last-child{
                border-right: 2px solid #000000;
            }
            .statement-content > tbody > tr:last-child > td{
                border-bottom: 2px solid #000000;
            }
            .statement-content > tbody > tr:nth-child(18) > td{
                border-bottom: 2px solid #000000;
            }
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

            <div class="content">
                <table class="statement-header">
                    <tbody>
                    <tr>
                        <td>
                            <div class="bold-text">
                                <?php
                                if(count($client_info)>0){
                                    foreach($client_info as $cv){
                                        echo '<span style="text-transform:uppercase;">'.$cv->CompanyName.'</span><br/><br/>';
                                        echo $cv->PostalAdress.'<br/>';
                                    }
                                }
                                ?>
                            </div>
                        </td>
                        <td style="width: 28%">
                            <img src="<?php echo base_url().'plugins/img/sample-logo.png';?>" width="250">
                            <div class="bold-text">
                                <?php
                                if(count($invoice_info)>0){
                                    foreach($invoice_info as $v){
                                        echo '<span style="text-transform:uppercase;">'.$v->company_name.'</span><br/>';
                                        echo $v->address.'<br/>';
                                        echo '<span style="font-weight:normal;white-space:nowrap;">Email: </span>'.$v->email.'<br/>';
                                    }
                                }
                                ?>
                            </div>
                            <div style="white-space: nowrap">
                                Date: <span class="date"><?php echo date('j F Y',strtotime($_GET['date']));?></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;" colspan="2">
                            <span class="title-text">Credit Note <?php echo $credit_ref;?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="statement-content">
                    <thead>
                    <tr>
                        <th width="80">Date</th>
                        <th width="50">Order No.</th>
                        <th width="80">Job No.</th>
                        <th>Job Name</th>
                        <th width="100">No. of Units/Hrs/Km</th>
                        <th width="80">Unit Price</th>
                        <th width="50">Extra</th>
                        <th width="60">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($credits)>0){
                        foreach($credits as $v){
                            ?>
                            <tr>
                                <td>
                                    <?php echo $v->date;?>
                                </td>
                                <td>
                                    <?php echo $v->order_number;?>
                                </td>
                                <td>
                                    <?php echo $v->job_num;?>
                                </td>
                                <td>
                                    <?php echo $v->job_name;?>
                                </td>
                                <td>
                                    <?php echo $v->rate;?>
                                </td>
                                <td>
                                    <?php echo $v->unit_price;?>
                                </td>
                                <td>
                                    <?php echo '$ '.number_format($v->extra,2,'.',',');?>
                                </td>
                                <td>
                                    <?php echo '$ '.number_format($v->subtotal,2,'.',',');?>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    <?php
                    $total_row = 18 - count($credits);
                    for($i=0;$i<$total_row;$i++){
                        echo '<tr>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr valign="top" style="font-size:12px;">
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
                        <td id="subtable" align="left" style="font-size: 13px;">
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
                                        echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal * 0.15),2,'.',',') : '$ 0.00';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="border:none;text-align:right;">
                                        <strong>
                                            <?php
                                            echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal + ($overAllsubTotal * 0.15)),2,'.',',') : '$ 0.00';
                                            $overall = ($overAllsubTotal - ($overAllsubTotal * 0.15));
                                            ?>
                                        </strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tbody>
                </table>
            </div>
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
$pdfName = $_GET['cID'].'_'.$credit_ref.'_'.date('d-F-y');
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