<?php
require_once(realpath(APPPATH ."../plugins/fpdf/break_line_fpdf.php"));
ini_set("memory_limit","512M");
set_time_limit(900000);

$pdf = new PDF_Break_Line("L");

$width = array(10, 30, 170, 30, 35);

$pdf->lineBreak = 0;
$pdf->widths = $width;
$pdf->headerTitle = (Object)array(
    (Object)array(
        'title' => array('Notification Print'),
        'FontFamily' => 'Arial',
        'FontStyle' => 'B',
        'FontSizePt' => 14,
        'TextColor' => (Object)array(
                'r' => 0,
                'g' => 0,
                'b' => 0
            ),
        'FillColor' => (Object)array(
                'r' => 255,
                'g' => 255,
                'b' => 255
            ),
        'Fills' => array(0),
        'Widths' => array(array_sum($pdf->widths)),
        'Aligns' => array('L')
    ),
    (Object)array(
        'title' => array('Message: ' . count($notification)),
        'FontFamily' => 'Arial',
        'FontStyle' => '',
        'FontSizePt' => 10,
        'TextColor' => (Object)array(
                'r' => 255,
                'g' => 255,
                'b' => 255
            ),
        'FillColor' => (Object)array(
                'r' => 0,
                'g' => 0,
                'b' => 0
            ),
        'Fills' => array(1),
        'Widths' => array(array_sum($pdf->widths)),
        'Aligns' => array('L'),
        'borderSize' => 1
    )
);

$pdf->AddPage();
$pdf->AliasNbPages();

//Table with 20 rows and 4 columns
srand(microtime()*1000000);

$pdf->SetFont('Helvetica', '', 9);

$ref = $current_page + 1;
if(count($notification) > 0){
    foreach($notification as $v){
        $pdf->SetFills(array(0, 0, 0, 0, 0));
        $pdf->aligns = array('C', 'L', 'L', 'L', 'L');

        //$v->notification = str_replace("<br />", "\n", $v->notification);
        $n = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($v->notification));
        $n = htmlentities($n, ENT_QUOTES, "UTF-8");

        $row = array(
            $ref,
            $v->author_name . ':',
            $n,
            'to ' . $v->receiver_name,
            date('d/m/Y h:i a', strtotime($v->date))
        );
        $pdf->Row($row);

        $ref++;
    }
}
else{
    $pdf->SetFills(array(0));
    $pdf->aligns = array('C');
    $pdf->widths = array(array_sum($pdf->widths));
    $row = array('No Notification');
    $pdf->Row($row);
}

$filename = "Notification_Print_" . date('Ymd-Hi');
$pdf->Output($filename . ".pdf", "I");