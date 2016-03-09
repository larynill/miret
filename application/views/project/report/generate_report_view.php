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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            body{
                font-family: helvetica, sans-serif;
                font-size: 11px;
            }
            .table > thead > tr > th{
                background: none;
                border: none;
                color: #1e7eea;
                font-size: 35px;
                font-weight: normal;
            }
            /*.content{
                margin: 190px 0;
            }*/
            .table > thead > tr > td.danger,
            .table > tbody > tr > td.danger,
            .table > tfoot > tr > td.danger,
            .table > thead > tr > th.danger,
            .table > tbody > tr > th.danger,
            .table > tfoot > tr > th.danger,
            .table > thead > tr.danger > td,
            .table > tbody > tr.danger > td,
            .table > tfoot > tr.danger > td,
            .table > thead > tr.danger > th,
            .table > tbody > tr.danger > th,
            .table > tfoot > tr.danger > th {
                background-color: #f2dede;
            }
            .table > thead > tr > th.text-right,
            .table > tbody > tr > td.text-right,
            .table > tfoot > tr > td.text-right{
                text-align: right;
            }
            .table > thead > tr > th.text-left,
            .table > tbody > tr > td.text-left,
            .table > tfoot > tr > td.text-left {
                text-align: left;
            }
            .table-details{
                font-size: 11px;
                color: #000000;
            }
            .table-details > tbody > tr > td.info{
                color: #737373;
            }
            .table-details > tbody > tr > td{
                padding: 5px;
            }
            .header{
                margin-top: -180px;
            }
            .header,
            .footer {
                width: 100%;
                text-align: center;
                position: fixed;
            }
            @page { margin: 190px 40px; }
            .header {
                top: 0;
            }
            .footer {
                margin-top: 25px;
                bottom: 0;
            }
            .pagenum:before {
                content: counter(page);
            }
            .details,.table{
                width: 100%;
            }
            .details-div{
                border: 1px solid #737373;
                /*padding: 15px;*/
            }
            .title{
                font-size: 13px;
                color: #1e7eea;
                /*font-weight: bold;*/
                padding: 15px 0 0;
            }
            .content-div{
                padding: 10px 0 0;
            }
            .border-table{
                border-collapse: collapse;
                width: 100%;
            }
            .border-table tr td{
                border-bottom: 1px solid #aaaaaa;
                padding: 5px;
            }
            .border-table tr td:nth-child(1){
                color: #737373;
                width: 30%;
            }
            .border-table tr td:nth-child(2){
                text-align: left;
            }
        </style>
    </head>

    <body>
    <div class="header">
        <div class="details">
            <?php
            if(count($job_details) > 0) {
                foreach ($job_details as $key => $val) {
                    ?>
                    <table class="table table-details">
                        <thead>
                        <tr>
                            <th class="text-left"><?php echo $val->job_type?></th>
                            <th class="text-right"><img src="<?php echo base_url().'img/logo-other.gif'?>" width="200"></th>
                        </tr>
                        </thead>
                        <tr>
                            <td style="padding: 0!important;">
                                <table class="table-details">
                                    <tr>
                                        <td class="text-left info" style="white-space: nowrap">Our Reference:</td>
                                        <td class="text-left"><?php echo $val->job_ref;?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left info">Date:</td>
                                        <td class="text-left"><?php echo date('d/m/Y');?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left info">Lbp No:</td>
                                        <td class="text-left">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="footer">
        <div class="details">
            <table class="table table-details">
                <tr>
                    <td class="text-left info">PO Box</td>
                    <td class="text-left">76237 – Northwood – Christchurch 8548</td>
                </tr>
                <tr>
                    <td class="text-left info">Email</td>
                    <td class="text-left">info@synergybc.co.nz</td>
                </tr>
                <tr>
                    <td class="text-left info">Web</td>
                    <td class="text-left">www.synergybuildingconsultants.co.nz</td>
                </tr>
                <tr>
                    <td class="text-left info">Phone</td>
                    <td class="text-left">0800 SYNERGY – (0800 796374)</td>
                </tr>
            </table>
            <strong>Page <span class="pagenum"></span></strong>
        </div>
    </div>
    <div class="content">
        <?php
        if(count($job_details) > 0) {
            foreach ($job_details as $key => $val) {
                ?><br/>
                <div class="details-div">
                    <table class="table table-details">
                        <tr>
                            <td class="text-left info">Client</td>
                            <td class="text-left info">Client Reference No.</td>
                            <td class="text-left info">Inspection Date</td>
                        </tr>
                        <tr>
                            <td class="text-left"><?php echo $val->project_name?></td>
                            <td class="text-left"><?php echo $val->client_ref?></td>
                            <td class="text-left"><?php echo $val->inspection_time ? date('d/m/Y',strtotime($val->inspection_time)) : '';?></td>
                        </tr>
                        <tr>
                            <td class="text-left info">Site Address</td>
                            <td class="text-left info" colspan="2">Insured Name</td>
                        </tr>
                        <tr>
                            <td class="text-left"><?php echo $val->address;?></td>
                            <td class="text-left" colspan="2"><?php echo $val->insured_name;?></td>
                        </tr>
                        <tr>
                            <td class="text-left info">Suburb</td>
                            <td class="text-left info">Building Consultant</td>
                            <td class="text-left info">Inspector</td>
                        </tr>
                        <tr>
                            <td class="text-left"><?php echo $val->suburb;?></td>
                            <td class="text-left">&nbsp;</td>
                            <td class="text-left"><?php echo $val->inspector_name;?></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <div class="title">Job Description</div>
                    <div class="content-div"><?php echo $val->job_description;?></div>
                    <div class="title">Description of System and Components</div>
                    <div class="content-div">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 50%;">
                                    <table class="border-table">
                                        <tr>
                                            <td>Type:</td>
                                            <td><?php echo $val->roof_type;?></td>
                                        </tr>
                                        <tr>
                                            <td>Pitch:</td>
                                            <td><?php echo $val->roof_pitch;?></td>
                                        </tr>
                                        <tr>
                                            <td>Roof Age:</td>
                                            <td><?php echo $val->roof_age .' <span style="margin-left:100px!important;">(approx.)</span>';?></td>
                                        </tr>
                                        <tr>
                                            <td>Design:</td>
                                            <td><?php echo $val->roof_design;?></td>
                                        </tr>
                                        <tr>
                                            <td>Condition:</td>
                                            <td><?php echo $val->roof_cladding_condition;?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 50%;">
                                    <table class="border-table">
                                        <tr>
                                            <td>Spouting Type:</td>
                                            <td><?php echo $val->spouting_type;?></td>
                                        </tr>
                                        <tr>
                                            <td>Flashings:</td>
                                            <td><?php echo $val->flashing_type;?></td>
                                        </tr>
                                        <tr>
                                            <td>Finish:</td>
                                            <td><?php echo $val->roof_cladding_finish;?></td>
                                        </tr>
                                        <tr>
                                            <td>Insulation:</td>
                                            <td><?php echo $val->insulation;?></td>
                                        </tr>
                                        <tr>
                                            <td>Fascia:</td>
                                            <td><?php echo $val->fascia_type;?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="title">History – Client Discussions</div>
                    <div class="content-div">
                        <?php echo str_replace("\n",'<br/>',$val->client_discussions);?>
                    </div>
                    <div class="title">Investigation</div>
                    <div class="content-div">
                        <?php echo str_replace("\n",'<br/>',$val->damage_sighted);?>
                    </div>
                    <div class="title">Recommendation</div>
                    <div class="content-div">
                        <?php echo str_replace("\n",'<br/>',$val->repair_strategy);?>
                    </div>
                    <div class="title">Overview</div>
                    <div class="content-div">
                        <?php echo str_replace("\n",'<br/>',$val->overview);?>
                    </div>
                    <div class="title">Conclusion</div>
                    <div class="content-div">
                        <?php echo str_replace("\n",'<br/>',$val->overview);?>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>
    </body>
    </html>
<?php
$size = 'A4';
$html = ob_get_clean();

$domPdf = new DOMPDF();
$domPdf->load_html($html,'UTF-8');
$domPdf->set_paper($size, "portrait");

$domPdf->render();

// The next call will store the entire PDF as a string in $pdf
$pdf = $domPdf->output();

// You can now write $pdf to disk, store it in a database or stream it
// to the client.
$pdfName = date('Ymd_His');
@ $domPdf->stream($pdfName.".pdf", array("Attachment" => 0));

$file_to_save = $pdfName.'.pdf';
?>