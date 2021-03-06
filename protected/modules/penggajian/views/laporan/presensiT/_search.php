<legend class="rim">Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kppresensi-t-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'presensi_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'statuskehadiran_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'statusscan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3')); ?>
<table>
    <tr>
        <td>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglpresensi',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,
                                                          'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                          'class'=>'dtPicker3',
                                     ),
            )); ?> 
            </div>
        </div>

        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglpresensi_akhir',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,
                                                          'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                          'class'=>'dtPicker3',
                                     ),
            )); ?> 
            </div>
        </div>

	<?php //echo $form->textFieldRow($model,'tglpresensi_akhir',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'no_fingerprint',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3','maxlength'=>30)); ?>
            <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->checkBoxRow($model,'verifikasi'); ?>

	<?php //echo $form->textAreaRow($model,'keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'jamkerjamasuk',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'jamkerjapulang',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'terlambat_mnt',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'pulangawal_mnt',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
				<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.presensiT.'/informasiPresensi'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
							  	<?php
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
	</div>

<?php $this->endWidget(); ?>
