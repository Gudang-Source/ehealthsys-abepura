<div class="white-container">
	<?php
	$this->breadcrumbs = array(
		'Daftar Faktur Pembelian',
	);

	Yii::app()->clientScript->registerScript('search', "
    $('#rencana-t-search').submit(function(){
            $('#fakturpembelian-m-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('fakturpembelian-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
	?>
    <legend class="rim2">Informasi Faktur <b>Pembelian Farmasi</b></legend>
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'rencana-t-search',
		'type' => 'horizontal',
		'focus' => '#BKFakturPembelianT_nofaktur'
	));
	?>
    <div class="block-tabel">
        <h6>Tabel Faktur <b>Pembelian Farmasi</b></h6>
		<?php
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'fakturpembelian-m-grid',
			'dataProvider' => $model->searchInformasi(),
			'template' => "{summary}\n{items}\n{pager}",
			'itemsCssClass' => 'table table-striped table-condensed',
			'columns' => array(
				array(
					'name' => 'tglfaktur',
					'type' => 'raw',
					'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
				),
				'nofaktur',
				array(
					'name' => 'supplier_id',
					'type' => 'raw',
					'value' => '$data->supplier_nama',
				),
				array(
					'name' => 'tgljatuhtempo',
					'type' => 'raw',
					'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
				),
				'keteranganfaktur',
				array(
					'header' => 'Umur Hutang',
					'type' => 'raw',
					'value' => '$data->umurHutang',
				),
				array(
					'name' => 'totharganetto',
					'type' => 'raw',
					'value' => 'MyFormatter::formatNumberForPrint($data->totharganetto)',
                                        'htmlOptions'=>array('style'=>'text-align: right'),
				),
				array(
					'name' => 'jmldiscount',
					'type' => 'raw',
					'value' => 'MyFormatter::formatNumberForPrint($data->jmldiscount)',
                                        'htmlOptions'=>array('style'=>'text-align: right'),
				),
				array(
					'name' => 'totalpajakpph',
					'type' => 'raw',
					'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakpph)',
                                        'htmlOptions'=>array('style'=>'text-align: right'),
				),
				array(
					'name' => 'totalpajakppn',
					'type' => 'raw',
					'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakppn)',
                                        'htmlOptions'=>array('style'=>'text-align: right'),
				),
				array(
					'name' => 'totalhargabruto',
					'type' => 'raw',
					'value' => 'MyFormatter::formatNumberForPrint($data->totalhargabruto)',
                                        'htmlOptions'=>array('style'=>'text-align: right'),
				),
				array(//Details ini langsung terhubung ke details Faktur d peneriaam Items supaya mudah memaintenance karena 1 view dan action 
					'header' => 'Details',
					'type' => 'raw',
					'htmlOptions' => array('style' => 'text-align:left;'),
					'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("keuangan/InformasiFakturFarmasi/detailsFaktur",array("idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik Untuk Melihat Detail Faktur","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsFaktur\").dialog(\"open\");", "rel"=>"tooltip"))',
				),
				array(
					'header' => 'Bayar ke Supplier',
					'type' => 'raw',
					'htmlOptions' => array('style' => 'text-align:left;'),
					'value' => '((empty($data->bayarkesupplier_id)) ? CHtml::link("<i class=\'icon-form-bayar\'></i> ",Yii::app()->createUrl("keuangan/pembayaranSupplierKU/index",array("frame"=>1,"idFakturPembelian"=>$data->fakturpembelian_id)) ,array("title"=>"Klik Untuk Membayar ke Supplier","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip")) : "Lunas")',
				),
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
    </div>
    <fieldset class="box" id="divSearch-form">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%">
            <tr>
                <td>
                    <div class="control-group ">
							<?php $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd'), 'medium', null); ?>
							<?php echo CHtml::label('Tanggal Faktur', 'BKFakturPembelianT_tgl_awal', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_awal',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>
						</div>
                    </div>
                    <div class="control-group ">
							<?php $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd'), 'medium', null); ?>
							<?php echo CHtml::label('Sampai Dengan', 'BKFakturPembelianT_tgl_akhir', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_akhir',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>
						</div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
							<?php $model->tgl_awalJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awalJatuhTempo, 'yyyy-MM-dd'), 'medium', null); ?>
                        <label class="control-label">
							<?php echo CHtml::checkBox('berdasarkanJatuhTempo', '', array('uncheckValue' => 0, 'onClick' => 'cekTanggal()')); ?>
                            Tanggal Jatuh Tempo
                        </label>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_awalJatuhTempo',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>
						</div>
                    </div>
                    <div class="control-group ">
							<?php $model->tgl_akhirJatuhTempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirJatuhTempo, 'yyyy-MM-dd'), 'medium', null); ?>
							<?php echo CHtml::label('Sampai Dengan', 'BKFakturPembelianT_tgl_akhirJatuhTempo', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_akhirJatuhTempo',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>
						</div>
                    </div>
                </td>
                <td>
<?php echo $form->textFieldRow($model, 'nofaktur', array('class' => 'numberOnly')); ?>
			<?php
			echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData($model->supplierItems, 'supplier_id', 'supplier_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
				'empty' => '-- Pilih --',));
			?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset'))." "; ?>
<?php
$content = $this->renderPartial($this->path_view . 'tips', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>
</div>

<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'form_hiddenFaktur',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('target' => '_new'),
	'action' => Yii::app()->createUrl($module . '/fakturPembelian/index'),
		));
?>
<?php echo CHtml::hiddenField('idPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('noPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('tglPenerimaanForm', '', array('readonly' => true)); ?>
<?php echo CHtml::hiddenField('currentUrl', $currentUrl, array('readonly' => true)); ?>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogDetailsFaktur',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Details Faktur Pembelian',
		'autoOpen' => false,
		'minWidth' => 1100,
		'minHeight' => 50,
		'resizable' => false,
	),
));
?>
<iframe src="" name="iframe" width="100%" height="350">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogRetur',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Pembayaran Supplier',
		'autoOpen' => false,
		'width' => 1100,
		'resizable' => false,
		"beforeClose" => 'js:function(){$("#divSearch-form form").submit();}'
	),
));
?>
<iframe src="" name="iframeRetur" width="100%" height="500">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

$js = <<< JSCRIPT
function formFaktur(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    $('#idPenerimaanForm').val(idPenerimaan);
    $('#noPenerimaanForm').val(noPenerimaan);
    $('#tglPenerimaanForm').val(tglPenerimaan);
    $('#form_hiddenFaktur').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD);
?>
<script>
	document.getElementById('KUInformasifakturpembelianV_tgl_awalJatuhTempo_date').setAttribute("style", "display:none;");
	document.getElementById('KUInformasifakturpembelianV_tgl_akhirJatuhTempo_date').setAttribute("style", "display:none;");
	function cekTanggal() {
		var checklist = $('#berdasarkanJatuhTempo');
		var pilih = checklist.attr('checked');
		if (pilih) {
			document.getElementById('KUInformasifakturpembelianV_tgl_awalJatuhTempo_date').setAttribute("style", "display:block;");
			document.getElementById('KUInformasifakturpembelianV_tgl_akhirJatuhTempo_date').setAttribute("style", "display:block;");
		} else {
			document.getElementById('KUInformasifakturpembelianV_tgl_awalJatuhTempo_date').setAttribute("style", "display:none;");
			document.getElementById('KUInformasifakturpembelianV_tgl_akhirJatuhTempo_date').setAttribute("style", "display:none;");
		}
	}
</script>
