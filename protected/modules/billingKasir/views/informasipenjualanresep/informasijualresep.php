<div class="white-container">
    <legend class="rim2">Informasi Penjualan <b>Obat Alkes</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Daftar Pasien'=>array('/billingKasir/daftarPasien'),
            'PasienRJ',
    );?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#BKPenjualanresepT_noresep',
                    'method'=>'GET',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Penjualan <b>Obat Alkes</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'pencarianpasien-grid',
            'dataProvider'=>$model->searchPenjualanBebasLuar(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                          array(
                              'header'=>'No. Resep / Struk',
                              'value'=>'$data->noresep',
                              'type'=>'raw',
                          ),
                          array(
                              'header'=>'Total Harga Jual',
                              'value'=>'"Rp. ".number_format($data->totalhargajual,0,"",".")',
                              'type'=>'raw',
                          ),
                          array(
                              'header'=>'Tanggal Penjualan',
                              'value'=>'$data->tglpenjualan',
                          ),
                          'jenispenjualan',
                            array(
                              'header'=>'No. BKM / No. Faktur',
                              'type'=>'raw',
                              'value'=>'((!empty($data->NoFaktur)) ? 
                                            CHtml::Link("<i class=\"icon-print\"></i> $data->NoBkm","",
                                            array("class"=>"", 
                                                  "href"=>"",
                                                  "onclick"=>"printKasir($data->penjualanresep_id,$data->tandaBuktiBayar,\"PRINT\");return false",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk print BKM",
                                            ))."<br>"
                                            .CHtml::Link("<i class=\"icon-print\"></i> $data->NoFaktur","",
                                            array("class"=>"", 
                                                  "href"=>"",
                                                  "onclick"=>"printFaktur($data->penjualanresep_id,$data->tandaBuktiBayar,\"PRINT\");return false",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk print faktur",
                                            )) : "Belum Lunas")'
                          ),
                          array(
                                'header'=>'Rincian Penjualan',
                                'type'=>'raw',
                                'value'=>'CHtml::Link("<i class=\"icon-form-rincianjual\"></i>",Yii::app()->controller->createUrl("informasipenjualanresep/FakturPembayaranApotek",array("penjualanresep_id"=>$data->penjualanresep_id, "tandabuktibayar_id"=>$data->tandaBuktiBayar)),
                                            array("class"=>"", 
                                                  "target"=>"iframeRincianTagihan",
                                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk melihat Rincian Tagihan",
                                            ))',          
                                'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                          ),

    //                        array(
    //                            'header'=>'Pembayaran',
    //                            'type'=>'raw',
    //                            'value'=>'((empty($data->NoFaktur)) ? CHtml::Link("<i class=\"icon-list-silver\"></i>",Yii::app()->createAbsoluteUrl("farmasiApotek/pembayaranLangsung/index",array("penjualanresep_id"=>$data->penjualanresep_id,"frame"=>true)),
    //                                        array("class"=>"", 
    //                                              "target"=>"iframePembayaran",
    //                                              "onclick"=>"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
    //                                              "rel"=>"tooltip",
    //                                              "title"=>"Klik untuk membayar ke kasir",
    //                                        )) : "Sudah Lunas")',          
    //                            'htmlOptions'=>array('style'=>'text-align: left; width:40px')
    //                        ),
                            //TEST NEW 
                            array(
                                'header'=>'Pembayaran',
                                'type'=>'raw',
                                'value'=>'((empty($data->NoFaktur)) ? CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->createAbsoluteUrl("/billingKasir/pembayaranPenjualanApotek/index",array("penjualanresep_id"=>$data->penjualanresep_id,"frame"=>true)),
                                            array("class"=>"", 
                                                  "target"=>"iframePembayaran",
                                                  "onclick"=>"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk membayar ke kasir",
                                            )) : "Sudah Lunas")',          
                                'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                            ),
                ),
            'afterAjaxUpdate'=>'function(penjualanresep_id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <fieldset class="box">
        <?php echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);  ?> 
        <?php Yii::app()->clientScript->registerScript('',"
        function printKasir(penjualanresep_id,tandabuktibayar_id,caraPrint)
        {
            if(tandabuktibayar_id!=''){ 
                     window.open('".Yii::app()->createUrl('billingKasir/informasipenjualanresep/buktiKasMasukFarmasi')."&penjualanresep_id='+penjualanresep_id+'&tandabuktibayar_id='+tandabuktibayar_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=840,height=400,scrollbars=1');
            }     
        }
        function printFaktur(penjualanresep_id,tandabuktibayar_id,caraPrint)
        {
            if(tandabuktibayar_id!=''){ 
                     window.open('".Yii::app()->createUrl('billingKasir/informasipenjualanresep/fakturPembayaranApotek')."&penjualanresep_id='+penjualanresep_id+'&tandabuktibayar_id='+tandabuktibayar_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=840,height=400,scrollbars=1');
            }     
        }
        ",  CClientScript::POS_HEAD);
        ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
            $content = $this->renderPartial('../tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPembayaranKasir',
        'options'=>array(
            'title'=>'Pembayaran',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1001,
            'minWidth'=>1100,
            'minHeight'=>610,
            'resizable'=>true,
            'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe src="" name="iframePembayaran" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    ?>

    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogRincianTagihan',
        'options'=>array(
            'title'=>'Rincian Penjualan',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1001,
            'minWidth'=>980,
            'minHeight'=>610,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" name="iframeRincianTagihan" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    ?>
</div>