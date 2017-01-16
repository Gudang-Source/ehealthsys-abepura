<?php 
if (isset($modDetail)){
echo $form->errorSummary($modDetail); 
}
?>
<?php if ($model->isNewRecord) { ?>
<div id="formDetailBarang">
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <label class='control-label'>Barang</label>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('idBarang'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'namaBarang',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutoCompleteBarang') . '",
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
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                'select' => 'js:function( event, ui ) {
                                                    $("#idBarang").val(ui.item.barang_id); 
                                                    return false;
                                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span2 custom-only',
                                'placeholder'=>'Ketikan nama barang',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogBarang', 'idTombol'=>'tombolDialogBarang'),
                        ));
                        ?>

                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class='control-label'>Jumlah</label>
                    <div class="controls">
                        <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)",'style' => 'text-align:right;')); ?>                
                        <?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                array('onclick' => 'inputBarang();return false;',
                                    'class' => 'btn btn-primary',
                                    'onkeypress' => "inputBarang();return $(this).focusNextInputField(event)",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan Barang",));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
    <?php } ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang <span id="dialog_ruangan"></span> ',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modBarang = new GUInformasistokbarangV('searchBarangRuangan');//GUBarangM('search')
$modBarang->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GUInformasistokbarangV'])){
    $modBarang->attributes = $_GET['GUInformasistokbarangV'];
}   

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->searchBarangRuangan(),
    'filter'=>$modBarang,
       // 'template'=>"{items}\n{pager}",
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        ////'barang_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#idBarang\').val(\'$data->barang_id\');
                                        $(\'#namaBarang\').val(\'$data->barang_nama\');
                                        $(\'#satuan\').val(\'$data->barang_satuan\');
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"))',
        ),
        array(
            'header' => 'Tipe Barang',
            'name' => 'barang_type',
            'filter' => CHtml::activeHiddenField($modBarang, 'ruangan_id', array('class'=>'dialog_ruangan_id')).CHtml::dropDownList('GUBarangM[barang_type]',$modBarang->barang_type,LookupM::getItems('barangumumtype'),array('empty'=>'-- Pilih --')),    
            'value' => '$data->barang_type',
        ),
        'barang_kode',
        'barang_nama',
        'barang_merk',        
        array(
            'name'=>'barang_satuan',
            'filter'=> CHtml::dropDownList('GUBarangM[barang_satuan]',$modBarang->barang_satuan,LookupM::getItems('satuanbarang'),array('empty'=>'--Pilih--')),
            'value'=>'$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_ekonomis_thn',
//        'barang_namalainnya',
        
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php 
$urlAjax = $this->createUrl('AjaxGetPesanBarang');
$notif = Yii::t('mds','Do You want to cancel?');
$js = <<< JS
    function inputBarang(){
        idBarang = $('#idBarang').val();
        jumlah = $('#jumlah').val();
        satuan = $('#satuan').val();

        if (!jQuery.isNumeric(idBarang)){
            myAlert('Isi Barang yang akan dipesan');
            return false;
        }
        else if (!jQuery.isNumeric(jumlah)){
            myAlert('Isi jumlah barang yang akan dipesan');
            return false;
        }
        else{
            if (cekList(idBarang) == true){
                $.post('${urlAjax}', {idBarang:idBarang, jumlah:jumlah, satuan:satuan}, function(data){
                    $('#tableDetailBarang tbody').append(data);
                    $("#tableDetailBarang tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    clear();
                    renameInput();
                }, 'json');
            }
        }
        
    }
            
    function cekList(id){
        x = true;
        $('.barang').each(function(){
            if ($(this).val() == id){
                myAlert('Barang telah ada di daftar');
                clear();
                x = false;
            }
        });
        return x;
    }
    
    function clear(){
        $('#formDetailBarang').find('input, select').each(function(){
            $(this).val('');
        });
        $('#jumlah').val(1);
    }
    
    function batal(obj){
        myConfirm('Apakah anda akan menghapus barang?', 'Perhatian!', function(r)
        {
            if(r){
                $(obj).parent().parent().remove();
            }
        });
        
        renameInput();
    }
    function renameInput(){
        urutan = 0;
        $('.barang').each(function(){
            $(this).parents('tr').find('[name*="PesanbarangdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('PesanbarangdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','PesanbarangdetailT['+urutan+']'+data[1]);
                }
            });
            urutan++;
        });        
    }
JS;
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_HEAD);
?>

<?php 
Yii::app()->clientScript->registerScript('onready','
    $("form").submit(function(){
        pesan = false;
        idRuangan = $("#'.CHtml::activeId($model, 'ruanganpemesan_id').'").val();
        idPemesan = $("#'.CHtml::activeId($model, 'pegpemesan_id').'").val();
            
        $(".pesan").each(function(){
            if ($(this).val() > 0){
                pesan = true
            }
        });
        
        if(!jQuery.isNumeric(idRuangan)){
            //myAlert("'.CHtml::encode($model->getAttributeLabel('ruanganpemesan_id')).' harus diisi");
            myAlert("Silakan isi kolom yang bertanda *!");
            idRuangan.focus();
            return false;
        }
        else if (!jQuery.isNumeric(idPemesan)){
            //myAlert("'.CHtml::encode($model->getAttributeLabel('pegpemesan_id')).' harus diisi");
            myAlert("Silakan isi kolom yang bertanda *");
            // idPemesan.focus();
            return false;
        }
        
        if ($(".cancel").length < 1){
            myAlert("Barang yang dipesan belum ditambahkan");
            namaBarang.focus();
            return false;
        }
        else if (pesan == false){
            myAlert("'.CHtml::encode($model->getAttributeLabel('qty_pesan')).' harus memiliki nilai yang lebih dari 0");
            return false;
        }else{
            return requiredCheck(this);
        }
    });
',CClientScript::POS_READY);?>