<fieldset>
    <legend>
    </legend> 
        <?php $this->widget('MyJuiAutoComplete',array(
                    'name'=>'paketBMHP',
                    'value'=>'',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.Yii::app()->createUrl('pemulasaranJenazah/TindakanPelayanan/PaketBMHP').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           tipepaket_id: $("#PJTindakanPelayananT_0_tipepaket_id").val(),
                                           kelaspelayanan_id: $("#PJPendaftaranT_kelaspelayanan_id").val(),
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
                            inputBMHP(ui.item.daftartindakan_id);
                            $("#kelompokumur_id").val(ui.item.kelompokumur_id);
                            $(this).val(\'\');
                            return false;
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','placeholder'=>'Paket BMHP'),
                    'tombolDialog'=>array('idDialog'=>'dialogPaketBMHP'),
        )); ?>
<table class="items table table-striped table-bordered table-condensed" id="tblInputPaketBhp">
    <?php echo CHtml::hiddenField('kelompokumur_id','kelompokumur_id',array()); ?>
    <thead>
        <tr>
            <th>Nama Tindakan</th>
            <th>Nama BHP</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
    <div>
        <b>Total Paket BMHP : </b>
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

$modBMHP = new PJPaketbmhpM('searchPaket');
    $modBMHP->unsetAttributes();    
    if(isset($_GET['PJPaketbmhpM'])) {
        $modBMHP->attributes = $_GET['PJPaketbmhpM'];
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
                    'value'=>'(isset($data->daftartindakan_id) ? $data->daftartindakan->daftartindakan_nama : "")',
                ),
                array(
                    'header'=>'Kelompok Umur',
                    'name'=>'kelompokumurNama',
                    'value'=>'(isset($data->kelompokumur_id) ? $data->kelompokumur->kelompokumur_nama : "")',
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