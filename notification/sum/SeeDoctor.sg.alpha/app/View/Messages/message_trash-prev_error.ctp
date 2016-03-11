<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Trash</a> 
                    </li>
                </ul>
            </div>
        </div>


<marquee direction='left' scrollamount='2' behavior='alternate'>Click on the column name to sort by that column.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Click on the subject to view the message.</marquee>
<div class="row-fluid">

                <div class="span12">
                    <section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <?php
                            echo $this->Html->image('../admin/img/icons/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
                            ?>
                            <span>Trash</span>
                        </div>

                        <div class="utopia-widget-content">
                                    
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">Sl No.</th>
                                    <th style="width: 15%;"><?php echo $this->Paginator->sort('touname','To');?></th>
                                    <th style="width: 15%;"><?php echo $this->Paginator->sort('totype','User Type');?></th>
                                    
                                    <th style="width: 35%;"><?php echo $this->Paginator->sort('subject','Subject');?></th>
                                    <th style="width: 15%;"><?php echo $this->Paginator->sort('datesent','Date & Time');?></th>
                                   
                                    <th style="width: 10%;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    //picking the paginator parameters
                                    $paginator_params=($this->paginator->params());
                                    
                                    //starting point of serial no. for current page
                                    $sl_start=($paginator_params['page']*$paginator_params['current'])-($paginator_params['current']-1);
                                    
                                    //listing all the pages in tabular form
                                    foreach($all_trash as $k=>$individual)
                                    {
                                    ?>
                                        <tr>
                                            <td><?php echo $sl_start+$k;?></td>
                                            <td><?php echo $individual['Message']['touname'];?></td>
                                            <td><?php echo $individual['Message']['totype'];?></td>
                                            <td><?php echo $individual['Messagecontent']['subject'];?></td>
                                            <td><?php echo $individual['Messagecontent']['datesent'];?></td>
                                            
                                            <td>
                                                <!----------------------------------------NOT DELETED RESTORE LINK -------------------------------------------------------------->
                                                <a href="javascript:do_trash('<?php echo BASE_URL;?>administrator/restoretrashmsg?messageid=<?php echo $individual['Message']['id'];?>');" class="restore">
                                                <!---------------------------------------------------- END ------------------------------------------------------->
                                                            <?php echo $this->Html->image('../admin/img/icons/clock.png',array('alt'=>'Restore','title'=>'Restore'));?>
                                                </a>
                                            </td>
                                
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
