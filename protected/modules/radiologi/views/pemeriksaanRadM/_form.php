
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapemeriksaan-rad-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#daftartindakan_nama',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary(array($model,$modReferensiHasil)); ?>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <label class="control-label" for="bidang">Daftar Tindakan</label>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('daftartindakan_id'); ?>
                            <?php 
							$model->daftartindakan_nama = !empty($model->daftartindakan_id) ? $model->daftartindakan->daftartindakan_nama : " ";
							$this->widget('MyJuiAutoComplete', array(
											'model'=>$model,
											'name'=>'daftartindakan_nama',
											//'value'=>$model,
											'attribute'=>'daftartindakan_nama',
											'source'=>'js: function(request, response) {
														   $.ajax({
															   url: "'.$this->createUrl('AutocompleteTindakan').'",
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
												   'minLength' => 2,
												   'focus'=> 'js:function( event, ui ) {
														$(this).val( ui.item.label);
														return false;
													}',
												   'select'=>'js:function( event, ui ) { 
														$("#'.CHtml::activeId($model, 'daftartindakan_id').'").val(ui.item.daftartindakan_id);
														$("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
														return false;
													}',
											),
//											'htmlOptions'=>array(
//												'onkeypress'=>"return $(this).focusNextInputField(event)",
//												
//											),
											'tombolDialog'=>array('idDialog'=>'dialogTindakan'),
											'htmlOptions'=>array('placeholder'=>'Ketik Nama Tindakan','rel'=>'tooltip','title'=>'Ketik Nama Tindakan','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'),
										)); 
						 ?>
                    </div><br /><br />
                    <?php echo $form->dropDownListRow($model,'jenispemeriksaanrad_id',CHtml::listData(JenispemeriksaanradM::model()->findAll(array('order'=>'jenispemeriksaanrad_nama', 'condition'=>'jenispemeriksaanrad_aktif = true')), 'jenispemeriksaanrad_id','jenispemeriksaanrad_nama'),array('class'=>'span3','empty'=>'--Pilih--')); ?>
                    </div>
                    <?php //echo $form->HiddenField($model,'daftartindakan_id',CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'pemeriksaanrad_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                    <?php echo $form->textFieldRow($model,'pemeriksaanrad_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $form->checkBoxRow($model,'pemeriksaanrad_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
        
        <fieldset class="box">
			<?php echo $form->hiddenField($model,'is_adareferensihasil', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-referensihasil',
                        'content'=>array(
                            'content-referensihasil'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'setReferensiHasil();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengisi form Referensi Hasil')).'<b> Referensi Hasil</b>',
                                'isi'=>$this->renderPartial('_formReferensiHasil',array(
                                        'form'=>$form,
                                        'modReferensiHasil'=>$modReferensiHasil,
                                        ),true),
                                'active'=>false,
                            ),   
                        ),
                )); ?>
        </fieldset>
        
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/pemeriksaanRadM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
						<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pemeriksaan Radiologi', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; ?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit3a',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTindakan',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modTindakanRad = new TariftindakanperdatotalV('search');
$modTindakanRad->unsetAttributes();
if(isset($_GET['TariftindakanperdatotalV']))
    $modTindakanRad->attributes = $_GET['TariftindakanperdatotalV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modTindakanRad->search(),
	'filter'=>$modTindakanRad,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                            "#",
                            array(
                                "class"=>"btn-small", 
                                "id" => "selectTindakan",
                                "onClick" => "
                                $(\"#daftartindakan_id\").val(\'$data->daftartindakan_id\');
                                $(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
                                $(\'#dialogTindakan\').dialog(\'close\');return false;"))'
            ),
            'kelompoktindakan_nama',
            'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',
            'harga_tariftindakan',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('ROPemeriksaanRadM_pemeriksaanrad_namalainnya').value = nama.value.toUpperCase();
    }
	
	function setReferensiHasil(){
		var is_adareferensihasil = $("#<?php echo CHtml::activeId($model,'is_adareferensihasil');?>");
		
		if(is_adareferensihasil.val() > 0){ //hide
			is_adareferensihasil.val(0);
		}else{//show
			is_adareferensihasil.val(1);
		}
	}
</script>