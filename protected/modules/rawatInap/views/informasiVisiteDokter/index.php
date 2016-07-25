<div class="white-container">
    <legend class="rim2">Informasi <b>Visite Dokter</b></legend>
    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarvisitedokter-form').submit(function(){
            $('#daftarvisitedokter-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarvisitedokter-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Visite Dokter</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            'id'=>'daftarvisitedokter-grid',
            'dataProvider'=>$model->searchInformasiVisite(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'Tgl. Tindakan Visite',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_tindakan)',
                            'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-style:italic;'),
                            'footer'=>'Total',
                    ),
                    array(
                            'header'=>'Kelas Tarif',
                            'value'=>'$data->kelaspelayanan_nama',
                    ),
                    array(
                            'header'=>'Nama Dokter',
                            'value'=>'$data->NamaLengkap',
                    ),
                    array(
                            'header'=>'Nama Pasien',
                            'value'=>'$data->nama_pasien',
                    ),
                    array(
                            'header'=>'Jumlah Visite',
                            'name'=>'qty_tindakan',
                            'value'=>'$data->qty_tindakan',
                            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                            'footer'=>'sum(qty_tindakan)',
                    ),
                    array(
                            'header'=>'Tarif Visite',
                            'name'=>'tarif_satuan',
                            'value'=>'number_format($data->tarif_satuan,0,"",".")',
                            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),			
                            'footerHtmlOptions'=>array('style'=>'text-align:right;color:white;'),
                            'footer'=>'-',
                    ),
                    array(
                            'header'=>'Jumlah Tagihan',
                            'name'=>'tarif_tindakan',
                            'value'=>'number_format($data->tarif_tindakan,0,"",".")',
                            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                            'footer'=>'sum(tarif_tindakan)',
                    ),
    //		array(
    //			'header'=>'Tgl. Rekam Medik',
    //			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_rekam_medik)',
    //		),
    //		array(
    //			'header'=>'Tgl. Pendaftaran',
    //			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
    //		),
    //		array(
    //			'header'=>'No. Rekam Medik',
    //			'value'=>'$data->no_rekam_medik',
    //		),
    //		array(
    //			'header'=>'No. Pendaftaran',
    //			'value'=>'$data->no_pendaftaran',
    //		),
    //		array(
    //			'header'=>'Jenis Kasus Penyakit',
    //			'value'=>'$data->jeniskasuspenyakit_nama',
    //		),
    //		
    //		array(
    //			'header'=>'Cara Bayar / Penjamin',
    //			'value'=>'$data->carabayar_nama."<br/>".$data->penjamin_nama',
    //		),
    //		array(
    //			'header'=>'Instalasi / Ruangan',
    //			'value'=>'$data->instalasi_nama."<br/>".$data->ruangan_nama',
    //		),     
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('model'=>$model)); ?>
</div>