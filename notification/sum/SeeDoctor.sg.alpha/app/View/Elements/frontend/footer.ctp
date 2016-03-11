          <footer>
               <div class="mainfooter-wrapp">
                    <div class="container">
                         <div class="row">
                              <div class="col-md-3 col-sm-6">
                                   <div class="fo-brandlo">
                                        <a href="<?php echo BASE_URL; ?>"><?php echo $this->Html->image('../frontend/images/logo-foo.png',array('alt'=>'')); ?></a>
                                   </div>
                                   <div class="footer-contentbox">
                                        <h6> SeeDoctor is a medical social platform designed by doctors to bring patients and healthcare professionals closer together.</h6>
                                        <div class="copyright-wrap">&copy; SeeDoctor.sg <?php echo date('Y'); ?> by MEDNET</div>
                                   </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                   <div class="footer-contentbox">
                                        <h2>Terms of Service </h2>
                                             <div class="fo-contentlist">
                                             <ul>
                                                  <li><?php echo $this->Html->link('Medical Disclaimer', array('controller' => 'contents', 'action' => 'showcontent', 'alias' => 'medical-disclaimer')); ?></li>
                                                  <li><?php echo $this->Html->link('Terms & Privacy', array('controller' => 'contents', 'action' => 'showcontent', 'alias' => 'terms-of-use')); ?></li>
                                                  <li><?php echo $this->Html->link('Clinics', array('controller' => 'clinics', 'action' => 'clintlist')); ?></li>
                                             </ul>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                   <div class="footer-contentbox">
                                        <h2>Explore </h2>
                                        <div class="ex-left">
                                             <div class="fo-contentlist">
                                                  <ul>
                                                       <li><?php echo $this->Html->link('Find Doctor', array('controller' => 'users', 'action' => 'home', 'home')); ?></a></li>
                                                       <li><?php echo $this->Html->link('Find Dentist', array('controller' => 'users', 'action' => 'home', 'home')); ?></a></li>
                                                       
                                                       <li><a href="javascript:void(0)">Appointment</a></li>
                                                       <li><?php echo $this->Html->link('Clinics', array('controller' => 'clinics', 'action' => 'clintlist')); ?></li>
                                                  </ul>
                                             </div>
                                        </div>
                                        <!--<div class="ex-right">
                                             <div class="fo-contentlist">
                                                  <ul>
                                                       <li><a href="javascript:void(0)">Notificiations</a></li>
                                                       <li><a href="javascript:void(0)">Inbox</a></li>
                                                       <li><a href="javascript:void(0)">Profile</a></li>
                                                       <li><?php //echo ($this->Session->read('reid_user_logged'))?$this->Html->link('Settings', array('controller' => 'users', 'action' => 'userprofile')):'<a href="javascript:void(0)">Settings</a>'; ?></li>
                                                  </ul>
                                             </div>
                                        </div>-->
                                        <div class="clearfix"></div>
                                   </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                   <div class="footer-contentbox">
                                        <h2>Contact Us </h2>
                                        <div class="fo-contentlist">
                                             <ul>
                                                 <!-- <li><a href="javascript:void(0)">Partnership</a></li>-->
                                                  <li><?php echo $this->Html->link('Partnership', array('controller' => 'contents', 'action' => 'showcontent', 'alias' => 'partnership')); ?></li>
                                                  <li><?php echo $this->Html->link('Advertisement', array('controller' => 'contents', 'action' => 'showcontent','alias' => 'advertisement')); ?></li>
                                                  <li>
                                                       <a href="mailto:help@seedoctor.sg">
                                                            <span class="email"><?php echo $this->Html->image('../frontend/images/email_i.png',array('alt'=>'')); ?></span>
                                                            help@seedoctor.sg
                                                       </a>
                                                  </li>
                                                  <li><a class="phno" href="javascript:void(0)">+65 81112233</a></li>
                                             </ul>
                                        </div>
                                   </div>
                              </div>
                              <div class="clearfix"></div>
                         </div>
                    </div>
               </div>
               <div class="clearfix"></div>
          </footer>
          <div class="scrolltop"></div>
     </body>
</html>

