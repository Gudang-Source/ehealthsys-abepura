<div class="block-tabel">
    <h6>Tabel <b>Penggantian Kacamata</b></h6>
    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
        'id'=>'daftargantikacamata-v-grid',
        'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeHeaders'=>array(
                    array(
                            'name'=>'<center>VOD</center>',
                            'start'=>7, //indeks kolom 8
                            'end'=>8, //indeks kolom 9
                    ),
                    array(
                            'name'=>'<center>VOS</center>',
                            'start'=>9, //indeks kolom 10
                            'end'=>10, //indeks kolom 11
                    ),
            ),
        'columns'=>array(   
                    array(
                            'header'=>'No. Memo',
                            'type'=>'raw',
                            'value'=>'isset($data->pengajuangantikm->no_pengajuan) ? $data->pengajuangantikm->no_pengajuan : ""',
                    ),
                    array(
                            'name'=>'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->namapasien_hub',
                    ),
                    array(
                            'name'=>'Satuan Hubungan',
                            'type'=>'raw',
                            'value'=>'$data->statushubungan',
                    ), 
                    array(
                            'name'=>'Nama Pekerja',
                            'type'=>'raw',
                            'value'=>'$data->pegawai->NamaLengkap',
                    ),            
                    array(
                            'name'=>'Departement',
                            'type'=>'raw',
                            'value'=>'$data->departement_peg',
                    ),            
                    array(
                            'name'=>'Due Date',
                            'type'=>'raw',
                            'value'=>'isset($data->duedata_kacamata) ? MyFormatter::formatDateTimeForUser($data->duedata_kacamata) : ""',
                    ),            
                    array(
                            'name'=>'Tgl. Pengajuan',
                            'type'=>'raw',
                            'value'=>'isset($data->pengajuangantikm_id) ? MyFormatter::formatDateTimeForUser($data->pengajuangantikm->tglpengajuan_km) : ""',
                    ),            
                    array(
                            'name'=>'Spheris',
                            'type'=>'raw',
                            'value'=>'$data->vod_spheris',
                    ),            
                    array(
                            'name'=>'Cylindrys',
                            'type'=>'raw',
                            'value'=>'$data->vod_cylindrys',
                    ),            
                    array(
                            'name'=>'Spehris',
                            'type'=>'raw',
                            'value'=>'$data->vos_spheris',
                    ),            
                    array(
                            'name'=>'Cylindrys',
                            'type'=>'raw',
                            'value'=>'$data->vos_cylindrys',
                    ),            
                    array(
                            'name'=>'ADD',
                            'type'=>'raw',
                            'value'=>'$data->add_kacamata',
                    ),            
                    array(
                            'name'=>'Harga',
                            'type'=>'raw',
                            'value'=>'$data->jumlahharga_km',
                    ),   
                    array(
                            'name'=>'Status',
                            'type'=>'raw',
                            'value'=>'(!empty($data->pengajuangantikm_id) ? "Sudah Diganti" : "Belum Diganti")',
                    ),           

        ),
                    'afterAjaxUpdate'=>'function(id, data){
                    jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>