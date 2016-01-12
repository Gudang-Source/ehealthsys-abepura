<div class="row-fluid">
    <div class="span4">
        <div class="block-tabel">
            <h6>Data <b>Kunjungan</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPenjualan,
                'attributes'=>array(
                    'jenispenjualan',
                    'noresep',
                    array(
                        'name'=>'tglpelayanan',
                        'value'=>MyFormatter::formatDateTimeForUser($modPenjualan->tglpelayanan),
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'label'=>'Poliklinik / Ruangan',
                        'value'=>$modPenjualan->ruanganasal_nama,
                    ),
                    'penjamin_nama',
                    'no_rekam_medik',
                    'nama_pasien',
    //                'nama_bin',
                    'jeniskelamin',
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>MyFormatter::formatDateTimeForUser($modPenjualan->tanggal_lahir),
                    ),
    //                'umur',
                    'nama_pj',
    //                array(
    //                    'name'=>'pengantar',
    //                    'label'=>'Status Penanggung Jawab',
    //                    'value'=>$modPenjualan->pengantar,
    //                ),
                ),
            )); ?>
        </div>
    </div>
    
    <div class="span4">
        <div class="block-tabel">
            <h6>Data <b>Pembayaran</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'name'=>'tglpembayaran',
                        'value'=>MyFormatter::formatDateTimeForUser($model->tglpembayaran),
                    ),
                    array(
                        'name'=>'totalbiayapelayanan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($model->totalbiayapelayanan).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('biayaadministrasi'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->biayaadministrasi).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('biayamaterai'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->biayamaterai).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('jmlpembulatan'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->jmlpembulatan).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('jmlpembayaran'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->jmlpembayaran).'</div>',
                    ),
                    array(
                        'label'=>$modPemakaianuangmuka->getAttributeLabel('pemakaianuangmuka'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modPemakaianuangmuka->pemakaianuangmuka).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangditerima'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->uangditerima).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangkembalian'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->uangkembalian).'</div>',
                    ),
                    array(
                        'name'=>'totalsisatagihan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($model->totalsisatagihan).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('carapembayaran'),
                        'type'=>'raw',
                        'value'=>$modTandabukti->carapembayaran,
                    ),
                ),
            )); ?>
        </div>
    </div>
    <div class="span4">
        <div class="block-tabel">
            <h6>Tanda <b>Bukti Bayar</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modTandabukti,
                'attributes'=>array(
                    'darinama_bkm',
                    'alamat_bkm',
                    'sebagaipembayaran_bkm',
                ),
            )); ?>
        </div>
    </div>
    
    <?php if($modTandabukti->is_menggunakankartu){ ?>
        <div class="span4">
            <div class="block-tabel">
                <h6>Kartu <b>Pembayaran</b></h6>
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$modTandabukti,
                    'attributes'=>array(
                        'dengankartu',
                        'bankkartu',
                        'nokartu',
                        'nostrukkartu',
                    ),
                )); ?>
            </div>
        </div>
    <?php } ?>
    
</div>