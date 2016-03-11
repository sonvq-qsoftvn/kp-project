			<?php
				$act_controller = $this->params->controller;
				$act_function = $this->params->action;
				
				$act1=$act2=$act3=$act4=$act5='';
				
				if($act_function == 'home'){$act1='active';}
				elseif($act_function == 'clintlist'){$act5='active'; $act1=''; $act2=''; $act3=''; $act4='';}
				elseif($act_function == 'appointments' || $act_function == 'book_appointment'){$act4='active'; $act1=''; $act2=''; $act3=''; $act5='';}
			?>
			
			<section class="mainheader-wrapp">
				<div class="container">
					<div class="navbar navbar-default navbar-fixed-top" role="navigation">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="<?php echo BASE_URL ?>"><img src="<?php echo BASE_URL;?>/frontend/images/logo.png" /></a>
						</div>
						
						<div class="navbar-collapse collapse">
							<ul class="nav navbar-nav navbar-right">
								<li class="<?php echo $act1; ?>"><a href="<?php echo BASE_URL ?>">Home</a></li>
								<li class="<?php echo $act2; ?>"><a href="#about">Find Doctor </a></li>
								<li class="<?php echo $act3; ?>"><a href="#contact">Find Dentist </a></li>
								<li class="<?php echo $act4; ?>"><?php echo $this->Html->link('Appointment', array('controller' => 'appointments', 'action' => 'appointments')); ?></li>
								<li class="<?php echo $act5; ?>"><?php echo $this->Html->link('Clinic', array('controller' => 'clinics', 'action' => 'clintlist')); ?></li>
							</ul>
						</div>
					</div>
				</div>
			</section>
			<div class="clearfix"></div>
		</header>
		<div class="clearfix"></div>