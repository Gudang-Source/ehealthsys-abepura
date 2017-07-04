<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kppresensi-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_fingerprint'),
)); ?>

	<?php //echo $form->textFieldRow($model,'presensi_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'statuskehadiran_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'statusscan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3')); ?>
<table width="100%">
    <tr>
        <td>
        <?php
            $format = new MyFormatter();
            $model->tglpresensi  = $format->formatDateTimeForUser($model->tglpresensi);
            $model->tglpresensi_akhir  = $format->formatDateTimeForUser($model->tglpresensi_akhir);
        ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglpresensi',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
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
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,
                                                          'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                          'class'=>'dtPicker3',
                                     ),
            )); ?> 
            </div>
        </div>

	<?php //echo $form->textFieldRow($model,'tglpresensi_akhir',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'no_fingerprint',array('class'=>'span3 numbers-only','maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3 numbers-only','maxlength'=>15)); ?>
            <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3 hurufs-only','maxlength'=>30)); ?>
			
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'kelompok_pegawai', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'kelompokpegawai_id', CHtml::listData(
                        KelompokpegawaiM::model()->findAllByAttributes(array (
                            'kelompokpegawai_aktif'=>true,
                        ), array(
                            'order'=>'kelompokpegawai_nama',
                        )), 'kelompokpegawai_id', 'kelompokpegawai_nama'
                    ), array(
                        'empty'=>'-- Pilih --',
                    ));?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'jabatan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jabatan_id', CHtml::listData(
                        JabatanM::model()->findAllByAttributes(array (
                            'jabatan_aktif'=>true,
                        ), array(
                            'order'=>'jabatan_nama',
                        )), 'jabatan_id', 'jabatan_nama'
                    ), array(
                        'empty'=>'-- Pilih --',
                    ));?>
                </div>
            </div>
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
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('PresensiT/InformasiPresensi'), array('class'=>'btn btn-danger')); ?>
							  	<?php
$content = $this->renderPartial('../tips/informasi_presensi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
	</div>

<?php $this->endWidget(); ?>
