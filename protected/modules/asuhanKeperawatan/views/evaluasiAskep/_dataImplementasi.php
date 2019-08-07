<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));          ?>
<div class="white-container">
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeLabel($modImpl, 'no_implementasi', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (!empty($modImpl->rencanaaskep_id)) {
                                                echo CHtml::hiddenField('ASImplementasiaskepT[implementasiaskep_id]', $modImpl->implementasiaskep_id, array('readonly' => true));
						echo CHtml::textField('ASImplementasiaskepT[no_implementasi]', $modImpl->no_implementasi, array('readonly' => true));
					} else {
						echo CHtml::hiddenField('ASImplementasiaskepT[implementasiaskep_id]', $modImpl->implementasiaskep_id, array('readonly' => true));
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'ASImplementasiaskepT[no_implementasi]',
							'value' => $modImpl->no_implementasi,
							'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('AutocompleteImplementasi') . '",
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
                                                cekImplementasiId(ui.item.implementasiaskep_id);
                                                return false;
                                            }',
							),
							'tombolDialog' => array('idDialog' => 'dialogImplKep', 'idTombol' => 'tombolImplDialog'),
							'htmlOptions' => array('class' => 'span2',
								'placeholder' => 'Ketik No. Implementasi', 'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
					}
					?>
				</div>
			</div>
		</div>
		<div class="span3">
			<div class="control-group">
				<?php echo $form->labelEx($modImpl, 'implementasiaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php echo CHtml::textField('ASImplementasiaskepT[implementasiaskep_tgl]', $modImpl->implementasiaskep_tgl, array('readonly' => true,'class'=>'span2')); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Nama pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->hiddenField($modImpl, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
					<?php echo CHtml::textField('ASImplementasiaskepT[nama_pegawai]', $modImpl->nama_pegawai, array('readonly' => true)); ?>
				</div>
			</div>
		</div>
		<div class="span1">
			<div class="control-group">
				<div class="controls">
					 <?php echo CHtml::link("<i class=icon-form-detail></i>", 'javasacript:void(0)', array("rel" => "tooltip",
																						 "title" => "Klik untuk melihat detail",
																						 "target" => "frameDetail",
																						 "onclick" => "cekImplementasi(this);",
																					 ));
//					echo CHtml::link(Yii::t('mds',array('{icon}'=>"<i class=\'icon-form-detail\'></i> ")), Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian", array("pengkajianaskep_id" => $modImpl->pengkajianaskep_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pengkajian Keperawatan", "onclick" => "window.parent.$(\'#dialogDetail\').dialog(\'open\')")); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogImplKep',
	'options' => array(
		'title' => 'Pencarian Implementasi Keperawatan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 540,
		'resizable' => false,
	),
));
$modImplAskep = new ASImplementasiaskepT('search');
$modImplAskep->unsetAttributes();
$modImplAskep->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['ASImplementasiaskepT'])) {
	$modImplAskep->attributes = $_GET['ASImplementasiaskepT'];
        $modImplAskep->no_rencana = $_GET['ASImplementasiaskepT']['no_rencana'];
	$modImplAskep->nama_pegawai = $_GET['ASImplementasiaskepT']['nama_pegawai'];
        $modImplAskep->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran-t-grid',
	'dataProvider' => $modImplAskep->searchImplementasiKeperawatan(),
	'filter' => $modImplAskep,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectImpl",
                                        "onClick" => "
                                            $(\"#dialogImplKep\").dialog(\"close\");
                                            cekImplementasiId($data->implementasiaskep_id);
                                        "))',
		),
		array(
			'name' => 'no_implementasi',
			'type' => 'raw',
			'value' => '$data->no_implementasi',
                    'filter' => Chtml::activeTextField($modImplAskep,'no_implementasi', array('class'=>'angkahuruf-only'))
		),
		array(
			'name' => 'no_rencana',
			'type' => 'raw',
			'value' => '$data->rencanaaskep->no_rencana',
                        'filter' => Chtml::activeTextField($modImplAskep,'no_rencana', array('class'=>'angkahuruf-only'))
		),		              
		array(
			'name' => 'implementasiaskep_tgl',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->implementasiaskep_tgl)',
                        'filter'=>$this->widget('MyDateTimePicker', array(
                                'model'=>$modImplAskep, 
                                'attribute'=>'implementasiaskep_tgl', 
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
                        'filter' => Chtml::activeDropDownList($modImplAskep, 'ruangan_id', Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE Order BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --'))
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->pegawai->nama_pegawai',
                        'filter' => Chtml::activeTextField($modImplAskep,'nama_pegawai', array('class'=>'hurufs-only'))
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