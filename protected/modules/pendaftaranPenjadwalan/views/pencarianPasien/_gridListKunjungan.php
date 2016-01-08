<table class="table table-condensed" id="dataPasienKunjungan">
    <tr>
        <td>No. Rekam Medik</td>
        <td>: <?php echo $modPasien->no_rekam_medik; ?></td>
        <td>Nama Pasien</td>
        <td>: <?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: <?php echo $modPasien->jeniskelamin; ?></td>
        <td>Nama Bin</td>
        <td>: <?php echo $modPasien->nama_bin; ?></td>
    </tr>
</table>
<style>
    #pencarianlistkunjungan-grid table thead tr th{
        vertical-align: middle;
    }
</style>
<?php 
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
        'id'=>'pencarianlistkunjungan-grid',
        'mergeHeaders'=>array(
//            0=>array(
//                'start'=>5,
//                'end'=>6,
//                'name'=>'Penunjang',
//            ), 
            0=>array(
                'start'=>6,
                'end'=>9,
                'name'=>'Tindak Lanjut Ke Rawat Inap',
            )
        ),
        'dataProvider'=>$modPendaftaran->searchListKunjungan(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            'ruangan.ruangan_nama',
            'no_pendaftaran',
            'tgl_pendaftaran',
            'tglselesaiperiksa',
            array(
                'header'=>'Ke Penunjang',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial('.$this->path_view.'."_pasienMasukPenunjang", array("pendaftaran_id"=>$data->pendaftaran_id))',
            ),
            'pasienadmisiTs.tgladmisi',
            'pasienadmisiTs.ruangan.ruangan_nama',
            'pasienadmisiTs.kelaspelayanan.kelaspelayanan_nama',
            array(
                'header'=>'Cara Pulang / Kondisi',
                'type'=>'raw',
                'value'=>'(isset($data->pasienpulang->carakeluar->carakeluar_nama) ? $data->pasienpulang->carakeluar->carakeluar_nama : " - ")." / ".(isset($data->pasienpulang->kondisikeluar->kondisikeluar_nama) ? $data->pasienpulang->kondisikeluar->kondisikeluar_nama : " - ")',
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            'statusperiksa',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>