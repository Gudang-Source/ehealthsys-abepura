
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sajenis-kelas-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAJenisKelasM_jeniskelas_nama',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'jeniskelas_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return nextFocus(this,event,'SAJenisKelasM_jeniskelas_namalainnya','')", 'maxlength'=>25)); ?>
            <?php echo $form->textFieldRow($model,'jeniskelas_namalainnya',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAJenisKelasM_jeniskelas_aktif','SAJenisKelasM_jeniskelas_nama')", 'maxlength'=>25)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'jeniskelas_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','SAJenisKelasM_jeniskelas_namalainnya')")); ?>
            </div>
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/jenisKelasM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Kelas', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                $this->createUrl('jenisKelasM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            <?php
            $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAJenisKelasM_jeniskelas_namalainnya').value = nama.value.toUpperCase();
    }
</script>