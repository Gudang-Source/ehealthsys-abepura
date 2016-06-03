<div class="search-form" style="">
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'type' => 'horizontal',
		'id' => 'searchLaporan',
		'htmlOptions' => array( 'onKeyPress' => 'return disableKeyPress(event)'),
	));
	?>
	<style>

		label.checkbox{
			width:150px;
			display:inline-block;
		}
	</style>
	<fieldset class='box'>
		<legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group ">
					<?php echo CHtml::label('Periode Posting', 'periodeposting_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php
						echo $form->dropDownList($modelLaporan, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll(), 'periodeposting_id', 'deskripsiperiodeposting'), array('empty' => '-- Pilih --',
							'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm'));
						?>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class='control-group'>
					<?php echo CHtml::label('Nama Rekening', 'namarekening', array('class' => 'control-label')) ?>
					<?php echo $form->hiddenField($modelLaporan, 'rekening5_id'); ?>
					<div class="controls">
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model' => $modelLaporan,
							'attribute' => 'namarekening',
							'name' => 'namarekening',
							'sourceUrl' => $this->createUrl('rekeningAkuntansi'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'select' => 'js:function( event, ui ) {
									$(this).val(ui.item.value);
									  return false;
								}'
							),
							'htmlOptions' => array(
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'placeholder' => 'Ketikan Nama Rekening',
								'class' => 'span3',
								'style' => 'width:150px;',
							),
							'tombolDialog' => array('idDialog' => 'dialogRek'),
						));
						?>
					</div>
				</div>
			</div>
		</div>

		<div class="form-actions">
			 <?php
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
				array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>

			<?php
			echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/Index'), array('class' => 'btn btn-danger',
				'onclick' => 'return refreshForm(this);'));
			?>
		</div>
</div>  
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
', CClientScript::POS_READY);
?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRek',
	'options' => array(
		'title' => 'Rekening',
		'autoOpen' => false,
		'modal' => true,
		'width' => 800,
		'height' => 500,
		'resizable' => false,
	),
));

$modRekeningDebit = new AKRekeningakuntansiV('search');
$modRekeningDebit->unsetAttributes();
if (isset($_GET['AKRekeningakuntansiV'])) {
	$modRekeningDebit->attributes = $_GET['AKRekeningakuntansiV'];
	$modRekeningDebit->rekening5_nb = $_GET['rekening5_nb'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'rekeningdebit-m-grid',
	'dataProvider' => $modRekeningDebit->search(),
	'filter' => $modRekeningDebit,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" => "
                                    $(\"#AKLaporanbukubesarV_rekening5_id\").val(\'$data->rekening5_id\');
                                    $(\"#namarekening\").val(\'$data->nmrekening5\');

                                    $(\'#dialogRek\').dialog(\'close\');
                                    return false;"))'
		),
		array(
			'header' => 'No. Urut',
			'name' => 'nourutrek',
			'value' => '$data->nourutrek',
		),
		array(
			'header' => 'Rek. 1',
			'name' => 'kdrekening1',
			'value' => '$data->kdrekening1',
		),
		array(
			'header' => 'Rek. 2',
			'name' => 'kdrekening2',
			'value' => '$data->kdrekening2',
		),
		array(
			'header' => 'Rek. 3',
			'name' => 'kdrekening3',
			'value' => '$data->kdrekening3',
		),
		array(
			'header' => 'Rek. 4',
			'name' => 'kdrekening4',
			'value' => '$data->kdrekening4',
		),
		array(
			'header' => 'Rek. 5',
			'name' => 'kdrekening5',
			'value' => '$data->kdrekening5',
		),
		array(
			'header' => 'Nama Rekening',
			'type' => 'raw',
			'name' => 'nmrekening5',
			'value' => '($data->nmrekening5 == "" ? $data->nmrekening4 : ($data->nmrekening4 == "" ? $data->nmrekening3 : ($data->nmrekening3 == "" ? $data->nmrekening2 : ($data->nmrekening2 == "" ? $data->nmrekening1 : ($data->nmrekening1 == "" ? "-" : $data->nmrekening5)))))',
		),
		array(
			'header' => 'Nama Lain',
			'name' => 'nmrekeninglain5',
			'value' => '($data->nmrekeninglain5 == "" ? $data->nmrekeninglain4 : ($data->nmrekeninglain4 == "" ? $data->nmrekeninglain3 : ($data->nmrekeninglain3 == "" ? $data->nmrekeninglain2 : ($data->nmrekeninglain2 == "" ? $data->nmrekeninglain1 : ($data->nmrekeninglain1 == "" ? "-" : $data->nmrekeninglain5)))))',
		),
		array(
			'header' => 'Saldo Normal',
			'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
			'filter' => CHtml::dropDownList(
					'rekening5_nb', $modRekeningDebit->rekening5_nb, array('D' => 'Debit',
				'K' => 'Kredit',), array('empty' => '--Pilih--'))
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>