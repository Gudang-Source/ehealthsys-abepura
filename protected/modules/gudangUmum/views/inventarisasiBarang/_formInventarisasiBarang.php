<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'invbarang_jenis', array('readonly'=>true,'empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));?>
		<?php echo $form->textFieldRow($model, 'invbarang_no', array('class' => 'span3 ', 'readonly' => true,'onkeyup' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
		<div class="control-group ">
        <?php echo $form->labelEx($model, 'invbarang_tgl', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php   
                $model->invbarang_tgl = (!empty($model->invbarang_tgl) ? date("d/m/Y H:i:s",strtotime($model->invbarang_tgl)) : null);
                $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'invbarang_tgl',
                    'mode'=>'datetime',
                    'options'=> array(
//						'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                    ),
                    'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
        </div>
    </div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'mengetahui_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'mengetahui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Pegawai Mengetahui',
						'class'=>'mengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogMengetahui'),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'petugas1_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'petugas1_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'petugas1_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'petugas1_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Petugas 1',
						'class'=>'petugas1_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'petugas1_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPetugas1'),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'petugas2_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'petugas2_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'petugas2_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'petugas2_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Petugas 2',
						'class'=>'petugas2_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'petugas2_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPetugas2'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'invbarang_totalharga',array('class'=>'span3 integer')); ?>
		<?php echo $form->textFieldRow($model,'invbarang_totalnetto',array('class'=>'span3 integer')); ?>
		<?php echo $form->textAreaRow($model,'invbarang_ket',array('class'=>'span3')); ?>
	</div>
</div>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new GUPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['GUPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GUPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengetahui->searchDialog(),
    'filter'=>$modPegawaiMengetahui,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($model,'mengetahui_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($model,'mengetahui_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogMengetahui\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
			'value'=>'$data->gelardepan',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		),
		array(
			'header'=>'Alamat Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
			'value'=>'$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPetugas1',
    'options'=>array(
        'title'=>'Pencarian Petugas 1',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPetugas1 = new GUPegawaiV('searchDialog');
$modPetugas1->unsetAttributes();
if(isset($_GET['GUPegawaiV'])) {
    $modPetugas1->attributes = $_GET['GUPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPetugas1->searchDialog(),
    'filter'=>$modPetugas1,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($model,'petugas1_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($model,'petugas1_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPetugas1\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPetugas1, 'gelardepan'),
			'value'=>'$data->gelardepan',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugas1, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPetugas1, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		),
		array(
			'header'=>'Alamat Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugas1, 'alamat_pegawai'),
			'value'=>'$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPetugas2',
    'options'=>array(
        'title'=>'Pencarian Petugas 2',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPetugas2 = new GUPegawaiV('searchDialog');
$modPetugas2->unsetAttributes();
if(isset($_GET['GUPegawaiV'])) {
    $modPetugas2->attributes = $_GET['GUPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPetugas2->searchDialog(),
    'filter'=>$modPetugas2,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($model,'petugas2_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($model,'petugas2_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPetugas2\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPetugas2, 'gelardepan'),
			'value'=>'$data->gelardepan',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugas2, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPetugas2, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		),
		array(
			'header'=>'Alamat Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugas2, 'alamat_pegawai'),
			'value'=>'$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>