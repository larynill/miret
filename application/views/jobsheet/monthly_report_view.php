<script type="text/javascript">
    $(function(){
        var uTable = $('#example').dataTable( {
            "sScrollY": 300,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false
        } );

        $('.assign-inspector').click(function(e){
            var clientID = this.id;
            $('.modal').bPopup({
                zIndex: 1000,
                closeClass: '.close',
                modalClose: false,
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(e){
                    var selectedID = '';
                    $('.inspector_username').click(function(e){
                        selectedID = this.id;

                        $('.assign').removeAttr('disabled');

                    });
                    $('.assign').click(function(e){
                        $.post(
                            '',
                            {
                                assigned: true,
                                UserID: selectedID,
                                ClientID: clientID
                            },
                            function(e){
                                location.reload();
                            }
                        );
                    });
                    uTable.fnAdjustColumnSizing();
                    uTable.fnDraw();
                }
            });
        });
    });
</script>
<?php
$navTitles = array(
    'monthlyReport' => 'Official',
    'monthlyReport/potential' => 'Potential'
);
?>

<div class="grid_16">
    <div>
        <ul class="" id="inline-menu">
            <?php
            if(isset($navTitles) && count($navTitles) > 0){
                foreach($navTitles as $link => $title){
                    if(is_array($title)){
                        getSublink($link, $title, $this->uri->segment(1) ? $this->uri->segment(1) : '');
                    }else{

                        ?>
                        <li  class="<?php echo $this->uri->segment(1) == $link ? 'selected' :  $this->uri->segment(2) == $link ? 'selected' : ''?>">
                            <a href="<?php echo $link ? base_url() . $link : "#"?>">
                                <?php echo $title; ?>
                            </a>
                        </li>
                    <?php
                    }
                }
            }
            ?>
        </ul>
    </div>
    <div class="small-heading">
        <div id='side-position'>
            <?php $filters = array('All', 'Assigned Jobs', 'Not Assigned Jobs')?>
            Filter By: <span style="float: right; margin: 0;padding: 0; width: 150px;"><?php echo form_dropdown('', $filters )?></span>
        </div>
        <?php
            if($_monthlyTitle){
                echo 'Inspections for Month of <strong>' .$_monthlyTitle. '</strong>';
            }
        ?>
    </div>
    <?php
    if(isset($_monthlyClient)){
        if(count($_monthlyClient) > 0){
            foreach($_monthlyClient as $client){
                $c1 = $client->CompanyName;
                $c2 = $client->FirstName . ' ' . $client->LastName;
                $decode = json_decode($client->WorkPhone);
                if(is_object($decode)){
                    $c3 = $decode->area_code .' '. $decode->number .' '. $decode->ext;
                }
                if($client->MobilePhone != ''){
                    $c3 .= ' - ' . $client->MobilePhone ;
                }
                ?>
                <div>
                    <?php if($this->uri->segment(1) == 'monthlyReport' && $this->uri->segment(2) == ''){
                        if($client->StatusID != 1){
                            ?>
                            <div style="text-align: right">
                                <button class="m-btn green assign-inspector" id="<?php echo $client->ID;?>">Assign</button>
                            </div>
                            <?php
                        }else if($client->StatusID == 1){
                            if(count($_jobData) > 0){
                                foreach($_jobData as $job){
                                    if(count($_inspectors) > 0){
                                        foreach($_inspectors as $inspect){
                                            if($inspect->ID == $job->UserID && $client->ID == $job->ClientID){
                                                $name = $inspect->Username;
                                            ?>
                                                <div style="text-align: right">
                                                    <button class="m-btn">Assigned to <?php echo $name;?></button>
                                                </div>
                                            <?php
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }?>
                    <p style="font-size: 18px; font-weight: bold">
                        <em style="float:left"><?php echo $c1 . ' - ' . $c2;?></em>
                        <em style="margin-left: 15%"> &nbsp  </em>
                        <em style="float:right"> <?php echo $c3;?></em>
                    </p>
                </div>
                <div class="sep-bold"></div>
                <table>
                    <thead>
                    <tr>
                        <th>Plant Description</th>
                        <th>Equipment Number</th>
                        <th>Type of Equipment</th>
                        <th>Manufacturer</th>
                        <th>Report Number</th>
                        <th>Inspection Date</th>
                        <th>Expiry Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(count($client->Equipment) > 0){
                            foreach($client->Equipment as $equip){
                                $e1 = $equip->PlantDescription;
                                $e2 = $equip->EquipmentNumber;
                                $e3 = $equip->TypeEquipment;
                                $e4 = $equip->Manufacturer;
                                $e5 = $equip->LastReportNumber;
                                $e6 = date('d/m/Y', strtotime($equip->InspectionDate));
                                $e7 = date('d/m/Y', strtotime($equip->ExpectationDate));
                                ?>
                                <tr>
                                    <td><?php echo $e1; ?></td>
                                    <td style="text-align: center;"><?php echo $e2; ?></td>
                                    <td style="text-align: center;"><?php echo $e3; ?></td>
                                    <td style="text-align: center;"><?php echo $e4; ?></td>
                                    <td style="text-align: center;"><?php echo $e5; ?></td>
                                    <td style="text-align: center;"><?php echo $e6; ?></td>
                                    <td style="text-align: center;"><?php echo $e7; ?></td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            }
        }
    }
    ?>
</div>
<div id="assign_view">
    <!--popup window-->
    <div id="" class="modal">
        <div id="heading">
            Assign An Inspector for the Job
        </div>
        <div id="modal_content">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Photo</th>
                    <th>Username</th>

                </tr>
                </thead>
                <tbody class="table-content">
                    <?php
                        $counter = 0;
                        if(count($_inspectors) > 0){
                            foreach($_inspectors as $inspect){
                                $counter++;
                            ?>
                                <tr>
                                    <td style="width: 20px"><?php echo $counter;?></td>
                                    <td>
                                        <img src="<?php echo base_url(); ?>plugins/img/photo_60x60.jpg" width="60" height="60" alt="photo" />
                                    </td>
                                    <td style="cursor: pointer" id="<?php echo $inspect->ID?>" class="inspector_username">
                                        <?php echo $inspect->Username;?>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
            <div class="sep-dashed"></div>
            <div style=" padding: 0 10px 10px 0">
                <div style="text-align: right;">
                    <button class="m-btn green assign" disabled="disabled">Assign</button>
                    <button class="m-btn green close" >Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .small-heading{
        font-size: 20px;
        padding: 10px 14px;
        margin-left: 20px;
    }
    .small-heading #side-position{
        float: right;
        font-size: 14px;
        width: 20%;
        margin: -20px;
        padding: 0;
        display: inline;
    }
    .division3{
        width: 100%;
        margin: 0;
        padding: 0;
    }
    table{
        width: 100%;
        margin-bottom: 50px;
    }
    table thead th{
        font-weight: normal;
        font-style: italic;
    }
    .division3 div{
        font-size: 22px;
    }
    .sep-bold{
        border: 1px solid #000;
    }
    #inline-menu{
        width: 100%;
        float:left;
        list-style: none;
        padding: 0;
        font-size: 16px;
        background-color: #f2f2f2;
        border-bottom: 1px solid #ccc;
        margin-bottom: 30px;
    }
    #inline-menu li a{
        display:block;
        padding: 8px 15px;
        color: #333;
        text-decoration: none;
        border-right: 1px solid #ccc;
    }
    #inline-menu li a:hover{
        background-color: #ccc;
    }
    #inline-menu li{
        float:left;
    }
    table td img{
        padding:4px;
        border:1px solid #bbb;
        background:#fff;
    }
</style>