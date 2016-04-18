<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class = "span4">
        <?php echo $form->hiddenField($model,'pesanobatalkes_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'tglmutasioa',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php
            if(isset($_GET['mutasioaruangan_id'])){
                echo $form->textFieldRow($model,'nomutasioa',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
            }
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi Tujuan', 'instalasitujuan_id', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'instalasitujuan_id', $instalasiTujuans, 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'ruangantujuan_id'),
                                )));?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model,'ruangantujuan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class = "span4">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegawaimengetahui_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawaimengetahui_id',array('readonly'=>true)); ?>
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
                            $("#'.CHtml::activeId($model, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'pegawaimengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'totalharganettomutasi',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'totalhargajual',array('readonly'=>true,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class = "span4">
        <?php echo $form->textAreaRow($model,'keteranganmutasi',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>


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
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new GFPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['GFPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchDialog(),
	'filter'=>$modPegawaiMengetahui,
        //'template'=>"{items}\n{pager}",
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
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
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
