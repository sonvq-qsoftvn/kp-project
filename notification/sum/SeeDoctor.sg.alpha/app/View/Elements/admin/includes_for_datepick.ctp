
<?php echo $this->Html->script('../frontend/dtpckr/jquery.min.js');?>
<?php echo $this->Html->script('../frontend/dtpckr/jquery.plugin.js');?>
<?php echo $this->Html->script('../frontend/dtpckr/jquery.datepick.js');?>
<script>
$(function() {
	$('.popupDatepicker').datepick({dateFormat: 'yyyy-mm-dd'});
	
});


</script>