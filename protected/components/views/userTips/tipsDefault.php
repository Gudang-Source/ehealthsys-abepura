<?php echo CHtml::link(Yii::t('mds','{icon} Instruction',array('{icon}'=>'<i class="icon-info-sign icon-white"></i>')), '#', array('class'=>'btn btn-info','id'=>'instruction_button')); ?>

<div id="instruction_form" class="well" style="display:none;">
	<?php
	if(isset($content)){
		echo $content;
	}else{
		echo "Tidak ada petunjuk khusus.";
	}
	?>
</div>

<?php 
Yii::app()->clientScript->registerScript('instruction', "
$('#instruction_button').click(function(){
	$('#instruction_form').toggle('fast');
	return false;
});
");
?>