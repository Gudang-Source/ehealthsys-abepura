<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'pengajuansterlilisasi_tgl', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$model->pengajuansterlilisasi_tgl = !empty($model->pengajuansterlilisasi_tgl) ? $format->formatDateTimeForUser($model->pengajuansterlilisasi_tgl) : date('d M Y');
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'pengajuansterlilisasi_tgl',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
//						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
				));
				$model->pengajuansterlilisasi_tgl = !empty($model->pengajuansterlilisasi_tgl) ? $format->formatDateTimeForDb($model->pengajuansterlilisasi_tgl) : date('Y-m-d');
				?>
				<?php echo $form->error($model, 'pengajuansterlilisasi_tgl'); ?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model,'pengajuansterlilisasi_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
	<?php 
	if ($ruangan_id == $ruangan_cssd) { 
	?>	
		<div class="control-group ">
			<?php echo CHtml::label('Instalasi <span class="required">*</span>','Instalasi', array('class'=>'control-label required')) ?>
			<div class="controls">
			<?php echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(),'instalasi_id','instalasi_nama'),
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
							'ajax'=>array('type'=>'POST',
										'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
										'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
							)));?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Ruangan <span class="required">*</span>','Ruangan', array('class'=>'control-label inline required')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	<?php } ?>
	</div>
	<div class="span4">
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegpengajuan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegpengajuan_id',array('readonly'=>true)); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$model,
                                    'attribute' => 'pegawaimengajukan_nama',
                                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                               url: "' . $this->createUrl('AutocompletePegawaiMengajukan') . '",
                                                                               dataType: "json",
                                                                               data: {
                                                                                       term: request.term,
                                                                               },
                                                                               success: function (data) {
                                                                                               response(data);
                                                                               }
                                                                       })
                                                                    }',
                                    'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                    $("#'.Chtml::activeId($model, 'pegpengajuan_id') . '").val(ui.item.pegawai_id); 
                                                    return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                            'class'=>'pegawaimengajukan_nama',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegpengajuan_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengajukan'),
                            ));
                            ?>
                    </div>
            </div>
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegmengetahui_id',array('readonly'=>true)); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$model,
                                    'attribute' => 'pegawaimengetahui_nama',
                                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                               url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
                                                                               dataType: "json",
                                                                               data: {
                                                                                       term: request.term,
                                                                               },
                                                                               success: function (data) {
                                                                                               response(data);
                                                                               }
                                                                       })
                                                                    }',
                                    'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                    $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
                                                    return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                            'class'=>'pegawaimengetahui_nama',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                            ));
                            ?>
                    </div>
            </div>
	</div>
	<div class="span4">
            <?php echo $form->textAreaRow($model,'pengajuansterlilisasi_ket',array('rows'=>4, 'cols'=>100, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<?php 
//========= Dialog buat cari data Pegawai Mengajukan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengajukan',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengajukan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengajukan = new STPegawaiV('searchPegawaiMengajukan');
$modPegawaiMengajukan->unsetAttributes();
if(isset($_GET['STPegawaiV'])) {
    $modPegawaiMengajukan->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengajukan-grid',
	'dataProvider'=>$modPegawaiMengajukan->searchPegawaiMengajukan(),
	'filter'=>$modPegawaiMengajukan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegpengajuan_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengajukan_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengajukan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengajukan, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengajukan, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengajukan, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengajukan, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengajukan dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new STPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['STPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>