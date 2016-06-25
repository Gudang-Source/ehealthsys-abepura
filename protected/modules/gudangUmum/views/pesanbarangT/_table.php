<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'gupesanbarang-t-grid',
	'dataProvider'=>$model->searchInformasi(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		////'pesanbarang_id',
//		array(
//                        'name'=>'pesanbarang_id',
//                        'value'=>'$data->pesanbarang_id',
//                        'filter'=>false,
//                ),
		//'mutasibrg_id',
		'nopemesanan',
		'tglpesanbarang',
		'tglmintadikirim',
                'keterangan_pesan',
		array(
                    'header'=>'Pegawai Pemesan',
                    'value'=>'isset($data->pegawaipemesan->nama_pegawai)?$data->pegawaipemesan->nama_pegawai:""',
                ),
                array(
                  'header'=>'Pegawai Mengetahui',
                  'name' => 'pegpemesan_id',
                  'value'=>'isset($data->pegawaimengetahui->nama_pegawai)?$data->pegawaimengetahui->nama_pegawai:""',
                ),
//		'pegmengetahui_id',
                array(
                    'header'=>'Ruangan Pemesan',
                    'value'=>'isset($data->ruanganpemesan->ruangan_nama)?$data->ruanganpemesan->ruangan_nama:""',
                ),
//		'ruanganpemesan.ruangan_nama',
		/*
		
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
		array(
                    'header'=>'Rincian',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("'.$controller.'/detailPesanBarang",array("id"=>$data->pesanbarang_id)),
                            array(
                                  "target"=>"iframeDetail",
                                  "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\');",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Detail Pemesanan Barang",
                            ))',
                    'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
                ),
                array(
                            'header'=>'Mutasi Barang',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=> function ($data){//'(empty($data->mutasibrg_id))? CHtml::link("<i class=\'icon-form-mutasi\'></i> ", Yii::app()->controller->createUrl("/gudangUmum/MutasibrgT/index",array("id"=>$data->pesanbarang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Mutasi")) : "Telah Dimutasi"',                                                                
                                $controller = Yii::app()->controller->id;
                                if ($data->ruanganpemesan_id == Yii::app()->user->getState('ruangan_id')){
                                    if (empty($data->mutasibrg_id)){
                                        if (empty($data->ruangantujuan_id)){
                                            return "BELUM DIMUTASI";
                                        }else{
                                            return "BELUM DIMUTASI DARI ".$data->ruangantujuan->ruangan_nama;
                                        }                                        
                                    }else{
                                        if (empty($data->ruangantujuan_id)){
                                            return "SUDAH DIMUTASI";
                                        }else{
                                            return "SUDAH DIMUTASI DARI ".$data->ruangantujuan->ruangan_nama;
                                        }
                                        
                                    }
                                }else{
                                    if ($data->ruangantujuan_id == Yii::app()->user->getState('ruangan_id')){
                                        if (empty($data->mutasibrg_id)){
                                            echo CHtml::link("<i class='icon-form-mutasi'></i> ", Yii::app()->controller->createUrl(str_replace('pesanbarang','mutasibrg',$controller).'/Index',array("id"=>$data->pesanbarang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Mutasi"));
                                        }else{
                                            return "SUDAH DIMUTASI KE ".$data->ruanganpemesan->ruangan_nama;
                                        }
                                        //return (empty($data->mutasibrg_id))?  : "Telah Dimutasi";
                                    }else{
                                        return "TIDAK DITUJUKAN KESINI";
                                    }
                                }                                
                            }
                    ), 
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>