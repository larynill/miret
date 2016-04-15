<table>
    <tr>
        <td>
            <img src="http://www.theestimator.co.nz/theestimatorpro/images/estimator_logo.jpg" />
        </td>
        <td>
            <strong>EOTL Daily Job Log - <?php echo isset($_GET['date']) ? date('d/m/Y', strtotime($_GET['date'])) : date('d/m/Y'); ?></strong>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php
            if(count($logs) > 0){
                foreach($logs as $type=>$data){
                    if($type == 1){
                        echo '<table>';
                        echo '<tr><td colspan="4"><h2>Created (' . count($data) . ')</h2></td></tr>';
                        ?>
                        <tr>
                            <th>Number</th>
                            <th>Reference</th>
                            <th>Client</th>
                            <?php echo $fMultiple ? '<th>Franchise</th>' : ''; ?>
                            <th>Alias</th>
                            <th>Job Name</th>
                        </tr>
                        <?php
                        foreach($data as $val){
                            foreach($val as $v) {
                                ?>
                                <tr>
                                    <td><center><?php echo $v->job_num; ?></center></td>
                                    <td><center><?php echo $v->ref; ?></center></td>
                                    <td><?php echo $v->client; ?></td>
                                    <?php echo $fMultiple ? '<td>' . $v->fCode . '</td>' : ''; ?>
                                    <td><?php echo $v->alias; ?></td>
                                    <td><?php echo $v->job_name; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        echo '</table><br />';
                    }
                    else if($type == 2){
                        echo '<table>';
                        echo '<tr><td colspan="4"><h2>Updated (' . count($data) . ')</h2></td></tr>';
                        ?>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <?php echo $fMultiple ? '<th>Franchise</th>' : ''; ?>
                            <th>Alias</th>
                            <th>Time</th>
                            <th>Changes</th>
                        </tr>
                        <?php
                        foreach($data as $val){
                            $ref = 0;
                            foreach($val as $v) {
                                if (count($v->changes) > 0) {
                                    foreach ($v->changes as $c) {
                                        if ($ref > 0) {
                                            ?>
                                            <tr>
                                                <td colspan="<?php echo $fMultiple ? '3' : '2'; ?>"></td>
                                                <td><?php echo $v->alias; ?></td>
                                                <td><?php echo $v->time; ?></td>
                                                <td><?php echo $c; ?></td>
                                            </tr>
                                        <?php
                                        } else {
                                            ?>
                                            <tr>
                                                <td>
                                                    <center><?php echo $v->job_num; ?></center>
                                                </td>
                                                <td><?php echo $v->job_name; ?></td>
                                                <?php echo $fMultiple ? '<td>' . $v->fCode . '</td>' : ''; ?>
                                                <td><?php echo $v->alias; ?></td>
                                                <td>
                                                    <center><?php echo $v->time; ?></center>
                                                </td>
                                                <td><?php echo $c; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        $ref++;
                                    }
                                } else {
                                    continue;
                                }
                            }
                        }
                        echo '</table>';


                    }
                }
            }
            ?>
        </td>
    </tr>
</table>