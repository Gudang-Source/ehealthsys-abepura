<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pindahkamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset>
    <legend>Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td>
                <?php $this->widget('MyJuiAutoComplete',array(
                        'model'=>$modPasienRIV,
                        'attribute'=>'no_rekam_medik',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 2,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                
                                return false;
                            }',
                            'select'=>'js:function( event, ui ) {
                                  $("#'.CHtml::activeId($modPasienRIV,'tgl_pendaftaran').'").val(ui.item.tgl_pendaftaran);
                                  $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);   
                                  $("#'.CHtml::activeId($modPasienRIV,'umur').'").val(ui.item.umur);     
                                  $("#'.CHtml::activeId($modPasienRIV,'jeniskasuspenyakit_nama').'").val(ui.item.jeniskasuspenyakit_nama);
                                  $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);   
                                  $("#'.CHtml::activeId($modPasienRIV,'nama_pasien').'").val(ui.item.nama_pasien);     
                                  $("#'.CHtml::activeId($modPasienRIV,'jeniskelamin').'").val(ui.item.jeniskelamin);  
                                  $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);  
                                  $("#'.CHtml::activeId($modPasienRIV,'nama_bin').'").val(ui.item.nama_bin);   
                                  $("#'.CHtml::activeId($modPindahKamar,'pasien_id').'").val(ui.item.pasien_id);     
                                  $("#'.CHtml::activeId($modPindahKamar,'pendaftaran_id').'").val(ui.item.pendaftaran_id);    
                                  $("#'.CHtml::activeId($modPindahKamar,'masukkamar_id').'").val(ui.item.masukkamar_id);    
                                  $("#'.CHtml::activeId($modPindahKamar,'pasienadmisi_id').'").val(ui.item.pasienadmisi_id);}'
     
                        ),
                 )); ?>
            </td>
        </tr>
        <tr>
            <td><label class="control-label">No. Pendaftaran</label></td>
            <td>
                <?php echo CHtml::activeTextField($modPasienRIV, 'no_pendaftaran', array('readonly'=>true, 'class'=>'span2')); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>
<fieldset>
    <legend>Data Pindah Kamar</legend>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

        <?php echo $form->errorSummary(array($modPindahKamar)); ?>
        <?php echo $form->hiddenField($modPindahKamar,'pasien_id');?>
        <?php echo $form->hiddenField($modPindahKamar,'pendaftaran_id');?>
        <?php echo $form->hiddenField($modPindahKamar,'pasienadmisi_id');?>
        <?php echo $form->hiddenField($modPindahKamar,'masukkamar_id');?>
        
        <?php echo $form->dropDownListRow($modPindahKamar,'ruangan_id', CHtml::listData($modPindahKamar->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama') ,
                                  array('empty'=>'-- Pilih --',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'onChange'=>'updateKamarRuangan(this.value)',
                                        'class'=>'span2')); ?>

        <?php echo $form->dropDownListRow($modPindahKamar,'kamarruangan_id', array() ,
                                  array('empty'=>'-- Pilih --',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'class'=>'span2')); ?>

        <div class="control-group ">
            <?php echo $form->labelEx($modPindahKamar,'tglpindahkamar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modPindahKamar,
                                        'attribute'=>'tglpindahkamar',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                             'class'=>'dtPicker3',
                                                             'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                             ),
                )); ?>
                <?php echo $form->error($modPindahKamar, 'tglpindahkamar'); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo $form->labelEx($modPindahKamar,'jampindahkamar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modPindahKamar,
                                        'attribute'=>'jampindahkamar',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                             'class'=>'tPicker3',
                                                             'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                             ),
                )); ?>
                <?php echo $form->error($modPindahKamar, 'jampindahkamar'); ?>
            </div>
        </div>

    <div class="form-actions">
         <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                                array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)')); ?>
    </div>

    <?php $this->endWidget(); ?>    
</fieldset>