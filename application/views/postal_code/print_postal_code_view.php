<?php
require_once(realpath(APPPATH ."../plugins/fpdf/break_line_fpdf.php"));
ini_set("memory_limit","512M");
set_time_limit(900000);

$pdf = new PDF_Break_Line("L");

$width = array(60, 35, 55, 50, 25, 50);

$pdf->lineBreak = 0;
$pdf->widths = $width;

$pdf->headerTitle = (Object)array(
    (Object)array(
        'title' => array('Synergy Franchise Postcodes'),
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
    //region Add Empty row under the Title
    (Object)array(
        'title' => array(''),
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
    //endregion
    (Object)array(
        'title' => array('Road Name', 'No. Range', 'Suburb', 'Town/City','Postal Code','Franchise'),
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
        'Fills' => array(1, 1, 1, 1, 1, 1),
        'Widths' => $pdf->widths,
        'Aligns' => array('C', 'C', 'C', 'C','C','C'),
        'borderSize' => 1
    )
);

$pdf->AddPage();
$pdf->AliasNbPages();

//Table with 20 rows and 4 columns
srand(microtime()*1000000);

$pdf->SetFont('Helvetica', '', 9);

$max_y = 180;
if(count($postal_codes) > 0){
    foreach($postal_codes as $v){

        $pdf->SetFills(array(0, 0, 0, 0, 0, 0));
        $pdf->aligns = array('L', 'C', 'L', 'L', 'C','L');
        $pdf->widths = $width;

        $row = array(
            $v->road_name,
            $v->num_range,
            $v->suburb,
            $v->town_city,
            $v->postcode,
            $v->franchise
        );
        $pdf->Row($row);
    }
}
else{
    $pdf->SetFills(array(0));
    $pdf->aligns = array('C');
    $pdf->widths = array(array_sum($pdf->widths));
    $row = array('No Result');
    $pdf->Row($row);
}


if(!is_dir($save_path)){
    mkdir($save_path,0755,TRUE);
}
$filename = 'Synergy_Franchise_Postcode_' . date('Ymd-Hi');
$pdf->Output($filename . ".pdf", 'I');
$pdf->Output($save_path . '/' . $filename . ".pdf", 'F');