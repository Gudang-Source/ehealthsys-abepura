<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));          ?>
<div class="white-container">
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeLabel($modRencana, 'no_rencana', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (!empty($modRencana->rencanaaskep_id)) {
						echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
						echo CHtml::textField('ASRencanaaskepT[no_rencana]', $modRencana->no_rencana, array('readonly' => true));
					} else {
						echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'ASRencanaaskepT[no_rencana]',
							'value' => $modRencana->no_rencana,
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
							'tombolDialog' => array('idDialog' => 'dialogRencanaKep', 'idTombol' => 'tombolRencanaDialog'),
							'htmlOptions' => array('class' => 'span2',
								'placeholder' => 'Ketik No. Rencana', 'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
					}
					?>
				</div>
			</div>
		</div>
		<div class="span3">
			<div class="control-group">
				<?php echo $form->labelEx($modRencana, 'rencanaaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php echo CHtml::textField('ASRencanaaskepT[rencanaaskep_tgl]', $modRencana->rencanaaskep_tgl, array('readonly' => true,'class'=>'span2')); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->hiddenField($modRencana, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
					<?php echo CHtml::textField('ASRencanaaskepT[nama_pegawai]', $modRencana->nama_pegawai, array('readonly' => true)); ?>
				</div>
			</div>
		</div>
		<div class="span1">
			<div class="control-group">
				<div class="controls">
					 <?php echo CHtml::link("<i class=icon-form-detail></i>", 'javascript:void(0)', array("rel" => "tooltip",
																						 "title" => "Klik untuk melihat detail",
																						 "target" => "frameDetail",
																						 "onclick" => "cekPengkajian(this);",
																					 ));
//					echo CHtml::link(Yii::t('mds',array('{icon}'=>"<i class=\'icon-form-detail\'></i> ")), Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian", array("pengkajianaskep_id" => $modRencana->pengkajianaskep_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pengkajian Keperawatan", "onclick" => "window.parent.$(\'#dialogDetail\').dialog(\'open\')")); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRencanaKep',
	'options' => array(
		'title' => 'Pencarian Rencana Keperawatan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 540,
		'resizable' => false,
	),
));
$modRencanaAskep = new ASRencanaaskepT('search');
$modRencanaAskep->unsetAttributes();
if (isset($_GET['ASRencanaaskepT'])) {
	$modRencanaAskep->attributes = $_GET['ASRencanaaskepT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran-t-grid',
	'dataProvider' => $modRencanaAskep->search(),
	'filter' => $modRencanaAskep,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectRencana",
                                        "onClick" => "
                                            $(\"#dialogRencanaKep\").dialog(\"close\");
											$(\"#ASRencanaaskepT_rencanaaskep_id\").val(\"$data->rencanaaskep_id\");
											$(\"#ASRencanaaskepT_no_rencana\").val(\"$data->no_rencana\");
											$(\"#ASRencanaaskepT_rencanaaskep_tgl\").val(\"$data->rencanaaskep_tgl\");
											$(\"#ASRencanaaskepT_pegawai_id\").val(\"{$data->pegawai->pegawai_id}\");
											$(\"#ASRencanaaskepT_nama_pegawai\").val(\"{$data->pegawai->nama_pegawai}\");
											loadPasien($data->rencanaaskep_id);
											loadRencanaDet($data->rencanaaskep_id);
                                        "))',
		),
		array(
			'name' => 'no_rencana',
			'type' => 'raw',
			'value' => '$data->no_rencana',
		),
		array(
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->pengkajianaskep->no_pengkajian',
		),
		array(
			'name' => 'rencanaaskep_tgl',
			'type' => 'raw',
			'value' => '$data->rencanaaskep_tgl',
		),
		array(
			'name' => 'ruangan_nama',
			'type' => 'raw',
			'value' => '$data->ruangan->ruangan_nama',
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->pegawai->nama_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>