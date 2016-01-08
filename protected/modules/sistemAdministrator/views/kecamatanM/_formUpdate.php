
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakecamatan-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#propinsi',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <?php echo CHtml::label('Propinsi','propinsi',array('class'=>"control-label")) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('propinsi', $model->getPropinsiItemsKab($model->kabupaten_id), CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('empty'=>'-- Pilih --',
                                                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                    'ajax'=>array(
                                                                                    'type'=>'POST',
                                                                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetKabupaten',array('encode'=>false,'namaModel'=>'','attr'=>'propinsi')),
                                                                                    'update'=>'#SAKecamatanM_kabupaten_id',))); 
                        ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model,'kabupaten_id',CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            </div>
            <div class="span4">
                <?php echo $form->textFieldRow($model,'kecamatan_nama',array('class'=>'span3', 'maxlength'=>50, 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php echo $form->textFieldRow($model,'kecamatan_namalainnya',array('class'=>'span3', 'maxlength'=>50, 'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'longitude', array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->textField($model,'longitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                            <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
                                            array(
                                                      'class'=>'btn btn-primary',
                                                      'rel'=>"tooltip",
                                                      'id'=>'yw1',
                                                      'title'=>"Klik untuk mencari Longitude & Latitude",)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'latitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <div>
                    <?php echo $form->checkBoxRow($model,'kecamatan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
	</div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                                                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                                    Yii::app()->createUrl($this->module->id.'/kecamatanM/admin'), 
                                                                    array('class'=>'btn btn-danger',
                                                                         'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kecamatan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                $this->createUrl('KecamatanM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
 <?php
$content = $this->renderPartial('../tips/tipsadd1',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>


<!--Extension location-picker latitude & longitude-->
<?php 
	$this->widget('ext.LocationPicker2.CoordinatePicker', array(
		'model' => $model,
		'latitudeAttribute' => 'latitude',
		'longitudeAttribute' => 'longitude',
		//optional settings
		'editZoom' => 12,
		'pickZoom' => 7,
		'defaultLatitude' => $latitude,
		'defaultLongitude' => $longitude,
	));
?>		
	
<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAKecamatanM_kecamatan_namalainnya').value = nama.value.toUpperCase();
    }
</script>