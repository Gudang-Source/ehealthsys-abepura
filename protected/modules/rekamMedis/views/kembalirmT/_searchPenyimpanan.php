
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'rkdokumenpasienrmlama-v-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model, 'tglrekammedis', array('class' => 'span3')); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglrekammedis', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tgl_rekam_medik = MyFormatter::formatDateTimeForUser($model->tgl_rekam_medik);
                    $model->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForUser($model->tgl_rekam_medik_akhir);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_rekam_medik',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_rekam_medik_akhir',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10)); ?>
            <div class="control-group ">
                
                <?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
                <div class='controls'>
                    <?php echo $form->textField($model, 'no_rekam_medik_akhir', array('class' => 'span3', 'maxlength' => 10)); ?>
                    </div>
            </div>
            
            
            
            <?php //echo $form->textFieldRow($model, 'instalasi_nama', array('class' => 'span3', 'maxlength' => 50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50)); ?>
            <?php //echo $form->dropDownListRow($model, 'statusrekammedis', LookupM::getItems('statusrekammedis')
//                    , array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 10)); ?>
            <?php echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true)), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onchange'=>'getRuangan();')); ?>
            <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true)), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20)); ?>
            
        </td>
    </tr>
</table>

    <div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    </div>

<?php $this->endWidget(); ?>


<script>
    function getRuangan(){
        var value = $('#<?php echo CHtml::activeId($model, 'instalasi_id'); ?>').val();
        if (jQuery.isNumeric(value)){
            $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {instalasi_id:value}, function(data){
                $('#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>').html('<option value="">-- Pilih --</option>'+data.dropDown);
            }, 'json');
        }
        else{
            
        }
    }
</script>