</div>
        <!-- Body end -->

    </div>

    <!-- Maincontent end -->

</div> <!-- end of container -->

<!-- javascript placed at the end of the document so the pages load faster -->
<?php echo $this->Element('admin/script_includes');?>

<!-- special scripts for special pages -->

<?php

//including scripts for form pages
if(isset($isformpage))
{
    if($isformpage==1)
    {
        echo $this->Element('admin/js_for_forms');
    }
    
}


?>
<p style='text-align:right;margin-right:20px;'>&copy; SeeDoctor.sg <?php echo date('Y');?></p>

</body>
</html>
