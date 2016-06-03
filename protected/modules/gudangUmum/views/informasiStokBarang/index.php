<?php
$this->breadcrumbs=array(
	'Inventarisasiruangan Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasistokbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Stok Barang</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Stok Barang</b></h6>
        <?php
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(case when inventarisasi_keadaan = :p1 then inventarisasi_qty_skrg else 0 end) as inventarisasi_qty_skrg';
        $criteria->addCondition('barang_id = :p2 and ruangan_id = :p3');
        $keadaan = LookupM::getItems("inventariskeadaan");
        
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'informasistokbarang-grid',
            'dataProvider'=>$model->search(),
    //	'filter'=>$model,
            'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Jumlah Barang</center>',
                        'start'=>8, 
                        'end'=>9, 
                    ),
                    array(
                        'name'=>'<center>Keadaan Barang</center>',
                        'start'=>11, 
                        'end'=>13, 
                    ),
                ),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    /* 'instalasi_nama',
                    'ruangan_nama', */
                    array (
                        'header'=>'Nama Barang/<br/>Tipe Barang',
                        'name'=>'barang_nama',
                        'type'=>'raw',
                        'value'=>'$data->barang_nama."/<br/>".$data->barang_type',
                    ),
                    array (
                        'header'=>'Merk',
                        'name'=>'barang_merk',
                        'type'=>'raw',
                        'value'=>'$data->barang_merk',
                    ),
                    array (
                        'header'=>'No. Seri',
                        'name'=>'barang_noseri',
                        'type'=>'raw',
                        'value'=>'$data->barang_noseri',
                    ),
                    array (
                        'header'=>'Ukuran',
                        'name'=>'barang_ukuran',
                        'type'=>'raw',
                        'value'=>'$data->barang_ukuran',
                    ),
                    array (
                        'header'=>'Bahan',
                        'name'=>'barang_bahan',
                        'type'=>'raw',
                        'value'=>'$data->barang_bahan',
                    ),
                    
                    array (
                        'header'=>'Tahun</br>Beli/Buat',
                        'name'=>'barang_thnbeli',
                        'type'=>'raw',
                        'value'=>'$data->barang_thnbeli',
                    ),
                    'barang_kode',
                    array (
                        'header'=>'Register',
                        'type'=>'raw',
                        'value'=>'$data->barang_statusregister?"Ya":"Tidak"',
                    ),
                
                    array (
                        'header'=>'Volume',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForPrint($data->inventarisasi_stok)." ".$data->barang_satuan',
                        'htmlOptions'=>array('style'=>'text-align: right;'),
                    ),
                    array(
                            'header'=>'Harga Beli/</br>Perolehan',
                            'name'=>'inventarisasi_hargabeli_avg',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatNumberForPrint($data->inventarisasi_hargabeli_avg)',
                            'htmlOptions'=>array('style'=>'text-align: right;'),
                    ),
                    array(
                            'header'=>'Baik',
                            'type'=>'raw',
                            'value'=>function($data) use ($criteria, $model) {
                                $criteria->params = array(
                                    ':p1' => 'Baik',
                                    ':p2' => $data->barang_id,
                                    ':p3' => $model->ruangan_id,
                                );
                                $m = InventarisasiruanganT::model()->find($criteria);
                                return $m->inventarisasi_qty_skrg." ".$data->barang_satuan;
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right',
                            ),
                    ),
                    array(
                            'header'=>'Kurang',
                            'type'=>'raw',
                            'value'=>function($data) use ($criteria, $model) {
                                $criteria->params = array(
                                    ':p1' => 'Kurang Baik',
                                    ':p2' => $data->barang_id,
                                    ':p3' => $model->ruangan_id,
                                );
                                $m = InventarisasiruanganT::model()->find($criteria);
                                return $m->inventarisasi_qty_skrg." ".$data->barang_satuan;
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right',
                            ),
                    ),
                    array(
                            'header'=>'Rusak',
                            'type'=>'raw',
                            'value'=>function($data) use ($criteria, $model) {
                                $criteria->params = array(
                                    ':p1' => 'Rusak Berat',
                                    ':p2' => $data->barang_id,
                                    ':p3' => $model->ruangan_id,
                                );
                                $m = InventarisasiruanganT::model()->find($criteria);
                                return $m->inventarisasi_qty_skrg." ".$data->barang_satuan;
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right',
                            ),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
        <div class="search-form">
            <?php $this->renderPartial($this->path_view.'_search',array(
                    'model'=>$model,
            )); ?>
        </div><!-- search-form -->
    </fieldset>
</div>


<?php 
	//echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	//echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	//echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//	$this->widget('UserTips',array('type'=>'admin'));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#informasistokbarang-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasistokbarang-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>