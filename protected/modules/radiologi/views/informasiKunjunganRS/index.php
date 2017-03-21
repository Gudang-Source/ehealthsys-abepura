<div class="white-container">
    <legend class="rim2">Informasi <b>Kunjungan RS</b></legend> 		
    <?php
    Yii::app()->clientScript->registerScript('search', "

    $('#search').submit(function(){
            $.fn.yiiGridView.update('kunjunganrs-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ", CClientScript::POS_READY);
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Kunjungan RS</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kunjunganrs-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tanggal Pendaftaran/<br/> No Pendaftaran',
                    'name'=>'tgl_pendaftaran',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br/>".$data->no_pendaftaran'
                ),
				array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan." ".$data->nama_pasien',
                ),
				array(
                    'header'=>'Umur/ <br/> Jenis Kelamin',
                    'type'=>'raw',
                    'value'=>'$data->umur."/ <br/>".$data->jeniskelamin',
                ),         
				array(
                    'name'=>'alamat_pasien',
                    'type'=>'raw',
                    'value'=>'$data->alamat_pasien',
                ),
				 array(
                    'header'=>'Kasus Penyakit',
                    'type'=>'raw',
                    'value'=>'$data->jeniskasuspenyakit_nama',
                ),
				 array(
                    'header'=>'Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'$data->kelaspelayanan_nama',
                ),
				array(
                    'header'=>'Cara Bayar/ <br/> Penjamin',
                    'name'=>'carabayar_nama',
                    'type'=>'raw',
                    'value'=>'$data->carabayar_nama."/<br/> ".$data->penjamin_nama',
                ),              
                array(
                    'header'=>'Instalasi/ <br/> Ruangan',
                    'name'=>'instalasi_nama',
                    'type'=>'raw',
                    'value'=>'$data->instalasi_nama."/ <br/>".$data->ruangan_nama',
                ),                                             
                array(
                    'header'=>'Dokter Penanggung Jawab',
                    'type'=>'raw',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                ),
                
               // array(
                 //  'header'=>'Pemeriksaan',
                  //  'type'=>'raw',
                  //  'value'=>'CHtml::link("<i class=\"icon-form-rkontrol\"></i>",Yii::app()->createUrl("radiologi/PendaftaranRadiologiRujukanRS/index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>$data->instalasi_id)), array("rel"=>"tooltip","title"=>"Klik untuk Rencana Pemeriksaan"))',  'htmlOptions'=>array('style'=>'text-align: center; width:40px')
               // ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial('_search', array('model'=>$model)); ?>
</div>