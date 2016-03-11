<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Clinic Managers</a> 
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
                        <h4 class="alert-heading">Invalid Clinic Manager Id</h4>
                        Sorry Clinic Manager Not Updated !!!
            </div>
<?php
}
else if($msg=='editnoclinicmanager')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">No Clinic Manager With Supplied Id</h4>
                        Sorry Clinic Manager Not Updated !!!
            </div>
<?php            
}
else if($msg=='editfailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Internal Error Occured</h4>
                        Sorry Clinic Manager Not Updated !!!
            </div>
<?php            
}
else if($msg=='editsuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Manager Successfully updated!!!
            </div>
<?php            
}
else if($msg=='deletefailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        Sorry Clinic Manager Not Deleted !!!
            </div>
<?php             
}
else if($msg=='deletesuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Manager Successfully deleted!!!
            </div>
<?php            
}
else if($msg=='addfailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        Sorry Clinic Manager Not Added !!!
            </div>
<?php             
}
else if($msg=='addsuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Clinic Manager Successfully Added!!!<br/>An email has been sent to the account holder informing the user about the account creation and the username and password.
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
                            <span>Clinic Manager List</span>
                        </div>

                        <div class="utopia-widget-content">
                                    <div style="width: 100%;margin-right:9%;margin-bottom:1%;text-align:right;">
                                                <a href='<?php echo BASE_URL;?>administrator/addclinicmanager'>
                                                            <?php
                                                                        echo $this->Html->image('../admin/img/icons/add.png',array('alt'=>'add','title'=>'add'));
                                                            ?>
                                                            &nbsp;&nbsp;Add Clinic Manager
                                               </a>
                                    </div>
 
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">Sl No.</th>
                                    
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('clinicmanagers_fname','First Name');?></th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('clinicmanagers_lname','Last Name');?></th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('clinicmanagers_username','Username');?></th>
                                    <th style="width: 20%;"><?php echo $this->Paginator->sort('clinicmanagers_email','Email Id');?></th>
                                    <th style="width: 5%;"><?php echo $this->Paginator->sort('clinicmanagers_gender','Gender');?></th>
                                    <th style="width: 20%;"><?php echo $this->Paginator->sort('clinicmanagers_date_of_birth','Date Of Birth');?></th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('clinicmanagers_hand_phone','Hand Phone');?></th>
                                   
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
                                    foreach($all_clinicmanagers as $k=>$individual)
                                    {
                                    ?>
                                        <tr>
                                            <td><?php echo $sl_start+$k;?></td>
                                            <td><?php echo $individual['Clinicmanager']['clinicmanagers_fname'];?></td>
                                            <td><?php echo $individual['Clinicmanager']['clinicmanagers_lname'];?></td>
                                            <td><?php echo $individual['Clinicmanager']['clinicmanagers_username'];?></td>
                                            <td><?php echo $individual['Clinicmanager']['clinicmanagers_email'];?></td>
                                            <td><?php echo $individual['Clinicmanager']['clinicmanagers_gender'];?></td>
                                            <td><?php echo $individual['Clinicmanager']['clinicmanagers_date_of_birth'];?></td>
                                            <td><?php echo $individual['Clinicmanager']['clinicmanagers_hand_phone'];?></td>
                                            
                                            <td>
                                                <a href="<?php echo BASE_URL;?>administrator/editclinicmanager?clinicmanagerid=<?php echo $individual['Clinicmanager']['id'];?>" class="edit">
                                                            <?php echo $this->Html->image('../admin/img/icons/pencil.png',array('alt'=>'Edit','title'=>'Edit'));?>
                                                </a>
                                                <a href="javascript:do_confirm('<?php echo BASE_URL;?>administrator/deleteclinicmanager?clinicmanagerid=<?php echo $individual['Clinicmanager']['id'];?>');" class="delete">
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
