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
                    array(
                            'header'=>'No. Urut Pinjam',
                            'value'=>'(isset($data->nourut_pinjam) ? $data->nourut_pinjam:"")',
                    ),
                    array(
                            'header'=>'No. Dokumen',
                            'value'=>'(isset($data->nodokumenrm) ? $data->nodokumenrm:"")',
                    ),
                    array(
                            'header'=>'Warna Dokumen',
                            'value'=>'(isset($data->warnadokrm_namawarna) ? $data->warnadokrm_namawarna:"")',
                    ),
                    array(
                            'header'=>'Tanggal Rekam Medik',
                            'value'=>'(isset($data->tgl_rekam_medik) ? MyFormatter::formatDateTimeForUser($data->tgl_rekam_medik):"")',
                    ),
                    array(
                            'header'=>'Nama Pasien',
                            'value'=>'(isset($data->nama_pasien) ? $data->nama_pasien:"")',
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
                            'header'=>'Tanggal Peminjaman',
                            'value'=>'(isset($data->tglpeminjamanrm) ? MyFormatter::formatDateTimeForUser($data->tglpeminjamanrm):"")',
                    ),
                    array(
                            'header'=>'Instalasi Tujuan',
                            'value'=>'(isset($data->instalasi_nama) ? $data->instalasi_nama:"")',
                    ),
                    array(
                            'header'=>'Ruangan Tujuan',
                            'value'=>'(isset($data->ruangan_nama) ? $data->ruangan_nama:"")',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
        <?php $this->renderPartial('_searchinformasi',array('model'=>$model)); ?>
    </fieldset>
</div>