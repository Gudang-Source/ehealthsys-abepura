<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'batalrawatinap-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert'); 
echo $form->errorSummary(array($modPasienBatalPulang)); ?>


<fieldset>
    <legend class="rim2">Data Pasien</legend>
    <table class="table table-condensed">
        <?php echo CHtml::hiddenField('pendaftaran_id', $modPendaftaran->pendaftaran_id); ?>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?> </td>
            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik')?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class'=>'control-label'))?></td>
            <td>
                <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true, 'class'=>'span2')); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php //echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); 
                      echo CHtml::label('Jenis Kasus Penyakit','jeniskasuspenyakit_nama', array('class'=>'control-label') ) ; ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>
<fieldset>
    <legend class="rim">Alasan Pembatalan Pulang Pasien</legend>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <br>
       <div class="control-group ">
            <?php echo $form->labelEx($modPasienBatalPulang,'tglpembatalan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php 
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modPasienBatalPulang,
                                'attribute'=>'tglpembatalan',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'timeFormat'=>  Params::TIME_FORMAT,
                                ),
                                'htmlOptions'=>array('readonly'=>true,
                                                 'class'=>'dtPicker3',
                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                 ),
                )); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modPasienBatalPulang, 'alasanpembatalan'); ?>
        <?php //echo CHtml::hiddenField('pasien_id', $modPasienAdmisi->pasien_id); ?>
        <?php echo CHtml::hiddenField('pasien_id', $modPendaftaran->pasien_id); ?>
        

    <div class="form-actions">
         <?php echo CHtml::htmlButton($modPasienBatalPulang->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                array('class'=>'btn btn-danger','onclick'=>'konfirmasi()')); 
           $content = $this->renderPartial('../tips/transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
    </div>   
</fieldset>
<script type="text/javascript">
    $(document).ready(function(){
        // Notifikasi Pasien
        <?php 
            if(isset($smspasien)){
                if($smspasien==0){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
            insert_notifikasi(params);
        <?php            
                }
            }
        ?>
    })
</script>
<?php
$this->endWidget();
if($tersimpan=='Ya'){
?>
<script>
parent.location.reload();
</script>
<?php
}
?>