<!-- Sidebar statrt -->
        <div class="span2 sidebar-container">

            <div class="sidebar">

                <div class="navbar sidebar-toggle">
                    <div class="container">

                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>

                    </div>
                </div>

                <div class="nav-collapse collapse leftmenu">

                    <ul>
                        <li id='dashboard' ><a class="dashboard smronju" href="<?php echo BASE_URL.'administrator/';?>dashboard" title="Dashboard"><span>Dashboard</span></a></li>
                        <li id='cmsforpages'><a class="editor" href="<?php echo BASE_URL.'administrator/';?>cmsforpages" title="CMS FOR FRONTEND PAGES"><span>Cms Pages</span></a>
                        </li>
                        <li id='masters'><a class="grid" href="javascript:void(0)" title="Masters"><span>Masters</span></a>
                            <ul class="dropdown">
                                <li><a class="simple smronju" href="<?php echo BASE_URL.'administrator/';?>specialitymaster" title="Specialities"><span>Speciality Master</span></a></li>
  <li><a class="simple smronju" href="<?php echo BASE_URL.'administrator/';?>insurancemaster" title="Insurances"><span>Insurance Master</span></a></li>

<li><a class="simple smronju" href="<?php echo BASE_URL.'administrator/';?>eligibilitymaster" title="Eligibility"><span>Eligibility Master</span></a></li>

                                
                            </ul>
                        </li>
                        <li id='clinics'><a class="grid" href="<?php echo BASE_URL.'administrator/';?>clinics" title="Clinica"><span>Clinics</span></a>
                            <ul class="dropdown">
                                <li><a class="simple smronju" href="<?php echo BASE_URL.'administrator/';?>clinics" title="Approved Clinics"><span>Approved</span></a></li>
                                <li><a class="simple smronju" href="<?php echo BASE_URL.'administrator/';?>disapprovedclinics" title="Disapproved/pending Clinics"><span>Disapproved / Pending</span></a></li>

                                
                            </ul>
                        </li>
                        
                        <li id='clinicmanagers'><a class="elements" href="<?php echo BASE_URL.'administrator/';?>clinicmanagers" title="Clinic Managers"><span>Clinic Managers</span></a></li>
                        <li id='users'><a class="elements" href="<?php echo BASE_URL.'administrator/';?>users" title="Users"><span>Users</span></a></li>
                        <li id='updates'><a class="charts" href="<?php echo BASE_URL.'administrator/';?>updatesfromtheheart" title="Updates From The Heart"><span>Updates From The Heart</span></a></li>
                        <li id='inbox'><a class="chat" href="<?php echo BASE_URL.'administrator/';?>inbox" title="Messages"><span>Inbox</span></a></li>
                        <li id='compose'><a class="editor" href="<?php echo BASE_URL.'administrator/composemessage';?>" title="Messages"><span>Compose</span></a></li>
                        <li id='outbox'><a class="tables" href="<?php echo BASE_URL.'administrator/';?>outbox" title="Messages"><span>Outbox</span></a></li>
                        <li id='draft'><a class="list" href="<?php echo BASE_URL.'administrator/';?>draft" title="Messages"><span>Draft</span></a></li>
                        <li id='trash'><a class="error" href="<?php echo BASE_URL.'administrator/';?>trash" title="Messages"><span>Trash</span></a></li>
                    </ul>

                </div>

            </div>
        </div>

        <!-- Sidebar end -->