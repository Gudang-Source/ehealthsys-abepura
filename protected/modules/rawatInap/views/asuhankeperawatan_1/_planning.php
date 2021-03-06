Kolaborasi Lanjutan
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjasuhankeperawatan-t-grid', 
    'dataProvider'=>$modDiagnosaKeperawatanSearch->searchDetail($modPendaftaran->pendaftaran_id), 
    //'filter'=>$modDiagnosaKeperawatanSearch, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        ////'asuhankeperawatan_id',
//        array( 
//                        'name'=>'asuhankeperawatan_id', 
//                        'value'=>'$data->asuhankeperawatan_id', 
//                        'filter'=>false, 
//                ),
//        'diagnosa_id',
//        'ruangan_id',
//        'pegawai_id',
//        'shift_id',
//        'pasienadmisi_id',
//        'pendaftaran_id',
//        'pasien_id',
        
        'diagnosakeperawatan.diagnosa_keperawatan',
        array(
                     'header'=>'Kolaborasi Lanjutan',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_kolaborasilanjutan\',array(\'asuhankeperawatan_id\'=>$data->asuhankeperawatan_id),true)',
        ),
//        'tglaskep',
//        'evaluasi_subjektif',
//        'evaluasi_objektif',
//        'tglassesment',
//        'evaluasi_assesment',
//        'askep_tujuan',
//        'askep_kriteriahasil',
//        'create_time',
//        'update_time',
//        'create_loginpemakai_id',
//        'update_loginpemakai_id',
//        'create_ruangan',
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?>
<br/>
Intervensi Lanjutan
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjasuhankeperawatan-t-grid', 
    'dataProvider'=>$modDiagnosaKeperawatanSearch->searchDetail($modPendaftaran->pendaftaran_id), 
    //'filter'=>$modDiagnosaKeperawatanSearch, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        ////'asuhankeperawatan_id',
//        array( 
//                        'name'=>'asuhankeperawatan_id', 
//                        'value'=>'$data->asuhankeperawatan_id', 
//                        'filter'=>false, 
//                ),
//        'diagnosa_id',
//        'ruangan_id',
//        'pegawai_id',
//        'shift_id',
//        'pasienadmisi_id',
//        'pendaftaran_id',
//        'pasien_id',
        'diagnosakeperawatan.diagnosa_keperawatan',
        array(
                     'header'=>'Intervensi Lanjutan',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_intervensilanjutan\',array(\'asuhankeperawatan_id\'=>$data->asuhankeperawatan_id),true)',
        ),
//        'tglaskep',
//        'evaluasi_subjektif',
//        'evaluasi_objektif',
//        'tglassesment',
//        'evaluasi_assesment',
//        'askep_tujuan',
//        'askep_kriteriahasil',
//        'create_time',
//        'update_time',
//        'create_loginpemakai_id',
//        'update_loginpemakai_id',
//        'create_ruangan',
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?>