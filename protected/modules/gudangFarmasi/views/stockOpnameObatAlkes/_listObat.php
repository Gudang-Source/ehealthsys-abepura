<?php 
echo CHtml::css('#isiScroll{max-height:500px;overflow-y:scroll;margin-bottom:10px;}#obatalkes-m-grid th{vertical-align:middle;}'); 
?>
<div id="form-carikata">
	<?php echo CHtml::textField('carikata',"",array('onkeyup'=>'return $(this).focusNextInputField(event);','onblur'=>'cariKata();','placeholder'=>'Ketik kata yang akan dicari')) ?>
	<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',array('class'=>'btn btn-primary','onclick'=>'cariKata();',)) ?>
	<?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger','onclick'=>'resetCariKata();')) ?>
</div>
<label><i>Maksimal data yang ditampilkan = 50</i></label>
<div id='isiScroll'>
<?php 

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'obatalkes-m-grid',
    'dataProvider'=>$modObat->searchObatStokOpname(), //RND-6011
    'mergeHeaders'=>array(
            array(
                'name'=>'<center>Stok</center>',
                'start'=>7,
                'end'=>9,
            ),
            
        ),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuaobat',false,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField("GFStokopnamedetT[".$data->obatalkes_id."][obatalkes_id]",$data->obatalkes_id).
                    CHtml::checkBox("GFStokopnamedetT[".$data->obatalkes_id."][cekList]", false, array("class"=>"cekList", "onclick"=>"getTotal(); setNol(this);", "onkeyup"=>"return $(this).focusNextInputField(event);"));
                    ',
            ),
			'jenisobatalkes_nama',
            'obatalkes_kode',
            array(
                'header'=>'Nama Obat',
                'type'=>'raw',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Golongan<br/>Kategori',
                'type'=>'raw',
                'value'=>'$data->obatalkes_golongan."<br/>".$data->obatalkes_kategori',
            ),
            array(
                'header'=>'HPP (Rp)',
                'type'=>'raw',
                'value'=>'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][harganetto]", MyFormatter::formatNumberForPrint(isset($data->hpp) ? $data->hpp : $data->harganetto), array("class"=>"span1 netto integer2", "onblur"=>"getTotal();","onkeyup"=>"return $(this).focusNextInputField(event);", "style"=>"width:64px;"))',
            ),
            array(
                'header'=>'Harga Jual (Rp)',
                'type'=>'raw',
                'value'=>'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][hargasatuan]", MyFormatter::formatNumberForPrint(isset($data->hargajual) ? $data->hargajual : $data->hargasatuan), array("class"=>"span1 harga integer2", "onblur"=>"getTotal();","onkeyup"=>"return $(this).focusNextInputField(event);", "style"=>"width:64px;"))',
            ),
            array(
                'header'=>'Sistem',
                'type'=>'raw',
                'value'=> 'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][volume_sistem]", number_format($data->qtystok), array("class"=>"stok span1 integer2", "readonly"=>true))',
            ),
            array(
                'header'=>'<div class="test" style="cursor:pointer;" onclick="openDialogini()"> Fisik <icon class="icon-white icon-list"></icon></div> ',
                'type'=>'raw',
                'value'=> 'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][volume_fisik]", (isset($data->volume_fisik) ? number_format($data->volume_fisik) : number_format($data->qtystok))  , array("class"=>"fisik span1 integer2", "onblur"=>"getTotal();", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
            ),
			array(
                'header'=>'Waktu Cek Fisik',
                'type'=>'raw',
                'value'=> 'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][tglperiksafisik]", (isset($data->tglperiksafisik) ? (empty($data->tglperiksafisik) ? date("d/m/Y H:i:s") : date("d/m/Y H:i:s",strtotime($data->tglperiksafisik))) : date("d/m/Y H:i:s"))  , array("class"=>"span2 datetimemask", "style"=>"width:105px;","onkeyup"=>"return $(this).focusNextInputField(event);"))',
            ),
            array(
                'header'=>'Kondisi Barang',
                'type'=>'raw',
                'value'=> 'CHtml::dropDownList("GFStokopnamedetT[".$data->obatalkes_id."][kondisibarang]", "", LookupM::getItems("inventariskeadaan"), array("class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            console.log("kick");
            $(".cekList").each(function() {setNol(this); });
            $("#obatalkes-m-grid .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null})
            $("#obatalkes-m-grid .datetimemask").mask("99/99/9999 99:99:99");    
            getTotal();
                }',
)); ?> 
    </div>

<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetails',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Volume Fisik',
                        'autoOpen'=>false,
                        'width'=>150,
                        'height'=>140,
                        'resizable'=>false,
                        'scroll'=>false,
                            'modal'=>true
                         ),
                    ));
?>
<div class="awawa" width="100%" height="100%">
    <?php echo CHtml::textField('fisiks', 0, array('class'=>'numbers-only span2')); ?><br><br>
    <?php echo CHtml::button('submit', array('class'=>'btn btn-primary', 'onclick'=>'setVolume();', 'id'=>'submitJumlahVolume')); ?>
</div>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

Yii::app()->clientScript->registerScript('openDialog','
    function openDialogini(){
        $("#dialogDetails").dialog("open");
    }
',  CClientScript::POS_HEAD);
?>