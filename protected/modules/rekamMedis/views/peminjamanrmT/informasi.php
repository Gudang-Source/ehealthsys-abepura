<?php
Yii::app()->clientScript->registerScript('search', "
$('#rmpeminjamanrm-t-search').submit(function(){
	$.fn.yiiGridView.update('informasipeminjaman-i-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Peminjaman Dokumen</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Peminjaman Dokumen</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'informasipeminjaman-i-grid',
            'dataProvider'=>$model->searchInformasi(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    /*array(
                            'header'=>'No. Urut Pinjam',
                            'value'=>'(isset($data->nourut_pinjam) ? $data->nourut_pinjam:"")',
                    ),*/
                    array(
                            'header'=>'Tanggal Peminjaman',
                            'value'=>'(isset($data->tglpeminjamanrm) ? MyFormatter::formatDateTimeForUser($data->tglpeminjamanrm):"")',
                    ),
                    array(
                            'header'=>'No. / <br> Warna Dokumen',
                            'value'=> function($data){
                                $nodok = (isset($data->nodokumenrm) ? $data->nodokumenrm:"-");
                                $warna = (isset($data->warnadokrm_namawarna) ? $data->warnadokrm_namawarna:"-");
                                
                                echo $nodok." / <br>".$warna;
                            },
                    ),   
                    array(
                        'header' => 'No. Rekam Medik',
                        'value' => '$data->no_rekam_medik'
                    ),
                    array(
                            'header'=>'Nama Pasien',
                            'value'=>'(isset($data->nama_pasien) ? $data->namadepan." ".$data->nama_pasien:"")',
                    ),
                    array(
                            'header'=>'Tanggal Lahir',
                            'value'=>'(isset($data->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($data->tanggal_lahir):"")',
                    ),
                    array(
                            'header'=>'Alamat',
                            'value'=>'(isset($data->alamat_pasien) ? $data->alamat_pasien:"")',
                    ),
                    array(
                        'header' => 'Untuk Kepentingan',
                        'value' => '!empty($data->untukkepentingan)?$data->untukkepentingan:"-"'
                    ),
                    /*array(
                        'header' => 'Peminjam',
                        'value' => function($data){
                                $id = PeminjamanrmT::model()->findByPk($data->peminjamanrm_id);
                                
                                $peminjam = PegawaiM::model()->find("nama_pegawai = '".$id->namapeminjam."' ");
                                
                                if (count($peminjam)>0){
                                    return $peminjam->namaLengkap;
                                }else{
                                    return '-';
                                }
                        },
                    ),*/
                    array(
                            'header'=>'Instalasi / <br> Ruangan Tujuan',
                            'value'=> function($data){
                                $ins = (isset($data->instalasi_nama) ? $data->instalasi_nama:"-");
                                $ruangan = (isset($data->ruangan_nama) ? $data->ruangan_nama:"-");
                                
                                echo $ins." / <br>".$ruangan;
                            },
                    ),                       
                    
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
        <?php $this->renderPartial($this->path_view.'_searchinformasi',array('model'=>$model)); ?>
    </fieldset>
</div>