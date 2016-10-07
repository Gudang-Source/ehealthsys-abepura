
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sajenis-kegiatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=> 'return requiredCheck(this)'),
        'focus'=>'#SAJenisKegiatanM_jeniskegiatan_nama',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'jeniskegiatan_kode',array('class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
                    <?php echo $form->textFieldRow($model,'jeniskegiatan_nama',array('class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'jeniskegiatan_ruangan',array('class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>                        
            <?php echo $form->checkBoxRow($model,'jeniskegiatan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </div>
        <div class = "span6">
            
        </table>
            
        <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>

                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.$this->id.'/admin'),  
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                             <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Kegiatan', array('{icon}'=>'<i class="entypo-folder"></i>')),
                        $this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                   <?php
                   $tips = array(
                    '0' => 'simpan',
                    '1' => 'ulang',

                );
                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));                 
                ?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAKomponenUnitM_komponenunit_namalainnya').value = nama.value.toUpperCase();
    }
</script>
