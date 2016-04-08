<?php $this->load->view('head_view'); ?>

<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navigation-bar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Synergy Project</a>
        </div>
        <div class="navbar-collapse collapse navigation-bar">
            <?php
            if(count($_userData) > 0){
                foreach($_userData as $user){
                    $name = $user->FName . ' ' . $user->LName;
                    ?>
                    <div class="navbar-right">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div style="color: #ffffff;font-size: 12px;margin-top: 7px;">
                                        Logged in as, <span style="text-decoration: underline;color: #1e90ff"><?php echo $user->Alias;?></span>
                                        ( <strong style="color: #2ea1ff"><?php echo $user->accountName;?></strong> )
                                    </div>
                                    <a class="msg-btn" data-toggle="dropdown" aria-labelledby="dLabel" href="#" style="color:#ffffff;padding: 0;margin: -20px 0;">
                                        <?php echo $count_msg > 0 ? '<span class="badge">'.$count_msg.'</span>' : ''?>
                                        <i class="fa fa-envelope fa-fw"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="notificationArea" style="position: absolute;width: 480px;font-size: 12px;"></div>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div><br/><br/><br/>

<!-- Fixed navbar -->
<div class="container">
    <nav class="navbar navbar-default">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <!--MENU HEADER HERE-->
                <?php
                $exceptions = array('login');
                if(!in_array($this->uri->segment(1) , $exceptions)){
                    $this->load->view('pagecomponents/menu_view');
                }
                ?>
            </div><!--/.nav-collapse -->
    </nav>
</div>
<div class="container">
    <h3 style="padding: 0!important;margin: 0;">
        <?php
        $exceptions = array('login');
        if(!in_array($this->uri->segment(1), $exceptions)){
            $this->data['_pageTitle'] = $_pageTitle;
            $this->load->view('pagecomponents/pageTitles_view', $this->data);
        }
        ?>
    </h3>
    <hr style="padding: 3px!important;margin: 0;"/>
    <!-- Main component for a primary marketing message or call to action -->
    <div>
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
   <!-- <div id="custom-footer">
        &nbsp;
    </div>-->
<!--large modal-->
<div class="modal fade this-modal bs-example-modal-lg largeModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title my-title">Add Invoice Entry</h4>
            </div>
            <div class="page-loader lg-page-load"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--default modal-->
<div class="modal fade my-modal defaultModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title my-title">New Order</h4>
            </div>
            <div class="load-page df-page-load"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--small modal-->
<div class="modal fade bs-example-modal-sm sm-modal smallModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title sm-title">New Order</h4>
            </div>
            <div class="sm-load-page sm-page-load"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>

</html>