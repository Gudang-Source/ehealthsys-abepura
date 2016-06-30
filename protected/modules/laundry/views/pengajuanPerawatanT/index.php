<div class="white-container">
    <legend class="rim2">Transaksi <b>Pengajuan Perawatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'LApengajuanperawatan Ts'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php 
        if(!empty($_GET['sukses'])){   
    ?>
	<?php echo Yii::app()->user->setFlash('success',"Data Pengajuan Perawatan berhasil disimpan !"); $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php } ?>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'lapengajuanperawatan-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
		'focus'=>'#',
	)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
	<fieldset class="box">
		<legend class="rim">Data Pengajuan</legend>
		<?php echo $this->renderPartial($this->path_view.'_formPengajuan', array(
            'model'=>$model, 'form'=>$form, 'format'=>$format)); ?>
	</fieldset>
	<div class="block-tabel">
            <h6><b>Linen</b></h6>
            <?php $this->renderPartial($this->path_view.'_formLinen', array('model'=>$model, 'form'=>$form,)); ?>		
            <?php echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

            <table class="table table-striped table-condensed" id="table-linen">
                    <thead>
                            <tr>
                                    <th>No. </th>
                                    <th>No. Register Linen</th>
                                    <th>Nama Linen</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Perawatan</th>
                                    <th>Keterangan</th>
                                    <th>Batal</th>
                            </tr>
                    </thead>
                    <tbody>
                    </tbody>
            </table>
        </div>
    <div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary','type'=>'submit','disabled'=>$disableSave)); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'),array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda akan mengulang input data ?').'")) return false;')); ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>$disablePrint)); ?>
		<?php	$content = $this->renderPartial($this->path_view.'tips/transaksi1',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
<?php 
/*
Yii::app()->clientScript->registerScript('onready','
	$("form").submit(function(){
		pesan = false;
                if ($(".cancel").length < 1){
                    myAlert("Data Line Harus Diisi");
                    noregisterlinen.focus();
                    return false;
                }
    }
);
',CClientScript::POS_READY);
 */ ?>
 
