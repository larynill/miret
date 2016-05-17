<link type="text/css" href="<?php echo base_url(); ?>plugins/js/ui/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
<link href="<?php echo base_url();?>plugins/css/addForm.css" rel="stylesheet"/>

<script src="<?php echo base_url() ?>plugins/js/ui/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/ui/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?php echo base_url();?>plugins/js/addForm.js" language="JavaScript"></script>
<script src='<?php echo base_url(); ?>plugins/js/number.js' language="JavaScript"></script>

<style>
    .ui-datepicker-trigger{
        width: 18px;
        margin: -2px 20px;
        position: absolute;
    }
    .statement-header,.statement-content{
        width: 85%;
        margin: 5px auto;
    }
    .statement-header > tbody > tr > td{
        padding: 5px;
    }
    .bold-text{
        font-weight: bold;
    }
    .title-text{
        background: #c4c4c4;
        padding: 5px 15px;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 18px;
    }
    .statement-content > thead > tr > th{
        background: #d0d0d0;
        padding: 5px;
        border: 2px solid #000000;
    }
    .statement-content > tbody > tr > td{
        border-left: 2px solid #000000;
        padding: 3px 15px;
        text-align: center;
        font-weight: bold;
    }
    .statement-content > tbody > tr > td:last-child{
        border-right: 2px solid #000000;
        background: #c6ffcf;
    }
    .statement-content > tbody > tr:last-child > td{
        border-bottom: 2px solid #000000;
    }
    .credits{
        color: #000000;
    }
    .credits:hover{
        text-decoration: underline;
    }
    .disable-btn{
        pointer-events:none;
        background: #808080!important;
    }
</style>
<?php
?>
<div class="content">
    <table class="statement-header">
        <tbody>
        <tr>
            <td>
                <div class="bold-text">
                    <?php
                    if(count($client_info)>0){
                        foreach($client_info as $cv){
                            echo '<span style="text-transform:uppercase;">'.$cv->CompanyName.'</span><br/><br/>';
                            echo $cv->PostalAdress.'<br/>';
                        }
                    }
                    ?>
                </div>
            </td>
            <td style="width: 28%">
                <img src="<?php echo base_url().'plugins/img/sample-logo.png';?>" width="250">
                <div class="bold-text">
                    <?php
                    if(count($invoice_info)>0){
                        foreach($invoice_info as $v){
                            echo '<span style="text-transform:uppercase;">'.$v->company_name.'</span><br/>';
                            echo $v->address.'<br/>';
                            echo '<span style="font-weight:normal;white-space:nowrap;">Email: </span>'.$v->email.'<br/>';
                        }
                    }
                    ?>
                </div>
                <div style="white-space: nowrap">
                    Date: <span class="date"><?php echo date('j F Y');?></span>
                    <input type="hidden" name="date" class="date-picker" value="<?php echo date('j F Y');?>">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;" colspan="2">
                <span class="title-text">Statement</span>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="statement-content">
        <thead>
        <tr>
            <th style="width: 15%;">Date</th>
            <th>Reference</th>
            <th style="width: 15%;">Debits</th>
            <th style="width: 15%;">Credits</th>
            <th style="width: 15%;">Balance</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(count($statement)>0){
            foreach($statement as $sv){
                ?>
                <tr>
                    <td>
                        <?php
                        echo $sv->date;
                        ?>
                    </td>
                    <td style="text-align: left;">
                        <?php
                        echo $sv->type;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $sv->debits;
                        ?>
                    </td>
                    <td>
                        <a href="#" class="credits" id="<?php echo $sv->id;?>">
                        <?php
                        echo $sv->credits;
                        ?>
                        </a>
                    </td>
                    <td>
                        <?php
                        echo $sv->balance;
                        ?>
                    </td>
                </tr>
            <?php
            }
        }
        $disable_class = count($statement) > 1 ? '' : 'disable-btn';
        $total_row = 30 - count($statement);
        for($i=0;$i<$total_row;$i++){
            echo '<tr>';
            echo '<td>&nbsp;</td>';
            echo '<td>&nbsp;</td>';
            echo '<td>&nbsp;</td>';
            echo '<td>&nbsp;</td>';
            echo '<td>&nbsp;</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
        <thead>
        <tr>
            <td colspan="5">
                <a href="#" class="m-btn green addPayment">Add Payment</a>
                <a href="<?php echo base_url().'creditNote?cID='.$_GET['cID'];?>" class="m-btn green">Add Credit Note</a>
                <a href="<?php echo base_url().'archiveStatement?cID='.$_GET['cID'];?>" class="m-btn green <?php echo $disable_class;?>">Archive</a>
                <a href="#" class="m-btn printPDF green <?php echo $disable_class;?>">Print PDF</a>
                <a href="<?php echo base_url().'invoices';?>" class="m-btn green">Back</a>
            </td>
        </tr>
        </thead>
    </table>
</div>

<script>
    $(function(e){
        var datepicker = $('.date-picker');
        var printPDF = $('.printPDF');
        var date = $('.date');
        var addPayment = $('.addPayment');
        var credits = $('.credits');
        datepicker.datepicker({
            showOn: "button",
            buttonImage:"plugins/img/calendar-add.png",
            buttonImageOnly:true,
            dateFormat: "d MM yy",
            onSelect: function(){
                date.html($(this).val());
            }
        });
        printPDF.click(function(e){
            window.open ("<?php echo base_url().'statement?cID='.$_GET['cID'].'&pageType=statementPDF&date='?>" + datepicker.val(),"_blank");
        });

        addPayment.click(function(e){
            $(this).newForm.addNewForm({
                title: 'Add Payment',
                url: '<?php echo base_url(). 'addPayment?cID='.$_GET['cID'];?>',
                toFind: '.payment'
            });
        });

        credits.click(function(e){
           $(this).newForm.addNewForm({
               title:'Edit Credits',
               url:'<?php echo base_url().'editCredits/'.$_GET['cID'].'/';?>' + this.id,
               toFind:'.edit-credits'
           });
        });
    });
</script>