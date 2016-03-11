<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>clinicmanager/dashboard">Home</a> 

                    </li>
                    
                </ul>
            </div>

        </div>
<!----------------------ERROR MESSAGE---------------------------->
<?php if($msg=='noupdates' && $msg!='')
{
?>
<div class="alert alert-error">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading">NO Updates!</h4>
            Sorry no updated message present at this moment...!
</div>
<?php             
}
?>
<!----------------------END ERROR MESSAGE---------------------------->
<marquee direction='left' scrollamount='2' behavior='alternate'>Click on the column name to sort by that column</marquee>
<div class="row-fluid">

                <div class="span12">
                    <section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <?php
                            echo $this->Html->image('../admin/img/icons/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
                            ?>
                            <span>Latest Update</span>
                        </div>

                        <div class="utopia-widget-content">
                                    
 
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">Sl No.</th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('text','Message');?></th>
                                    <th style="width: 15%;"><?php echo $this->Paginator->sort('date_last_modified','Modified Date');?></th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    //picking the paginator parameters
                                    $paginator_params=($this->paginator->params());
                                    
                                    //starting point of serial no. for current page
                                    $sl_start=($paginator_params['page']*$paginator_params['current'])-($paginator_params['current']-1);
                                    
                                    //listing all the pages in tabular form
                                    if(!empty($no_update)){
                                   
                                    foreach($all_updates as $k=>$val)
                                    {  
                                    ?>
                                        <tr>
                                            <td><?php echo $sl_start+$k;?></td>
                                            <td>
                                                <?php 
                                                  if(mb_strlen($val['Update']['text'])>100){echo $sub=strip_tags(substr($val['Update']['text'] ,1,100),'<p></p>').".....<MORE>";}
                                                  else{echo strip_tags($val['Update']['text'], '<p></p>');}
                                                 ?> 
                                            </td>
                                            <td><?php echo $val['Update']['date_last_modified']; ?></td>
                                        </tr>
                                    <?php
                                    }
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
