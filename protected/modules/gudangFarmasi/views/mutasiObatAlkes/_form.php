<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class = "span4">
        <div class="control-group ">
            <?php echo CHtml::label("No Pemesanan ", 'nopemesanan', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modPemesanan,
                    'attribute' => 'nopemesanan',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteNoPemesanan') . '",
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
                            $("#'.CHtml::activeId($modPemesanan, 'nopemesanan') . '").val(ui.item.nopemesanan);
                            $("#'.CHtml::activeId($modPemesanan, 'tglpemesanan') . '").val(ui.item.tglpemesanan);
                            $("#'.CHtml::activeId($modPemesanan, 'ruanganpemesan_id') . '").val(ui.item.ruanganpemesan_id);
                            $("#'.CHtml::activeId($modPemesanan, 'ruanganpemesan_nama') . '").val(ui.item.ruanganpemesan_nama);
                            $("#'.CHtml::activeId($modPemesanan, 'pegawaipemesan_id') . '").val(ui.item.pegawaipemesan_id);
                            $("#'.CHtml::activeId($modPemesanan, 'pegawaipemesan_nama') . '").val(ui.item.pegawaipemesan_nama);
                            $("#'.CHtml::activeId($model, 'pesanobatalkes_id') . '").val(ui.item.pesanobatalkes_id);
                            submitMutasi();
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class'=>'nopsn',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modPemesanan, 'nopemesanan') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPemesanan'),
                ));
                ?>
                <?php //echo $form->hiddenField($modPemesanan, 'nopemesanan',array('readonly'=>true)); ?>

            </div>
        </div>

    </div>

    <div class="span4">
        <?php echo $form->textFieldRow($modPemesanan, 'tglpemesanan',array('readonly'=>true, 'class'=>'span3')); ?>
    </div>
    
    <div class = "span4">
        <?php echo $form->hiddenField($modPemesanan, 'ruanganpemesan_id',array('readonly'=>true)); ?>
        <?php echo $form->textFieldRow($modPemesanan, 'ruanganpemesan_nama',array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($modPemesanan, 'pegawaipemesan_id',array('readonly'=>true)); ?>
        <?php echo $form->textFieldRow($modPemesanan, 'pegawaipemesan_nama',array('readonly'=>true)); ?>
    </div>
</div>

<hr/>
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
    'id'=>'dialogPemesanan',
    'options'=>array(
        'title'=>'Pencarian Data Pemesanan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPesan = new InformasipesanobatalkesV('search');
$modPesan->unsetAttributes();
$modPesan->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['InformasipesanobatalkesV'])) {
    $modPesan->attributes = $_GET['InformasipesanobatalkesV'];
    $modPesan->ruanganpemesan_id = $_GET['InformasipesanobatalkesV']['ruanganpemesan_id'];
    $modPesan->pegawaipemesan_id = $_GET['InformasipesanobatalkesV']['pegawaipemesan_id'];
}
$provider = $modPesan->search();
$provider->criteria->addCondition('mutasioaruangan_id is null');
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'nopemesanan-grid',
	'dataProvider'=>$provider,
	'filter'=>$modPesan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                    "href"=>"",
                                    "id" => "selectNopemesanan",
                                    "onClick" => "$(\"#'.CHtml::activeId($modPemesanan,'nopemesanan').'\").val(\"$data->nopemesanan\");
                                                  $(\"#'.CHtml::activeId($modPemesanan,'tglpemesanan').'\").val(\"".MyFormatter::formatDateTimeForUser($data->tglpemesanan)."\");
                                                  $(\"#'.CHtml::activeId($modPemesanan,'ruanganpemesan_id').'\").val(\"$data->ruanganpemesan_id\");
                                                  $(\"#'.CHtml::activeId($modPemesanan,'ruanganpemesan_nama').'\").val(\"$data->ruanganpemesan_nama\");
                                                  $(\"#'.CHtml::activeId($modPemesanan,'pegawaipemesan_id').'\").val(\"$data->pegawaipemesan_id\");
                                                  $(\"#'.CHtml::activeId($modPemesanan,'pegawaipemesan_nama').'\").val(\"$data->pegawaipemesan_nama\");
                                                  $(\"#'.CHtml::activeId($model,'pesanobatalkes_id').'\").val(\"$data->pesanobatalkes_id\");
                                                  $(\"#'.CHtml::activeId($model,'instalasitujuan_id').'\").val(\"$data->instalasipemesan_id\");
                                                  $(\"#'.CHtml::activeId($model,'ruangantujuan_id').'\").val(\"$data->ruanganpemesan_id\");
                                                  listRuangan(\"$data->instalasipemesan_id\",\"$data->ruanganpemesan_id\");
                                                  submitMutasi();                                                  
                                                  $(\"#dialogPemesanan\").dialog(\"close\");
                                                  return false;
                                        "))',
                ),
                array(
                  'name'=>'tglpemesanan',
                  'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemesanan)',
                  'filter'=>false
                  ),
                'nopemesanan',
                array(
                  'header'=>'Ruangan Pemesan',
                  'name'=>'ruanganpemesan_id',
                  'value'=>'$data->ruanganpemesan_nama',
                  'filter'=>CHtml::activeDropDownList($modPesan,'ruanganpemesan_id',CHtml::listData(RuanganM::model()->findAll(array('condition'=>'ruangan_aktif = true','order'=>'ruangan_nama')),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'ruanganPemesan'))
                ),
                array(
                  'name'=>'pegawaipemesan_id',
                  'value'=>'$data->pegawaipemesan_nama',
                  'filter'=>CHtml::activeDropDownList($modPesan,'pegawaipemesan_id',CHtml::listData(PegawaiM::model()->findAll(array('condition'=>'pegawai_aktif = true','order'=>'nama_pegawai')),'pegawai_id','nama_pegawai'),array('empty'=>'-- Pilih --'))
                ),
                'keterangan_pesan'
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
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
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new GFPegawaiV('searchDialogMengetahui');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');

if(isset($_GET['GFPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchDialogMengetahui(),
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
                ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
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
$urlGetMutasi =  $this->createUrl('getPesanObatAlkesDariMutasi');
$jscript = <<< JS
function submitMutasi()
{
    idPesanobatalkes = $('#GFMutasioaruanganT_pesanobatalkes_id').val();
        if(idPesanobatalkes==''){
            alert('Silahkan Pilih No.Pemesanan Terlebih Dahulu');
        }else{
            $("#table-mutasidetail tbody tr").remove();
            $.post("${urlGetMutasi}", { idPesanObatAlkes: idPesanobatalkes },
            function(data){
                //if (typeof data.stok == "undefined") {
                //  myAlert(data.pesan);
               //}
                //else{
                $('.labelTotal').html('Total');
                $('#table-mutasidetail').append(data.tr);
                $("#table-mutasidetail tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                renameInputRowObatAlkes($("#table-mutasidetail"));
                hitungTotal();                
              //}
            }, "json");
        }

        instalasiId = $('#GFMutasioaruanganT_instalasitujuan_id').val();
        
}
JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
?>
<script>
function listRuangan(instalasi_id, ruangan_id)
{
	$.ajax({
		type:'POST',
		url:'<?php echo Yii::app()->createUrl('ActionDynamic/ListRuangan/'); ?>',
		data: {instalasi_id: instalasi_id, ruangan_id: ruangan_id},//
		dataType: "json",
		success:function(data){
			$('#GFMutasioaruanganT_ruangantujuan_id').html(data.listRuangan);
                        
                        $('#GFMutasioaruanganT_ruangantujuan_id').val(data.ruangan_id);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});	
}
</script>