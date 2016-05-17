<script>
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
    });
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display table-colored-header" id="example" >
    <thead>
    <tr>
        <th>No.</th>
        <th>Plant Description</th>
        <th>Equipment Number</th>
        <th>Type of Equipment</th>
        <th>Manufacturer</th>
        <th>Report Number</th>
        <th>Inspection Date</th>
        <th>Expectation Date</th>
    </tr>
    </thead>
    <tbody class="table-content">

    </tbody>
</table>