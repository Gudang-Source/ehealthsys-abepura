<legend class="rim">Pilih Barang</legend>
<?php 
if (isset($modDetails)){
echo $form->errorSummary($modDetails); 
}
?>
<?php if (!isset($modPesan)){ ?>
<div id="formDetailBarang">
    <table>
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
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/barang') . '",
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
                                'class' => 'span2',
                                                'placeholder'=>'Ketikan Nama Barang'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogBarang'),
                        ));
                        ?>

                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class='control-label'>Jumlah</label>
                    <div class="controls">
                        <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
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
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modBarang = new GUBarangM('search');
$modBarang->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GUBarangM']))
    $modBarang->attributes = $_GET['GUBarangM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->searchDialog(),
    'filter'=>$modBarang,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
			'name'=>'barang_id',
			'value'=>'$data->barang_id',
			'filter'=>false,
		),
        'bidang.subkelompok.kelompok.golongan.golongan_nama',
        'bidang.subkelompok.kelompok.kelompok_nama',
        'bidang.subkelompok.subkelompok_nama',
        'bidang.bidang_nama',
        'barang_nama',
        array(
            'name'=>'barang_satuan',
            'filter'=>LookupM::getItems('satuanbarang'),
            'value'=>'$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_bahan',
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
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
<?php } ?>
<?php 
$urlAjax = $this->createUrl('getMutasiBarang');
$urlAjaxStok = $this->createUrl('getStokBarang');
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
                    if (data == 'kosong'){
                        myAlert('Stok Kosong');
                    }else{
                        $('#tableDetailBarang tbody').append(data);
                        $("#tableDetailBarang tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                        rename();
                    }
                    clear();
                }, 'json');
            }
        }
        
    }
            
    function cekList(id){
        x = true;
        $('.barang').each(function(){
            if ($(this).val() == id){
                myAlert('Barang telah ada d List');
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
        myConfirm("${notif}",'Perhatian!',function(r){
            if(!r) {
                return false;
            }else{
                $(obj).parents('tr').remove();
                rename();
            }
        });
    }
    function rename(){
        noUrut = 1;
        $('.cancel').each(function(){
            $(this).parents('tr').find('[name*="MutasibrgdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('MutasibrgdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','MutasibrgdetailT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
        });        
    }
    
    function cekStok(obj){
        
        var idBarang = $(obj).parents('tr').find('.barang').val();
        var qty_pesan = $(obj).parents('tr').find('.qty_pesan').val();
        var qty = $(obj).val();
        if (jQuery.isNumeric(qty_pesan)){
            if (qty > qty_pesan){
                myAlert('Jumlah yang dimutasikan tidak boleh lebih besar dari pesanan');
                $(obj).val(0);
                return false;
            }
        }
        $.post('${urlAjaxStok}', {idBarang:idBarang, qty:qty}, function(data){
            if (data == 'kosong'){
                myAlert('Stok Kosong');
                $(obj).val(0);
            }
        }, 'json');
    }
JS;
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_HEAD);
?>

<?php 
Yii::app()->clientScript->registerScript('onready','
    $("form").submit(function(){
        mutasi = false;
        idRuangan = $("#'.CHtml::activeId($model, 'ruangantujuan_id').'").val();
        idPengirim = $("#'.CHtml::activeId($model, 'pegpengirim_id').'").val();
        
        $(".mutasi").each(function(){
            if ($(this).val() > 0){
                mutasi = true
            }
        });
        
        if (!jQuery.isNumeric(idPengirim)){
            myAlert("'.CHtml::encode($model->getAttributeLabel('pegpengirim_id')).' harus diisi");
            return false;
        }
        else if(!jQuery.isNumeric(idRuangan)){
            myAlert("'.CHtml::encode($model->getAttributeLabel('ruangantujuan_id')).' harus diisi");
            return false;
        }
        

        if ($(".cancel").length < 0){
            myAlert("Detail Barang Harus Diisi");
            return false;
        }
        else if (mutasi == false){
            myAlert("'.CHtml::encode($model->getAttributeLabel('qty_mutasi')).' harus memiliki value yang lebih dari 0");
            return false;
        }
    });
',CClientScript::POS_READY);?>