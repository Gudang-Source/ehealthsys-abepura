<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'reinformasipenjualanprodukpos-v-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Tanggal Rencana Operasi','',array('class'=>'control-label')); ?>
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
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')); ?>
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
                            )); 
                    ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','style'=>'width:140px','maxlength'=>100, 'placeholder'=>'Ketik nama pasien', 'autofocus'=>true)); ?>
            <?php echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','style'=>'width:140px','maxlength'=>200, 'placeholder'=>'Alias')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','style'=>'width:140px','maxlength'=>200, 'placeholder'=>'Ketik no. rekam medik')); ?>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','style'=>'width:140px','maxlength'=>200, 'placeholder'=>'Ketik no. pendaftaran')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
     <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php  
        $content = $this->renderPartial('../tips/informasi_jadwalOperasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
     ?>
</div>

<?php $this->endWidget(); ?>
