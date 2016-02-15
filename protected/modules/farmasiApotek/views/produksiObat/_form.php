<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<fieldset>
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->textFieldRow($model,'tglproduksiobt',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'noproduksiobt',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'disabled'=>true)); ?>
                <div class="control-group">
                    <label class="control-label">Nama Obat</label>
                    <div class="controls">
                        <?php // echo CHtml::dropDownList('obatProduksi',null,  CHtml::listData(ObatalkesfarmasiV::model()->findAll(), 'obatalkes_id', 'obatalkes_nama'),array('empty'=>'-- Pilih Obat --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::hiddenField('obatProduksiId');?>
                        <?php echo CHtml::hiddenField('obatProduksiKode');?>
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'name'=>'obatProduksi',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.$this->createUrl('AutoCompleteObat').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   pegawai_id: $("#pegawai_id").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   // 'readonly'=>false,
                                                   'minLength' => 2,
                                                   'select'=>'js:function( event, ui ) {
                                                        $(this).val( ui.item.value);
                                                        $("#obatProduksiId").val(ui.item.obatalkes_id);
                                                        $("#obatProduksiKode").val(ui.item.obatalkes_kode);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array('class'=>'span3 obatProduksi','disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik Nama Obat'),
                                            'tombolDialog'=>array('idDialog'=>'dialogObatalkesM', 'jsFunction'=>'$("#dialogObatalkesM #forRow").val(""); $("#dialogObatalkesM").dialog("open");'), //dialogObatproduksiM akak di switch otomastis jika berdasarkanSupplier di ceklis
                                        )); 
                        ?>
                    </div>
