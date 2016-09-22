<?php 
echo CHtml::css('#isiScroll{max-height:500px;overflow-y:scroll;margin-bottom:10px;}#barang-m-grid th{vertical-align:middle;}'); 
?>
<div id="form-carikata">
	<?php echo CHtml::textField('carikata',"",array('onkeyup'=>'return $(this).focusNextInputField(event);','onblur'=>'cariKata();','placeholder'=>'Ketik kata yang akan dicari')) ?>
	<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',array('class'=>'btn btn-primary','onclick'=>'cariKata();',)) ?>
	<?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger','onclick'=>'resetCariKata();')) ?>
</div>
<label><i>Maksimal data yang ditampilkan = 1000</i></label>
<div id='isiScroll'>
<?php 

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->searchBarangFormulirInventarisasi(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuabarang',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
			'type'=>'raw',
			'value'=>'
				CHtml::hiddenField("GUBarangV[".$data->barang_id."][barang_id]",$data->barang_id).
				CHtml::checkBox("GUBarangV[".$data->barang_id."][cekList]", true, array("onclick"=>"setUrutan()", "class"=>"cekList", "onclick"=>"getTotal();setNol(this);", "onkeyup"=>"return $(this).focusNextInputField(event);"));
				',
		),
		array(
			'header'=>'Kode Barang',
			'type'=>'raw',
			'value'=>'$data->barang_kode',
		),
		array(
			'header'=>'Nama Barang',
			'type'=>'raw',
			'value'=>'$data->barang_nama',
		),
		array(
			'header'=>'Merk',
			'type'=>'raw',
			'value'=>'$data->barang_merk',
		),
		array(
			'header'=>'No. Seri',
			'type'=>'raw',
			'value'=>'$data->barang_noseri',
		),
		array(
			'header'=>'Satuan Kecil',
			'type'=>'raw',
			'value'=>'$data->barang_satuan',
		),
		array(
			'header'=>'HPP (Rp)',
			'type'=>'raw',
			'value'=>'CHtml::textField("GUBarangV[".$data->barang_id."][harga_netto]", MyFormatter::formatNumberForPrint((isset($data->barang_hpp) && !empty($data->barang_hpp) && $data->barang_hpp != 0) ? $data->barang_hpp : $data->barang_harganetto), array("class"=>"span1 netto integer2", "onblur"=>"getTotal();","onkeyup"=>"return $(this).focusNextInputField(event);", "style"=>"width:64px;"))',
		),
		array(
			'header'=>'Inventarisasi Sistem',
			'type'=>'raw',
			'value'=> function($data) {
				$stok = InventarisasiruanganT::model()->findAllByAttributes(array(
					'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
					'barang_id'=>$data->barang_id,
				));
				$total = 0;
				foreach ($stok as $item) {
					$total += $item->inventarisasi_qty_skrg;
				}
				return CHtml::textField("GUBarangV[".$data->barang_id."][volume_inventaris]", $total, array("class"=>"stok span1 integer2", "readonly"=>true));
			},
		),
    ),
	'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
		$("#barang-m-grid .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null})
		$("#barang-m-grid .datetimemask").mask("99/99/9999 99:99:99");    
		getTotal();
			}',
)); ?> 
    </div>
