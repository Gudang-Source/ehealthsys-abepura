
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfsupplier-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'supplier_kode'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'supplier_kode',array('class'=>'span2','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                    <?php echo $form->textFieldRow($model,'supplier_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)",  'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
					<?php echo $form->dropDownListRow($model,'pbf_id',
								CHtml::listData(SAPbfM::model()->findAll(), 'pbf_id', 'pbf_nama'),
								array('readonly'=>false,'class'=>'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
								'empty'=>'-- Pilih --',)); ?>
                    <?php echo $form->textFieldRow($model,'supplier_namalain',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textAreaRow($model,'supplier_alamat',array('rows'=>4, 'cols'=>30, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->textFieldRow($model,'supplier_kodepos',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
				</td>
				<td>
					<div class="control-group ">
						<?php echo CHtml::activeLabel($model, 'longitude', array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'longitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
							<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
									array(
				//						  'onclick'=>'$("#dialogLongitudeLatitude").dialog("open");return false;',
										  'class'=>'btn btn-primary',
										  'rel'=>"tooltip",
										  'id'=>'yw1',
										  'title'=>"Klik untuk mencari Longitude & Latitude",)); ?>
						</div>
					</div>
					<?php echo $form->textFieldRow($model,'latitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
					<?php echo $form->dropDownListRow($model,'supplier_propinsi', CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'ajax'=>array('type'=>'POST','url'=>$this->createUrl('GetKabupatendrNamaPropinsi',array('encode'=>false,'namaModel'=>'SASupplierM','attr'=>'supplier_propinsi')),'update'=>'#SASupplierM_supplier_kabupaten'))); ?>
                    <?php echo $form->dropDownListRow($model,'supplier_kabupaten',array(),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>  
					<?php echo $form->textFieldRow($model,'supplier_telp',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
					<?php echo $form->textFieldRow($model,'supplier_fax',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
				</td>
                <td>
					<?php echo $form->textFieldRow($model,'supplier_npwp',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($model,'supplier_website',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'supplier_email',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'supplier_cp',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($model,'supplier_norekening',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($model,'supplier_jenis',array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readOnly'=>true)); ?>
				</td>
            </tr>
            <tr>
				<td>
					<?php echo $form->checkBoxRow($model,'supplier_aktif',array('checked'=>'supplier_aktif')); ?>
				</td>
			</tr>
        </table>
            <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl('admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Supplier', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                               $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
						<?php
                            $content = $this->renderPartial($this->path_view.'tips.tipsCreateUpdate',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
			</div>

<?php $this->endWidget(); ?>
<?php
                       
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>

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
	document.getElementById('SASupplierM_supplier_namalain').value = nama.value.toUpperCase();
}
</script>