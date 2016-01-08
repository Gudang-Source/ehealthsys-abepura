<style type="text/css">
	.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > li > a{
		cursor: pointer;
	}
</style>
<?php 
	$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'bookingkamar-t',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array(
			'onKeyPress'=>'return disableKeyPress(event);',
			'onsubmit'=>'return requiredCheck(this);'),
		'focus'=>'#',
	)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>

	<?php 
		if(isset($_GET['sukses'])){ 
			Yii::app()->user->setFlash('success', "Data Pemesanan Kamar berhasil dibuat !");
		}
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>	
 

	<div class="row-fluid">
			<?php
				$this->widget('bootstrap.widgets.BootTabbable', array(
				   'type'=>'tabs',
				   'placement'=>'above', // 'above', 'right', 'below' or 'left'
				   'tabs'=>array(
					   array('label'=> 'Data Pasien', 'content'=> $this->renderPartial('_formPasien', array('form'=>$form,'model'=>$model,'modPasien'=>$modPasien,'modPegawai'=>$modPegawai), true)),
					   array('label'=> 'Data Pemesanan', 'content'=> $this->renderPartial('_formPemesanan', array('form'=>$form,'model'=>$model,'modPasien'=>$modPasien,'modPegawai'=>$modPegawai), true)),
				   ),
			   ));
		   ?>
		<div class="form-actions">
			<?php 
				$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
				$disableSave = false;
				$disableSave = (!empty($_GET['bookingkamar_id'])) ? true : ($sukses > 0) ? true : false;
			?>
			<?php $disablePrint = ($disableSave) ? false : true; ?>
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disableSave));
			?>
			 <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
						array('class'=>'btn btn-danger',
							'onclick'=>'return refreshForm(this);'));  ?>
			<?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false",'disabled'=>$disablePrint  )).'&nbsp;'; ?>
		</div>
	</div>
<?php $this->endWidget(); ?>