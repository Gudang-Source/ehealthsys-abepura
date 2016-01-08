<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Rawat Jalan</b></legend>
    <?php
    $urlTindakLanjut = Yii::app()->createUrl('actionAjax/pasienRujukRI');
    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Rawat Jalan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->searchDaftarPasien(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(	
                    'no_urutantri',	
                    //'pendaftaran.pasienpulang_id',	
                                    array(
                                    'name'=>'tgl_pendaftaran',
                                    'type'=>'raw',
                                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                                    ),
                    array(
                        'header'=>'No. Pendaftaran </br> No. Rekam Medik',
                        'name'=>'No_pendaftaran'.'/<br/>'.'No_rekam_medik',
                        'type'=>'raw',
                        'value'=>'"$data->no_pendaftaran"."<br/>"."$data->no_rekam_medik"',
                    ),
                    array(
                        'name'=>'nama_pasien'.'/<br/>'.'Alias',
                        'header'=>'Nama Pasien'.'/<br/>'.'Panggilan',
                        'type'=>'raw',
                        'value'=>'"$data->NamaPasienNamaBin"',
                    ),
                    array(
                        'name'=>'alamat_pasien'.'/<br/>'.'RT RW',
                        'type'=>'raw',
                        'value'=>'"$data->alamat_pasien"."<br/>"."$data->RTRW"',
                    ),
                    array(
                        'name'=>'Penjamin'.'/<br/>'.'Cara Bayar',
                        'type'=>'raw',
                        'value'=>'"$data->penjamin_nama"."<br/>"."$data->carabayar_nama"',
                    ),
                    //'no_rekam_medik',
                    //'nama_pasien',
                    //'nama_bin',
                    //'alamat_pasien',
                    //'RTRW',
                    //'penjamin_nama',
                    //'carabayar_id',
                    'nama_pegawai',
                    //'ruangan_nama',
                    'jeniskasuspenyakit_nama',
                    'statusperiksa',

                    array(
                        'header'=>'Pemakaian Ambulans',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'(empty($data->pemakaianambulans_id)) ? CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
                                               Yii::app()->controller->createUrl("pemakaianAmbulanPasienRS/index",array("instalasi_id"=>Params::INSTALASI_ID_RJ,"pendaftaran_id"=>$data->pendaftaran_id,
                                                                                                             "modul_id"=>Yii::app()->session["modul_id"])),
                                               array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk pemakaian Ambulans")) : ""',
                    )
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_searchPasienRJ',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
</div>
<script>
document.getElementById('AMInfokunjunganrjV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('AMInfokunjunganrjV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){
    var checklist = $('#AMInfokunjunganrjV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('AMInfokunjunganrjV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('AMInfokunjunganrjV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('AMInfokunjunganrjV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('AMInfokunjunganrjV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}    
</script>
