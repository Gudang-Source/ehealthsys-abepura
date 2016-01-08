<div class="white-container">
    <legend class="rim2">Infomasi <b>Kunjungan RS</b></legend> 		
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
                    'header'=>'Tgl. Pendaftaran',
                    'name'=>'tgl_pendaftaran',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
                ),
                array(
                    'header'=>'Instalasi',
                    'name'=>'instalasi_nama',
                    'type'=>'raw',
                    'value'=>'$data->instalasi_nama',
                ),
                array(
                    'header'=>'Ruangan/Klinik',
                    'name'=>'ruangan_nama',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'name'=>'no_pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'Nama Pasien / Alias',
                    'type'=>'raw',
                    'value'=>'$data->NamaNamaAlias',
                ),
                array(
                    'header'=>'Cara Bayar',
                    'name'=>'carabayar_nama',
                    'type'=>'raw',
                    'value'=>'$data->carabayar_nama',
                ),
                array(
                    'header'=>'Penjamin',
                    'name'=>'penjamin_nama',
                    'type'=>'raw',
                    'value'=>'$data->penjamin_nama',
                ),
                 array(
                    'header'=>'Kasus Penyakit / <br/> Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                ),
                array(
                    'name'=>'umur',
                    'type'=>'raw',
                    'value'=>'$data->umur',
                ),
                array(
                    'header'=>'Jenis Kelamin',
                    'type'=>'raw',
                    'value'=>'$data->jeniskelamin',
                ),
                array(
                    'header'=>'Dokter<br/>Penanggung Jawab',
                    'type'=>'raw',
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'name'=>'alamat_pasien',
                    'type'=>'raw',
                    'value'=>'$data->alamat_pasien',
                ),
                array(
                    'header'=>'Pemeriksaan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\"icon-form-rkontrol\"></i>",Yii::app()->createUrl("radiologi/PendaftaranRadiologiRujukanRS/index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>$data->instalasi_id)), array("rel"=>"tooltip","title"=>"Klik untuk Rencana Pemeriksaan"))',  'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial('_search', array('model'=>$model)); ?>
</div>