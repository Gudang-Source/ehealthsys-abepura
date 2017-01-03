<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'pengperawatanlinen_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'tglpengperawatanlinen', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$model->tglpengperawatanlinen = !empty($model->tglpengperawatanlinen) ? $format->formatDateTimeForUser($model->tglpengperawatanlinen) : date('d M Y');
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tglpengperawatanlinen',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
//						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
				));
				$model->tglpengperawatanlinen = !empty($model->tglpengperawatanlinen) ? $format->formatDateTimeForDb($model->tglpengperawatanlinen) : date('Y-m-d');
				?>
				<?php echo $form->error($model, 'tglpengperawatanlinen'); ?>
			</div>
		</div>
	</div>
	<div class="span4">
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'mengajukan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model, 'mengajukan_id',array('readonly'=>true)); ?>
                        <?php echo $form->textField($model, 'pegawaimengajukan_nama',array('readonly'=>true)); ?>
                            <?php
                           /* $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$model,
                                    'attribute' => 'pegawaimengajukan_nama',
                                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                               url: "' . $this->createUrl('AutocompletePegawaiMengajukan') . '",
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
                                                    $("#'.Chtml::activeId($model, 'mengajukan_id') . '").val(ui.item.pegawai_id); 
                                                    return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                            'class'=>'pegawaimengajukan_nama',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'mengajukan_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengajukan'),
                            ));*/
                            ?>
                    </div>
            </div>
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model, 'mengetahui_id',array('readonly'=>true)); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$model,
                                    'attribute' => 'pegawaimengetahui_nama',
                                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                               url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
                                            'class'=>'pegawaimengetahui_nama',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                            ));
                            ?>
                    </div>
            </div>
	</div>
	<div class="span4">
            <?php echo $form->textAreaRow($model,'keterangan_pengperawatanlinen',array('rows'=>4, 'cols'=>100, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<?php 
//========= Dialog buat cari data Pegawai Mengajukan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengajukan',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengajukan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengajukan = new LAPegawaiV('searchPegawaiMengajukan');
$modPegawaiMengajukan->unsetAttributes();
$modPegawaiMengajukan->pegawai_aktif = true;
if(isset($_GET['LAPegawaiV'])) {
    $modPegawaiMengajukan->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengajukan-grid',
	'dataProvider'=>$modPegawaiMengajukan->searchPegawaiMengajukan(),
	'filter'=>$modPegawaiMengajukan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'mengajukan_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengajukan_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengajukan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                    'name'=>'nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengajukan, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengajukan, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengajukan dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV('pegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->pegawai_aktif = true;
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
    $modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
	$modPegawaiMengetahui->jabatan_id = $_GET['PegawairuanganV']['jabatan_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->pegawaiMengetahui(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
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
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                    'name'=>'nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
				array(
					'header'=>'Jabatan',
					'name'=>'jabatan_id',
					'value'=>function($data) {
						$dat = JabatanM::model()->findByPk($data->jabatan_id);
						return (empty($dat))?"":$dat->jabatan_nama;
					},
					'filter'=>CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', 
						CHtml::listData(JabatanM::model()->findAll(array(
							'condition'=>'jabatan_aktif = true',
							'order'=>'jabatan_nama',
						)),'jabatan_id', 'jabatan_nama'), array(
							'empty'=>'-- Pilih --',
						)),
				), /*
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ), */
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>