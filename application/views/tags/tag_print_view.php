<?php
require_once(realpath(APPPATH ."../plugins/fpdf/break_line_fpdf.php"));
ini_set("memory_limit","512M");
set_time_limit(900000);

$pdf = new PDF_Break_Line("L");

$width = array(80, 198);

$pdf->lineBreak = 0;
$pdf->widths = $width;

$pdf->headerTitle = (Object)array(
    (Object)array(
        'title' => array('Tag Print'),
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
        'title' => array('Description', 'Text'),
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
        'Fills' => array(1, 1),
        'Widths' => $pdf->widths,
        'Aligns' => array('C', 'C'),
        'borderSize' => 1
    )
);

$pdf->AddPage();
$pdf->AliasNbPages();

//Table with 20 rows and 4 columns
srand(microtime()*1000000);

$pdf->SetFont('Helvetica', '', 9);

$max_y = 180;
if(count($tags) > 0){
    foreach($tags as $v){
        if($pdf->GetY() > $max_y){
            $pdf->AddPage();
        }

        $pdf->SetFills(array(0, 0));
        $pdf->aligns = array('L', 'L');
        $pdf->widths = $width;

        $row = array(
            $v->description,
            $v->text
        );
        $pdf->Row($row);

        /*$pdf->aligns = array('L');
        $pdf->widths = array(array_sum($pdf->widths));
        $row = array($v->text);
        $pdf->Row($row);*/
    }
}
else{
    $pdf->SetFills(array(0));
    $pdf->aligns = array('C');
    $pdf->widths = array(array_sum($pdf->widths));
    $row = array('No Result');
    $pdf->Row($row);
}

$filename = "Tag_" . date('Ymd-Hi');
$pdf->Output($filename . ".pdf", 'I');