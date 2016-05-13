<div class="white-container">
    <legend class="rim2">Informasi Rincian <b>Tagihan Pasien Penunjang</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
    <div class="block-tabel">
        <h6>Tabel Rincian <b>Tagihan Pasien Penunjang</b></h6>
        <?php
            Yii::app()->clientScript->registerScript('search', "
            $('.currency').each(
                function()
                {
                    var result = formatInteger($(this).text());
                    $(this).text(result);
                }
            );        
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('#search').submit(function(){
                    $('#rinciantagihanpasienpenunjang-v-grid').addClass('animation-loading');
                    $.fn.yiiGridView.update('rinciantagihanpasienpenunjang-v-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

        $this->widget('bootstrap.widgets.BootAlert'); 
        ?>

        <?php 
            $module  = $this->module->name; 
            $controller = $this->id;
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert');	?>
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
                'id'=>'rinciantagihanpasienpenunjang-v-grid',
                'dataProvider'=>$model->searchRincianTagihan(),
        //	'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'mergeColumns' => array('rincian', 'tagihan', 'cetak'),
                'columns'=>array(
                        array(
                            'header'=>'Tgl. Pendaftaran<br/>No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->tgl_pendaftaran."<br/>".$data->no_pendaftaran'
                        ),
                        array(
                            'header'=>'No. Rekam Medik',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik',
                        ),

                        array(
                            'header'=>'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->namadepan.$data->nama_pasien',
                        ),
                        array(
                            'header'=>'Cara Bayar<br/>Penjamin',
                            'type'=>'raw',
                            'value'=>'$data->carabayar_nama."<br/>".$data->penjamin_nama',
                        ),
                        array(
                            'header'=>'Dokter',
                            //'name'=>'nama_pegawai',
                            'value'=>function($data) use (&$p) {
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                return $p->pegawai->namaLengkap;
                                //'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                            }
                        ),
                        'ruangan_nama',
                        array(
                            'header'=>'Status Periksa',
                            'type'=>'raw',
                            'value'=>function($data) use (&$p) {
                                return $p->statusperiksa;
                            }
                        ),
                        array(
                            'header'=>'Total Tagihan',
                            'type'=>'raw',
                            'htmlOptions'=>array(
                                'class'=>'currency'
                            ),
                            'value'=>'(empty($data->totaltagihan)) ? "0" : "Rp".MyFormatter::formatNumberForPrint($data->totaltagihan)',
                            'htmlOptions'=>array('style'=>'text-align: right'),
                        ),            
                        array(
                        'header'=>'Rincian <br/> Tagihan',
                        'name'=>'rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("rinciantagihanpasienLab/rincian",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "id"=>$data->pendaftaran_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogPembayaran\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat rincian tagihan pasien",
                                    ))',
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                        ),
                        array(
                            'header'=>'Bayar Tagihan Pasien',
                            'name'=>'tagihan',
                            'type'=>'raw',
                            'value'=>'($data->totaltagihan != 0 ? 
                                    CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->createUrl("billingKasir/pembayaranTagihanPasienPenunjang/index",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                        array("class"=>"", 
                                              "target"=>"iframePembayaran",
                                              "onclick"=>"$(\"#dialogPembayaran\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk membayar tagihan pasien",
                                        )) : "<div id=\"$data->pendaftaran_id\">SUDAH LUNAS</div>"
                            )',
                            'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                        ),
                        array(
                            'header'=>'Status Pembayaran',
                            'name'=>'cetak',
                            'type'=>'raw',
                            'value'=>function($data) {
                                $total = (empty($data->totaltagihan)) ? "0" : $data->totaltagihan;
            
                                return ($total != 0 ? "<div id=\"$data->pendaftaran_id\">Belum Lunas</div>" : "Sudah Lunas"."<br/>"); /*.CHtml::Link("<i class=\"icon-form-print\"></i>",Yii::app()->controller->createUrl("kwitansiLab/view",array("pendaftaran_id"=>$data->pendaftaran_id,"idPembayaranPelayanan"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                                array("class"=>"", 
                                      "target"=>"iframeKwitansi",
                                      "onclick"=>"$(\"#dialogKwitansi\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk cetak Kwitansi",
                                ))); */
                            },           
                            'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                        ),		
                ),
                'afterAjaxUpdate'=>'function(id, data){
                    jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                    $(".currency").each(
                        function()
                        {
                            var result = formatInteger($(this).text());
                            $(this).text(result);
                        }
                    );
                }',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <?php 
            $this->renderPartial($this->path_view.'_search',array(
                        'model'=>$model,'format'=>$format
            ));
        ?>
    </fieldset>

    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogKwitansi',
            'options' => array(
                'title' => 'Kwitansi Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 550,
                'resizable' => false,
            ),
        ));
    ?>
    <iframe name='iframeKwitansi' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>

    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogPembayaran',
            'options' => array(
                'title' => 'Pembayaran Tagihan Pasien Laboratorium',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1200,
                'height' => 700,
                'resizable' => false,
                'close'=>'js:function(){$.fn.yiiGridView.update(\'rinciantagihanpasienpenunjang-v-grid\', {data: $(\'#search\').serialize()});}'
            ),
        ));
    ?>
    <iframe name='iframePembayaran' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
</div>