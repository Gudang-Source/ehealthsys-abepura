<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
)); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
            <div class="control-group ">
                <label for="namaPasien" class="control-label">
                    <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggal()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                    <?php echo $model->getAttributeLabel('tgl_pendaftaran'); ?>
                </label>
                <div class="controls">
                    <?php 
                        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
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
            
                        $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                        ?> </div></div>
						<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                            <?php
                            $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
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
                            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                            ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'No. Rekam Medis','class'=>'span3', 'maxlength'=>10)); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Nama Pasien','class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran','class'=>'span3', 'maxlength'=>20)); ?>
            <?php echo $form->dropDownListRow($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --')); ?>
        </td>
    </tr>
</table>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>								
<?php  
$content = $this->renderPartial('../tips/informasiPasienRawatJalan',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
	</div>

<?php $this->endWidget(); ?>