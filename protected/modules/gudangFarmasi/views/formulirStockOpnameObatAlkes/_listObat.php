<?php 
echo CHtml::css('#isiScroll{max-height:300px;overflow-y:scroll;margin-bottom:10px;}'); 
?>
<!-- search-form -->
<div id="form-carikata">
	<?php echo CHtml::textField('carikata',"",array('onkeyup'=>'return $(this).focusNextInputField(event);','onblur'=>'cariKata();','placeholder'=>'Ketik kata yang akan dicari')) ?>
	<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',array('class'=>'btn btn-primary','onclick'=>'cariKata();',)) ?>
	<?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger','onclick'=>'resetCariKata();')) ?>
</div>

<div id='isiScroll'>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatalkes-m-grid',
    'dataProvider'=>$modObat->searchObatFormulirStokOpname(), //RND-6228
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuaobat',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField(\'GFFormstokopnameR[\'.$data->obatalkes_id.\'][obatalkes_id]\',$data->obatalkes_id).
                    CHtml::checkBox(\'GFFormstokopnameR[\'.$data->obatalkes_id.\'][cekList]\', true, array(\'class\'=>\'cekList\', \'onclick\'=>\'getTotal();setNol(this);\'));
                    ',
            ),
            array(
                'name'=>'jenisobatalkes_id',
                'value'=>'isset($data->jenisobatalkes_nama)?$data->jenisobatalkes_nama:""',
                ),
            'obatalkes_kode',
            array(
                'header'=>'Nama Obat',
                'type'=>'raw',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Golongan<br/>Kategori',
                'type'=>'raw',
                'value'=>'$data->obatalkes_golongan.\'<br/>\'.$data->obatalkes_kategori',
            ),
            array(
                'header'=>'Satuan Kecil',
                'type'=>'raw',
                'value'=>'$data->satuankecil_nama',
            ),
            array(
                'header'=>'HPP',
                'type'=>'raw',
                'value'=>'CHtml::textField(\'harga\', number_format($data->harganetto), array(\'class\'=>\'span2 integer\', \'readonly\'=>true))'
            ),
            array(
                'header'=>'Stok Sistem',
                'type'=>'raw',
                'value'=> 'CHtml::textField(\'stok\', number_format($data->getStokObatRuangan()),array(\'class\'=>\'stok span1 integer\', \'readonly\'=>true))',
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                    getTotal();
					setTanggalSistem();
                }',
)); ?> 
</div>