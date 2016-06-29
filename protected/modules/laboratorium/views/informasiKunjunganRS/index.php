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
                    'header'=>'Tgl Pendaftaran/<br> No Pendaftaran ',                    
                    'type'=>'raw',
                    'name' => 'tgl_pendaftaran',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)." /<br>".$data->no_pendaftaran'
                ),                
                 array(
                    'header'=>'No Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),                             
                array(
                    'header'=>'Nama Pasien',// Alias
                    'type'=>'raw',
                    'value'=>'$data->sapaanPasien',//$data->NamaNamaAlias
                ),
                array(
                    'header'=>'Jenis Kelamin/<br>Umur',
                    'type'=>'raw',
                    'value'=>'$data->jeniskelamin." /<br>".$data->umur',
                ),
                 array(
                    'name'=>'Jenis Kasus Penyakit',
                    'type'=>'raw',
                    'value'=>'$data->jeniskasuspenyakit_nama',
                ),                                                
                array(
                    'header'=>'Cara Bayar/ <br> Penjamin',                    
                    'type'=>'raw',
                    'value'=>'$data->carabayar_nama." /<br>".$data->penjamin_nama',
                ), 
                array(
                    'header'=>'Instalasi /<br> Ruangan',                    
                    'type'=>'raw',
                    'value'=>'$data->instalasi_nama." /<br>".$data->ruangan_nama',
                ), 
                array(
                    'header'=> (strtolower(Yii::app()->controller->module->id)=='gasmedis')?'Dokter PJP':'Dokter Penanggung Jawab',
                    'type'=>'raw',
                    'value'=>'$data->NamaLengkap',
                ),
                                 
                array(
                    'header'=>'Status Periksa',
                    'type'=>'raw',
                    'value'=>'$data->statusperiksa',
                ),
                //array(
                 //   'header'=>'Pemeriksaan',
                //    'type'=>'raw',
                 //   'value'=>'CHtml::link("<i class=\"icon-form-periksa\"></i>",Yii::app()->createUrl("laboratorium/pendaftaranLaboratoriumRujukanRS/index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>$data->instalasi_id)), array("rel"=>"tooltip","title"=>"Klik untuk Rencana Pemeriksaan"))',  'htmlOptions'=>array('style'=>'text-align:left; width:40px')
              //  ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'_search', array('model'=>$model)); ?>
</div>