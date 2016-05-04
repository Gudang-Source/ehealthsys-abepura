<div class="white-container">
	<legend class="rim2">Diagnosa, <b> CBG dan CMG </b></legend>
	<?php 
		$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
			'id'=>'pencarian-diagnosa-cbg-cmg-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
			'htmlOptions'=>array(
				'onKeyPress'=>'return disableKeyPress(event);',
				'onsubmit'=>'return requiredCheck(this);'),
			'focus'=>'#',
		)); 
	?>
	<?php 
		if(isset($_GET['sukses'])){ 
			Yii::app()->user->setFlash('success', "Data Pemesanan Kamar berhasil dibuat !");
		}
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>	
 
	<?php
		$this->widget('bootstrap.widgets.BootTabbable', array(
		   'type'=>'tabs',
		   'placement'=>'above', // 'above', 'right', 'below' or 'left'
		   'tabs'=>array(
			   array('label'=> 'Diagnosa','content'=> $this->renderPartial('_formDiagnosa', array('form'=>$form), true)),
			   array('label'=> 'CBG','content'=> $this->renderPartial('_formCBG', array('form'=>$form), true)),
			   array('label'=> 'CMG','content'=> $this->renderPartial('_formCMG', array('form'=>$form), true)),
		   ),
//				'htmlOptions'=>array('onclick'=>'setTab(this);')
	   ));
	?>	
	<div class="form-actions">
		<?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue','type'=>'button','disabled'=>true,'onclick'=>'printData(\'PRINT\')')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array());?>