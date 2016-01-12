<div class="row-fluid">
    <div class="span4">
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pesanperlinensteril_tgl', array('class' => 'control-label')) ?>
                    <div class="controls">
                            <?php
                            $model->pesanperlinensteril_tgl = !empty($model->pesanperlinensteril_tgl) ? $format->formatDateTimeForUser($model->pesanperlinensteril_tgl) : date('d M Y');
                            $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'pesanperlinensteril_tgl',
                                    'mode' => 'date',
                                    'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
//						'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                            ));
                            $model->pesanperlinensteril_tgl = !empty($model->pesanperlinensteril_tgl) ? $format->formatDateTimeForDb($model->pesanperlinensteril_tgl) : date('Y-m-d');
                            ?>
                            <?php echo $form->error($model, 'pesanperlinensteril_tgl'); ?>
                    </div>
            </div>
            <?php echo $form->textFieldRow($model,'pesanperlinensteril_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
    <?php 
    if ($ruangan_id == $ruangan_cssd) { 
    ?>	
            <div class="control-group ">
                    <?php echo CHtml::label('Instalasi','Instalasi', array('class'=>'control-label')) ?>
                    <div class="controls">
                    <?php echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(),'instalasi_id','instalasi_nama'),
                                    array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                    'ajax'=>array('type'=>'POST',
                                                                            'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                                                            'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                                                    )));?>
                    </div>
            </div>
            <div class="control-group ">
                    <?php echo CHtml::label('Ruangan','Ruangan', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                            <?php echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
            </div>
    <?php } ?>
    </div>
    <div class="span4">
        <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegpemesan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegpemesan_id',array('readonly'=>true)); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$model,
                                    'attribute' => 'pegawaimemesan_nama',
                                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                               url: "' . $this->createUrl('AutocompletePegawaiMemesan') . '",
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
                                                    $("#'.Chtml::activeId($model, 'pegpemesan_id') . '").val(ui.item.pegawai_id); 
                                                    return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                            'class'=>'pegawaimemesan_nama',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegpemesan_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMemesan'),
                            ));
                            ?>
                    </div>
            </div>
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegmengetahui_id',array('readonly'=>true)); ?>
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
                                                    $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
                                                    return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                            'class'=>'pegawaimengetahui_nama',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                            ));
                            ?>
                    </div>
            </div>
    </div>
    <div class="span4">
        <?php echo $form->textAreaRow($model,'pesanperlinensteril_ket',array('rows'=>4, 'cols'=>100, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<?php 
//========= Dialog buat cari data Pegawai Memesan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMemesan',
    'options'=>array(
        'title'=>'Pencarian Pegawai Memesan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMemesan = new STPegawaiV('searchPegawaiMemesan');
$modPegawaiMemesan->unsetAttributes();
if(isset($_GET['STPegawaiV'])) {
    $modPegawaiMemesan->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimemesan-grid',
	'dataProvider'=>$modPegawaiMemesan->searchPegawaiMemesan(),
	'filter'=>$modPegawaiMemesan,
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
                                                  $(\"#'.CHtml::activeId($model,'pegpemesan_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimemesan_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMemesan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Memesan dialog =============================
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

$modPegawaiMengetahui = new STPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['STPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
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
                                                  $(\"#'.CHtml::activeId($model,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
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