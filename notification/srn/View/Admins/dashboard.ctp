<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li class='action disabled'>
                        <a href="#">Home</a> 
                    
                </ul>
            </div>
        </div>
<div class="row-fluid">

                    <!--Chart Icons -->
                    
                    <div class="span3">
                        <a class='elements' href="<?php echo BASE_URL.'administrator/';?>users" title="Users">
                            <div class="utopia-chart-legend">
                                <div class="utopia-chart-icon">
                                    <?php
                                    echo $this->HTML->image('../admin/img/icons2/user.png',array('alt'=>'total no. of registered users'));
                                    ?>
                                   
                                </div>
                                <div class="utopia-chart-heading"><?php echo $tnru;?></div>
                                <div class="utopia-chart-desc">Registered Users</div>
                            </div>
                        </a>
                    </div>
                    
                    
                    <div class="span3">
                        <a class='elements' href="<?php echo BASE_URL.'administrator/';?>clinicmanagers" title="Clinic Managers">
                            <div class="utopia-chart-legend">
                                <div class="utopia-chart-icon">
                                   <?php
                                    echo $this->HTML->image('../admin/img/icons2/administrator.png',array('alt'=>'total no. of registered clinic owners'));
                                    ?>
                                </div>
                                <div class="utopia-chart-heading"><?php echo $tnco;?></div>
                                <div class="utopia-chart-desc">Registered Clinic Owners</div>
                            </div>
                        </a>
                    </div>
                    

                    <div class="span3">
                        <a class='elements' href="<?php echo BASE_URL.'administrator/';?>clinics" title="Users">
                            <div class="utopia-chart-legend">
                                <div class="utopia-chart-icon">
                                <?php
                                    echo $this->HTML->image('../admin/img/icons2/door.png',array('alt'=>'total no. of clinics'));
                                ?>  
                                </div>
                                <div class="utopia-chart-heading"><?php $tnc=$tnac+$tndac;echo $tnc;?></div>
                                <div class="utopia-chart-desc">
                                Clinics
                                <span>
                                ( Active : <?php echo $tnac;?> ; &nbsp;Inactive : <?php echo $tndac;?> )
                                </span>
                                </div>
                                
                            </div>
                        </a>
                    </div>

                    <div class="span3">
                        <div class="utopia-chart-legend">
                            <div class="utopia-chart-icon">
                            <?php
                                echo $this->HTML->image('../admin/img/icons2/notepad.png',array('alt'=>'total no. of bookkings'));
                            ?>      
                            </div>
                            <div class="utopia-chart-heading">0</div>
                            <div class="utopia-chart-desc">Bookings</div>
                        </div>
                    </div>
                    <!--Chart Icons End -->
                </div>