<!--                     <div class="controls"> 
                        <?php echo CHtml::checkBox('berdasarkanDokter', false,array('onclick'=>'setValue();', 'title'=>'Filter Obat Berdasarkan Dokter', 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                        <?php echo $form->label($model,'Cek jika ingin menampilakan obat produksi berdasarkan dokter'); ?>
                    </div> -->
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::label("Tanggal Kadaluarsa<font color='red'> *</font>",'tglkadaluarsa', array('class'=>'control-label inline')) ?>
                    <div class="controls">
			<?php $format = new MyFormatter(); ?>
                        <?php $modObatalkesM->tglkadaluarsa = $format->formatDateTimeForUser($modObatalkesM->tglkadaluarsa); ?>
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                    'model'=>$modObatalkesM,
                                    'attribute'=>'tglkadaluarsa',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'minDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker2', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                            )); ?>
                        <?php $modObatalkesM->tglkadaluarsa = $format->formatDateTimeForDb($modObatalkesM->tglkadaluarsa); ?>
                    </div>
                </div>
                <?php 
                    $criteria = new CDbCriteria();
                    $criteria->addInCondition('kelompokpegawai_id', array(1,3));
                    $criteria->order = 'nama_pegawai';
                    
                    echo $form->dropDownListRow($model,'pegawai_id',CHtml::listData(PegawaiM::model()->findAll($criteria), 'pegawai_id', 'NamaLengkap'),array('onchange'=>'setValue();','empty'=>'-- Pilih Dokter --','class'=>'span3 pegawai_id', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    echo CHtml::hiddenField('dokter_id','',array());
                ?>
            </td>
	    <td>
                <?php echo $form->textAreaRow($model,'keternganprdobat',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	    </td>
        </tr>
    </table>
</fieldset>   
	
<?php 
//========= Dialog buat cari data ObatalkesM=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatalkesM',
    'options'=>array(
        'title'=>'Pencarian Obat Alkes',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatAlkes = new FAObatalkesM('search');
$modObatAlkes->unsetAttributes();
if(isset($_GET['FAObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['FAObatalkesM'];
}
echo CHtml::hiddenField('obatalkes_untuk',0,array('readonly'=>true));
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ObatalkesM-m-grid',
	'dataProvider'=>$modObatAlkes->searchObatFarmasi(),
	'filter'=>$modObatAlkes,
        'template'=>"{items}\n{pager}",
//        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    
                                    "id" => "selectObat",
                                    "onClick" => "
                                               
											   $(\"#obatProduksiId\").val(\"$data->obatalkes_id\");
                                               $(\"#obatProduksiKode\").val(\"$data->obatalkes_kode\");
											   $(\"#obatProduksi\").val(\"$data->obatalkes_nama\");
                                               submitObat(\"$data->obatalkes_id\");
                                                $(\"#dialogObatalkesM\").dialog(\"close\"); 
                                                
                                    "))',
                ),
                array(
                    'header'=>'Kategori Obat',
                    'value'=>'$data->obatalkes_kategori',
                ),
                array(
                    'header'=>'Golongan Obat',
                    'value'=>'$data->obatalkes_golongan',
                ),
                array(
                    'header'=>'Kode Obat',
                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'obatalkes_kode'),
                    'value'=>'$data->obatalkes_kode',
                ),
                array(
                    'header'=>'Nama Obat Alkes',
                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'obatalkes_nama'),
                    'value'=>'$data->obatalkes_nama',
                ),
                array(
                    'header'=>'Sumber Dana',
                    'value'=>'$data->sumberdana->sumberdana_nama',
                ),
                array(
                    'header'=>'Kadar Obat',
                    'value'=>'$data->obatalkes_kadarobat',
                ),
                array(
                    'header'=>'Kemasan Besar',
                    'value'=>'$data->kemasanbesar',
                ),
                array(
                    'header'=>'Kekuatan',
                    'value'=>'$data->kekuatan',
                ),
                array(
                    'header'=>'Jumlah Stok',
                    'value'=>'$data->StokObatRuangan',
                ),
                array(
                    'header'=>'Tgl. Kadaluarsa',
                    'value'=>'$data->tglkadaluarsa',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end ObatalkesM dialog =============================
?>

<?php 
//========= Dialog buat cari data ObatsupplierM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatproduksiM',
    'options'=>array(
        'title'=>'Pencarian Obat Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatAlkesProduksi = new ObatalkesproduksiM('searchDialog');
$modObatAlkesProduksi->unsetAttributes();
$modObatAlkesProduksi->pegawai_id = isset($var['pegawai_id'])?$var['pegawai_id']:'';
if(isset($_GET['ObatalkesproduksiM'])) {
    $modObatAlkesProduksi->attributes = $_GET['ObatalkesproduksiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'ObatproduksiM-m-grid',
        'dataProvider'=>$modObatAlkesProduksi->searchDialog(),
        'filter'=>$modObatAlkesProduksi,
        'template'=>"{items}\n{pager}",
//        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectPasien",
                                    "onClick" => "$(\"#obatProduksiId\").val(\"$data->obatalkesproduksi_id\");
                                                  $(\"#obatProduksi\").val(\"".$data->obatalkes->obatalkes_nama."\");
                                                  $(\"#dokter_id\").val(\"".$data->pegawai_id."\");
                                                  submitObat();
                                                  $(\"#dialogObatproduksiM\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'Dokter / Pegawai',
                    'filter'=>CHtml::activeHiddenField($modObatAlkesProduksi, 'nama_pegawai'),
                    'value'=>'$data->pegawai->NamaLengkap',
                ),
                array(
                    'header'=>'Kategori Obat',
                    'value'=>'$data->obatalkes->obatalkes_kategori',
                ),
                array(
                    'header'=>'Golongan Obat',
                    'value'=>'$data->obatalkes->obatalkes_golongan',
                ),
                array(
                    'header'=>'Kode Obat',
                    'filter'=>  CHtml::activeTextField($modObatAlkesProduksi, 'obatalkes_kode'),
                    'value'=>'$data->obatalkes->obatalkes_kode',
                ),
                array(
                    'header'=>'Nama Obat Alkes',
                    'filter'=>  CHtml::activeTextField($modObatAlkesProduksi, 'obatalkes_nama'),
                    'value'=>'$data->obatalkes->obatalkes_nama',
                ),
                
  ),
        'afterAjaxUpdate' => 'function(id, data){
        $("#ObatproduksiM_pegawai_id").val($("#pegawai_id").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end ObatsupplierM dialog =============================
?>
<script>
    // the subviews rendered with placeholders
    var trBahan=new String(<?php echo CJSON::encode($this->renderPartial('_rowDetailProduksi',array('model'=>$model,'modProduksiDetail'=>$modProduksiDetail,'modObatalkesM'=>$modObatalkesM,'form'=>$form,'removeButton'=>true),true));?>);
    var trBahanFirst=new String(<?php echo CJSON::encode($this->renderPartial('_rowDetailProduksi',array('model'=>$model,'modProduksiDetail'=>$modProduksiDetail,'modObatalkesM'=>$modObatalkesM,'form'=>$form,'removeButton'=>false),true));?>);
    
    function get_qty_a(obj){
        var qty = $(obj).val();
        // alert (qty);
        $(obj).parents("tr").find('input[name$="[qtyproduksi]"]').val(Math.ceil(qty));
    }
    // function pilihDokter(obj){}    
    function pilihDokter(obj){
        $('#obatProduksiId').val("");
        $('#obatProduksi').val("");
        if($(obj).val()){
            $("#obatProduksi").parent().find("a").removeAttr("onclick");
            $("#obatProduksi").parent().find("a").attr("onclick",'$(\"#dialogObatproduksiM\").dialog(\"open\");return false;');
        }
        // }else{
        //     // alert (id);
        //     $("#obatProduksi").parent().find("a").removeAttr("onclick");
        //     $("#obatProduksi").parent().find("a").attr("onclick",'$(\"#dialogObatalkesM\").dialog(\"open\");return false;');
        // }
    }
    
   function submitObat(obatalkes_id)
{
    var obatalkes_untuk = $("#obatalkes_untuk").val();
    var jumlah = 1;
    var dosis = 0;
    $.get('<?php echo Yii::app()->createUrl('farmasiApotek/produksiObat/setFormProduksiDetail'); ?>',{obatalkes_id: obatalkes_id,jumlah: jumlah},function(data){
        if(data.pesan !== ""){
            myAlert(data.pesan);
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatProduksiKode+' '+obatProduksi+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
            insert_notifikasi(params);
            return false;
        }
        if(data.kekuatan == ""){data.kekuatan=0;}
        if(data.kemasanbesar == ""){data.kemasanbesar=0;}
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[obatalkes_id]"]').val(data.detailBahan.obatalkes_id);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[qtyproduksi]"]').val(data.detailBahan.qtyproduksi);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[qtystok]"]').val(data.qtystok);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[satuankecil_id]"]').val(data.satuankecil_id);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[obatalkes_nama]"]').val(data.obatalkes_nama);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[satuankecil_nama]"]').val(data.satuankecil_nama);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[kekuatan]"]').val(data.kekuatan);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[kemasan]"]').val(data.kemasanbesar);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[dosis]"]').val(dosis);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[obatalkes_kode]"]').val(data.obatalkes_kode);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[hargasatuan]"]').val(data.hargasatuan);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[harganetto]"]').val(data.harganetto);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[hpp]"]').val(data.hpp);
        $("#"+obatalkes_untuk).parents('tr').find('input[name$="[stokobatalkes_id]"]').val(data.stokobatalkes_id);
    },"json");
}

    
    function addRowBahan(obj)
    {
        $(obj).parents('table').children('tbody').append(trBahan.replace());
        <?php 
        $attributes = $modProduksiDetail->attributeNames(); 
            foreach($attributes as $i=>$attribute){
                echo "renameInput('FAProduksiobatdetT','$attribute');";
            }
        ?>
        renameInput('FAProduksiobatdetT','obatalkes_kode');
        renameInput('FAProduksiobatdetT','obatalkes_nama');
        renameInput('FAProduksiobatdetT','dosis');
        renameInput('FAProduksiobatdetT','kemasan');
        renameInput('FAProduksiobatdetT','kekuatan');
        renameInput('FAProduksiobatdetT','qtyproduksi');
        renameInput('FAProduksiobatdetT','satuankecil_nama');
        renameInput('FAProduksiobatdetT','stokobatalkes_id');
        renameInput('FAProduksiobatdetT','qtystok');
        
        $(obj).parents('tr').find('input[name$="[obatalkes_nama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
//                                                                                    setTindakan(this, ui.item);
                                                                                    $(this).val(ui.item.value);
                                                                                    $(this).parents("tr").find("input[name$=\"[obatalkes_id]\"]").val(ui.item.obatalkes_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[obatalkes_kode]\"]").val(ui.item.obatalkes_kode);
                                                                                    $(this).parents("tr").find("input[name$=\"[hargasatuan]\"]").val(ui.item.hjaresep);
                                                                                    $(this).parents("tr").find("input[name$=\"[harganetto]\"]").val(ui.item.harganetto);
                                                                                    $(this).parents("tr").find("input[name$=\"[hpp]\"]").val(ui.item.hpp);
                                                                                    $(this).parents("tr").find("input[name$=\"[satuankecil_id]\"]").val(ui.item.satuankecil_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[satuankecil_nama]\"]").val(ui.item.satuankecil_nama);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutoCompleteObat');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
                                                                                
        $(obj).parents('table').find('.integer').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        $(obj).parents('table').find('.float').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":2});
//        renameInputRowObatAlkes($("#tblDetailProduksi"));    
    }
 
    function batalBahan(obj)
    {
        myConfirm('Apakah anda yakin akan membatalkan bahan ini?','Perhatian!',
        function(r){
            if(r){
                $(obj).parents('tr').next('tr').detach();
                $(obj).parents('tr').detach();
                
                <?php 
                $attributes = $modProduksiDetail->attributeNames(); 
                    foreach($attributes as $i=>$attribute){
                        echo "renameInput('FAProduksiobatdetT','$attribute');";
                    }
                ?>
                renameInput('FAProduksiobatdetT','obatalkes_kode');
                renameInput('FAProduksiobatdetT','obatalkes_nama');
                renameInput('FAProduksiobatdetT','dosis');
                renameInput('FAProduksiobatdetT','kemasan');
                renameInput('FAProduksiobatdetT','kekuatan');
                renameInput('FAProduksiobatdetT','qtyproduksi');
                renameInput('FAProduksiobatdetT','satuankecil_nama');
                renameInput('FAProduksiobatdetT','stokobatalkes_id');
                renameInput('FAProduksiobatdetT','qtystok');
            }
        });
    }
    
    function renameInput(modelName,attributeName)
    {
        var trLength = $('#tblDetailProduksi tr').length;
        var i = -1;
        $('#tblDetailProduksi tr').each(function(){
            if($(this).has('input[name$="[obatalkes_id]"]').length){
                i++;
            }
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            $(this).find('input[id="row"]').attr('value',i);
            $(this).find('input[id="row"]').val(i)
            $(this).find('input[name$="[obatalkes_nama]"]').addClass('ui-autocomplete-input');
            $(this).find('input[name$="[obatalkes_nama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
//                                                                                    setTindakan(this, ui.item);
                                                                                    $(this).val(ui.item.value);
                                                                                    $(this).parents("tr").find("input[name$=\"[obatalkes_id]\"]").val(ui.item.obatalkes_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[obatalkes_kode]\"]").val(ui.item.obatalkes_kode);
                                                                                    $(this).parents("tr").find("input[name$=\"[hargasatuan]\"]").val(ui.item.hjaresep);
                                                                                    $(this).parents("tr").find("input[name$=\"[harganetto]\"]").val(ui.item.harganetto);
                                                                                    $(this).parents("tr").find("input[name$=\"[hpp]\"]").val(ui.item.hpp);
                                                                                    $(this).parents("tr").find("input[name$=\"[satuankecil_id]\"]").val(ui.item.satuankecil_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[satuankecil_nama]\"]").val(ui.item.satuankecil_nama);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutoCompleteObat');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
        });
        clear();
    }
    
    function clear(){
        urut = 1;
            $(".noUrut").each(function(){
                    $(this).val(urut);
                     urut++;
                });
    }
    
    function setDialog(obj){
       var obatalkes_untuk = $(obj).parent().parent().find('input').attr('id');
        $("#obatalkes_untuk").val(obatalkes_untuk);
        
//        $("#dialogObatalkesM > div").addClass("animation-loading");
        $("#dialogObatalkesM").dialog("open");
    }    
    
    function hitungQty(obj){
        var dosis = unformatNumber(parseFloat($(obj).parents('tr').find('input[name$="[dosis]"]').val()));
        var kemasan = unformatNumber(parseFloat($(obj).parents('tr').find('input[name$="[kemasan]"]').val()));
        var kekuatan = unformatNumber(parseFloat($(obj).parents('tr').find('input[name$="[kekuatan]"]').val()));
        if(kekuatan > 0)
            var qty = dosis * kemasan / kekuatan;
        else
            var qty = 0;
        $(obj).parents('tr').find('input[name$="[qtyproduksi]"]').val(formatFloat(parseFloat(qty)));
    }
</script>


<?php
$urlGetObatProduksi = Yii::app()->createUrl('actionAjax/getObatProduksi');
//$urlGetObatProduksi = $this->createUrl('farmasiApotek/produksiObat/setFormProduksiDetail');
//                                    Yii::app()->createUrl('rawatJalan/tindakan/daftarTindakan');
$inputObat = CHtml::activeId($model, 'obatProduksi');
$urlGetDokter = Yii::app()->createUrl('actionAjax/getDokter');
$urlHalamanIni = Yii::app()->createUrl($this->route);
$pegawai_id = CHtml::activeId($model, 'pegawai_id');
$obatProduksi = CHtml::activeId($model, 'obatProduksi');

$jscript = <<< JS
function setValue()
{
    id = $('#${pegawai_id}').val();
    pegawai_id = $('#pegawai_id').val();
    $('#${obatProduksi}').val('');
    $('#obatProduksiId').val('');
    if(id == ""){
        $("#berdasarkanDokter").removeAttr("checked");
        myAlert("Anda belum memilih Dokter !");
    }
    
    if($("#berdasarkanDokter").is(":checked")){
        $("#pegawai_id").val(id);
        $("#obatProduksi").removeAttr("onclick");
        $("#obatProduksi").attr("onclick",'$(\"#dialogObatproduksiM\").dialog(\"open\");return false;');
        $.post("${urlGetDokter}", {pegawai_id:id},
        function(data){
           $('#pegawai_id').val(data.pegawai_id);
//         ERROR INPUT number >>  $(".numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
           $.get('${urlHalamanIni}', {pegawai_id:data.pegawai_id}, function(datas){
                $.fn.yiiGridView.update('ObatproduksiM-m-grid', {
                    url: document.URL+'&ObatproduksiM%5Bpegawai_id%5D='+data.pegawai_id,
                }); 
            });

        }, "json");
        
    }else{
        id = "";
        $("#pegawai_id").val(id);
        //switch to dialogObatAlkesM
        $("#${inputObat}").parent().find("a").removeAttr("onclick");
        $("#${inputObat}").parent().find("a").attr("onclick",'$(\"#dialogObatAlkesM\").dialog(\"open\");return false;');
    }
    
    
}

function remove(obj) {
    myConfirm('Apakah anda yakin akan membatalkan bahan ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').remove();
        }
    }); 
}

JS;
Yii::app()->clientScript->registerScript('masukanobat',$jscript, CClientScript::POS_HEAD);
?>
