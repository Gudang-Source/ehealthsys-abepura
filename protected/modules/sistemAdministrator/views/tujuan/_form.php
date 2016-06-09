<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'sarekeningcolumn-m-form',
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
		<?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_id', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->hiddenField($model, 'diagnosakep_id'); ?>
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'model' => $model,
				'attribute' => 'diagnosakep_nama',
				'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutoCompleteDiagnosaKeperawatan') . '",
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
												$("#' . CHtml::activeId($model, 'diagnosakep_id') . '").val(ui.item.diagnosakep_id);
												return false;
											}',
				),
				'htmlOptions' => array(
					'placeholder' => 'Kode / Nama Diagnosa',
					'onkeypress' => "return $(this).focusNextInputField(event)",
				),
				'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
			));
			?>
		</div>
	</div>
	<div class='control-group'>
		<?php echo $form->labelEx($model, 'tujuan_nama', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model, 'tujuan_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
		</div>
	</div> 

	<div class='control-group'>
		<?php echo $form->labelEx($model, 'tujuan_aktif', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->checkBox($model, 'tujuan_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
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
		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tujuan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
		<?php
		$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
		$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
		?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogDiagnosa',
	'options' => array(
		'title' => 'Diagnosa Keperawatan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 800,
		'height' => 500,
		'resizable' => false,
	),
));

$modDiagnosaKep = new SADiagnosakepM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['SADiagnosakepM'])) {
	$modDiagnosaKep->attributes = $_GET['SADiagnosakepM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'diagnosakep-m-grid',
	'dataProvider' => $modDiagnosaKep->search(),
	'filter' => $modDiagnosaKep,
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
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_id') . '\").val(\'$data->diagnosakep_id\');
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_nama') . '\").val(\'$data->diagnosakep_nama\');

                                    $(\'#dialogDiagnosa\').dialog(\'close\');
                                    return false;"))'
		),
		array(
			'header' => 'Kode Diagnosa',
			'name' => 'diagnosakep_kode',
			'value' => '$data->diagnosakep_kode',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'type' => 'raw',
			'name' => 'diagnosakep_nama',
			'value' => '$data->diagnosakep_nama',
		),
		array(
			'header' => 'Deskripsi',
			'name' => 'diagnosakep_deskripsi',
			'value' => '$data->diagnosakep_deskripsi',
		),
		array(
			'header' => 'Status',
			'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
			'filter' => CHtml::dropDownList(
					'diagnosakep_aktif', $modDiagnosaKep->diagnosakep_aktif, array('1' => 'Aktif',
				'0' => 'Tidak Aktif',), array('empty' => '--Pilih--'))
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script type="text/javascript">
	function cek(obj) {
		if ($(obj).is(':checked')) {
			$(obj).parents("tr").find("input[name$='[tujuan_aktif]']").val(1);
		} else {
			$(obj).parents("tr").find("input[name$='[tujuan_aktif]']").val(0);
		}
	}
</script>