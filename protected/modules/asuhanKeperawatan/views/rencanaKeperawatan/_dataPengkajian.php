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
				<?php echo CHtml::label('No. Pengkajian Keperawatan <font style="color:red">*</font>', 'no_pengkajian', array('class' => 'control-label')); ?>
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
                                                       url: "' . $this->createUrl('Autocompletepengkajiankep') . '",
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
                                                        cekPengkajianId(ui.item.pengkajianaskep_id);
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
				<?php echo CHtml::label('No. Pengkajian Kebidanan  <font style="color:red">*</font>', 'no_pengkajian', array('class' => 'control-label')); ?>
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
                                                       url: "' . $this->createUrl('Autocompletepengkajiankeb') . '",
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
                                                cekPengkajianId(ui.item.pengkajianaskep_id);
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
$modPengkajianAskep = new ASPengkajianaskepT('searchInformasi');//ASInfopengkajianaskepV
$modPengkajianAskep->unsetAttributes();
$modPengkajianAskep->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['ASPengkajianaskepT'])) {
	$modPengkajianAskep->attributes = $_GET['ASPengkajianaskepT'];
        $modPengkajianAskep->no_pendaftaran = $_GET['ASPengkajianaskepT']['no_pendaftaran'];
        $modPengkajianAskep->nama_pegawai = $_GET['ASPengkajianaskepT']['nama_pegawai'];
        $modPengkajianAskep->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran-t-grid',
	'dataProvider' => $modPengkajianAskep->searchPengkajian(),
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
                                            cekPengkajianId($data->pengkajianaskep_id);
                                        "))',
		),
		array(
                        'header' => 'No Pengkajian',
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->no_pengkajian',
                        'filter' => Chtml::activeTextField($modPengkajianAskep,'no_pengkajian', array('class'=>'angkahuruf-only'))
		),
		array(
                        'header' => 'No Pendaftaran',
			'name' => 'no_pendaftaran',
			'type' => 'raw',
			'value' => '$data->pendaftaran->no_pendaftaran',
                        'filter' => Chtml::activeTextField($modPengkajianAskep,'no_pendaftaran', array('class'=>'angkahuruf-only'))
		),
		array(
			'header' => 'Tgl Pengkajian Keperawatan',
                        'name' => 'pengkajianaskep_tgl',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->pengkajianaskep_tgl)',
                        'filter'=>$this->widget('MyDateTimePicker', array(
                                'model'=>$modPengkajianAskep, 
                                'attribute'=>'pengkajianaskep_tgl', 
                                'mode' => 'date',    
                                //'language' => 'ja',
                                // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                'htmlOptions' => array(
                                    'id' => 'datepicker_for_due_date',
                                    'size' => '10',
                                    'style'=>'width:80%',                                    
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
                        'filter' => Chtml::activeDropDownList($modPengkajianAskep, 'ruangan_id', Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE Order BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --','disable'=>TRUE))
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->pegawai->nama_pegawai',
                        'filter' => Chtml::activeTextField($modPengkajianAskep,'nama_pegawai', array('class'=>'hurufs-only'))
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . 'reinstallDatePicker();'
    . '$(".hurufs-only").keyup(function() {
        setHurufsOnly(this);        
    });
    $(".angkahuruf-only").keyup(function() {
        setAngkaHurufsOnly(this);});'
    . '}',
));

$this->endWidget();
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
    $('#datepicker_for_due_date1').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
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
$modPengkajianKeb = new ASPengkajianaskepT('searchInformasi');//ASInfopengkajiankebidananV
$modPengkajianKeb->unsetAttributes();
$modPengkajianKeb->ruangan_id = Params::RUANGAN_ID_BERSALIN;
if (isset($_GET['ASPengkajianaskepT'])) {
	$modPengkajianKeb->attributes = $_GET['ASPengkajianaskepT'];
        $modPengkajianKeb->no_pendaftaran = $_GET['ASPengkajianaskepT']['no_pendaftaran'];
        $modPengkajianKeb->nama_pegawai = $_GET['ASPengkajianaskepT']['nama_pegawai'];
        $modPengkajianKeb->ruangan_id = Params::RUANGAN_ID_BERSALIN;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pendaftaran1-t-grid',
	'dataProvider' => $modPengkajianKeb->searchPengkajianKebidanan(),
	'filter' => $modPengkajianKeb,
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
                                            cekPengkajianId($data->pengkajianaskep_id);
                                        "))',
		),
		array(
                        'header' => 'No Pengkajian',
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->no_pengkajian',
                        'filter' => Chtml::activeTextField($modPengkajianKeb,'no_pengkajian', array('class'=>'angkahuruf-only'))
		),
		array(
                        'header' => 'No Pendaftaran',
			'name' => 'no_pendaftaran',
			'type' => 'raw',
			'value' => '$data->pendaftaran->no_pendaftaran',
                        'filter' => Chtml::activeTextField($modPengkajianKeb,'no_pendaftaran', array('class'=>'angkahuruf-only'))
		),
		array(
			'header' => 'Tgl Pengkajian Keperawatan',
                        'name' => 'pengkajianaskep_tgl',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->pengkajianaskep_tgl)',
                        'filter'=>$this->widget('MyDateTimePicker', array(
                                'model'=>$modPengkajianKeb, 
                                'attribute'=>'pengkajianaskep_tgl', 
                                'mode' => 'date',    
                                //'language' => 'ja',
                                // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                'htmlOptions' => array(
                                    'id' => 'datepicker_for_due_date1',
                                    'size' => '10',
                                    'style'=>'width:80%',                                    
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
                        'filter' => Chtml::activeDropDownList($modPengkajianKeb, 'ruangan_id', Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE Order BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --','disable'=>TRUE))
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->pegawai->nama_pegawai',
                        'filter' => Chtml::activeTextField($modPengkajianKeb,'nama_pegawai', array('class'=>'hurufs-only'))
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . 'reinstallDatePicker();'
    . '$(".hurufs-only").keyup(function() {
        setHurufsOnly(this);        
    });
    $(".angkahuruf-only").keyup(function() {
        setAngkaHurufsOnly(this);});'
    . '}',
));
$this->endWidget();
////======= end pendaftaran dialog =============
?>