<script type="text/javascript">
function featuredWallpost(post_id,status)
{
			if(status==1)
			{
				status = 0;
			}
			else 
			{
				status = 1;
			}
			
	
		$.ajax({
            url: '<?php echo BASE_URL."doctors/featured"?>',
            type: 'POST',
            data: {post_id:post_id,status:status},			
            success: function(data){
					alert(data);
				window.location.reload();
                }
        });
		
}
</script>
<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Wallpost</a> 
                    </li>
                </ul>
            </div>
        </div>

<!-- Error Message section Starts-->

<?php
            
/*if($msg=='deletefailure')
{*/
?>
          <!--  <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        Sorry User Not Deleted !!!
            </div>-->
<?php             
/*}
else if($msg=='deletesuccess')
{*/
?>
         <!--   <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Doctor Successfully deleted!!!
            </div>-->
<?php            
//}

?>
            
<!-- Error Message section Ends-->
<marquee direction='left' scrollamount='2' behavior='alternate'>Click on the column name to sort by that column</marquee>
<div class="row-fluid">

                <div class="span12">
                    <section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <?php
                            echo $this->Html->image('../admin/img/icons/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
                            ?>
                            <span>Wallpost List</span>
                        </div>

                        <div class="utopia-widget-content">

                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">Sl No.</th>
                                    
                                    <th style="width: 25%;"><?php echo $this->Paginator->sort('name','Clinic');?></th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('username','User');?></th>
                                    <th style="width: 25%;"><?php echo $this->Paginator->sort('post_title','Wallpost');?></th>
                                    <th style="width: 20%;"><?php echo $this->Paginator->sort('post_create_time','Posteddate');?></th>
                                     <th style="width: 5%;">View Post</th>
                                    <th style="width: 5%;">Featured</th>
                                   
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    //picking the paginator parameters
                                    $paginator_params=($this->paginator->params());
                                    
                                    //starting point of serial no. for current page
                                    $sl_start=($paginator_params['page']*$paginator_params['limit'])-($paginator_params['limit']-1);
                                    
                                    //listing all the pages in tabular form
                                    foreach($all_wallposts as $k=>$individual)
                                    {
										/*---for featured home doctors----*/
										if($individual['Wallpost']['featured']==1)
											$enabled_status="checked='checked'";
										else
											$enabled_status="";
                                              //  pr($individual);
                                    ?>
                                        <tr>
                                            <td><?php echo $sl_start+$k;?></td>
                                            <td><?php echo ucwords($individual['Clinic']['name']);?></td>
                                            <td><?php echo ucwords($individual['User']['username']);?></td>
                                            <td><?php echo $individual['Wallpost']['post_title'];?></td>
                                            <td><?php echo $individual['Wallpost']['post_create_time'];?></td>
                           <td>
                           <a href="<?php echo BASE_URL;?>administrator/viewwallpost/<?php echo $individual['Wallpost']['id'];?>" class="edit">
                           <?php echo $this->Html->image('../admin/img/icons/gear.png',array('alt'=>'Settings','title'=>'Wallpost View'));?>
                           </a>
                           </td>
                                            
       <td><input type="checkbox" name="featured"  <?php echo $enabled_status?>  onclick="featuredWallpost(<?php echo $individual['Wallpost']['id'];?>,<?=$individual['Wallpost']['featured']?>)"/></td>
                                            
                                            <!--<td>
                                               
                                                </a>
                                                <a href="javascript:do_confirm('<!?php echo BASE_URL;?>administrator/deleteuser?userid=<!?php echo $individual['User']['id'];?>');" class="delete">
                                                            <!?php echo $this->Html->image('../admin/img/icons/trash_can.png',array('alt'=>'Delete','title'=>'Delete'));?>
                                                </a>
                                            </td>-->
                                
                                        </tr>
                                    <?php
                                    }
                                    
                                    ?>
                                </tbody>

                            </table>
                            <div class="row-fluid">
                                <div class="span6"><div class="dataTables_info" id="DataTables_Table_0_info"><?php echo $this->Paginator->counter(array(
    'format' => 'Page {:page} of {:pages}, showing {:current} records out of
             {:count} total'
));?></div></div>

                                <div class="span6">
                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                <ul>
                                                            <?php
                                                                
                                                                
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->prev(
                                                                  ' ←',
                                                                  $options=array('tag'=>'li','class'=>'prev','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'prev disabled')
                                                                );
                                                                
                                                                // Shows the page numbers
                                                                echo $this->Paginator->numbers($options=array('tag'=>'li','separator'=>'','currentTag'=>'a','currentClass'=>'active'));
                                                                
                                                                // Shows the next and previous links 
                                                                echo $this->Paginator->next(
                                                                  '→ ',
                                                                  $options=array('tag'=>'li','class'=>'next','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'next disabled')
                                                                );
                    
                                                            ?>
                                                </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
</div>
