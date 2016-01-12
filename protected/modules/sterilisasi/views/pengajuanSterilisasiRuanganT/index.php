<div class="white-container">
    <legend class="rim2">Transaksi <b>Pengajuan Sterilisasi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'STpengajuansterilisasi Ts'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>
     <?php 
        if(!empty($_GET['sukses'])){   
    ?>
	<?php echo Yii::app()->user->setFlash('success',"Data Pengajuan Sterilisasi berhasil disimpan !"); $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php } ?>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'cspengajuansterilisasi-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
		'focus'=>'#'.CHtml::activeId($model,'pengajuansterlilisasi_ket'),
	)); ?>

	<?php echo $form->errorSummary($model); ?>
	<fieldset class="box">
		<legend class="rim">Data Pengajuan</legend>
                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
		<?php echo $this->renderPartial($this->path_view.'_formPengajuan', array(
            'model'=>$model, 'form'=>$form, 'format'=>$format, 'ruangan_id'=>$ruangan_id, 'ruangan_cssd'=>$ruangan_cssd)); ?>
	</fieldset>
	<div class="block-tabel">
            <h6>Peralatan <b>dan Linen</b></h6>
            <?php $this->renderPartial($this->path_view.'_formPeralatanLinen', array('model'=>$model, 'form'=>$form,)); ?>		
            <?php echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

            <table class="table table-striped table-condensed" id="table-linen">
                    <thead>
                            <tr>
                                    <th>No. </th>
                                    <th>Nama Peralatan dan Linen</th>
                                    <th>Jumlah</th>
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
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','disabled'=>$disableSave)); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>$disablePrint)); ?>
		<?php	$content = $this->renderPartial($this->path_view.'tips/transaksi1',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>