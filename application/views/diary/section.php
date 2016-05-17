<div class="grid_4">

    <div class="block" id="section-menu">

        <ul class="section menu">

            <?php
            if(count($_inspectDates) > 0){
                foreach($_inspectDates as $year => $dateVal){
                    ?>
                    <li>
                        <a class="menuitem"><?php echo $year?></a>
                        <ul class="submenu">
                            <?php
                            if(count($dateVal) > 0){
                                foreach($dateVal as $month => $monthValue){
                                    $url = base_url() . 'schedule/' . $year . '-' . $month;
                                    ?>
                                    <li>
                                        <a href=<?php echo $url; ?>><?php echo $month; ?></a>
                                    </li>
                                <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                }
            }else{
                ?>
                <p style="text-align: center">No Available Schedules</p>
            <?php
            }
            ?>
        </ul>
    </div>
</div>