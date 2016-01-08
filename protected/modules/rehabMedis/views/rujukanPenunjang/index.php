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
                    'tgl_pendaftaran',
                    'tgl_kirimpasien',
                    array(
                        'header'=>'Instalasi / Ruangan Asal',
                        'value'=>'$data->InstalasiNamaRuanganNama',
                    ),
                    'no_pendaftaran',
                    'no_rekam_medik',
                    array(
                        'header'=>'Nama Pasien / Alias',
                        'value'=>'$data->NamaPasienNamaBin',
                    ),
                    array(
                        'header'=>'Cara Bayar / Penjamin',
                        'value'=>'$data->CaraBayarPenjaminNama',
                    ),
                    'jeniskasuspenyakit_nama',
    //                'umur',
                    'alamat_pasien',
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