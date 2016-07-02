<?php echo $form->errorSummary($modPenyimpananLinen); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->hiddenField($modPenyimpananLinen,'penyimpananlinen_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<div class="control-group ">
            <?php echo $form->labelEx($modPenyimpananLinen,'tglpenyimpananlinen', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $modPenyimpananLinen->tglpenyimpananlinen = (!empty($modPenyimpananLinen->tglpenyimpananlinen) ? MyFormatter::formatDateTimeForUser($modPenyimpananLinen->tglpenyimpananlinen) : null);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$modPenyimpananLinen,
                            'attribute'=>'tglpenyimpananlinen',
                            'mode'=>'datetime',
                            'options'=> array(
                                'showOn' => false,
//                                'maxDate' => 'd',
                                'dateFormat'=>Params::DATE_FORMAT,
                                'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                    )); ?>
                </div>
        </div>
		<?php
			echo $form->textFieldRow($modPenyimpananLinen,'nopenyimpamanlinen',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>true)); 
        ?>
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($modPenyimpananLinen,'keterangan_penyimpanan',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Keterangan Perawatan')); ?>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($modPenyimpananLinen, 'pegmengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPenyimpananLinen, 'pegmengetahui_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPenyimpananLinen,
					'attribute' => 'pegmengetahui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
							$("#'.Chtml::activeId($modPenyimpananLinen, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Pegawai Mengetahui',
						'class'=>'pegmengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPenyimpananLinen, 'pegmengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
	</div>
</div>

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
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new LAPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['LAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengetahui->searchDialogRuangan(),
    'filter'=>$modPegawaiMengetahui,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($modPenyimpananLinen,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modPenyimpananLinen,'pegmengetahui_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->namaLengkap',
		),
		array(
			'header'=>'Jabatan',
			'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
			'value'=>'$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>