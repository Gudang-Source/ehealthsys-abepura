<div class="row-fluid">
	<div class = "span4">
		<?php echo CHtml::hiddenField('penerimaanbarang_id',$modPenerimaanBarang->penerimaanbarang_id, array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo $form->hiddenField($modPenerimaanBarang,'permintaanpembelian_id', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php if(isset($_GET['sukses'])) { ?>
		   <?php echo $form->textFieldRow($modPenerimaanBarang,'noterima', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php } ?>
	   <div class="control-group ">
			   <?php echo $form->labelEx($modPenerimaanBarang,'tglterima', array('class'=>'control-label')) ?>
				  <div class="controls">
					   <?php   
						   $modPenerimaanBarang->tglterima = (!empty($modPenerimaanBarang->tglterima) ? date("d/m/Y H:i:s",strtotime($modPenerimaanBarang->tglterima)) : null);
						   $this->widget('MyDateTimePicker',array(
							   'model'=>$modPenerimaanBarang,
							   'attribute'=>'tglterima',
							   'mode'=>'datetime',
							   'options'=> array(
   //                                            'dateFormat'=>Params::DATE_FORMAT,
								   'showOn' => false,
								   'maxDate' => 'd',
								   'yearRange'=> "-150:+0",
							   ),
							   'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
							   ),
					   )); ?>
				  </div>
	   </div>
	   <?php echo $form->textFieldRow($modPenerimaanBarang,'nosuratjalan', array('placeholder'=>'Ketik No. Surat Jalan','class'=>'span3 alphanumber', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
	   <div class="control-group ">
			   <?php echo $form->labelEx($modPenerimaanBarang,'tglsuratjalan', array('class'=>'control-label')) ?>
				  <div class="controls">
					   <?php   
						   $modPenerimaanBarang->tglsuratjalan = (!empty($modPenerimaanBarang->tglsuratjalan) ? date("d/m/Y H:i:s",strtotime($modPenerimaanBarang->tglsuratjalan)) : null);
						   $this->widget('MyDateTimePicker',array(
							   'model'=>$modPenerimaanBarang,
							   'attribute'=>'tglsuratjalan',
							   'mode'=>'datetime',
							   'options'=> array(
   //                                            'dateFormat'=>Params::DATE_FORMAT,
								   'showOn' => false,
								   'maxDate' => 'd',
								   'yearRange'=> "-150:+0",
							   ),
							   'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
							   ),
					   )); ?>
				  </div>
	   </div>
	   
   </div>
	<div class = "span4">
		<div class="control-group">
			<?php echo $form->dropDownListRow($modPenerimaanBarang,'supplier_id',
			 CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
			 array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			 'empty'=>'-- Pilih --')); ?>
		</div>
		<?php echo $form->textAreaRow($modPenerimaanBarang,'keteranganterima', array('placeholder'=>'Ket. Penerimaan Barang','class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>		    
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($modPenerimaanBarang, 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPenerimaanBarang, 'pegawaimengetahui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPenerimaanBarang,
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
							$("#'.Chtml::activeId($modPenerimaanBarang, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modPenerimaanBarang, 'pegawaimengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($modPenerimaanBarang, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPenerimaanBarang, 'pegawaimenyetujui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPenerimaanBarang,
					'attribute' => 'pegawaimenyetujui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
							$("#'.Chtml::activeId($modPenerimaanBarang, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimenyetujui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modPenerimaanBarang, 'pegawaimenyetujui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo Chtml::label('Status Penerimaan <font style="color:red">*</font>','statuspenerimaan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPenerimaanBarang,'statuspenerimaan',LookupM::getItems('statuspenerimaan'),array('class'=>'required','empty'=>'--Pilih--','style'=>'width:130px;','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
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

$modPegawaiMengetahui = new GFPegawairuanganV('search');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['GFPegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawairuanganV'];
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
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
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

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new GFPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['GFPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
	'filter'=>$modPegawaiMenyetujui,
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
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
					'name'=>'nomorindukpegawai',
                ),
		/*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
		 * 
		 */
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
		/*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
		 * 
		 */
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>