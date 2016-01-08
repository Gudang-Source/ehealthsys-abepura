<div class="white-container">
    <legend class="rim2">Transaksi <b>Pengiriman Peralatan dan Linen Steril</b></legend>
    <?php
    $this->breadcrumbs=array(
            'STpengirimanalatsteril Ts'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>
     <?php 
        if(!empty($_GET['sukses'])){   
    ?>
	<?php echo Yii::app()->user->setFlash('success',"Data Pengiriman Peralatan dan Linen Steril berhasil disimpan !"); $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php } ?>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'cspengirimanalatsteril-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
		'focus'=>'#'.CHtml::activeId($model,'kirimperlinensteril_ket'),
	)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
	<fieldset class="box">
		<legend class="rim">Data Pencarian</legend>
		<?php echo $this->renderPartial('_formPencarian', array(
            'modCari'=>$modCari, 'form'=>$form, 'format'=>$format)); ?>
	</fieldset>
	<div class="block-tabel">
            <h6>Peralatan <b>dan Linen</b></h6>
		<?php $this->renderPartial('_tabelPenyimpanan', array('modPenyimpananDetails'=>$modPenyimpananDetails)); ?>		
	</div>
	<fieldset class="box">
		<legend class="rim">Data Pengiriman</legend>
		<?php $this->renderPartial('_formPengiriman', array('model'=>$model, 'form'=>$form, 'format'=>$format)); ?>		
	</fieldset>

    <div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'cekPengiriman()','onkeypress'=>'cekPengiriman()','disabled'=>$disableSave)); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>$disablePrint)); ?>
		<?php	$content = $this->renderPartial('tips/transaksi1',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array('model'=>$model,'modCari'=>$modCari)); ?>