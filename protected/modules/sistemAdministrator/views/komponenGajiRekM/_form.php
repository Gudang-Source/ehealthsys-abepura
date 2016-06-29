<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'sakompgajirek-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
	'focus' => '#',
		));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->labelEx($model, "komponengaji_id", array('class' => 'control-label')); ?>
        <div class="controls">
			<?php echo $form->hiddenField($model, 'komponengaji_id'); ?>
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'model' => $model,
				'attribute' => 'komponengaji_nama',
				'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('KomponenGaji') . '",
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
					'focus' => 'js:function( event, ui ) {
												$(this).val( ui.item.value);
												return false;
											}',
					'select' => 'js:function( event, ui ) { 
												$("#' . CHtml::activeId($model, 'komponengaji_id') . '").val(ui.item.komponengaji_id);
												return false;
											}',
				),
				'htmlOptions' => array(
					'placeholder' => 'Kode / Nama Komponen Gaji',
					'onkeypress' => "return $(this).focusNextInputField(event)",
				),
				'tombolDialog' => array('idDialog' => 'dialogKompGaji'),
			));
			?>
        </div>
    </div>
    <div class="control-group">
		<?php echo $form->labelEx($model, "rekening5_id", array('class' => 'control-label')); ?>
        <div class="controls">
			<?php echo $form->hiddenField($model, 'debitkredit'); ?>
			<?php echo $form->hiddenField($model, 'rekening5_id'); ?>
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'model' => $model,
				'attribute' => 'nmrekening5',
				'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('RekeningAkuntansi') . '",
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
					'focus' => 'js:function( event, ui ) {
												$(this).val( ui.item.value);
												return false;
											}',
					'select' => 'js:function( event, ui ) { 
												$("#' . CHtml::activeId($model, 'rekening5_id') . '").val(ui.item.rekening5_id);
												return false;
											}',
				),
				'htmlOptions' => array(
					'placeholder' => 'Kode / Nama Rekening',
					'onkeypress' => "return $(this).focusNextInputField(event)",
				),
				'tombolDialog' => array('idDialog' => 'dialogRek'),
			));
			?>
        </div>
    </div>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'debitkredit', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->dropDownList($model, 'debitkredit', array("D" => "Debit", "K" => "Kredit"), array('class' => 'span3')); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls checkbox-column">
			<?php echo $form->checkBox($model, 'ispenggajian', array('onclick' => 'setUntukTransaksi();')) . CHtml::activeLabel($model, 'ispenggajian'); ?>
			<br>
			<br>
			<?php echo $form->checkBox($model, 'ispembayarangaji', array('onclick' => 'setUntukTransaksi();')) . CHtml::activeLabel($model, 'ispembayarangaji'); ?>				
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
		<?php
		echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
			'onclick' => 'return refreshForm(this);'));
		?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Rekening Komponen Gaji', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
		<?php
		$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
		$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
		?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
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

$modRekeningDebit = new SARekeningakuntansiV('search');
$modRekeningDebit->unsetAttributes();
if (isset($_GET['SARekeningakuntansiV'])) {
	$modRekeningDebit->attributes = $_GET['SARekeningakuntansiV'];
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
                                    $(\"#' . CHtml::activeId($model, 'rekening5_id') . '\").val(\'$data->rekening5_id\');
                                    $(\"#' . CHtml::activeId($model, 'nmrekening5') . '\").val(\'$data->nmrekening5\');

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

<?php
//========= Dialog buat cari data Komponen Gaji =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogKompGaji',
	'options' => array(
		'title' => 'Komponen Gaji',
		'autoOpen' => false,
		'modal' => true,
		'width' => 800,
		'height' => 500,
		'resizable' => false,
	),
));

$modKompGaji = new SAKomponengajiM('search');
$modKompGaji->unsetAttributes();
if (isset($_GET['SAKomponengajiM'])) {
	$modKompGaji->attributes = $_GET['SAKomponengajiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'komponengaji-m-grid',
	'dataProvider' => $modKompGaji->search(),
	'filter' => $modKompGaji,
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
                                    "id" => "selectKompGaji",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'komponengaji_id') . '\").val(\'$data->komponengaji_id\');
                                    $(\"#' . CHtml::activeId($model, 'komponengaji_nama') . '\").val(\'$data->komponengaji_nama\');

                                    $(\'#dialogKompGaji\').dialog(\'close\');
                                    return false;"))'
		),
		array(
			'header' => 'No. Urut',
			'name' => 'nourutgaji',
			'value' => '$data->nourutgaji',
		),
		array(
			'header' => 'Kode',
			'name' => 'komponengaji_kode',
			'value' => '$data->komponengaji_kode',
		),
		array(
			'header' => 'Nama',
			'name' => 'komponengaji_nama',
			'value' => '$data->komponengaji_nama',
		),
		array(
			'header' => 'Singkatan',
			'name' => 'komponengaji_singkt',
			'value' => '$data->komponengaji_singkt',
		),
		array(
			'header' => 'Potongan',
			'name' => 'ispotongan',
			'value' => '($data->ispotongan == 1)?"Ya":"Tidak"',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
// $this->renderPartial($this->path_view . "_jsFunctions", array('model' => $model)); ?>