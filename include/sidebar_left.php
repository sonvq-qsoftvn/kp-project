<div class="leftcol_link">
                  <div class="heading2">Contact us for more information</div>
                    <ul>
					<?php
							//list all ticket solution
							$obj->ticket_solution_list();
							while($obj->next_record()){
						?>
                      <li><a href="<?php echo $obj_base_path->base_path(); ?>/solutions/<?php echo $obj->f('slug'); ?>"><?php echo $obj->f('name'); ?></a></li>
					  <?php }?>
                      <!--<li><a href="#">FESTIVALS & TOURS</a></li>
                      <li><a href="#">NIGHTLIFE & CLUBS</a></li>
                      <li><a href="#">SPORTS</a></li>
                      <li><a href="#">FUNDRAISERS</a></li>
                      <li><a href="#">MUSEUMS & EXHIBITIONS</a></li>
                      <li><a href="#">HOLIDAYS & NEW YEARS EVE</a></li>   -->                  
                    </ul>
                </div>