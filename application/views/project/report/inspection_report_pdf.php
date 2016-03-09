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
            padding: 0!important;
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
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 15px 0;
        }
        .content-div{
            padding: 10px 0 0;
        }
        .border-table{
            border-collapse: collapse;
            width: 100%;
        }
        .df-table{
            border: none;
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        .df-table tr td{
            border: none;
            padding: 5px;
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
        .client-details tr td:nth-child(1){
            text-transform: uppercase;
            font-weight: bold;
            width: 50%;
        }
        .client-details tr td, .property-table tr td{
            border: 1px solid #000000;
        }
        .list li{
            padding-bottom: 15px;
            text-align: justify;
        }
        .property-table tr td:nth-child(2){
            text-align: center;
        }
        .sub-title{
            font-weight: bold;
            font-size: 14px;
            text-decoration: underline;
        }
        .details-table{
            margin: 15px 0;
            border-collapse: collapse;
            border: 1px solid #000000!important;
            border-top: none!important;
            border-left: none!important;
            border-right: none!important;
        }
        .details-table tr td{
            border: 1px solid #000000;
            padding: 5px;
        }
        /*.dp-text{
            color: #ff4b88;
        }*/
    </style>
</head>

<body>
<div class="header">
    <img src="<?php echo base_url().'img/logo-other.gif'?>" width="300">
</div>
<div class="footer">
    <div class="details">
        <table class="table table-details">
            <tr>
                <td>
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
                        <tr>
                            <td colspan="2" class="text-left">&copy; Copyright Synergy Property Inspections</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <img src="<?php echo base_url().'img/footer-logo-sitesafe.gif'?>" width="120">
                </td>
                <td>
                    <img src="<?php echo base_url().'img/footer-logo-lbp.gif'?>" width="120">
                </td>
            </tr>
            <tr>
                <td style="text-align: justify;" colspan="3">
                    REPORT LIMITATIONS This report has been prepared for the sole and exclusive use of the client indicated above and is limited to an impartial
                    opinion which is not a warranty that the items inspected are defect-free, or that latent or concealed defects may exist as of the date of this
                    inspection or which may have existed in the past or may exist in the future. The report is limited to the components of the property which were
                    visible to the inspector on the date of the inspection and his opinion of their condition at the time of the inspection.
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="content">
    <div class="content-div">
        <div class="title">DETAILED PROPERTY INSPECTION</div>
        <table class="df-table">
            <tr>
                <td style="vertical-align: top;font-weight: bold;">Scope of Report:</td>
                <td style="text-align: justify">
                    Visual inspection of the property for the purpose of a pre
                    purchase/sale inspection in	accordance with	NZS	4306
                    Residential	Property Inspections.
                </td>
            </tr>
        </table>
        <table class="df-table client-details">
            <tr>
                <td>Client</td>
                <td><?php echo $inspection_report->insured_name;?></td>
            </tr>
            <tr>
                <td>Client Reference Number</td>
                <td><?php echo $inspection_report->client_ref;?></td>
            </tr>
            <tr>
                <td>Site Address</td>
                <td><?php echo $inspection_report->address?></td>
            </tr>
            <tr>
                <td>Inspection Date</td>
                <td><?php echo $inspection_report->inspection_time ? date('d M Y',strtotime($inspection_report->inspection_time)) : ''?></td>
            </tr>
            <tr>
                <td>Building Inspector</td>
                <td><?php echo $inspection_report->inspector;?></td>
            </tr>
            <tr>
                <td>Report</td>
                <td><?php echo $inspection_report->report;?></td>
            </tr>
        </table>
        <table class="df-table">
            <tr>
                <td style="text-decoration: underline;font-weight: bold;">ORIENTATION</td>
                <td style="text-align: left!important;">
                    For the purpose of this report the main entrance to the house is
                    on the <span class="dp-text"><?php echo $inspection_report->elevation;?></span> elevation.
                </td>
            </tr>
        </table>
        <div style="text-align: center;padding-top: 15px;">
            <img src="<?php echo base_url().'uploads/job/' . $inspection_report->job_id . '/photos/' . $inspection_report->photo?>" width="600" height="350">
        </div>
        <div class="title" style="page-break-before: always;">INTRODUCTION</div>
        <div>
            <?php
            $client_name = explode(' ',$inspection_report->insured_name);
            ?>
            <p>Dear <?php echo $client_name[0];?>,</p><br/>
            <p>Thank you so much for the opportunity to inspect and report on your new property. We appreciate the confidence
                you placed in our team by allowing us to assist you in this way.</p><br/>
            <p>If you have any questions about this inspection please do not hesitate to give us a call.</p><br/>
            <p>Thank you again for the confidence you have placed in Synergy Property Inspections.</p><br/>
            <p>Sincerely,</p><br/>
            <p><?php echo $inspection_report->inspector;?></p><br/>
            <p>Synergy Property Inspections</p><br/>
            <p><img src="<?php echo base_url().'img/logo-other.gif'?>" width="150"></p><br/><br/>
            <p style="text-align: justify">
                *** Please note what this report should be seen as a reasonable attempt to identify any significant defects at the time
                of the visual inspection, not an all-encompassing report dealing with the property from every aspect. Minor defects
                are common to most properties and may include minor blemishes, corrosion, cracking, weathering, general
                deterioration, unevenness, and physical damage to materials and finishes that could be expected with age, and
                general wear and tear. While some minor defects may be noted, it is unrealistic for the Inspector to comment on all
                minor defects and imperfections in this standard property report, we also unable to carry out any probe or
                destructive testing, nor move any furnishings, appliances or vegetation in a visual inspection.
            </p>
        </div>
        <div class="title" style="page-break-before: always;">SUMMARY</div>
        <p style="text-align: justify">
            This section of the report is to provide the reader with the inspector’s overall opinion of the property. The summary
            is designed to identify the main points about the property and Synergy Property Inspections recommends that the
            entire report be read in full. Please note that this report is completed in accordance with Terms of Agreement,
            Disclaimer and special reporting conditions that are detailed in this report.
        </p><br/>
        <p>The inspection and any subsequent investigations involved the following procedures:</p><br/>
        <ol class="list">
            <li>
                Visual inspection of all buildings and elements/components of the property that are not concealed. This includes
                electrical fittings and appliances but does not include the actual testing of the operation or electrical circuits
                within fittings or appliances in anyway. The inspection also includes assessing the roof from ladder access at the
                perimeters or other vantage points but does not include climbing onto the roof due to health and safety
                restrictions. If specified non-accessible roof surfaces and other elements were viewed and assessed through aerial
                photography or videography where possible.
            </li>
            <li>
                If access permits, visual inspection of the roof space as described within the report.
            </li>
            <li>
                Drain testing of gulley traps and the waste water system by running cold water from all sanitary fixtures.
            </li>
            <li>
                Moisture scanning of wall linings and skirting that surround wet areas such as showers and baths, and to external
                wall cladding that are considered at risk to moisture issues with a non-invasive moisture meter that provides
                indicative readings within the lining material.
            </li>
            <li>
                Considering normal significant maintenance that is likely to be required in the next three years or as stated.
            </li>
            <li>
                A hose test on all storm water connections including the garage, house and drains within paved areas.
            </li>
            <li>
                Using a digital thermometer to determine water temperature of all taps to hand basins and sinks.
            </li>
            <li>
                Visual inspection of water pressure for general adequacy and taking the use of the fixture into consideration.
            </li>
            <li>
                Obtaining spot level readings throughout the ground floor surface using a Ziplevel Pro-2000 (Elevation
                Measurement System) to locations considered necessary to obtain the required data to reflect the differences in
                levels within the floor and foundations that would indicate any substantial settlement within the floor and
                foundations that are outside the acceptable tolerances.
            </li>
            <li>
                Carry out a visual inspection of the grounds within the apparent boundaries.
            </li>
        </ol>
        <div class="title" style="page-break-before: always;">CONCLUSIONS</div>
        <p style="text-align: justify">
            <?php 
            $notes = $inspection_report->notes;
            $conclusion = $inspection_report->conclusion;
            ?>

            The house is located in the <?php
            echo '<span class="dp-text">'.@$conclusion->side.'</span> side of ' . trim(str_replace(range(0,9),'',$inspection_report->address));
            ?> and is oriented on the section so that the living areas are
            facing generally <span class="dp-text"><?php echo @$conclusion->facing?></span>.
            The site is located on a <span class="dp-text"><?php echo @$conclusion->located?></span> suburban section that has
            <span class="dp-text"><?php echo @$conclusion->exposure?></span> exposure to the prevailing
            winds.<?php echo @$notes->site ? @$notes->site : '';?><br/><br/>

            The age of the house was taken into consideration when the inspection and reporting was carried out. The survey of
            the condition of the building elements and components were carried out on the basis of ‘the expected condition of
            the materials’ considering their use, location and age.<br/><br/>

            The house is constructed on a <span class="dp-text"><?php echo @$conclusion->constructed?></span>. At the time of inspection the foundation to the
            dwelling appeared in <span class="dp-text"><?php echo @$conclusion->house_condition?></span> condition.
            <?php echo @$notes->subfloor ? @$notes->subfloor : '';?><br/><br/>

            The majority of the building is clad with <span class="dp-text"><?php echo @$conclusion->finish?></span> finish, which appears structurally sound and generally
            in <span class="dp-text"><?php echo @$conclusion->general_condition?></span> condition.
            <?php echo @$notes->exterior ? @$notes->exterior : '';?><br/><br/>
            
            The roof to the dwelling consists of <span class="dp-text"><?php echo @$conclusion->dwelling?></span> roof,
            which appears in <span class="dp-text"><?php echo @$conclusion->appears?></span> condition for its age and will
            require a <span class="dp-text"><?php echo @$conclusion->level?></span> level of maintenance over the coming years.
            <?php echo @$notes->roof_exterior ? @$notes->roof_exterior : '';?><br/><br/>

            The floor levels in our opinion are at <?php echo @$conclusion->floor_level?> tolerances.
            No evidence of <?php echo @$conclusion->evidence?> settlement has been
            identified.<br/><br/>

            No access was available to view the roof space, we sighted a blocked access to the hallway cupboard but this fixed
            shut. <?php echo @$notes->roof_space ? @$notes->roof_space : '';?><br/><br/>

            Internally the house appears in good condition. Overall, the house appears structurally sound.<br/><br/>

            Normal maintenance and repairs will be required over the coming years. The more significant items are detailed
            throughout the report.<br/><br/>

            <?php echo @$notes->interior ? @$notes->interior.'<br/><br/>' : '';?>
            <?php echo @$notes->services ? @$notes->services.'<br/><br/>' : '';?>

            The grounds to the property are generally in a <span class="dp-text"><?php echo @$conclusion->condition?></span> condition and
            landscaped to a <span class="dp-text"><?php echo @$conclusion->landscape?></span> condition for an existing
            <span class="dp-text"><?php echo @$conclusion->property?></span> property. Due to the concrete patios and pathways only a low level of maintenance would be required over the
            years. We noted some debris and old building materials stored down the southern side of the property.
            <?php echo @$notes->ancillary_space ? @$notes->ancillary_space : '';?><br/><br/>
        </p>
        <div class="title" style="page-break-before: always;">STATEMENT OF POLICY FOR STANDARD HOUSE INSPECTION</div>
        <p style="text-align: justify">
            Please Read Carefully.<br/><br/>
            The inspection of the property identified above is subject to the following Terms and Conditions:<br/><br/>
            a) The inspection by Synergy Property Inspections will be performed in accordance with generally accepted
            Standards of Practice.<br/><br/>
            b) A report will be provided at the conclusion of the inspection. This Report will be based on a limited visual
            inspection of the readily accessible aspects of the building. The Report is representative of the Inspector's opinion of
            the observable conditions on the day and time of inspection.<br/><br/>
            c) This inspection does not constitute an engineering evaluation and is not provided as either an engineering or
            architectural service.<br/><br/>
            d) The Inspection Report reflects the present condition of the subject property at the time of inspection.<br/><br/>
            e) This Report does not imply or constitute a guarantee, warranty, or an insurance policy with regards to this
            property.<br/><br/>
            This is not a home warranty, guarantee, insurance policy or substitute for real estate transfer disclosures which may
            be required by law. Your inspector is a home inspection generalist and is not acting as a licensed engineer or expert
            in any craft or trade. If your inspector recommends consulting other specialized experts, Client must do so at Client's
            expense
        </p>
        <div style="font-weight: bold;">SCOPE</div>
        <p style="text-align: justify">
            1. VISUAL INSPECTION: This inspection is a visual inspection only of readily accessible aspects of the property.
            A home inspection does not include identifying defects that are hidden behind walls, floors, or ceilings. This
            includes structure, wiring, plumbing, ducting, and insulation that are hidden or inaccessible. The inspector will not
            conduct any invasive or destructive testing of the property. Safety, accessibility, or other considerations may present
            the inspector with restrictions in examining specific home elements or components.<br/><br/>

            2. LIMITED ASSESSMENT The home inspection will provide you with a basic overview of the condition of the
            property. This inspection is not technically exhaustive or all encompassing, as your inspector has only a limited
            amount of time, as well as constraints in methodology, to complete the inspection. The inspector is a generalist, not
            a specialist in all disciplines, and may refer the home owner to specialists for further investigation of certain items.<br/><br/>

            3. CONTEXT OF INSPECTION This inspection should also be considered in the context of a "snapshot in time",
            reflecting the conditions of the home at the date of inspection. Future performance of components and elements of
            the home is outside the context of this inspection. For example, your inspector may not discover leaks that occur
            only under certain weather conditions. Some conditions noted, such as cracks in foundations, may be either cosmetic
            in nature or indicators of settlement; however predicting whether an individual condition will present future
            problems is beyond the scope of the inspection.<br/><br/>

            4. NOT BUILDING CODE OR BY-LAW COMPLIANCE INSPECTION Jurisdiction for Building Code, Electrical
            Code, Gas Code, Fire Code, Plumbing Code, or other statutory or by-law compliance inspections resides with the
            appropriate mandated authorities. The services provided by your home inspector are not conducted in the context of
            Code or by-law compliance inspections. The client acknowledges that it may be necessary to confer directly with the
            appropriate authorities to determine whether specific conditions comply with Code or by-law requirements.<br/><br/>

            5. ENVIRONMENTAL AND AIR QUALITY CONCERNS This inspection will not assess for environmental or air
            quality concerns. The scope on inspection does not include examination for hazardous materials that may be on the
            property, in or behind surfaces, or are constituent to building materials. The inspection does not include
            determination for irritants, pollutants, toxic materials, or contaminants; presence of mold, spores, or fungus;
            asbestos, radon gas, or carcinogens; etc. As well, the inspection does not include the determination of presence of
            insect, bird, rodent, or other infestations.<br/><br/>

            CONFIDENTIAL REPORT: The inspection report to be prepared for Client is solely and exclusively for Client's
            own information and may not be relied upon by any other person. Client agrees to maintain the confidentiality of the
            inspection report and agrees not to disclose any part of it to any other person. Client may distribute copies of the
            inspection report to the seller and the real estate agents directly involved in this transaction, but said persons are not
            specifically intended beneficiaries of this Agreement or the inspection report. Client and Inspector do not in any way
            intend to benefit said seller or the real estate agents directly or indirectly through this Agreement or the inspection
            report. Client agrees to indemnify defend and hold Inspector harmless from any third party claims arising out of
            Client's unauthorized distribution of the inspection report.<br/><br/>

            REPORT LIMITATIONS This report has been prepared for the sole and exclusive use of the client indicated above
            and is limited to an impartial opinion which is not a warranty that the items inspected are defect-free, or that latent
            or concealed defects may exist as of the date of this inspection or which may have existed in the past or may exist in
            the future. The report is limited to the components of the property that were visible to the inspector on the date of
            the inspection and his opinion of their condition at the time of the inspection.<br/><br/>

            SEVERABILITY: Client and Inspector agree that should a Court of Competent Jurisdiction determine and declare
            that any portion of this contract is void, voidable or unenforceable, the remaining provisions and portions shall
            remain in full force and effect.<br/><br/>

            DISPUTES: Client understands and agrees that any claim for failure to accurately report the visually discernible
            conditions at the Subject Property, as limited herein above, shall be made in writing and reported to the Inspector
            within ten business days of discovery. Client further agrees that, with the exception of emergency conditions. Client
            or Client's agents, employees or independent contractors, will make no alterations, modifications or repairs to the
            claimed discrepancy prior to a re-inspection by the Inspector. Client understands and agrees that any failure to notify
            the Inspector as stated above shall constitute a waiver of any and all claims for said failure to accurately report the
            condition in question.<br/><br/>

            ARBITRATION: Any dispute concerning the interpretation of this agreement or arising from this inspection and
            report, except one for inspection fee payment, shall be resolved informally between the parties or by arbitration
            conducted in accordance with the rules of a recognized arbitration association except that the parties shall select an
            arbitrator who is familiar with the home inspection industry. The arbitrator shall conduct summary judgment
            motions and enforce full discovery rights as a court would as provided in civil proceeding by legal code.<br/><br/><br/>

            Important Information:<br/><br/>

            You need to be aware that it is possible for problems in a house to be disguised to prevent detection. If you notice
            anything that were not visible at the time of your visit and our inspection on the day you move into the property then
            you should immediately contact us to discuss.<br/><br/>

            Vendor Inspections:<br/><br/>

            The vendor is required to notify the inspector of any existing conditions that you are aware of that have been an
            issue or may become a problem at the time of the inspection. Cancellation: If the inspection is cancelled up to 24
            hours before the inspection is due to be undertaken, a fee of $100 will be charged. If the inspection is cancelled
            within a 24-hour period of the due date of the inspection, the full cost of the inspection will be charged. We reserve
            the right to apply this policy at our discretion.<br/><br/>

            Payment: Payment is due on delivery of the inspection report unless otherwise arranged. All costs associated with
            debt collection will be added to the value of the invoice. Interest will be added at 2% per month for overdue
            accounts.<br/><br/>

            Insurers Disclaimer:<br/><br/>

            (a) This is a report of a visual only, non-invasive inspection of the areas of the building that were readily visible at
            the time of inspection. The inspection did not include any areas or components which were concealed or closed in
            behind finished surfaces (such as plumbing, drainage, heating, framing, ventilation, insulation or wiring) or which
            required the moving of anything which impeded access or limited visibility (such as floor coverings, furniture,
            appliances, personal property, vehicles, vegetation, debris or soil).<br/><br/>

            (b) The inspection did not assess compliance with the NZ Building Code including the Code’s weather tightness
            requirements, or structural aspects. On request, specialist inspections can be arranged of weather tightness or
            structure or of any systems including electrical, plumbing, gas or heating.<br/><br/>

            (c) As the purpose of the inspection was to assess the general condition of the building based on the limited visual
            inspection described in (a), this report may not identify all past, present or future defects. Descriptions in this report
            of systems or appliances relate to existence only and not adequacy or life expectancy. Any area or component of the
            building or any item or system not specifically identified in this report as having been inspected was excluded from
            the scope of the inspection.”<br/><br/><br/>

            DISCLAIMER<br/><br/>

            By ordering this Inspection, I/we acknowledge that we have reviewed, understood, and accepted the Terms and
            Conditions and the SCOPE OF INSPECTION described above. Inspector's liability for mistakes or omissions in this
            inspection report is limited to a refund of the fee paid for this inspection and report. The liability of the inspector's
            principals, agents, and employees is also limited to the fee paid. This limitation applies to anyone who is damaged or
            has to pay expenses of any kind because of mistakes or omissions in this inspection and report. This liability
            limitation is binding on client and client's spouses, heirs, principals, assigns and anyone else who may otherwise
            claim through client. Client assumes the risk of all losses greater than the fee paid for the inspection. Client agrees to
            immediately accept a refund of the fee paid as full settlement of any and all claims, which may ever arise from this
            inspection.
        </p>
        <div class="title" style="page-break-before: always;text-align: center">CERTIFICATE OF INSPECTION IN ACCORDANCE WITH NZS 4306:2005</div>
        <table class="df-table">
            <tr>
                <td colspan="2">Client: <?php echo $inspection_report->insured_name;?></td>
            </tr>
            <tr>
                <td colspan="2">Site Address: <?php echo $inspection_report->address;?></td>
            </tr>
            <tr>
                <td colspan="2">Inspector: <?php echo $inspection_report->inspector;?></td>
                <td>Company: Synergy Building Consultants</td>
            </tr>
            <tr>
                <td colspan="2">Qualifications: </td>
            </tr>
            <tr>
                <td colspan="2">Date of inspection: <?php echo $inspection_report->inspection_time ? date('d M Y',strtotime($inspection_report->inspection_time)) : ''?></td>
            </tr>
            <tr>
                <td colspan="2">The following areas of the property have been inspected:</td>
            </tr>
        </table>
        <table class="df-table property-table">
            <tr>
                <th style="width: 70%;border: none">&nbsp;</th>
                <th style="border: none">Yes</th>
                <th style="border: none">No</th>
                <th style="text-align: left; width:5%;border: none">Limited<br/>Inspection</th>
            </tr>
            <?php
            if(count($area_inspected) > 0){
                foreach($area_inspected as $val){
                    ?>
                    <tr>
                        <td style="text-align: left;"><?php echo $val->area_inspected;?></td>
                        <td style="text-align: center;"><?php echo $inspection_report->{$val->name} == 1 ? 'X' : '';?></td>
                        <td style="text-align: center;"><?php echo $inspection_report->{$val->name} == 0 ? 'X' : '';?></td>
                        <td style="text-align: center;"><?php echo $inspection_report->{$val->name} == 2 ? 'X' : '';?></td>
                    </tr>
                <?php
                }
            }
            ?>
        </table><br/>
        <p style="text-align: justify">
            Any limitations to the coverage of the inspection are detailed in the written report.<br/><br/>
            Certification:<br/><br/>
            I hereby certify that I have carried out the inspection of the property site at the above address in accordance with
            NZS 4306:2005 Residential Property Inspections and I am competent to undertake this inspection.
        </p>
        <table class="df-table">
            <tr>
                <td>Name: <?php echo $inspection_report->inspector;?></td>
                <td>Date: <?php echo date('d F Y')?></td>
            </tr>
            <tr>
                <td colspan="2">Signature: &nbsp;<span style="margin-left: 150px;">(for and on behalf of Synergy Property Inspections)</span></td>
            </tr>
        </table><br/>
        <p style="text-align: justify">
            An inspection carried out in accordance with NZS 4306:2005 is not a statement that a property complies with the
            requirement of any Act, regulation or bylaw, nor is the report a warranty against any problems developing after the
            date of the property report. Refer to NZS 4306:2005 for full details.
        </p>
        <div class="title" style="page-break-before: always">SITE INSPECTION</div>
        <?php
        if(count($site_inspection) > 0){
            foreach($site_inspection as $key=>$val){
                ?>
                <div class="sub-title"><?php echo $key;?></div>
                <table class="table details-table">
                    <tr>
                        <th>&nbsp;</th>
                        <th>COMMENTS:</th>
                        <th>PHOTO:</th>
                    </tr>
                <?php
                if(count($val) > 0){
                    foreach($val as $k=>$v){
                        ?>
                        <tr>
                            <td><?php echo $v->details;?></td>
                            <td style="width: 250px;">&nbsp;</td>
                            <td style="width: 250px;">&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </table>
                <?php
            }
        }
        ?>
    </div>
</div>
</body>
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