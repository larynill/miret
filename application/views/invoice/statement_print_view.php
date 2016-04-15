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
                padding: 3px 15px;
                text-align: center;
                font-weight: bold;
            }
            .statement-content > tbody > tr > td:last-child{
                border-right: 2px solid #000000;
                background: #c6ffcf;
            }
            .statement-content > tbody > tr:last-child > td{
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
                            <span class="title-text">Statement</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="statement-content">
                    <thead>
                    <tr>
                        <th style="width: 15%;">Date</th>
                        <th>Reference</th>
                        <th style="width: 15%;">Debits</th>
                        <th style="width: 15%;">Credits</th>
                        <th style="width: 15%;">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($statement)>0){
                        foreach($statement as $sv){
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    echo $sv->date;
                                    ?>
                                </td>
                                <td style="text-align: left;">
                                    <?php
                                    echo $sv->type;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $sv->debits;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $sv->credits;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $sv->balance;
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                    $disable_class = count($statement) > 1 ? '' : 'disable-btn';
                    $total_row = 38 - count($statement);
                    for($i=0;$i<$total_row;$i++){
                        echo '<tr>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '<td>&nbsp;</td>';
                        echo '</tr>';
                    }
                    ?>
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
$domPdf->set_paper("A4", "portrait");

$domPdf->render();

// The next call will store the entire PDF as a string in $pdf
$pdf = $domPdf->output();

// You can now write $pdf to disk, store it in a database or stream it
// to the client.
$pdfName = $_GET['cID'].'_'.date('d-F-y');
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