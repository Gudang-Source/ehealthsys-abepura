
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'tarif-ambulans-m-form',
        'type'=>'horizontal',
	'enableAjaxValidation'=>false,
        'focus'=>'#daftartindakan',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p><br>
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
	<div class='span4'>
		<div class="control-group">
			<div class="control-label"> Daftar Tindakan <font style="color:red">*</font> </div>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'daftartindakan_id',array('id'=>'daftartindakan_id')) ?>
				<?php $this->widget('MyJuiAutoComplete', array(
																   'name'=>'daftartindakan', 
																	'source'=>'js: function(request, response) {
																		   $.ajax({
																			   url: "'.Yii::app()->createUrl('ActionAutoComplete/Daftartindakan').'",
																			   dataType: "json",
																			   data: {
																				   term: request.term,
																			   },
																			   success: function (data) {
																					   response(data);
																			   }
																		   })
																		}',
																	'options'=>array(
																			   'showAnim'=>'fold',
																			   'minLength' => 1,
																			   'focus'=> 'js:function( event, ui )
																				   {
																					$(this).val(ui.item.daftartindakan_nama);
																					return false;
																					}',
																			   'select'=>'js:function( event, ui ) {
																				   $("#daftartindakan_id").val(ui.item.daftartindakan_id);
																					return false;
																				}',
																	),
																	'htmlOptions'=>array(
																		'readonly'=>false,
																		'placeholder'=>'Daftar Tindakan',
																		'class'=>'span3',
																		'onkeypress'=>"return $(this).focusNextInputField(event);",
																	),
																	'tombolDialog'=>array('idDialog'=>'dialogDaftartindakan'),
															)); ?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model,'tarifambulans_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->dropDownListRow($model,'kepropinsi_nama', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
				  array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3',
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'kekabupaten_nama'),
                                ),
                                'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
	</div>
	<div class='span4'>
		<?php echo $form->dropDownListRow($model,'kekabupaten_nama', CHtml::listData($model->getKabupatenItems($model->kepropinsi_nama), 'kabupaten_id', 'kabupaten_nama'),
				  array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3',
						'ajax'=>array('type'=>'POST',
									'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($model))),
									'update'=>"#".CHtml::activeId($model, 'kekecamatan_nama'),
						),
						'onchange'=>"setClearDropdownKelurahan();",));?>

		<?php echo $form->dropDownListRow($model,'kekecamatan_nama',CHtml::listData($model->getKecamatanItems($model->kekabupaten_nama), 'kecamatan_id', 'kecamatan_nama'), 
				  array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
						'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'kekelurahan_nama')))); ?>

		<?php $model->kekelurahan_nama = (!empty($model->kekelurahan_nama))?$model->kekelurahan_nama:Yii::app()->user->getState('kekelurahan_nama');?>
		<?php echo $form->dropDownListRow($model,'kekelurahan_nama', CHtml::listData($model->getKelurahanItems($model->kekecamatan_nama), 'kelurahan_id', 'kelurahan_nama'),
				  array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3'
					   )); ?>
	</div>
	<div class='span4'>
            <?php  echo $form->textFieldRow($model,'jmlkilometer',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'tarifperkm',array('class'=>'span3 integer','onkeypress'=>"return $(this).focusNextInputField(event)",'onkeyup'=>'tarif()')); ?>
            <?php echo $form->textFieldRow($model,'tarifambulans',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
    array('class'=>'btn btn-primary', 'type'=>'submit', 
        'onKeypress'=>'return formSubmit(this,event)',
        'id'=>'btn_simpan','onclick'=>'do_upload()',
       )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
    Yii::app()->createUrl($this->module->id.'/tarifAmbulansM/admin'), 
    array('class'=>'btn btn-danger',
          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tarif Ambulans',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php
    $content = $this->renderPartial('../tarifAmbulansM/tips/transaksi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
	function tarif(){
		var km = document.getElementById("TarifAmbulansM_jmlkilometer").value;
		var tr = document.getElementById("TarifAmbulansM_tarifperkm").value;
		//var tkm = tr.replace(",","")*km;
		var tkm = tr.replace(/,/gi,"")*km;		
		document.getElementById("TarifAmbulansM_tarifambulans").value = tkm;		
	}
	/** bersihkan dropdown kecamatan */
	function setClearDropdownKecamatan()
	{
		$("#<?php echo CHtml::activeId($model,"kekecamatan_nama");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
	}
	/** bersihkan dropdown kelurahan */
	function setClearDropdownKelurahan()
	{
		$("#<?php echo CHtml::activeId($model,"kekelurahan_nama");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
	}
</script>

<?php

   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDaftartindakan',
    'options'=>array(
        'title'=>'Pencarian Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
        ),
    ));
   
$modDaftartindakan = new AMDaftartindakanM('search');
$modDaftartindakan->unsetAttributes();
if(isset($_GET['AMDaftartindakanM'])) {
    $modDaftartindakan->attributes = $_GET['AMDaftartindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftartindakan-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modDaftartindakan->search(),
	'filter'=>$modDaftartindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectDaftartindakan",
                                        "onClick" => "\$(\"#daftartindakan_id\").val($data->daftartindakan_id);
                                                              \$(\"#daftartindakan\").val(\"$data->daftartindakan_nama\");
                                                              \$(\"#dialogDaftartindakan\").dialog(\"close\");"
                                 )
                 )',
            ),
             array(
                    'name'=>'komponenunit_id',
                    'filter'=> CHtml::dropDownList('AMDaftartindakanM[komponenunit_id]',$modDaftartindakan->komponenunit_id,CHtml::listData($modDaftartindakan->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'),array('empty'=>'--Pilih--')),
                    'value'=>'(isset($data->komponenunit->komponenunit_nama) ? $data->komponenunit->komponenunit_nama : "")',
            ),
            array(
                    'name'=>'kategoritindakan_id',
                    'filter'=> CHtml::dropDownList('AMDaftartindakanM[kategoritindakan_id]',$modDaftartindakan->kategoritindakan_id,CHtml::listData($modDaftartindakan->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('empty'=>'--Pilih--')),
                    'value'=>'(isset($data->kategoritindakan->kategoritindakan_nama) ? $data->kategoritindakan->kategoritindakan_nama : "")',
            ),
            array(
                    'name'=>'kelompoktindakan_id',
                    'filter'=> CHtml::dropDownList('AMDaftartindakanM[kelompoktindakan_id]',$modDaftartindakan->kelompoktindakan_id,CHtml::listData($modDaftartindakan->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'),array('empty'=>'--Pilih--')),
                    'value'=>'(isset($data->kelompoktindakan->kelompoktindakan_nama) ? $data->kelompoktindakan->kelompoktindakan_nama : "")',
            ),
            array(
                        'name'=>'daftartindakan_nama',
                        'filter'=>  CHtml::dropDownList('AMDaftartindakanM[daftartindakan_nama]',$modDaftartindakan->daftartindakan_nama,CHtml::listData($modDaftartindakan->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),array('empty'=>'--Pilih--')),
                        'value'=>'(isset($data->daftartindakan_nama) ? $data->daftartindakan_nama : "")',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ------------------------------------------------------------------- endWidget BarangM ----------------------------------------------------------------- */