<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
        $('#informasi-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasi-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$provider = $model->searchDataObat();
$provider->sort->defaultOrder = "obatalkes_nama";

?>
<div class="white-container">
    <legend class="rim2">Informasi Stok <b>Obat Dan Alat Kesehatan</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Stok</b></h6>
        <div class="table-responsive">
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'informasi-grid',
                'dataProvider'=>$provider,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                        // 'instalasi_nama',
                        // 'ruangan_nama',
                        'jenisobatalkes_nama',
                        'obatalkes_golongan',
                        'obatalkes_kategori',
			//			'nobatch',
                        /*
                        array(
                            'name'=>'tglkadaluarsa',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
                        ),*/		
                        
                        'obatalkes_kode',
                        'obatalkes_nama',
                        array(
                            'header'=>'Diterima',
                            'type'=>'raw',
                            'value'=>function($data) use (&$stok) {
                                $stok = StokobatalkesT::model()->findAllByAttributes(array(
                                    'obatalkes_id'=>$data->obatalkes_id,
                                    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                                ));
                                $total = 0;
                                foreach ($stok as $item) {
                                    $total += $item->qtystok_in;
                                }
                                return $total." ".$data->satuankecil->satuankecil_nama;
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right;'
                            )
                        ), 
                        array(
                            'header'=>'Dipakai',
                            'type'=>'raw',
                            'value'=>function($data) use (&$stok) {
                                $total = 0;
                                foreach ($stok as $item) {
                                    $total += $item->qtystok_out;
                                }
                                return $total." ".$data->satuankecil->satuankecil_nama;
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right;'
                            )
                        )
                    /*
                        'satuankecil_nama',
                        array(
                            'name'=>'hpp_max',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatUang($data->hpp_max)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        
        //                array(
        //                    'header'=>'Rincian',
        //                    'type'=>'raw',
        //                    'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("MutasiObatAlkes/print",array("mutasioaruangan_id"=>$data->mutasioaruangan_id,"frame"=>true)),
        //                                 array("class"=>"", 
        //                                       "target"=>"mutasimasuk",
        //                                       "onclick"=>"$(\"#dialogMutasi\").dialog(\"open\");",
        //                                       "rel"=>"tooltip",
        //                                       "title"=>"Klik untuk melihat rincian mutasi masuk",
        //                                 ))',
        //                ),
                        array(
                            'name'=>'hpp_min',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatUang($data->hpp_min)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'name'=>'hpp_avg',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatUang($data->hpp_avg)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'name'=>'hargajual_max',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatUang($data->hargajual_max)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'name'=>'hargajual_min',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatUang($data->hargajual_min)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'name'=>'hargajual_avg',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatUang($data->hargajual_avg)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'name'=>'qtystok',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatNumberForUser($data->qtystok)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'header'=>'Nilai Persediaan',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatUang($data->hargajual_avg*$data->qtystok)',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'header'=>'Lokasi Rak',
                            'type'=>'raw',
                            'value'=>'
                               CHtml::link($data->lokasiobat_nama."<br><i class=\'icon-form-ubah\'></i>", Yii::app()->createUrl("/gudangFarmasi/InformasiStokObatAlkes/ubahLokasiObat", array("obatalkes_id"=>$data->obatalkes_id,"ruangan_id"=>$data->ruangan_id)),
                               array("class"=>"",
                               "target"=>"frameEditLokasiObat",
                               "rel"=>"tooltip",
                               "title"=>"Klik Untuk Mengubah Data Lokasi Obat",
                               "onclick"=>"$(\'#editlokasiobat\').dialog(\'open\');return true;"))',
                            'htmlOptions'=>array('style'=>'text-align:left;')
                        ),
                        array(
                            'header'=>'Sub Rak',
                            'type'=>'raw',
                                                'value'=>'(!empty($data->rakobat_id)?$data->rakobat_nama:"-")',
                            'htmlOptions'=>array('style'=>'text-align:left; width:60px')
                        ),
                         * 
                         */
//                array(
//                    'header'=>'Rincian',
//                    'type'=>'raw',
//                    'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("MutasiObatAlkes/print",array("mutasioaruangan_id"=>$data->mutasioaruangan_id,"frame"=>true)),
//                                 array("class"=>"", 
//                                       "target"=>"mutasimasuk",
//                                       "onclick"=>"$(\"#dialogMutasi\").dialog(\"open\");",
//                                       "rel"=>"tooltip",
//                                       "title"=>"Klik untuk melihat rincian mutasi masuk",
//                                 ))',
//                ),
                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
        </div>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array(
        'model'=>$model,
        'format'=>$format,
        //'instalasiAsals'=>$instalasiAsals,
        //'ruanganAsals'=>$ruanganAsals
    )); ?>
</div>
<?php
    //=============================== Ganti Data Pasien Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editlokasiobat',
            'options'=>array(
                'title'=>'Ubah Data Lokasi Obat' ,
                'autoOpen'=>false,
                'width' => 780,
                'height' => 480,
                'resizable' => true,
				"beforeClose"=>'js:function(){  $.fn.yiiGridView.update(\'informasi-grid\', {}); }'
            ),
			
        )
    );
    echo '<iframe name="frameEditLokasiObat" width="100%" height="100%"></iframe>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
