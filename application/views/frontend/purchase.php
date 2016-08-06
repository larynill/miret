<!--Purchase-->
<div class="container" id="purchase">

    <div class="row center">

        <div class="col-sm-12">
            <p class="v-smash-text-large-2x">
                <span>Purchase</span>
            </p>
            <div class="horizontal-break"></div>
        </div>
        <?php
        if(count($this->cart->contents()) > 0){
            ?>
            <table class="table table-bordered table-hovered">
                <thead>
                <tr>
                    <th class="text-center">QTY</th>
                    <th class="text-center">Item Description</th>
                    <th class="text-center">Item Price</th>
                    <th class="text-center">Sub-Total</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <?php $i = 1; ?>

                <?php foreach ($this->cart->contents() as $items): ?>

                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>

                    <tr class="column-<?php echo $items['rowid'];?>">
                        <td><?php echo $items['qty'];?></td>
                        <td>
                            <?php echo str_replace('.',',',$items['name']); ?>

                            <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

                                <p>
                                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

                                        <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

                                    <?php endforeach; ?>
                                </p>

                            <?php endif; ?>

                        </td>
                        <td style="text-align:right">&nbsp;</td>
                        <td style="text-align:right">&nbsp;</td>
                        <td style="text-align:center"><a href="#" class="remove-item" id="<?php echo $items['rowid'];?>"><i class="glyphicon glyphicon-remove"></i></a></td>
                    </tr>

                    <?php $i++; ?>

                <?php endforeach; ?>

                <tr class="danger">
                    <td colspan="2"> </td>
                    <td class="text-right"><strong>Total</strong></td>
                    <td class="text-right">&nbsp;</td>
                    <td class="text-right">&nbsp;</td>
                </tr>
            </table>
            <a href="#" class="btn btn-primary pull-right">Purchase</a>
        <?php
        }
        else{
            ?>
            <div class="v-spacer col-sm-12 v-height-standard"></div>
            <h4 class="no-result-found">No item added to cart.</h4>
        <?php
        }
        ?>

    </div>
</div>
<!--End Purchase-->