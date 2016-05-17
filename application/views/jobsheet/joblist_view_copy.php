

<script type="text/javascript">
    $(function(){
        var uTable = $('#example').dataTable( {
            "sScrollY": 500,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu" : ["All"],
            "iDisplayLength" : -1
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );
        $('.spinx-content.toggle').hide();

        $('.toggle-spinx').click(function(e){

            $('.spinx-content.toggle').toggle(
                "blind",            //effect
            {                       //options
                queue: false
            },
            500                     //duration
            );
        });

        var assignTable = $('#assign-table').dataTable( {
            "sScrollY": 200,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu" : ["All"],
            "iDisplayLength" : -1
        } );
        $(window).bind('resize', function () {
            assignTable.fnAdjustColumnSizing();
        } );
        $('.assign').click(function(e){
            var selectedID = this.id;
            $('.modal').bPopup({
                zIndex: 1000,
                closeClass: '.close',
                modalClose: false,
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(e){
                    $.post(
                        '<?php echo base_url() . 'joblist'?>',
                        {
                            RequestInspector: true
                        },
                        function(json){
                            assignTable.fnClearTable();
                            assignTable.fnAddData(json);
                            assignTable.fnDraw();
                            assignTable.fnAdjustColumnSizing();
                            assignTable.fnOpen(func);
                        }
                    );

                    $('.select').click(function(e){
                        alert(this.id);
                    });
                }
            });
        });



    });


</script>
<div class="grid_16">
    <div class="description">
        This is the list of all the jobs that are already confirmed by the client.
    </div>

    <div class="spinx">
        <div class="spinx-header">
            Jobs Available
        </div>
        <div class="spinx-content">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Company</th>
                    <th>Equipment</th>
                    <th>Inspector</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(count($_clientData) > 0){
                    $info = array();
                    $schedMonth = array();
                    $totalEquipments = 1;

                    $userDD = array();
                    if(count($_inspectorData)>0){ //used for drop down.
                        foreach($_inspectorData as $user){
                            $userDD[$user->ID] = $user->Username;
                        }
                    }
                    foreach($_clientData as $client){
                        $clientName = $client->FirstName . ' ' . $client->LastName;
                        $clientID = $client->ID;
                        $c1 = $client->CompanyName;
                        $inspectDate = date('F d Y', strtotime($client->JobSchedule));
                        foreach($_status as $s){ //get the client status
                            if($s->StatusID == $client->StatusID){
                                $status = $s->Status;
                            }
                        }

                        ?>
                        <tr class="odd gradeX">
                            <td><a href="<?php echo base_url() . 'viewClient/' . $this->encryption->encode($clientID); ?>" style="color:#364C50;"><?php echo $clientName; ?></a></td>
                            <td><?php echo $c1 ?></td>
                            <td style="text-align:center; "><button class="m-btn green" style="padding: 3px 7px; margin: 0;">View</button> </td>
                            <td style="text-align:center; ">
                                <button class="m-btn green assign" id="<?php echo $clientID; ?>" style="padding: 3px 7px; margin: 0;">Assign</button>
                            </td>
                            <td style="width: 100px;">
                                <button>a</button>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!--popup window-->
<div id="" class="modal">
    <div id="heading">
        Quote for Inspection
    </div>
    <div id="modal_content">
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="assign-table" >
            <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="table-content">

            </tbody>
        </table>
        <div class="sep-dashed"></div>
        <div style=" padding: 0 10px 10px 0">
            <div style="text-align: right;">
                <button class="m-btn green close" >Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    #example .odd{
        background-color: #e9e9e9;
    }
    #example .even{
        background-color: #f3f3f3;
    }
    #example td{

    }
    .spinx{
        margin-top: 20px;
        width: 100%;
        font-size: 14px;
    }
    .spinx .spinx-header{
        padding: 10px 14px;
        background-color: #35aa47;
        color: #fff;
        cursor: pointer;
    }
    #section-menu{
        font: inherit;
    }
    #section-menu li a{
        padding: 10px;
    }
</style>

