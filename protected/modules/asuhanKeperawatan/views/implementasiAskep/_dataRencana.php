<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));          ?>
<div class="white-container">
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeLabel($modRencana, 'no_rencana', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (!empty($modRencana->rencanaaskep_id)) {
                                                echo CHtml::hiddenField('ASRencanaaskepT[iskeperawatan]', $modRencana->iskeperawatan, array('readonly' => true));
						echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
						echo CHtml::textField('ASRencanaaskepT[no_rencana]', $modRencana->no_rencana, array('readonly' => true));
					} else {
                                                echo CHtml::hiddenField('ASRencanaaskepT[iskeperawatan]', $modRencana->iskeperawatan, array('readonly' => true));
						echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'ASRencanaaskepT[no_rencana]',
							'value' => $modRencana->no_rencana,
							'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('AutocompleteRencana') . '",
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
                                                cekRencanaId(ui.item.rencanaaskep_id);
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
						"onclick" => "cekRencana(this);",
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
$modRencanaAskep->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['ASRencanaaskepT'])) {
	$modRencanaAskep->attributes = $_GET['ASRencanaaskepT'];
        $modRencanaAskep->no_pengkajian = $_GET['ASRencanaaskepT']['no_pengkajian'];
        $modRencanaAskep->nama_pegawai = $_GET['ASRencanaaskepT']['nama_pegawai'];
        $modRencanaAskep->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran-t-grid',
	'dataProvider' => $modRencanaAskep->searchRencanaKeperawatan(),
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
                                                cekRencanaId($data->rencanaaskep_id);
                                        "))',
		),
		array(
			'name' => 'no_rencana',
			'type' => 'raw',
			'value' => '$data->no_rencana',
                        'filter' => Chtml::activeTextField($modRencanaAskep,'no_rencana', array('class'=>'angkahuruf-only'))
		),
		array(
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->pengkajianaskep->no_pengkajian',
                        'filter' => Chtml::activeTextField($modRencanaAskep,'no_pengkajian', array('class'=>'angkahuruf-only'))
		),
		array(
			'name' => 'rencanaaskep_tgl',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->rencanaaskep_tgl)',
                        'filter'=>$this->widget('MyDateTimePicker', array(
                                'model'=>$modRencanaAskep, 
                                'attribute'=>'rencanaaskep_tgl', 
                                'mode' => 'date',    
                                //'language' => 'ja',
                                // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                'htmlOptions' => array(
                                    'id' => 'datepicker_for_due_date',
                                    'size' => '10',
                                    'style'=>'width:80%'
                                ),
                                'options' => array(  // (#3)                    
                                    'dateFormat' => Params::DATE_FORMAT,                    
                                    'maxDate' => 'd',
                                ),
                               
                            ), 
                            true),
		),
		array(
                        'header' =>  'Ruangan',
			'name' => 'ruangan_id',
			'type' => 'raw',
			'value' => '$data->ruangan->ruangan_nama',
                        'filter' => Chtml::activeDropDownList($modRencanaAskep, 'ruangan_id', Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE Order BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --'))
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->pegawai->nama_pegawai',
                        'filter' => Chtml::activeTextField($modRencanaAskep,'nama_pegawai', array('class'=>'hurufs-only'))
		),
	),
	 'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                . ' $(".angkahuruf-only").keyup(function() {
                        setAngkaHurufsOnly(this);
                    });
                    $(".hurufs-only").keyup(function() {
                        setHurufsOnly(this);
                    });
                    reinstallDatePicker();'
                . '}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
?>