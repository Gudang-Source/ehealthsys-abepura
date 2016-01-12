<div class="white-container">
    <legend class="rim2">Informasi <b>Pembayaran Gizi</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pembayaran Gizi</b></h6>
        <?php
        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','').' Informasi Pembayaran Gizi', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;             
        $this->menu=$arrMenu;
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('rjrinciantagihanpasien-v-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php 
            $module  = $this->module->name; 
            $controller = $this->id;?>
        <?php
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id'=>'rjrinciantagihanpasien-v-grid',
            'dataProvider'=>$model->searchKonsulGizi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'mergeHeaders'=>array(
                array(
                    'name'=>'<center>Penjamin</center>',
                    'start'=>5,
                    'end'=>6,
                ),
            ),
            'columns'=>array(
                        array(
                            'header'=>'Tanggal Pendaftaran',
                            'name'=>'tgl_pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->tgl_pendaftaran',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tanggal Masuk Penunjang',
                            'name'=>'tglmasukpenunjang',
                            'type'=>'raw',
                            'value'=>'$data->tglmasukpenunjang',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'name'=>'no_pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->no_pendaftaran',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'name'=>'no_rekam_medik',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Nama',
                            'name'=>'nama_pasien',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Alias',
                            'name'=>'nama_bin',
                            'type'=>'raw',
                            'value'=>'$data->nama_bin',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;')
                        ),
                        array(
                            'header'=>'Cara Bayar',
                            'name'=>'carabayar_nama',
                            'type'=>'raw',
                            'value'=>'$data->carabayar_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;')
                        ),
                        array(
                            'header'=>'Penjamin',
                            'name'=>'penjamin_nama',
                            'type'=>'raw',
                            'value'=>'$data->penjamin_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;')
                        ),
                        array(
                            'header'=>'Penanggung',
                            'name'=>'nama_pj',
                            'type'=>'raw',
                            'value'=>'isset($data->nama_pj) ? CHtml::Link($data->nama_pj,Yii::app()->controller->createUrl("DaftarPasien/informasiPenanggung",array("id"=>$data->no_pendaftaran,"frame"=>true)),array("class"=>"", "target"=>"iframeInformasiPenanggung", "onclick"=>"$(\"#dialogInformasiPenanggung\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk melihat Informasi Penanggung Jawab",)) : "-"',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Jenis Kasus Penyakit',
                            'name'=>'jeniskasuspenyakit_nama',
                            'type'=>'raw',
                            'value'=>'$data->jeniskasuspenyakit_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'name'=>'umur',
                            'type'=>'raw',
                            'value'=>'$data->umur',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Alamat',
                            'name'=>'alamat_pasien',
                            'type'=>'raw',
                            'value'=>'$data->alamat_pasien',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Rincian Tagihan',
                            'type'=>'raw',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'value'=>'($data->pembayaranpelayanan_id == null) ? CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->createUrl("gizi/PembayaranGizi/rincian",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                                        array("class"=>"", 
                                              "target"=>"iframeRincianTagihan",
                                              "onclick"=>"$(\"#dialogRincian\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat Rincian Tagihan",
                                        )) : Lunas',          'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        ),
                //RND-5195 - Pembayaran dilakukan dimodul kasir
    //                    array(
    //                        'header'=>'Pembayaran Kasir',
    //                        'type'=>'raw',
    //                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
    //                    ),
                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <fieldset class="box search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </fieldset>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRincian',
        'options' => array(
            'title' => 'Rincian Tagihan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='iframeRincianTagihan' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPembayaranKasir',
        'options' => array(
            'title' => 'Rincian Tagihan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='iframePembayaran' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
</div>