<style>
    #custom-header{
        width: 100%;
        height: 30px;
        background-color: #484b4a;
        padding: 5px;
        border-bottom: 2px solid #ffffff;
		position: fixed;
		right: 0;
		left: 0;
		z-index: 400;
		margin-bottom: 0;
    }
    #header-content{
        width: 92%;
        margin: 0 auto;
    }

    #header-content a.images-right {
        float:right;
        margin-top: 12px;
        padding:4px;
        border:1px solid #bbb;
        background:#fff;
    }
    #header-content .accounts{
        float:right;
        width: 400px;
        color: #fff;
        font-size: 12px;
        line-height: 23px;
        text-align: right;
        margin-top: 4px;
        margin-right: 20px;
    }

    #header-content .accounts a{
        color: #fff;
    }
    #custom-footer{
        width: 100%;
        height: 75px;
        background-color: #428EB4;
        margin: 0;
        padding: 0;
    }
</style>

<?php $this->load->view('head_view'); ?>

<body>
    <div id="custom-header">
        <div id="header-content">
            <div id="">
                <div class="accounts" style="font-size: 13px;">

                    <?php
                    if(count($_userData) > 0){
                        foreach($_userData as $user){
							$name = $user->FName . ' ' . $user->LName;
                            ?>
                              Logged in as, <span style="text-decoration: underline;color: #1e90ff"><?php echo $name;?></span>
							  ( <strong style="color: #ff0000"><?php echo $user->accountName;?></strong> )
							  | <a href="<?php echo base_url() . 'logout';?>">Logout</a><br/>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<div id="main-div">
    <div class="container_16">
            <div class="grid_16">

                <div class="grid_2">&nbsp;</div>
                <div class="grid_14" style="margin-top: 45px">
                    <!--MENU HEADER HERE-->
                    <?php
                    $exceptions = array('login');
                    if(!in_array($this->uri->segment(1) , $exceptions)){
                        $this->load->view('pagecomponents/menu_view');
                    }
                    ?>

                    <!--PAGE TITLES HERE-->
                    <?php
                    $exceptions = array('diary', 'login');
                    if(!in_array($this->uri->segment(1), $exceptions)){
                        $this->data['_pageTitle'] = $_pageTitle;
                        $this->load->view('pagecomponents/pageTitles_view', $this->data);
                    }
                    ?>

                    <?php
                    if(isset($_pageLoad)){
                        if(is_array($_pageLoad)){
                            foreach($_pageLoad as $page){
                                $this->load->view($page);
                            }
                        }
                        else{
                            $this->load->view($_pageLoad);
                        }
                    }?>
                </div>
            </div>
        </div>

    </div>

    <div class="container_16">

        <!--MENU HEADER HERE-->
        <?php
        /*$exceptions = array('login');
        if(!in_array($this->uri->segment(1) , $exceptions)){
            $this->load->view('pagecomponents/menu_view');
        }*/
        ?>

        <!--PAGE TITLES HERE-->
        <?php
        //used menu titles except for the exceptions
        /*$exceptions = array('diary', 'login');
        if(!in_array($this->uri->segment(1), $exceptions)){
            $this->data['_pageTitle'] = $_pageTitle;
            $this->load->view('pagecomponents/pageTitles_view', $this->data);
        }*/
        ?>

        <?php
        /*if(isset($_pageLoad)){
            if(is_array($_pageLoad)){
                foreach($_pageLoad as $page){
                    $this->load->view($page);
                }
            }
            else{
                $this->load->view($_pageLoad);
            }
        }*/
        ?>

        <div class="grid_2">
            &nbsp;
        </div>


        <div class="clear"></div>
    </div>

</div>




   <!-- <div id="custom-footer">
        &nbsp;
    </div>-->
</body>

</html>