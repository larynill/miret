<button class="btn btn-primary btn-sm add_lead"><i class="glyphicon glyphicon-plus"></i> Leads</button>
<div style="height: 10px;"></div>
<div class="row responsive col-sm-12">
<table class="table table-colored-header">
    <thead>
    <tr>
        <th style="text-align: center;">First Name</th>
        <th>Last Name</th>
        <th>Title</th>
        <th class="data-column">Phone</th>
        <th class="data-column">Email</th>
        <th class="data-column">City</th>
        <th class="data-column">State/Province</th>
        <th class="data-column">Country</th>
        <th class="data-column">Leads Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($leads) > 0){
        foreach($leads as $lv){
            ?>
            <tr>
                <td style="cursor:pointer" id="<?php echo $lv->id;?>" class="a"><?php echo $lv->first_name?></td>
                <td><?php echo $lv->last_name?></td>
                <td><?php echo $lv->title?></td>
                <td class="data-column"><?php echo $lv->phone?></td>
                <td class="data-column"><?php echo $lv->email?></td>
                <td class="data-column"><?php echo $lv->city?></td>
                <td class="data-column"><?php echo $lv->state_province?></td>
                <td class="data-column"><?php echo $lv->country_name?></td>
                <td class="data-column"><?php echo $lv->leads_status?></td>
            </tr>
            <tr>
                <td style="display: none" id="a<?php echo $lv->id;?>">
                    <strong>Phone: </strong><?php echo $lv->phone?><br><br>
                    <strong>Email: </strong><?php echo $lv->email?><br><br>
                    <strong>City: </strong><?php echo $lv->city?><br><br>
                    <strong>State/Province: </strong><?php echo $lv->state_province?><br><br>
                    <strong>Country: </strong><?php echo $lv->country_name?><br><br>
                    <strong>Leads Status: </strong><?php echo $lv->leads_status?>
                </td>
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
</div>
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
    $('.a').click(function() {
         var trid = $(this).closest('td').attr('id');
         // alert(trid);
         // $(trid).show();
         $('#a'+ trid).toggle();
        });
</script>