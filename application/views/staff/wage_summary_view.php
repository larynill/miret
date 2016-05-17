<?php
echo form_open('');
?>
<div class="row">
    <div class="form-group">
        <div class="col-sm-2">
            <?php
            $thisMonth = date('m');
            echo form_dropdown('month',$month,$thisMonth,'class="form-control input-sm"');
            ?>
        </div>
        <div class="col-sm-2">
            <?php
            echo form_dropdown('year',$year,'','class="form-control input-sm"');
            ?>
        </div>
        <div class="col-sm-1">
            <button type="submit" name="submit" class="btn btn-sm btn-primary submit-btn">Go</button>
        </div>
    </div>
</div><br/>
<div class="row">
    <div class="col-sm-6">
        <label class="control-label text-uppercase">Monthly Pay Sheet</label>
        <table class="table table-colored-header">
            <?php
            if(count($empArr)>0){
                foreach($empArr as $k=>$v){
                    $totalGross = 0;
                    $totalKS = 0;
                    $totalNett = 0;
                    $totalPaye = 0;
                    ?>
                    <tr>
                        <td style="border: none">
                            <table class="table table-colored-header">
                                <thead>
                                <tr style="background: #dcb42c;">
                                    <td colspan="2" style="text-align: left;border: none;">
                                        Name: <strong><?php echo $v->FName.' '.$v->LName;?></strong>
                                    </td>
                                    <td colspan="2" style="text-align: left;border: none;">
                                        IRD No: <strong><?php echo $v->IRD;?></strong>
                                    </td>
                                    <td colspan="2" style="text-align: left;border: none;">Tax Code: <strong><?php echo $v->tax_code?></strong></td>
                                    <td style="text-align: left;border: none;">
                                        KS %: <strong><?php echo $v->kiwi;?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Month</th>
                                    <th style="width: 15%;">Gross</th>
                                    <th style="width: 15%;">PAYE</th>
                                    <th style="width: 10%;">KS</th>
                                    <th style="width: 13%;">KS Emp.</th>
                                    <th style="width: 10%;">ST Loan</th>
                                    <th style="width: 15%;">NETT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($dateArr)>0){
                                    foreach($dateArr as $sunday){
                                        $totalGross += $v->Gross;
                                        $totalKS += $v->KS;
                                        $totalNett += ($v->Gross - ($v->Paye + $v->KS));
                                        $totalPaye += $v->Paye;
                                        ?>
                                        <tr>
                                            <td><?php echo $sunday->format("M - d");?></td>
                                            <td><?php echo '$ ' . number_format($v->Gross,2,'.',' ');?></td>
                                            <td><?php echo '$ ' . number_format($v->Paye,2,'.',' ');?></td>
                                            <td><?php echo '$ ' . number_format($v->KS,2,'.',' ');?></td>
                                            <td>$ 0.00</td>
                                            <td>$ 0.00</td>
                                            <td><?php echo '$ ' . number_format(($v->Gross - ($v->Paye + $v->KS)),2,'.',' ');?></td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <td>
                                        <a href="#">add extra</a>
                                    </td>
                                    <td colspan="6"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php echo '$ ' . number_format($totalGross,2,'.',' ');?></td>
                                    <td><?php echo '$ ' . number_format($totalPaye,2,'.',' ');?></td>
                                    <td><?php echo '$ ' . number_format($totalKS,2,'.',' ');?></td>
                                    <td>$ 0.00</td>
                                    <td>$ 0.00</td>
                                    <td><?php echo '$ ' . number_format($totalNett,2,'.',' ');?></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php
                }
            }
            ?>
        </table>
    </div>
    <div class="col-sm-6">
        <label class="control-label text-uppercase">Summary</label>
        <table class="table table-colored-header">
            <thead>
            <tr>
                <th>Date</th>
                <th>Gross</th>
                <th>KIWI SAVER</th>
                <th>PAYE</th>
                <th>ST Loan</th>
                <th>Nett</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $gross = 0;
            $ks = 0;
            $paye = 0;
            $nett = 0;
            $weeks = 0;
            if(count($dateArr)>0){
                foreach($dateArr as $sunday){
                    $weeks += count($dateArr);
                    $gross += $totalGrossValue;
                    $ks += $totalKSValue;
                    $paye += $totalPayeValue;
                    $nett += ($totalGrossValue - ($totalKSValue + $totalPayeValue));
                    ?>
                    <tr>
                        <td><?php echo $sunday->format("M - d");?></td>
                        <td><?php echo '$ ' . number_format($totalGrossValue,2,'.',' ');?></td>
                        <td><?php echo '$ ' . number_format($totalKSValue,2,'.',' ');?></td>
                        <td><?php echo '$ ' . number_format($totalPayeValue,2,'.',' ');?></td>
                        <td>$ 0.00</td>
                        <td><?php echo '$ ' . number_format(($totalGrossValue - ($totalKSValue + $totalPayeValue)),2,'.',' ');?></td>
                    </tr>
                <?php
                }
            }
            ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr class="last-child">
                <td></td>
                <td><?php echo '$ ' . number_format($gross,2,'.',' ');?></td>
                <td><?php echo '$ ' . number_format($ks,2,'.',' ');?></td>
                <td><?php echo '$ ' . number_format($paye,2,'.',' ');?></td>
                <td>$ 0.00</td>
                <td><?php echo '$ ' . number_format($nett,2,'.',' ');?></td>
            </tr>
            </tbody>
            <tr>
                <td colspan="6" style="border: none;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" style="border: none;">
                    <table class="table table-colored-header">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Gross</th>
                            <th>PAYE</th>
                            <th>ST Loan</th>
                            <th>KIWI SAVER</th>
                        </tr>
                        </thead>
                        <?php
                        $overallGross = 0;
                        $overallPaye = 0;
                        $overallKS = 0;
                        if(count($empArr)>0){
                            foreach($empArr as $ek=>$ev){
                                $overallGross += ($ev->Gross * $weeks);
                                $overallPaye += ($ev->Paye * $weeks);
                                $overallKS += ($ev->KS * $weeks);
                                $StBack = !$ev->STLoan ? 'style="background: #AEAEAE"' : '';
                                $ksBack = !$ev->KiwiSave && ! $ev->KiwiPercent ? 'style="background: #AEAEAE"' : '';
                                $ksVal = !$ev->KiwiSave && ! $ev->KiwiPercent ? '' : '$ ' . number_format(($ev->KS * $weeks),2,'.',' ');
                                ?>
                                <tr>
                                    <td style="text-align: left;"><?php echo $ev->FName.' '.$ev->LName;?></td>
                                    <td><?php echo '$ ' . number_format(($ev->Gross * $weeks),2,'.',' ');?></td>
                                    <td><?php echo '$ ' . number_format(($ev->Paye * $weeks),2,'.',' ');?></td>
                                    <td <?php echo $StBack;?>><?php echo $ev->STLoan ? '$ 0.00':''?></td>
                                    <td <?php echo $ksBack;?>><?php echo $ksVal;?></td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        <tr>
                            <td style="background: none;"></td>
                            <td><?php echo '$ ' . number_format($overallGross,2,'.',' ');?></td>
                            <td><?php echo '$ ' . number_format($overallPaye,2,'.',' ');?></td>
                            <td>$ 0.00</td>
                            <td><?php echo '$ ' . number_format($overallKS,2,'.',' ');?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php
echo form_close();
?>