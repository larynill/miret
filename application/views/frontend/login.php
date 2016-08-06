
<div class="v-bg-stylish">
<div class="container">
    <div class="row center">
        <div class="col-sm-6 col-sm-offset-3">

            <div class="v-spacer col-sm-12 v-height-small"></div>
            <div class="form-horizontal" style="border: 1px solid #dadada">
                <form action="<?php echo base_url() . 'logging'?>" method="post">
                    <div class="row">
                        <div class="form-group">
                            <label for="name" class="col-sm-offset-3 col-sm-2">Username <span class="required">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" value="" maxlength="100" class="form-control" name="login" id="name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="name" class="col-sm-offset-3 col-sm-2">Password <span class="required">*</span></label>
                            <div class="col-sm-5">
                                <input type="password" value="" maxlength="100" class="form-control" name="pass" id="name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button name="submit" type="submit" id="sendmesage" class="btn v-btn no-three-d" style="margin-left: 15px;">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="v-spacer col-sm-12 v-height-small"></div>
    </div>

</div>
</div>