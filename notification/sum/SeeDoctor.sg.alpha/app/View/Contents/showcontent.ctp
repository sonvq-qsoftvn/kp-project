
     <section class="emai-registration">
		<!--<div class="topheading-box"><div class="container"><h2>Article</h2></div></div>-->
		<div class="container">
			<div class="inner-gapbox-1">
				<div class="heading-box">
					<div class="regi-heading">
						<span class="email2"><?php echo $this->Html->image('../frontend/images/email_ib.png',array('alt'=>'')); ?></span>
						<?php echo (isset($content_details['title']))?$content_details['title']:'Article'; ?>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="rgeistration-wrapp">
					<div class="user-head">
						<?php echo (isset($content_details['content']))?str_replace('\n', '<br>', $content_details['content']):'Sorry article content  not found.'; ?>
					</div>
                    </div>
               </div>
          </div>
     </section>