<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Karcis</b></legend>
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
                    'focus'=>'#BKTindakanPelayananT_no_rekam_medik',
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
        <h6>Tabel <b>Pasien Karcis</b></h6>
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'pencarianpasien-grid',
                'dataProvider'=>$model->searchPasienKarcis(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran',
                    ),
                    array(
                        'header'=>'No. Rekam Medik',
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                    ),
                    array(
                        'name'=>'umur',
                        'type'=>'raw',
                        'value'=>'$data->umur',
                    ),
                    array(
                        'header'=>'Alamat',
                        'name'=>'alamat_pasien',
                        'type'=>'raw',
                        'value'=>'$data->alamat_pasien',
                    ),
                    array(
                        'header'=>'Jenis Kasus Penyakit',
                        'name'=>'jeniskasuspenyakit_nama',
                        'type'=>'raw',
                        'value'=>'(isset($data->jeniskasuspenyakit_id) ? $data->jeniskasuspenyakit_nama : "")',
                    ),
                    array(
                        'header'=>'Cara Bayar/<br/>Penjamin',
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                    ),
                    array(
                        'header'=>'Instalasi/<br/>Ruangan',
                        'name'=>'instalasi',
                        'type'=>'raw',
                        'value'=>'$data->instalasi_nama."/<br/>".$data->ruangan_nama',
                    ),
                    array(
                        'header'=>'Nama Karcis',
                        'name'=>'daftartindakan_nama',
                        'type'=>'raw',
                        'value'=>'$data->daftartindakan_nama',
                    ), /*
                    array(
                        'header'=>'Tarif',
                        'name'=>'tarif_tindakan',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=icon-form-print></i> ".MyFormatter::formatUang($data->tarif_tindakan),"javascript:void(0)",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Print Karcis","onclick"=>"printKarcis($data->pendaftaran_id)"))',
                    ), 
                    array(
                        'header'=>'Pembayaran Karcis',
                        'type'=>'raw',
                        'value'=>'empty($data->tindakansudahbayar_id) ? CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("pembayaranTagihanPasien/index",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogBayarKarcis\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk membayar karcis",
                                    )) : "Sudah Bayar" ',          
                        'htmlOptions'=>array('style'=>'text-align:left; width:40px')
                    ) , */
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
    <fieldset class="box">
        <?php echo $this->renderPartial('_formKriteriaPencarianPKarcis', array('model'=>$model,'form'=>$form,'format'=>$format),true);  ?> 
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl('DaftarPasien/PasienKarcis'), array('class'=>'btn btn-danger','onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php  
                $content = $this->renderPartial('../tips/informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBayarKarcis',
        'options'=>array(
            'title'=>'Pembayaran Karcis',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>1280,
            'zIndex'=>1001,
            'minHeight'=>610,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" name="iframePembayaran" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    ?>
</div>
<script type="text/javascript">
function printKarcis(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/printKarcis'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}
</script>