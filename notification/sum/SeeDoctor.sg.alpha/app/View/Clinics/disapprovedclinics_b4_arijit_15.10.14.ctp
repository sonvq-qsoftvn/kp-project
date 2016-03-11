<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Disapproved Clinics</a> 
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
                        Sorry Clinic Manager Not Updated !!!
            </div>
<?php
}
else if($msg=='editnoclinic')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">No Clinic With Supplied Id</h4>
                        Sorry Clinic Not Updated !!!
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
else if($msg=='disapprovesuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Successfully disapproveded!!! A mail has been snt to the clinic owner informing him/her that his/her clinic is now disapproved.
            </div>
<?php            
}
else if($msg=='approvefailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        Sorry Clinic Not Approved !!! Please try again....
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
                        Clinic Successfully Added!!!<br/>An email has been sent to the clinic manager informing him/her about the clinic creation.
            </div>
<?php            
}
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
                            <span>Disapproved Clinic List</span>
                        </div>

                        <div class="utopia-widget-content">
                                    
 
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">Sl No.</th>
                                    
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('name','Name');?></th>
                                    <th style="width: 20%;"><?php echo $this->Paginator->sort('address','Address');?></th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('license','License');?></th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('handphone','Handphone');?></th>
                                    <th style="width: 20%;"><?php echo $this->Paginator->sort('url','Url');?></th>
                                    <th style="width: 5%;"><?php echo $this->Paginator->sort('Cm.clinicmanagers_username','Clinic Manager');?></th>
                                    <th style="width: 5%;"><?php echo $this->Paginator->sort('likes','Likes');?></th>
                                    
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
                                    foreach($all_clinics as $k=>$individual)
                                    {
                                    ?>
                                        <tr>
                                            <td><?php echo $sl_start+$k;?></td>
                                            <td><?php echo $individual['Clinic']['name'];?></td>
                                            <td><?php echo $individual['Clinic']['address'];?></td>
                                            <td><?php echo $individual['Clinic']['license'];?></td>
                                            <td><?php echo $individual['Clinic']['handphone'];?></td>
                                            <td><?php echo $individual['Clinic']['url'];?></td>
                                            <td><?php echo $individual['Cm']['clinicmanagers_username'];?></td>
                                           <td><?php echo $individual['Clinic']['likes'];?></td>
                                           
                                            
                                            <td>
                                                <a href="javascript:do_confirm('<?php echo BASE_URL;?>administrator/deleteclinic?clinicid=<?php echo $individual['Clinic']['id'];?>');" class="delete">
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
