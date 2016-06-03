<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));               ?>
<div class="white-container">
	<div class="row-fluid">
		<div class="control-group">
			<?php echo CHtml::label('Pengkajian Kebidanan', 'iskeperawatan', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::checkBox('iskeperawatan', false, array('uncheckValue' => 0, 'onclick' => 'cekListKebidanan(this)', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo CHtml::activeHiddenField($modPengkajian, 'anamesa_id', array('readonly' => true, 'class' => 'span1')); ?>
				<?php echo CHtml::activeHiddenField($modPengkajian, 'pemeriksaanfisik_id', array('readonly' => true, 'class' => 'span1')); ?>
				<?php echo CHtml::hiddenField('ASPengkajianaskepT[pengkajianaskep_id]', $modPengkajian->pengkajianaskep_id, array('readonly' => true)); ?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">

			<div class="control-group keperawatan">
				<?php echo CHtml::label('No. Pengkajian Keperawatan', 'no_pengkajian', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (!empty($modPengkajian->pengkajianaskep_id)) {
						echo CHtml::textField('ASPengkajianaskepT[no_pengkajian]', $modPengkajian->no_pengkajian, array('readonly' => true));
					} else {
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'ASPengkajianaskepT[no_pengkajian]',
							'value' => $modPengkajian->no_pengkajian,
							'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienInstalasi') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#ASPengkajianaskepT_instalasi_id").val(),
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
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
								'select' => 'js:function( event, ui ) {
                                                isiDataPasien(ui.item);
                                                return false;
                                            }',
							),
							'tombolDialog' => array('idDialog' => 'dialogPengkajianKep', 'idTombol' => 'tombolPengkajianDialog'),
							'htmlOptions' => array('class' => 'span2',
								'placeholder' => 'Ketik No. Pengkajian', 'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
					}
					?>
				</div>
			</div>
			<div class="control-group kebidanan">
				<?php echo CHtml::label('No. Pengkajian Kebidanan', 'no_pengkajian', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (!empty($modPengkajian->pengkajianaskep_id)) {
						echo CHtml::textField('ASPengkajianaskepT[no_pengkajian]', $modPengkajian->no_pengkajian, array('readonly' => true));
					} else {
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'ASPengkajianaskepT[no_pengkajian_keb]',
							'value' => $modPengkajian->no_pengkajian,
							'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienInstalasi') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#ASPengkajianaskepT_instalasi_id").val(),
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
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
								'select' => 'js:function( event, ui ) {
                                                isiDataPasien(ui.item);
                                                return false;
                                            }',
							),
							'tombolDialog' => array('idDialog' => 'dialogPengkajianKeb', 'idTombol' => 'tombolPengkajianDialog'),
							'htmlOptions' => array('class' => 'span2 hidden',
								'placeholder' => 'Ketik No. Pengkajian', 'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
					}
					?>
				</div>
			</div>
		</div>
		<div class="span3">
			<div class="control-group">
				<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php echo CHtml::textField('ASPengkajianaskepT[pengkajianaskep_tgl]', $modPengkajian->pengkajianaskep_tgl, array('readonly' => true, 'class' => 'span2')); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Nama pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->hiddenField($modPengkajian, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
					<?php echo CHtml::textField('ASPengkajianaskepT[nama_pegawai]', $modPengkajian->nama_pegawai, array('readonly' => true)); ?>
				</div>
			</div>
		</div>
		<div class="span1">
			<div class="control-group">
				<div class="controls">
					<?php
					echo CHtml::link("<i class=icon-form-detail></i>", 'javascript:void(0);', array("rel" => "tooltip",
						"title" => "Klik untuk melihat detail",
						"target" => "frameDetail",
						"onclick" => "cekPengkajian(this);",
					));
//					echo CHtml::link(Yii::t('mds',array('{icon}'=>"<i class=\'icon-form-detail\'></i> ")), Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian", array("pengkajianaskep_id" => $modPengkajian->pengkajianaskep_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pengkajian Keperawatan", "onclick" => "window.parent.$(\'#dialogDetail\').dialog(\'open\')")); 
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPengkajianKep',
	'options' => array(
		'title' => 'Pencarian Pengkajian Keperawatan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 540,
		'resizable' => false,
	),
));
$modPengkajianAskep = new ASInfopengkajianaskepV('searchInformasi');
$modPengkajianAskep->unsetAttributes();
if (isset($_GET['ASPengkajianaskepT'])) {
	$modPengkajianAskep->attributes = $_GET['ASPengkajianaskepT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran-t-grid',
	'dataProvider' => $modPengkajianAskep->searchInformasi(),
	'filter' => $modPengkajianAskep,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPengkajian",
                                        "onClick" => "
                                            $(\"#dialogPengkajianKep\").dialog(\"close\");
											$(\"#ASPengkajianaskepT_pengkajianaskep_id\").val(\"$data->pengkajianaskep_id\");
											$(\"#ASPengkajianaskepT_pengkajianaskep_id\").val(\"$data->pengkajianaskep_id\");
											$(\"#ASPengkajianaskepT_no_pengkajian\").val(\"$data->no_pengkajian\");
											$(\"#ASPengkajianaskepT_pengkajianaskep_tgl\").val(\"$data->pengkajianaskep_tgl\");
											$(\"#ASPengkajianaskepT_pegawai_id\").val(\"{$data->pegawai_id}\");
											$(\"#ASPengkajianaskepT_nama_pegawai\").val(\"{$data->nama_pegawai}\");
											loadPasien($data->pendaftaran_id);
                                        "))',
		),
		array(
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->no_pengkajian',
		),
		array(
			'name' => 'no_pendaftaran',
			'type' => 'raw',
			'value' => '$data->no_pendaftaran',
		),
		array(
			'name' => 'pengkajianaskep_tgl',
			'type' => 'raw',
			'value' => '$data->pengkajianaskep_tgl',
		),
		array(
			'name' => 'ruangan_nama',
			'type' => 'raw',
			'value' => '$data->ruangan_nama',
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->nama_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPengkajianKeb',
	'options' => array(
		'title' => 'Pencarian Pengkajian Kebidanan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 540,
		'resizable' => false,
	),
));
$modPengkajianAskep = new ASInfopengkajiankebidananV('searchInformasi');
$modPengkajianAskep->unsetAttributes();
if (isset($_GET['ASPengkajianaskepT'])) {
	$modPengkajianAskep->attributes = $_GET['ASPengkajianaskepT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran-t-grid',
	'dataProvider' => $modPengkajianAskep->searchInformasi(),
	'filter' => $modPengkajianAskep,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPengkajian",
                                        "onClick" => "
                                            $(\"#dialogPengkajianKeb\").dialog(\"close\");
											$(\"#ASPengkajianaskepT_pengkajianaskep_id\").val(\"$data->pengkajianaskep_id\");
											$(\"#ASPengkajianaskepT_no_pengkajian_keb\").val(\"$data->no_pengkajian\");
											$(\"#ASPengkajianaskepT_pengkajianaskep_tgl\").val(\"$data->pengkajianaskep_tgl\");
											$(\"#ASPengkajianaskepT_pegawai_id\").val(\"{$data->pegawai_id}\");
											$(\"#ASPengkajianaskepT_nama_pegawai\").val(\"{$data->nama_pegawai}\");
											loadPasien($data->pendaftaran_id);
                                        "))',
		),
		array(
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->no_pengkajian',
		),
		array(
			'name' => 'no_pendaftaran',
			'type' => 'raw',
			'value' => '$data->no_pendaftaran',
		),
		array(
			'name' => 'pengkajianaskep_tgl',
			'type' => 'raw',
			'value' => '$data->pengkajianaskep_tgl',
		),
		array(
			'name' => 'ruangan_nama',
			'type' => 'raw',
			'value' => '$data->ruangan_nama',
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->nama_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>