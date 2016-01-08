
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sainstalasi-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAInstalasiM_instalasi_nama',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'instalasi_nama',array('class'=>'span2', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_namalainnya','')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'instalasi_namalainnya',array('class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_singkatan','SAInstalasiM_instalasi_nama')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'instalasi_singkatan',array('class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_lokasi','SAInstalasiM_instalasi_namalainnya')", 'maxlength'=>2)); ?>
                    <?php echo $form->textFieldRow($model,'instalasi_lokasi',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SAInstalasiM_instalasi_singkatan')", 'maxlength'=>50)); ?>
                    <div>
                        <?php echo $form->checkBoxRow($model,'instalasi_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                    <?php echo $form->textAreaRow($modRiwayatRuanganR,'tentangpenetapan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'instalasirujukaninternal',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_namalainnya','')", 'maxlength'=>50)); ?>
                    <?php echo $form->dropDownListRow($model,'instalasi_adakamar',array(''=>'-Pilih-',1=>'Ya',0=>'Tidak'),array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_singkatan','SAInstalasiM_instalasi_nama')", 'maxlength'=>50)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modRiwayatRuanganR,'tglpenetapanruangan', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modRiwayatRuanganR,
                                                    'attribute'=>'tglpenetapanruangan',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                        'yearRange'=> "-60:+0",
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php echo $form->error($modRiwayatRuanganR, 'tglpenetapanruangan'); ?>
                        </div>
                    </div>   
                     <?php echo $form->textFieldRow($modRiwayatRuanganR,'nopenetapanruangan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->labelEx($model,'instalasi_image', array('class'=>'control-label','onkeypress'=>"return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
                          <div class="controls">  
                            <?php echo Chtml::activeFileField($model,'instalasi_image',array('maxlength'=>254,'hint'=>'Isi Jika Akan Menambahkan Logo')); ?>
                          </div>
                     <img src="<?php echo Params::urlInstalasiTumbsDirectory().'kecil_'.$model->instalasi_image ?> ">
                </td>
            </tr>
        </table>
           
	<div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/instalasiM/admin'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Instalasi', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                            $this->createUrl('instalasiM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            <?php
                $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAInstalasiM_instalasi_namalainnya').value = nama.value.toUpperCase();
    }
</script>