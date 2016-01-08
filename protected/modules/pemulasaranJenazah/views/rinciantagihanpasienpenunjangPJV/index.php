<div class='white-container'>
    <legend class="rim2">Informasi Rincian <b>Tagihan Pasien</b></legend>
    <?php
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
    <div class='block-tabel'>
        <h6>Tabel Rincian <b>Tagihan Pasien</b></h6>
        <?php 
        $module  = $this->module->name; 
        $controller = $this->id;
        ?><?php $this->widget('bootstrap.widgets.BootAlert');	?>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'rjrinciantagihanpasien-v-grid',
                'dataProvider'=>$model->searchRincian(),
        //	'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                        'tgl_pendaftaran',
                        array(
                            'header'=>'No. Rekam Medik<br/>No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik.\'<br/>\'.$data->no_pendaftaran',
                        ),
                        array(
                            'header'=>'Nama Pasien / Alias',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien.\'<br/>\'.$data->nama_bin',
                        ),
                        array(
                            'header'=>'Cara Bayar<br/>Penjamin',
                            'type'=>'raw',
                            'value'=>'$data->CaraBayarPenjamin',
                        ),
                        'nama_pegawai',
                        'jeniskasuspenyakit_nama',
                        array(
                            'header'=>'Status Bayar',
                            'type'=>'raw',
                            'value'=>'(empty($data->pembayaranpelayanan_id)) ? "Belum Lunas" : "Lunas"' ,
                        ),
                        array(
                            'header'=>'Total Tagihan',
                            'value'=>'number_format($data->getTotaltagihanpj(),0,".",".")',
                        ),
                        array(
                            'header'=>'Rincian',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->createUrl("'.$module.'/'.$controller.'/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        ),		
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <?php $this->renderPartial('laboratorium.views.rinciantagihanpasienpenunjangV._search',array(
                'model'=>$model,'format'=>$format
        )); ?>
    </fieldset>
</div>
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
<iframe name='frameRincian' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>