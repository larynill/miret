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
                font-size: 12px;
                line-height: 20px;
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
                font-size: 12px;
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
                font-weight: bold;
                padding: 15px 0 0;
            }
            .content-div{
                padding: 10px 0 0;
                text-align: justify;
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
            .content-div > ol {
                counter-reset:yourCounter;
                padding: 0;
            }
            .content-div > ol > li:not(.skip) {
                counter-increment:yourCounter;
                list-style:none;
            }
            .content-div > ol > li:not(.skip):before {
                content:counter(yourCounter) ". ";
            }
            .content-div > ol > li.skip {
                list-style: none;
            }
            .content-div > ol > li{
                /*padding: 10px;*/
                text-align: justify;
            }
            .content-div ul.text-list{
                counter-reset: myCounter;
            }
            .content-div ul.text-list > li{
                counter-increment:myCounter;
                list-style-type: lower-alpha;
                /*padding: 10px 0;*/
                text-align: justify;
            }
            .content-div ul.text-list > li:before{
                content:") ";
            }
        </style>
    </head>

    <body>
    <div class="header">
        <div class="details">
            <?php
            $job_id = 0;
            $job_name = '';
            if(count($job_details) > 0) {
                foreach ($job_details as $key => $val) {
                    $job_id = $val->id;
                    $job_name = $val->project_name;
                    ?>
                    <table class="table table-details">
                        <thead>
                        <tr>
                            <th class="text-left"><?php echo $val->job_type?></th>
                            <th class="text-right"><img src="<?php echo realpath(APPPATH .'../img/logo-other.gif')?>" width="200"></th>
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
                    <td class="text-left">info@Synergy Projectbc.co.nz</td>
                </tr>
                <tr>
                    <td class="text-left info">Web</td>
                    <td class="text-left">www.Synergy Projectbuildingconsultants.co.nz</td>
                </tr>
                <tr>
                    <td class="text-left info">Phone</td>
                    <td class="text-left">0800 Synergy Project – (0800 796374)</td>
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
                    </div><div class="title">History – Client Discussions</div>
                    <div class="content-div">
                        <p>
                            <?php echo str_replace("\n",'<br/>',$val->client_discussions);?>
                        </p>
                    </div>
                    <div class="title">Investigation</div>
                    <div class="content-div">
                        <p>
                            <?php echo str_replace("\n",'<br/>',$val->damage_sighted);?>
                        </p>
                    </div>
                    <div class="title">Recommendation</div>
                    <div class="content-div">
                        <p>
                            <?php echo str_replace("\n",'<br/>',$val->repair_strategy);?>
                        </p>
                    </div>
                    <div class="title">Overview</div>
                    <div class="content-div">
                        <p>
                            <?php echo str_replace("\n",'<br/>',$val->overview);?>
                        </p>
                    </div>
                    <div class="title">Estimate</div>
                    <div class="content-div" style="page-break-after: always">
                        <table class="table">
                            <tr>
                                <td colspan="3" class="text-left"><strong>Scope of Works:</strong></td>
                            </tr>
                            <?php
                            $ref = 1;
                            $total = 0;
                            if(count($val->estimate) > 0){
                                foreach($val->estimate as $v){
                                    $cost = ($v->cost ? $v->cost : $v->default_rate);
                                    $subtotal = $cost * $v->quantity;
                                    $total += $subtotal;
                                    ?>
                                    <tr>
                                        <td style="width: 5%;"><?php echo $ref;?></td>
                                        <td style="width: 65%"><?php echo $v->report_text;?></td>
                                        <td class="text-right"><?php echo $v->quantity . $v->unit_from . ' @ $' . $cost . '/' . $v->unit_from . ' = $' . number_format($subtotal,2,'.','');?></td>
                                    </tr>
                                    <?php
                                    $ref++;
                                }
                                ?>
                                <tr>
                                    <td colspan="2" class="text-left">
                                        <div class="title">Total (not including GST or builder's margin)</div>
                                    </td>
                                    <td class="text-right"><strong><?php echo '$' . number_format($total,2,'.','');?></strong></td>
                                </tr>
                            <?php
                            }
                            else{
                                ?>
                                <tr>
                                    <td colspan="3">No data was found.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="title">Conclusion</div>
                    <div class="content-div" style="page-break-after: always">
                        <?php echo str_replace("\n",'<br/>',$val->report_conclusion);?>
                    </div>
                    <div class="photo-area" style="page-break-after: always">
                        <table style="font-size: 12px">
                            <?php
                            $arr = array_chunk($val->photos,3);
                            if(count($arr) > 0){
                                foreach($arr as $_val){
                                    echo '<tr>';
                                    $ref = 1;
                                    if(count($_val) > 0){
                                        foreach($_val as $v){
                                            $dir = realpath(APPPATH . '../uploads/job/');
                                            if(file_exists($dir . '/' . $val->id . '/photos/' . $v->photo_name)){
                                                ?>
                                                <td style="padding: 20px 10px;">
                                                    <img src="<?php echo base_url() . 'uploads/job/' . $val->id . '/photos/' . $v->photo_name?>" style="width: 30%;">
                                                    <strong style="margin-top: 15px"><?php echo $v->comment;?></strong>
                                                </td>
                                                <?php
                                                $ref++;
                                            }
                                        }
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <div class="disclaimer" >
                        <div class="title">Disclaimer and Special Reporting Conditions</div>
                        <div class="content-div">
                            <p>Note- For the purpose of this document Synergy Building Consultants Limited is also known as Synergy.</p>
                            <p>1. Our responsibility in connection with this report is limited to the person or party to whom the report is addressed and we disclaim all responsibility
                                to any other party with reference to us.
                            </p>
                            <p>2. This report is a visual one only of the building elements which may be seen easily during the inspection process and does not include any item
                                that is closed in or concealed including (but not limited to) flooring, walls, ceiling, framing, plumbing and drainage, heating, ventilation and wiring.</p>
                            <p>3. Unless expressly stated, we have made no detailed survey of the property in terms of boundary or contour surveys, geotechnical or hydrological
                                survey, environmental surveys, structural assessments, building defects survey, valuation, legal assessment, etc. We have prepared this report on
                                the information available at the time and information provided by the client and/or third parties.</p>
                            <p>4. Where another party has supplied information to us for the purpose of the report, this information is believed to be reliable but we can accept no
                                responsibility if this should prove not to be so. Where information is given without being attributed directly to another party, this information has
                                been obtained by our search of council records and examination of documents or by enquiry from Government or other appropriate departments
                                or companies.</p>
                            <p>5. It is agreed that this report is compiled and completed by Synergy on the basis that it is not liable for any loss or damage resulting from its failure
                                or omission in identifying any condition or latent defect that may be concealed at the time of inspection.</p>
                            <p>6. Unless otherwise stated and specifically commissioned, no documentation we provide including any drawings are to be considered design
                                document pursuant to the building legislation. It is the responsibility of the designer and contractor to determine what is “Restricted Building
                                Work” and to ensure that all “Restricted Building Work” will be carried out or supervised by a Licensed Building Practitioner who holds a correct
                                licence class pursuant to the building legislation for the work being completed. The designer and contractor takes full responsibility for any
                                penalties incurred regarding non-compliance with this part of the building legislation.</p>
                            <p>7. The cost and revenue figures provided in this report are estimates only and are based on information available at the time and/or information
                                provided by the client and/or third parties. Cost or revenue projections outlined in this report are based on the typical costs or revenue that can
                                reasonably be expected at the time, and may be subject to unforseen or unaccounted items, issues or events. Synergy Building Consultants
                                Limited does not take any responsibility for the financial outcomes of any property development to which the figures in the report relate.</p>
                            <p>8. Time frames outlined in this report are estimates only. Timeframes are based on what could be reasonably expected or achieved over a period of
                                time and are based on the information available at the time, and may be subjected to unforseen issues and/or events. Synergy Building
                                Consultants Limited does not take responsibility for the accuracy of timeframes.</p>
                            <p>9. Any Liability Synergy attracts to the client for defects it could easily viewed by omitted to notice and/or arising from, the provision of this report is
                                limited to the aggregated amount of the fee, with a multiple of five (5) charged by Synergy for this report.</p>
                            <p>10. Synergy’s responsibility in connection with this inspection report is limited to the client to whom this report is addressed and not its assignees or
                                to third parties. Synergy disclaims all responsibility and accepts no liability to any other party other than the client. Acceptance and payment of
                                the fee is deemed as acceptance of all conditions.</p>
                            <p>11. This report may be not reproduced, in whole or part, without our prior written approval.</p>
                        </div>
                        <div class="title">Terms of Business</div>
                        <div class="content-div">
                            <p>Note- For the purpose of this document Synergy Building Consultants Limited is also known as Synergy.</p>
                            <p>12. Form of Engagement: Synergy agrees to undertake a visual inspection of the property in order to provide a report on the estimated scope of
                                works and cost to repair property (“the services”). The report is an estimate only and is based on a visual inspection of the building elements,
                                which could be seen easily and does not include any item that is closed in or concealed. Therefore we are unable to report that any such part of
                                the property is free from defect.</p>
                            <p>13. Exclusions: Without limiting cause 1, the client acknowledges that the inspection undertaken by Synergy does not cover the following items and
                                Synergy accepts no liability whatsoever for these items:
                                <ul class="text-list">
                                    <li>Items not listed in the report or not commented on;</li>
                                    <li>Latent defects; i.e. defects that are not visible or are dormant or existing, but not developed or manifested at the time of the report.</li>
                                    <li>Specialist areas such as structural, electrical, plumbing, gas or heating and ventilations;</li>
                                    <li>The accuracy of fence lines, boundary lines or survey pegs; or</li>
                                    <li>Any tests or specialist knowledge relating to anything involving chemicals or hazardous substances, including but not limited to asbestos.</li>
                                </ul>
                            </p>
                            <p>14. Leaking Building Syndrome: It is agreed that Synergy is not liable for any loss, cost, defect or damage whatsoever to any building, structure, or
                                person, nor any claim, defence or cost which is directly or indirectly caused by or contributed to by, or arises directly or indirectly out of.
                                <ul class="text-list">
                                    <li>The actions or effects of mould, fungi, rot, decay or any other similar forms in any building structure;</li>
                                    <li>The failure of any building structure to meet or conform to the requirements of the New Zealand Building Code in relation to external water or
                                        moisture entering that building or structure and the effects thereof;</li>
                                    <li>Any failure to discover, identify or minimise any defect or damage the type referred to sub-causes a. or b. above.</li>
                                </ul>
                            </p>
                            <p>15. Prices: The client shall pay Synergy the prices stated in this Estimate/Report for the services (“the prices”). All additional out of pocket expenses
                                incurred by Synergy will be payable for the Client, including but not limited to accommodation and meals, travel and administration costs.</p>
                            <p>16. Payment: Synergy will invoice the Client monthly and payment is due on the 20th of the month following the invoice date without deduction or
                                set off. Synergy shall be entitled to charge default interest on all amounts outstanding at a rate of two precent (2%) per annum above the Base
                                Lending Rate of Synergy’s bank from the due date of payment until the actual date of payment of all amounts.</p>
                            <p>17. Clients Premises: The client shall at all reasonable times give Synergy’s authorised personnel free and safe access to the Client’s premises and any
                                facilities, equipment or computer systems as is reasonably necessary for Synergy to preform its obligations under this Estimate/Report. When
                                using the Client’s premises, Synergy shall comply with all reasonable directions and procedures relating to occupational health and safety and
                                security in effect at those premises.</p>
                            <p>18. Intellectual Property: All intellectual property developed by Synergy during the term of this of this Estimate/Report shall remain the property of
                                Synergy. The client is granted a non-exclusive, non-transferable licence in perpetuity to use such intellectual property in the manor anticipated by
                                this Estimate.</p>
                            <p>19. Termination: Synergy shall have the right to terminate this Estimate/Report (without prejudice to any other of its rights) immediately if the Client
                                commits a breach of this Estimate/Report and the breach is not remedied within fourteen (14) days of notification of the breach by Synergy.</p>
                            <p>20. Warranty: Synergy warrants that the Services will be provided with due care and diligence, taking into account the nature and scope of the work.
                                This warranty is only applicable for ninety (90) days from the delivery of the services. All other warranties, representations or conditions, wether
                                express or implied, are hereby excluded to the fullest extent permitted by law. The Client’s sole remedy in respect of a breach of this warranty
                                period, at the cost of Synergy, in order to rectify any breach of this warranty. No representation or warranty is made with respect to the outcome
                                of such efforts.</p>
                            <p>21. Liability: Synergy will not be liable to any third party for any incidental, indirect, special or consequential loss or damage, including but not limited
                                to loss of profits or data, errors, deficiencies, delays, loss of service, profits or savings, or any damages based on a third party claim. In any event,
                                the total liability of Synergy shall not exceed the total payments made under this Estimate/Report in the twelve (12) months immediately prior to
                                the breach.</p>
                            <p>22. Indemnity: The Client hereby indemnifies, and will keep Synergy indemnified, against all obligations and liabilities incurred by any act or omission
                                of the Client in relation to the Estimate/Report.</p>
                            <p>23. Confidential Information: The parties shall keep all business information gained in relation to this Estimate/Report confidential and shall ensure
                                that, at any time during or after the term of this Estimate/Report, such information shall not be disclosed to any other third party without the
                                consent of the party suppling such information. Confidential information does not include information that is required to be disclosed by law, or is
                                in the public domain without a party having breached its obligations under this Estimate/Report.</p>
                            <p>24. Force Majeure: If Synergy is unable to perform its obligations under this Estimate/Report due to events beyond its control, then Synergy shall be
                                released from its obligations under this Estimate/Report, but with out prejudice to any pre-existing claim, liability or responsibility in respect of this
                                Estimate/Report.</p>
                            <p>25. General: This Estimate/Report supersedes all previous communications, representations, agreements or understandings, verbal or written,
                                between the parties with respect to the Services. If, at any time, any provision of this Estimate/Report is or becomes illegal, invalid or
                                unenforceable, neither the legal validity nor enforceability of the remaining provisions shall in any way be affected or impaired. No failure or delay
                                by Synergy in exercising any power or right under this Estimate/Report shall be deemed to be a waiver of any such power or right. The
                                Estimate/Report shall not be modified or amended except by written agreement between Synergy and the Client. The Estimate shall be governed
                                and construed in accordance with the law of New Zealand.</p>
                        </div>
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
$pdfName = str_replace(' ','_',$job_name) . '_Inspection_Report_' . date('Ymd_His');
@ $domPdf->stream($pdfName.".pdf", array("Attachment" => 0));

$dir = realpath(APPPATH.'../pdf/inspection_report');

$file_to_save = $dir . '/' . $job_id . '/' . $pdfName.'.pdf';

file_put_contents($file_to_save, $domPdf->output());
?>