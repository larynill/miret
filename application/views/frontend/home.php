<!--Home-->
<div class="container" id="home">

    <div class="row center">
        <p class="v-smash-text-large-2x">
            <span>ScopePro Property Inspection</span>
        </p>
        <div class="horizontal-break"></div>
        <div class="col-sm-12">
            <div class="v-wrapper">
                <p>Do you need a report prepared for your property?</p>
                <a href="<?php echo base_url().'?p=request';?>" class="btn btn-sm btn-warning">Request a Property Inspection</a><br/>
                <strong style="font-style: italic">It won't cost you a thing!</strong>
            </div>
            <div class="v-wrapper-right">
                <p>Do we have the Property Report you are after?</p>
                <a href="<?php echo base_url().'?p=search';?>" class="btn btn-sm btn-info">Search for a Property Report</a><br/><br/>
            </div>
            <img src="<?php echo base_url('img/home-inspection.png');?>">
        </div>
        <div class="v-spacer col-sm-12 v-height-standard"></div>
    </div>
</div>
<!--End Home-->
<style>
    .v-wrapper{
        position: absolute;
        border: 1px solid #000000;
        padding: 5px;
        background: #76d07c;
    }
    .v-wrapper-right{
        float:right;
        position: absolute;
        margin-left: 750px;
        padding: 5px;
        border: 1px solid #000000;
        background: #76d07c;
    }
</style>