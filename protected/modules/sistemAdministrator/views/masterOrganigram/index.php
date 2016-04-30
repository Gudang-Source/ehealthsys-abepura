<?php
$this->breadcrumbs=array(
	'Kporganigram Ms'=>array('index'),
	'Create',
);
?>
<div class="white-container">
	<legend class="rim2"><b>Struktur Organigram</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        
	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
	<hr />
	<?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
	<?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
	<div>
		<iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
	<div>
</div>