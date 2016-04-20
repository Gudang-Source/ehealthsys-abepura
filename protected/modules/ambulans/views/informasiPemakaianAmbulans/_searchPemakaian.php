<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'pemakaianambulans-t-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nopolisi'),
)); ?>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Pemakaian','tglPemakaian', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
					$model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
												'dateFormat'=>  Params::DATE_FORMAT,
												'maxDate' => 'd',
                                                'showOn' => false,
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker2', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'tgl_awal'); ?>
                </div>
            </div>
            <div class="control-group ">
                <label for="namaPasien" class="control-label">Sampai dengan</label>
                <div class="controls">
                    <?php   
					$model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
												'dateFormat'=>  Params::DATE_FORMAT,
												'maxDate' => 'd',
                                                'showOn' => false,
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'tgl_akhir'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'nopolisi',array('placeholder'=>'No. Polisi','class'=>'span3','maxlength'=>20)); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran','class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'No. Rekam Medik','class'=>'span3','maxlength'=>10)); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Nama Pasien','class'=>'span3','maxlength'=>100)); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'pemakai_nama',array('placeholder'=>'Nama Pemakai','class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'ruangan_nama',array('placeholder'=>'Ruangan','class'=>'span3')); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
<?php  
$content = $this->renderPartial('../tips/informasiPemakaianAmbulans',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>

<?php $this->endWidget(); ?>
</div>