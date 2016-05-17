<div id="external-event-group">
    <div class="external-event-title">
        Available Jobs
    </div>
    <?php
    /*if(count($_acceptedClientData) > 0){*/if(count($_acceptedClientData) > 0){
        foreach($_acceptedClientData as $client){
            $name = $client->FirstName . " " . $client->LastName;
            $company = $client->CompanyName;

            $isAssigned = false;

            foreach($_assignmentData as $assign){
                if($client->ID == $assign->ClientID ){ //if the client id is found in the table
                    $isAssigned = true;
                }

            }
            ?>

            <div class='external-event <?php if($isAssigned){ echo 'isAssigned'; } else { echo 'notAssigned'; }?>' id="<?php echo $client->ID;?>">
                <p><?php echo $name . ' - ' . $company; ?></p>
            </div>

        <?php
        }
    }
    else{
        ?>
        <div class='external-event notAssigned no-jobs'>
            <p style="text-align: center">No Jobs Available</p>
        </div>
    <?php
    }
    ?>
</div>