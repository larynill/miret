<style>
    .my-button{
        float: right;
        margin-bottom: 8px
    }
</style>
<script type="text/javascript">
    $(function(){
        var uTable = $('#example').dataTable( {
            "sScrollY": 300,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu" : ["All"],
            "iDisplayLength" : -1
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );

        $('.my-button').click(function(e){
            var selectedID = this.id;
            $('#modal').bPopup({
                zIndex: 1000,
                modalClose: false,
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(e){ //when open,fire this event.

                }
            });
        });
    });
</script>
<h5 style="float:left; margin-top: 20px">
    <?php
    if(count($_clientData) > 0 ){
        foreach($_clientData as $client){
            echo 'Client Name: ' . $client->FirstName . ' ' . $client->LastName;
        }
    }
    else{
        echo 'No Client';
    }
    ?>

</h5>
<div class="m-btn my-button"  style="cursor: pointer">Add Equipment</div>
<!--<button class="m-btn green my-button" style="margin-bottom: 8px">Add Equipment</button>-->
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
    <tr>
        <th>Plant Description</th>
        <th>Equipment Number</th>
        <th>Type of Equipment</th>
        <th>Manufacturer</th>
        <th>Report Number</th>
        <th>Inspection Date</th>
        <th>Expectation Date</th>
    </tr>
    </thead>
    <tbody>

            <!--<tr class="odd gradeX">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>-->

    </tbody>
</table>
<!--<button class="m-btn green my-button">Add Equipment</button>-->
<div class="m-btn my-button"  style="cursor: pointer">Add Equipment</div>
<!--popup window-->
<div id="modal" class="my-modal">
    <div id="heading">
        Quote for Inspection
    </div>
    <div id="modal_content">
        <p style="text-align: center; padding: 20px">
            Force Delete will make the client invisible from the system. <br/>
            Are you sure you want to force delete this client?
        </p>
        <div class="sep-dashed"></div>
        <div style=" padding: 0 10px 10px 0">
            <div style="text-align: right;">
                <button class="m-btn green yes" >Yes</button>
                <button class="m-btn green no" >No</button>
            </div>
        </div>
    </div>
</div>

<!--popup window style-->
<style>

    #modal {
        display:none;
        width:600px;
        padding:8px;

        background:rgba(0,0,0,.3);
        z-index:101;
    }

    #heading {
        width:600px;
        height:44px;

        background-color: coral;
        border-bottom:1px solid #bababa;

        -webkit-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        -moz-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);

        font-size:18px;
        text-align:center;
        line-height:44px;
        color:#ffffff;

    }

    #modal_content {
        width:600px;
        background:#fcfcfc;

        -webkit-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        -moz-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        box-shadow:0px 1px 3px rgba(0,0,0,.25);
    }


    #modal_content p {
        font-size:14px;
        font-weight:normal;
        line-height:22px;
        color:#555555;
        width:100%;
        margin:0;
    }
</style>
