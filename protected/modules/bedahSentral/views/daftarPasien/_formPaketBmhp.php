<fieldset>
<table>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'name'=>'paketBMHP',
                    'value'=>'',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/PaketBMHP').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           idTipePaket: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                           idKelasPelayanan: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            inputBMHP(ui.item.daftartindakan_id, ui.item.kelompokumur_id);
                            $(this).val(\'\');
                            return false;
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','placeholder'=>'Paket BMHP'),
                    'tombolDialog'=>array('idDialog'=>'dialogPaketBMHP'),
        )); ?>
        </td>
    </tr>
</table>
    
<table class="items table table-striped table-condensed" id="tblInputPaketBhp">
    <thead>
        <tr>
            <th>Nama Tindakan</th>
            <th>Nama Paket BMHP</th>
            <th>Harga</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
            <?php
                $data = '';
                if(count($modViewBmhp) > 0)
                {
                    for($i=0;$i<count($modViewBmhp);$i++)
                    {
                        $modDaftartindakan = DaftartindakanM::model()->findByPk(
                            $modViewBmhp[$i]['daftartindakan_id']
                        );
            ?>
                        <tr>
                            <td>
                                <?php echo $modDaftartindakan->daftartindakan_nama;?>
                            </td>
                            <td>
                                <?php echo $modViewBmhp[$i]['obatalkes']['obatalkes_nama']; ?>
                            </td>
                            <td><?php echo $modViewBmhp[$i]['qty_oa']; ?></td>
                            <td>&nbsp;</td>
                        </tr>
            <?php
                    }
                }
                echo $data;
            ?>        
    </tbody>
</table>
    <div>
        <b>Total BMHP : </b>
        <?php echo CHtml::textField("totHargaBmhp", 0,array('readonly'=>true,'class'=>'inputFormTabel currency')); ?>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Paket BMHP =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPaketBMHP',
    'options'=>array(
        'title'=>'Paket BMHP',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modBMHP = new BSPaketbmhpM('searchPaket');
    $modBMHP->unsetAttributes();    
    if(isset($_GET['BSPaketbmhpM'])) {
        $modBMHP->attributes = $_GET['BSPaketbmhpM'];
        $modBMHP->kelompokumurNama = $_GET['BSPaketbmhpM']['kelompokumurNama'];
        $modBMHP->daftartindakanNama = $_GET['BSPaketbmhpM']['daftartindakanNama'];
    }

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjpaketobat-alkes-m-grid',
    'dataProvider'=>$modBMHP->searchPaket(),
    'filter'=>$modBMHP,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputBMHP($data->daftartindakan_id,$data->kelompokumur_id);return false;"))',
                ),
                array(
                    'header'=>'Daftar Tindakan',
                    'name'=>'daftartindakanNama',
                    'value'=>'$data->daftartindakan->daftartindakan_nama',
                ),
                array(
                    'header'=>'Kelompok Umur',
                    'name'=>'kelompokumurNama',
                    'value'=>'$data->kelompokumur_nama',
                ),
                array(
                    'header'=>'Harga Pemakaian',
                    'name'=>'hargapemakaian',
                    'value'=>'number_format($data->hargapemakaian)',
                ),
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
function inputBMHP(idDaftarTindakan,idKelUmur)
{
    var idPenunjang = <?php echo $_GET['id']; ?> ;
    var ketemu = false;
    $('#tblInputPemakaianBahan').find('input[name$="[daftartindakan_id]"]').each(function(){
        // if($(this).val() == idDaftarTindakan){

            ketemu = true;
            jQuery.ajax({'url':'<?php echo $this->createUrl('addFormPaketBmhp')?>',
                 'data':{idDaftarTindakan:idDaftarTindakan, idKelUmur:idKelUmur, id:idPenunjang },
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         $('#tblInputPaketBhp').append(data.form);
                         urutkanInputBMHP();
                         hitungTotalBMHP();
                 } ,
                 'cache':false});
        // } 
    });
    if(!ketemu) {
        myAlert('Tidak ada tindakan yang dimaksud.');
    }
}
    
function hitungTotalBMHP()
{ 
    var total = 0;
    $('#tblInputPaketBhp').find('input[name$="[hargapemakaian]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totHargaBmhp').val(formatNumber(total));
}

function urutkanInputBMHP()
{
    renameInputBMHP('paketBmhp', 'daftartindakan_id');
    renameInputBMHP('paketBmhp', 'obatalkes_id');
    renameInputBMHP('paketBmhp', 'satuankecil_id');
    renameInputBMHP('paketBmhp', 'sumberdana_id');
    renameInputBMHP('paketBmhp', 'qtypemakaian');
    renameInputBMHP('paketBmhp', 'hargasatuan');
    renameInputBMHP('paketBmhp', 'harganetto');
    renameInputBMHP('paketBmhp', 'hargajual');
    renameInputBMHP('paketBmhp', 'hargapemakaian');
}

function renameInputBMHP(modelName,attributeName)
{
    var i = -1;
    $('#tblInputPaketBhp tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

function hapusBMHP(obj){
    myConfirm("Apakan anda ingin menghapus ini ?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
            urutkanInputBMHP();
            hitungTotalBMHP();
        }
    });
    return false;
}
</script>