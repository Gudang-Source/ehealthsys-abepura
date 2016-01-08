<?php 
$modAmbulans = new MobilambulansM;
$modAmbulans->unsetAttributes();
if(isset($_GET['MobilambulansM'])){
    $modAmbulans->attributes = $_GET['MobilambulansM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'ambulans-t-grid',
    'dataProvider'=>$modAmbulans->search(),
    'filter'=>$modAmbulans,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        //'mobilambulans_id',
        'mobilambulans_kode',
        'nopolisi',
        'jeniskendaraan',
        //'photokendaraan',
        array(
                'header'=>$modAmbulans->getAttributeLabel('photokendaraan'),
                'type'=>'raw',
                'value'=>'CHtml::image(Params::urlKendaraanTumbsDirectory()."kecil_".$data->photokendaraan, "Ambulans ".$data->nopolisi, array());',
        ),
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputKendaraan($data->mobilambulans_id,
                                                        \'$data->nopolisi\',
                                                        \'$data->jeniskendaraan\',
                                                        \'$data->mobilambulans_kode\',
                                                        \'$data->kmterakhirkend\',
                                                        \'$data->isibbmliter\');return false;"))',
        )
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<script type="text/javascript">
function inputKendaraan(idAmbulans,noPol,jenis,kode,kmAwal,isiBbm)
{
    $("#PJPemakaianambulansT_mobilambulans_id").val(idAmbulans);
    $("#PJPemakaianambulansT_mobilambulans_nama").val(kode);
    $("#PJPemakaianambulansT_nopolisi").val(noPol);
    $("#PJPemakaianambulansT_jeniskendaraan").val(jenis);
    $("#PJPemakaianambulansT_kmawal").val(kmAwal);
    $("#PJPemakaianambulansT_jmlbbmliter").val(isiBbm);
    $("#dialogKendaraan").dialog('close');
    $('.currency').each(function(){this.value = formatNumber(this.value)});
    $('.number').each(function(){this.value = formatNumber(this.value)});
}
</script>

    
