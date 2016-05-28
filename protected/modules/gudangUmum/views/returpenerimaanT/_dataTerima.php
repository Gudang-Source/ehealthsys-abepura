<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modTerima, 'nopenerimaan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    if (!empty($id)) echo CHtml::activeTextField($modTerima, 'nopenerimaan', array('readonly'=>true));
                    else {
                        $this->widget('MyJuiAutoComplete', array(
                            'name'=>'nopenerimaan',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.$this->createUrl('loadPenerimaan').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term
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
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                        loadTerima(ui.item.value);
                                    }',
                            ),
                            'htmlOptions'=>array(
                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPenerimaan'),
                        ));
                    }
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modTerima, 'tglterima', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modTerima, 'tglterima', array('readonly'=>true))
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modTerima, 'sumberdana_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modTerima, 'sumberdana_id', array('readonly'=>true, 'value'=>empty($modTerima->sumberdana_id)?null:$modTerima->sumberdana->sumberdana_nama))
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>


<?php


//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPenerimaan',
    'options'=>array(
        'title'=>'Daftar Terima Barang',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>620,
        'resizable'=>false,
    ),
));
$format = new MyFormatter();
$terima = new GUTerimapersediaanT('search');
$terima->unsetAttributes();
if(isset($_GET['GUTerimapersediaanT'])){
    $terima->attributes = $_GET['GUTerimapersediaanT'];
}

$provider = $terima->searchInformasi();
$provider->sort->defaultOrder = 'tglterima desc';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'terima-barang-grid',
	'dataProvider'=>$provider,
	'filter'=>$terima,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#dialogPenerimaan\').dialog(\'close\');
                                        loadTerima(".$data->terimapersediaan_id.")
                                        return false;"
                                        ))',
                ),
            array(
                'header'=>'No. Penerimaan',
                'name'=>'nopenerimaan'
            ),
            array(
                'header'=>'Tgl. Terima',
                'name'=>'tglterima',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tglterima)',
            ),
            array(
                'header'=>'Sumber Dana',
                'name'=>'sumberdana_id',
                'type'=>'raw',
                'value'=>function($data) {
                    $sd = SumberdanaM::model()->findByPk($data->sumberdana_id);
                    if (empty($sd)) return "-";
                    return $sd->sumberdana_nama;
                //'empty($data->sumberdana)?"-":$data->sumberdana->sumberdana_nama',
                },
                'filter'=>CHtml::activeDropDownList($terima, 'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAllByAttributes(array(
                        'sumberdana_aktif'=>true,
                )), 'sumberdana_id', 'sumberdana_nama'), array('empty'=>'-- Pilih --')),
            ),
                        /*
            array(
                'header'=>'Total Terima',
                'name'=>'totalharga',
                'value'=>'MyFormatter::formatNumberForPrint($data->totalharga)',
                'htmlOptions'=>array(
                    'style'=>'text-align: right',
                )
            ) */
                    //'sumberdana.sumberdana_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>

<script>

function loadTerima(id)
{
    $.post('<?php echo $this->createUrl('loadPenerimaanID'); ?>', {
        id: id
    }, function(data)
    {
        $("#tableDetailBarang tbody").empty().html(data.tab);
        $("#nopenerimaan").val(data.data.nopenerimaan);
        $("#GUReturpenerimaanT_terimapersediaan_id").val(data.data.terimapersediaan_id);
        $("#TerimapersediaanT_tglterima").val(data.data.tglterima);
        $("#TerimapersediaanT_sumberdana_id").val(data.data.sumberdana_id);
        
        hitungRetur();
        
    }, 'json');
}

</script>