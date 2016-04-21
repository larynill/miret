<button class="btn btn-primary btn-sm add_lead"><i class="glyphicon glyphicon-plus"></i> Leads</button>
<div style="height: 10px;"></div>
<table class="table table-colored-header">
    <thead>
    <tr>
        <th style="text-align: center;">First Name</th>
        <th>Last Name</th>
        <th>Title</th>
        <th>Phone</th>
        <th>Email</th>
        <th>City</th>
        <th>State/Province</th>
        <th>Country</th>
        <th>Leads Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($leads) > 0){
        foreach($leads as $lv){
            ?>
            <tr>
                <td><?php echo $lv->first_name?></td>
                <td><?php echo $lv->last_name?></td>
                <td><?php echo $lv->title?></td>
                <td><?php echo $lv->phone?></td>
                <td><?php echo $lv->email?></td>
                <td><?php echo $lv->city?></td>
                <td><?php echo $lv->state_province?></td>
                <td><?php echo $lv->country_name?></td>
                <td><?php echo $lv->leads_status?></td>
            </tr>
            <?php
        }
    }else{
        ?>
        <tr>
            <td colspan="9" style="text-align: center;">No data has been found</td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<script>
    $(function(e){
        $('.add_lead').on('click',function(){
            var link = bu + 'leads/add_lead';
            console.log(link);
            $(this).modifiedModal({
                'title': 'Add Leads',
                'url': link,
                'type': 'large'
            });
        });
    })
</script>