<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'monitoring-search-form',
                'type'=>'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'peminjamanrm_id',array('class'=>'span5')); ?>
<table style="width:100%;">
    <tr>
        <td style="width:30%">
            <div class="control-group ">
                <div class="control-label">
                    <?php echo CHtml::label('Tanggal Pendaftaran','tgl_awal'); ?>
                </div>
                <div class="controls">
                    <?php   
                            $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                            $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
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
                            ?>
                </div>
                <?php echo CHtml::label('Sampai dengan','tgl_akhir',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)', 'autofocus'=>true, 'placeholder'=>'Ketik no. rekam medik')); ?>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)', 'placeholder'=>'Ketik no. pendaftaran')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nama_pasien', array('placeholder'=>'Ketik nama pasien')); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'carakeluar_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'carakeluar_id', CHtml::listData($model->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), 
                                array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        'ajax'=>array('type'=>'POST',
                                                    'url'=>$this->createUrl('SetDropDownKondisiKeluar',array('encode'=>false,'model_nama'=>get_class($model))),
                                                    'update'=>"#".CHtml::activeId($model, 'kondisikeluar_id'),
                                        ),));?>                            
                    <?php echo $form->error($model, 'carakeluar_id'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Kondisi Pulang <font color=red>*</font>', 'RIPasienPulangT_kondisikeluar_id', array('class'=>'control-label'))?>
                <?php //echo $form->labelEx($model,'kondisikeluar_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'kondisikeluar_id', CHtml::listData($model->getKondisikeluarItems($model->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), 
                                array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)"));?>
                    <?php echo $form->error($model, 'kondisikeluar_id'); ?>
                </div>
            </div>    
            <?php //echo $form->dropDownListRow($model,'carakeluar',LookupM::getItems('carakeluar'),array('empty'=>'-- Pilih --','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
            <?php //echo $form->dropDownListRow($model,'kondisipulang',LookupM::getItems('kondisipulang'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
        echo "&nbsp;";
        echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/Monitoring/Rawatdarurat'), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
        $content = $this->renderPartial('../tips/informasi',array(),true);
        echo "&nbsp;";
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>