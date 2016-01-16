<script type="text/javascript">
    $(function(){
        var uTable = $('#example').dataTable( {
            "sScrollY": 300,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu" : ["All"],
            "iDisplayLength" : -1
        } );
        $('.modal').bPopup({
            zIndex: 1000,
            closeClass: '.close',
            modalClose: false,
            modalColor: 'rgba(0, 0, 0, 0.5)',
            onOpen: function(e){
                uTable.fnAdjustColumnSizing();
            }
        });
    });
</script>
<!--popup window-->
<div id="" class="modal">
    <div id="heading">
        Quote for Inspection
    </div>
    <div id="modal_content">
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
            <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Equipment Number</th>

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