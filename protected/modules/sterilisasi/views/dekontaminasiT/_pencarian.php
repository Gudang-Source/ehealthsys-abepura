<div class="search-form">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarian-form',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($modPenerimaanSterilisasiDetail,'penerimaansterilisasi_no'),
        ));
?>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group ">
				<?php echo CHtml::label('Tanggal Penerimaan','Tanggal Awal', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$modPenerimaanSterilisasiDetail->tgl_awal = (!empty($modPenerimaanSterilisasiDetail->tgl_awal) ? date("d/m/Y H:i:s",strtotime($modPenerimaanSterilisasiDetail->tgl_awal)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modPenerimaanSterilisasiDetail,
								'attribute'=>'tgl_awal',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
	//                                'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
						)); ?>
					</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Sampai Dengan','Tanggal Akhir', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$modPenerimaanSterilisasiDetail->tgl_akhir = (!empty($modPenerimaanSterilisasiDetail->tgl_akhir) ? date("d/m/Y H:i:s",strtotime($modPenerimaanSterilisasiDetail->tgl_akhir)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modPenerimaanSterilisasiDetail,
								'attribute'=>'tgl_akhir',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
	//                                'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
						)); ?>
					</div>
			</div>
		</div>
		<div class="span4">			
			<div class="control-group ">
				<?php echo CHtml::label('No. Penerimaan','',array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPenerimaanSterilisasiDetail,'penerimaansterilisasi_no',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>false)); ?>
					</div> 
			</div>
			
			<div class="control-group ">
				<?php echo $form->labelEx($modPenerimaanSterilisasiDetail, 'Nama Peralatan', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->hiddenField($modPenerimaanSterilisasiDetail, 'barang_id'); ?>
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'model'=>$modPenerimaanSterilisasiDetail,
						'attribute' => 'barang_nama',
						'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompletePeralatan') . '",
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
								$("#'.Chtml::activeId($modPenerimaanSterilisasiDetail, 'barang_id') . '").val(ui.item.barang_id); 
								return false;
							}',
						),
						'htmlOptions' => array(
							'placeholder'=>'Ketikan Nama Peralatan',
							'class'=>'barang_nama',
							'onkeyup'=>"return $(this).focusNextInputField(event)",
							'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPenerimaanSterilisasiDetail, 'barang_id') . '").val(""); '
						),
						'tombolDialog' => array('idDialog' => 'dialogPeralatan'),
					));
					?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPenerimaanSterilisasiDetail,'instalasi_id', $instalasiTujuans, 
							array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
									'ajax'=>array('type'=>'POST',
												'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modPenerimaanSterilisasiDetail))),
												'update'=>"#".CHtml::activeId($modPenerimaanSterilisasiDetail, 'ruangan_id'),
									)));?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPenerimaanSterilisasiDetail,'ruangan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>           
				</div>
			</div>			
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onkeypress'=>'searchPenerimaan();','onclick'=>'searchPenerimaan()')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
	</div>
<?php $this->endWidget(); ?>
</div>
<?php
//========= Dialog buat cari data Peralatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPeralatan',
    'options'=>array(
        'title'=>'Pencarian Peralatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPeralatan = new STBarangM('searchDialog');
$modPeralatan->unsetAttributes();
if(isset($_GET['STBarangM'])) {
    $modPeralatan->attributes = $_GET['STBarangM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modPeralatan->searchDialog(),
    'filter'=>$modPeralatan,
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
							  $(\"#'.CHtml::activeId($modPenerimaanSterilisasiDetail,'barang_id').'\").val(\"$data->barang_id\");
							  $(\"#'.CHtml::activeId($modPenerimaanSterilisasiDetail,'barang_nama').'\").val(\"$data->barang_nama\");
							  $(\"#dialogPeralatan\").dialog(\"close\"); 
							  return false;
					"))',
		),
		array(
			'header'=>'Tipe Peralatan',
			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_type'),
			'value'=>'$data->barang_type',
		),
		array(
			'header'=>'Kode Peralatan',
			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_kode'),
			'value'=>'$data->barang_kode',
		),
		array(
			'header'=>'Nama Barang',
			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_nama'),
			'value'=>'$data->barang_nama',
		),
		array(
			'header'=>'Nama Lain',
			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_namalainnya'),
			'value'=>'$data->barang_namalainnya',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Peralatan dialog =============================
?>