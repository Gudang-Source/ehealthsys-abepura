<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Rujukan</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Rujukan</b></h6>
        <?php 
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasienpenunjangrujukan-m-grid',
            'dataProvider'=>$dataProvider,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'tgl_pendaftaran',
                        'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/</br/>".$data->no_pendaftaran',
                    ),
                    'tgl_kirimpasien',
                    array(
                        'header'=>'Instalasi / Ruangan Asal',
                        'value'=>'$data->InstalasiNamaRuanganNama',
                    ),
                    //'no_pendaftaran',
                    'no_rekam_medik',
                    array(
                        'header'=>'Nama Pasien',
                        'value'=>'$data->namadepan.$data->nama_pasien',
                    ),
                    'alamat_pasien',
                    array(
                        'header' => 'Kasus Penyakit / <br/> Kelas Pelayanan',
                        'name' => 'kasus_pelayanan',
                        'type' => 'raw',
                        'value' => '"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                    ),
                    array(
                        'header'=>'Cara Bayar / Penjamin',
                        'value'=>'$data->CaraBayarPenjaminNama',
                    ),
    //                'umur',
    //                'pemeriksaanrad_nama',
                    array(
                        'header'=>'&nbsp;&nbsp;Pemeriksaan&nbsp;&nbsp;',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value'=>'CHtml::Link("<i class=\'icon-form-periksa\'></i>",Yii::app()->controller->createUrl("pendaftaranRehabilitasiMedisRujukanRS/index",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
                                        array("class"=>"icon-form-periksa", 
                                              "id" => "selectPasien",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk rencana operasi pasien",
                                              "target"=>"blank",
                                        ))',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_formSearch',array());  ?>
    </fieldset>
</div>