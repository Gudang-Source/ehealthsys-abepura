<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
)); ?>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group ">
            <?php echo $form->labelEx($model,'Tanggal Pendaftaran', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                ?>
            </div>
        </div>
        <div class="control-group ">
            <label class='control-label'>Sampai dengan</label>
            <div class="controls">
                <?php   
                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3', 'maxlength'=>20)); ?>
        <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3', 'maxlength'=>10)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','maxlength'=>50)); ?>
        <?php echo $form->textFieldRow($model,'no_masukpenunjang',array('placeholder'=>'Ketik No. Masuk Penunjang','class'=>'span3', 'maxlength'=>20)); ?>
    </div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'
	 ));  ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
		Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
		array('class'=>'btn btn-danger',
			  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	<?php
		$content = $this->renderPartial('laboratorium.views.informasiBatalPeriksaLab.tips.informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>