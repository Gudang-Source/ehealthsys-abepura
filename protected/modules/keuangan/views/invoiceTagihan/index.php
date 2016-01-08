<div class="white-container" id="input-penerimaan-kas">
	<?php $totTagihan = 0; ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'kuinvoicetagihan-t-form',
		'enableAjaxValidation'=>false,
			'type'=>'horizontal',
			'htmlOptions'=> array(
				'onKeyPress'=>'return disableKeyPress(event)'
			),
	)); ?>
	<?php
	if (isset($_GET['sukses'])) {
		Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
	}
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<legend class="rim2">Transaksi <b>Pencatatan Invoice Tagihan</b></legend>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<table width="100%">
		<tr>
			<td>
				<?php echo $form->textFieldRow($modInvoiceTagihan,'invoicetagihan_no',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
				<div class="control-group ">
					<?php $modInvoiceTagihan->invoicetagihan_tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modInvoiceTagihan->invoicetagihan_tgl, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
					<?php echo $form->labelEx($modInvoiceTagihan,'invoicetagihan_tgl', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php   
							$this->widget('MyDateTimePicker',
								array(
										'model'=>$modInvoiceTagihan,
										'attribute'=>'invoicetagihan_tgl',
										'mode'=>'datetime',
										'options'=>array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array(
											'class'=>'dtPicker2-5 reqForm',
											'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
								)
							); 
						?>

					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label('Dari','namapenagih', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modInvoiceTagihan,'namapenagih', array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50))?>
					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label('Perihal','perihal_tagihan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modInvoiceTagihan,'perihal_tagihan', array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100))?>
					</div>
				</div>
			</td>
			<td>
				<div class="control-group">
					<?php echo CHtml::label('Rekanan','rekanan_tagihan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modInvoiceTagihan,'rekanan_tagihan', array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100))?>
					</div>
				</div>
				<?php echo $form->textAreaRow($modInvoiceTagihan,'ket_pembayaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textAreaRow($modInvoiceTagihan,'isisurat_tagihan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</td>
			<td width="33%" align="left">
				<?php echo $form->dropDownListRow($modInvoiceTagihan,'status_verifikasi', LookupM::getItems('status_verifikasi'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<div class="control-group ">
					<?php $modInvoiceTagihan->tgl_verfikasi_tagihan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modInvoiceTagihan->tgl_verfikasi_tagihan, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
					<?php echo $form->labelEx($modInvoiceTagihan,'tgl_verfikasi_tagihan', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php   
							$this->widget('MyDateTimePicker',
								array(
										'model'=>$modInvoiceTagihan,
										'attribute'=>'tgl_verfikasi_tagihan',
										'mode'=>'datetime',
										'options'=>array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array(
											'class'=>'dtPicker2-5 reqForm',
											'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
								)
							); 
						?>
					</div>
				</div>
				<div class="control-group ">
					<?php echo $form->labelEx($modInvoiceTagihan,'peg_verifikasi_tag_id', array('class'=>'control-label')) ?>
					<?php echo $form->hiddenField($modInvoiceTagihan,'peg_verifikasi_tag_id',array('class'=>'span3','maxlength'=>50));  ?>
					<div class="controls">
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'verifikator_tag_nama',
							'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteVerifikator') . '",
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
								'minLength' => 2,
								'select' => 'js:function( event, ui ) {
													   $(this).val( ui.item.label);
													   $("#verifikator_tag_nama").val(ui.item.namalengkap);
													   $("#KUInvoicetagihanT_peg_verifikasi_tag_id").val(ui.item.pegawai_id);
														return false;
													}',
							),
							'tombolDialog' => array('idDialog' => 'dialogVerifikator', 'idTombol' => 'tombolDialogVerifikator'),
							'htmlOptions' => array("placeholder"=>"Ketik nama verifikator","rel" => "tooltip", "title" => "Pencarian Data Verifikator",'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
						?>
				</div>
			</div>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<fieldset class="box">
		<legend class="rim">
			<?php echo CHtml::checkBox('tagihanDetail', true, array('onchange'=>'bukaDetail(this)','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			Detail Tagihan
		</legend>
		<div id="div_tblInputDetail">
			<table id="tblInputDetail" class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>Uraian</th>
						<th>Total</th>
						<th>Keterangan</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php $this->renderPartial('_rowDetail',array('form'=>$form, 'modInvoiceTagDetail'=>$modInvoiceTagDetail)); ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" style="text-align:right;">TOTAL TAGIHAN &nbsp;&nbsp;
						<?php echo $form->textField($modInvoiceTagihan,'total_tagihan',array('class'=>'span3 integer','style'=>'width:90px;','readonly'=>true))?></td>
					</tr>
				</tfoot>
			</table>
	   </div>
	</fieldset>
	<fieldset class="box">
		<legend class="rim">
			<?php echo CHtml::checkBox('tagihanDisposisi', true, array('onchange'=>'bukaDisposisi(this)','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			Data Disposisi
		</legend>
		<div id="div_tblInputDisposisi">
			<table id="tblInputDisposisi" class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>Uraian</th>
						<th>Total</th>
						<th>Keterangan</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php $this->renderPartial('_rowDisposisi',array('form'=>$form, 'modInvoiceDisposisi'=>$modInvoiceDisposisi)); ?>
				</tbody>
			</table>
	   </div>
	</fieldset>
	<fieldset class="box">
		<legend class="rim">Verifikasi</legend>
		<table width="100%">
			<tr>
				<td width="50%">
					<?php echo $form->textFieldRow($modInvoiceTagihan,'disetujui_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->textFieldRow($modInvoiceTagihan,'disetujui_posisi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				</td>
				<td width="50%">
					<?php echo $form->textFieldRow($modInvoiceTagihan,'verifikator_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->textFieldRow($modInvoiceTagihan,'verifikator_posisi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				</td>

			</tr>
		</table>
	</fieldset>
	<div class="form-actions">
		<div style="float:left;margin-right:6px;">
			<?php
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
				$urlSave=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/index');
			?>
		</div>
		<?php
			if (!isset($_GET['sukses'])) {
					echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type'=>'submit','onClick'=>'inputData()' ,'onKeypress'=>'inputData() return formSubmit(this,event)')) . "&nbsp; ";
					echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), array('id' => 'reseter', 'class'=>'btn btn-danger', 'type'=>'reset')) . "&nbsp; ";
					echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true)) . "&nbsp; ";
				} else {
					echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')) . " &nbsp; ";
					echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), array('style'=>'display:none','id' => 'reseter', 'class'=>'btn btn-danger', 'type'=>'reset')) . "&nbsp; ";
					echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onClick' => 'print("PRINT")')) . " &nbsp; ";
				}
		?>
	</div>
</div>
<?php $this->renderPartial('_jsFunctions',array('form'=>$form,'modInvoiceTagDetail'=>$modInvoiceTagDetail, 'modInvoiceDisposisi'=>$modInvoiceDisposisi)); ?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogVerifikator',
	'options' => array(
		'title' => 'Daftar Pegawai Verifikator',
		'autoOpen' => false,
		'modal' => true,
		'minWidth' => 900,
		'minHeight' => 400,
		'resizable' => false,
	),
));
$modPegawai = new PegawaiV('search');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
	$modPegawai->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pegawai-v-grid',
	'dataProvider' => $modPegawai->search(),
	'filter' => $modPegawai,
	'template' => "{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
				"id"=>"selectPegawai",
				"onClick"=>"
							$(\"#KUInvoicetagihanT_peg_verifikasi_tag_id\").val(\"$data->pegawai_id\");
							$(\"#verifikator_tag_nama\").val(\"$data->namalengkap\");
							$(\"#dialogVerifikator\").dialog(\"close\");
							return false;
				",
			   ))'
		),
		array(
			'header' => 'NIK',
			'type' => 'raw',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header' => 'ID',
			'type' => 'raw',
			'value'=>'$data->pegawai_id',
		),
		array(
			'header' => 'Nama Pegawai',
			'type' => 'raw',
			'value'=>'$data->namalengkap',
			'filter' => CHtml::activeTextField($modPegawai,'nama_pegawai'),
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>