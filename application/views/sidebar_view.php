<div class="grid_3">
                    <?php
                    $navTitles = array(
                        'idashboard' => 'Dashboard',
                        'clients' => 'Clients'
                    );
                    ?>


                    <div style="background-color: #e9e9e9; height: 500px">
                        <ul>
                            <?php
                            if(count($navTitles) > 0){
                                foreach($navTitles as $link => $title){
                                    if(is_array($title)){
                                        getSublink($link, $title, $this->uri->segment(1) ? $this->uri->segment(1) : '');
                                    }else{

                                        ?>
                                        <li  class="<?php echo $this->uri->segment(1) == $link ? 'selected' : ''?>">
                                            <a href="<?php echo $link ? base_url() . $link : "#"?>">
                                                <?php echo $title; ?>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>