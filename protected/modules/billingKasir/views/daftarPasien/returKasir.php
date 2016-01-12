<?php
$this->breadcrumbs=array(
	'Daftar Pasien'=>array('/billingKasir/daftarPasien'),
	'PasienKarcis',
);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'caripasien-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
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
<fieldset>
<legend class="rim2">Informasi Retur Kasir </legend>
<div>
<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarianpasien-grid',
	'dataProvider'=>$model->search(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Tgl. Bukti Bayar',
                'name'=>'tglbuktibayar',
                'type'=>'raw',
                'value'=>'$data->tandabuktibayar->tglbuktibayar."<br>".$data->tandabuktibayar->nobuktibayar',
            ),
            // array(
            //     'name'=>'instalasi',
            //     'type'=>'raw',
            //     'value'=>'$data->pendaftaran->instalasi->instalasi_nama',
            // ),
            // array(
            //     'header'=>'No. Pendaftaran / No. Rekam Medik',
            //     'value'=>'$data->pendaftaran->no_pendaftaran." / ".$data->pasien->no_rekam_medik',
            // ),
            // array(
            //     'name'=>'nama_pasien',
            //     'type'=>'raw',
            //     'value'=>'$data->pasien->namaNamaBin',
            // ),
            array(
                'header'=>'Cara Bayar | Penjamin',
                'name'=>'carabayar_nama',
                'type'=>'raw',
                'value'=>'$data->pendaftaran->carabayar->carabayar_nama."<br>".$data->pendaftaran->penjamin->penjamin_nama',
            ),
            array(
                'name'=>'total_tagihan',
                'type'=>'raw',
                'value'=>'"Rp. ".number_format($data->totalbiayapelayanan)',
            ),
            array(
                'header'=>'Subsidi Asuransi',
                'name'=>'subsidi_asuransi',
                'type'=>'raw',
                'value'=>'$data->totalsubsidiasuransi',
            ),
            array(
                'header'=>'Subsidi Pemerintah',
                'name'=>'subsidi_pemerintah',
                'type'=>'raw',
                'value'=>'$data->totalsubsidipemerintah',
            ),
            array(
                'header'=>'Subsidi RS / Klinik',
                'name'=>'subsidi_rs',
                'type'=>'raw',
                'value'=>'$data->totalsubsidirs',
            ),
            array(
                'header'=>'Biaya',
                'name'=>'iur_biaya',
                'type'=>'raw',
                'value'=>'"Rp. ".number_format($data->totaliurbiaya)',
            ),
            array(
                'header'=>'Disc',
                'name'=>'discount',
                'type'=>'raw',
                'value'=>'$data->totaldiscount',
            ),
            array(
                'header'=>'Pembebasan',
                'name'=>'pembebasan',
                'type'=>'raw',
                'value'=>'$data->totalpembebasan',
            ),
            array(
                'header'=>'Jumlah Pembayaran',
                'name'=>'jumlah_pembayaran',
                'type'=>'raw',
                'value'=>'"Rp. ".number_format($data->totalbayartindakan)',
            ),
            array(
                'header'=>'Rincian Sudah Bayar',
                'type'=>'raw',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianSudahBayar",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframeRincianTagihan",
                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk melihat Rincian Tagihan",
                            ))',          'htmlOptions'=>array('style'=>'text-align: center; width:40px')
            ),            
            array(
                'header'=>'Retur Tagihan Pasien',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("returTagihanPasien/index",array("idPembayaran"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframePembayaran",
                                  "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk meretur tagihan pasien",
                            ))',           'htmlOptions'=>array('style'=>'text-align: center; width:40px')
            ),
            array(
                'header'=>'Kwitansi Pasien',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-list-silver\"></i>",Yii::app()->controller->createUrl("kwitansi/view",array("idPembayaranPelayanan"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframeKwitansi",
                                  "onclick"=>"$(\"#dialogKwitansi\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk cetak Kwitansi",
                            ))',           'htmlOptions'=>array('style'=>'text-align: center; width:40px')
            ),
            array(
                'header'=>'BKM',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("detailKasMasuk",array("idPembayaran"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframeDetPembayaran",
                                  "onclick"=>"$(\"#dialogDetPembayaran\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk detail BKM",
                            ))',
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;'
                            )
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
</div>
</fieldset>

<?php echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);  ?> 

    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
			<?php  
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>

<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRetur',
    'options'=>array(
        'title'=>'Retur Tagihan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframePembayaran" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogKwitansi',
    'options'=>array(
        'title'=>'Kwitansi Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeKwitansi" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetPembayaran',
    'options'=>array(
        'title'=>'Detail Pembayaran',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeDetPembayaran" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianTagihan',
    'options'=>array(
        'title'=>'Rincian Tagihan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>700,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>