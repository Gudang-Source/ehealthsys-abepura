
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sajenis-kasus-penyakit-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAJenisKasusPenyakitM_jeniskasuspenyakit_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jeniskasuspenyakit_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jeniskasuspenyakit_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jeniskasuspenyakit_urutan', array('onkeypress'=>"return $(this).focusNextInputField(event);",'size'=>4)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'jeniskasuspenyakit_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php  echo $form->labelEx($model,'ruangan_id',array('class'=>'control-label required'));  ?>
            <div class="control-group">
                <div class="controls">
                    <?php 
                        $arrRuangan = array();
                        if(count($modRuangan) > 0){
                                foreach($modRuangan as $Ruangan){
                                        $arrRuangan[] = $Ruangan['ruangan_id'];
                                }
                        }
                        $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                  array('sortable'=>true, 'searchable'=>true)
                                         );
                        echo CHtml::dropDownList(
                        'ruangan_id[]',
                        $arrRuangan,
                        CHtml::listData(SARuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'),
                        array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
                    ?>

                 </div>
            </div>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
            $this->createUrl('admin'), 
            array('class'=>'btn btn-danger',
                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Kasus Penyakit', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
        $content = $this->renderPartial($this->path_view.'tips.tipsCreateUpdate',array(),true);
        $this->widget('UserTips',array('content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAJenisKasusPenyakitM_jeniskasuspenyakit_namalainnya').value = nama.value.toUpperCase();
    }
</script>