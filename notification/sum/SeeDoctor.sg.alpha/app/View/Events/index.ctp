<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Approved Clinics</a> 
                    </li>
                </ul>
            </div>
        </div>

<!-- Error Message section Starts-->

<?php
if($msg=='editinvalid')
{

?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Invalid Clinic Id</h4>
                        Sorry Operation not completed !!!
            </div>
<?php
}
else if($msg=='editnoclinic')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">No Clinic With Supplied Id</h4>
                        Sorry Operation not completed !!!
            </div>
<?php            
}
else if($msg=='editfailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Internal Error Occured</h4>
                        Sorry Clinic Not Updated !!!
            </div>
<?php            
}
else if($msg=='editsuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Successfully updated!!!
            </div>
<?php            
}
else if($msg=='disapprovefailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        Sorry Clinic Not Disapproved !!! Please try again....
            </div>
<?php             
}
else if($msg=='approvesuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Successfully approveded!!! A mail has been snt to the clinic owner informing him/her that his/her clinic is now approved.
            </div>
<?php            
}
else if($msg=='deletefailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        Sorry Clinic Not Deleted !!!
            </div>
<?php             
}
else if($msg=='deletesuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Successfully deleted!!!
            </div>
<?php            
}
else if($msg=='addfailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        Sorry Clinic Not Added !!!
            </div>
<?php             
}
else if($msg=='addsuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Successfully Created And Approved!!!<br/>An email has been sent to the clinic manager informing him/her about the clinic creation.Please setup the followings to complete the proper clinic creation:<ul><li>Setup the opening hours and time slots</li><li>Complete/edit the clinic settings.</li></ul>
            </div>
<?php            
}
?>
<!-- Error Message section Ends-->
<marquee direction='left' scrollamount='2' behavior='alternate'>Click on the column name to sort by that column</marquee>
<marquee direction='left' scrollamount='2' behavior='alternate'>Click on the clinic name to view the appointments</marquee>

<div class="row-fluid">

                <div class="span12">
                    <section class="utopia-widget">
                        <div class="utopia-widget-title">   
                            <?php
                            echo $this->Html->image('../admin/img/icons/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
                            ?>
                            <span>Approved Clinic List</span>
                        </div>

                        <div class="utopia-widget-content">
                                    <div style="width: 100%;margin-right:9%;margin-bottom:1%;text-align:right;">
                                                <a href='<?php echo BASE_URL;?>administrator/addevent'>
                                                            <?php
                                                                        echo $this->Html->image('../admin/img/icons/add.png',array('alt'=>'add','title'=>'add'));
                                                            ?>
                                                            &nbsp;&nbsp;Add Event
                                               </a>
                                    </div>
 
                            <table class="table table-striped table-bordered" style='width:100%;'>
                                <thead>
                                <tr>
                                    <th style="width: 5%;">Sl No.</th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('event_name','Event Name');?></th>
                                    <th style="width: 15%;"><?php echo $this->Paginator->sort('event_time','Event Date');?></th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('organizer_name','Organizer');?></th>
                                    <!--<th style="width: 10%;"><?php //echo $this->Paginator->sort('status','Status');?></th>-->
                                    
                                    <!--<th style="width: 5%;">Exceptions</th>  
                                    <th style="width: 5%;">Opening Hours</th> -->                                  
                                    <th style="width: 5%;">Participants</th>                                   
                                    <th style="width: 5%;">Satus</th>
                                    <th style="width: 5%;">Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    //picking the paginator parameters
                                    $paginator_params=($this->paginator->params());
                                    
                                    //starting point of serial no. for current page
                                    $sl_start=($paginator_params['page']*$paginator_params['current'])-($paginator_params['current']-1);
                                    
                                    //listing all the pages in tabular form
                                    foreach($all_events as $k=>$individual)
                                    {
                                    ?>
                                        <tr>
                                            <td><?php echo $sl_start+$k;?></td>
                                            <td><?php echo $individual['Event']['event_name'];?></td>
                                            <td><?php echo date("d-m-Y",strtotime($individual['Event']['event_time']));?></td>
                                            <td><?php echo $individual['Event']['organizer_name'];?></td>
                                            <td><a href="#"><?php echo count($all_participant);?></a></td>
                                            <td><?php echo $individual['Event']['status'];?></td>
                                            
                                            
                                             <td>
                                                <a href="<?php echo BASE_URL;?>administrator/edituser?userid=<?php echo $individual['Event']['id'];?>" class="edit">
                                                            <?php echo $this->Html->image('../admin/img/icons/pencil.png',array('alt'=>'Edit','title'=>'Edit'));?>
                                                </a>
                                                <a href="javascript:do_confirm('<?php echo BASE_URL;?>administrator/deleteuser?userid=<?php echo $individual['Event']['id'];?>');" class="delete">
                                                            <?php echo $this->Html->image('../admin/img/icons/trash_can.png',array('alt'=>'Delete','title'=>'Delete'));?>
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
