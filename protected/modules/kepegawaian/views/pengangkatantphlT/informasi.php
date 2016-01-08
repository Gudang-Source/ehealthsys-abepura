<div class="white-container">
    <legend class="rim2">Informasi <b>Pengangkatan TPHL</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kppengangkatantphl Ts'=>array('index'),
            'Manage',
    );


    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#kppengangkatantphl-t-form').submit(function(){
            $.fn.yiiGridView.update('kppengangkatantphl-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pengangkatan TPHL</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'kppengangkatantphl-t-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'mergeHeaders'=>array(
                array(
                    'name'=>'<center>Pengangkatan TPHL</center>',
                    'start'=>8, //indeks kolom 3
                    'end'=>14, //indeks kolom 4
                ),
            ),
                    'columns'=>array(
                            array(
                                    'header'=>'NIP',
                                    'name'=>'nomorindukpegawai',
                                    'value'=>'$data->pegawai->nomorindukpegawai',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Gelar Depan',
                                    'name'=>'gelardepan',
                                    'value'=>'$data->pegawai->gelardepan',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Nama Pegawai',
                                    'name'=>'nama_pegawai',
                                    'value'=>'$data->pegawai->nama_pegawai',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Tempat, <br> Tanggal Lahir',
                                    'value'=>'$data->pegawai->tempatlahir_pegawai." , ".MyFormatter::formatDateTimeForUser($data->pegawai->tgl_lahirpegawai)',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Jenis Kelamin',
                                    'name'=>'jeniskelamin',
                                    'value'=>'$data->pegawai->jeniskelamin',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Agama',
                                    'name'=>'agama',
                                    'value'=>'$data->pegawai->agama',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Status Perkawinan',
                                    'name'=>'statusperkawinan',
                                    'value'=>'$data->pegawai->statusperkawinan',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Alamat Pegawai',
                                    'name'=>'alamat_pegawai',
                                    'value'=>'$data->pegawai->alamat_pegawai',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'No. Perjanjian',
                                    'name'=>'pengangkatantphl_noperjanjian',
                                    'value'=>'$data->pengangkatantphl_noperjanjian',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'TMT',
                                    'name'=>'pengangkatantphl_tmt',
                                    'value'=>'$data->pengangkatantphl_tmt',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                             array(
                                    'header'=>'No. SK',
                                    'name'=>'pengangkatantphl_nosk',
                                    'value'=>'$data->pengangkatantphl_nosk',
                                     'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Tugas Pekerjaan',
                                    'name'=>'pengangkatantphl_tugaspekerjaan',
                                    'value'=>'$data->pengangkatantphl_tugaspekerjaan',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Tgl. SK',
                                    'name'=>'pengangkatantphl_tglsk',
                                    'value'=>'$data->pengangkatantphl_tglsk',
                                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                             array(
                                    'header'=>'TMT SK',
                                    'name'=>'pengangkatantphl_tmtsk',
                                    'value'=>'$data->pengangkatantphl_tmtsk',
                                     'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            ),
                            array(
                                    'header'=>'Detail',
                                    'type'=>'raw',
                                    'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->createUrl(\'kepegawaian/PengangkatantphlT/detail&pengangkatantphl_id=\'.$data->pengangkatantphl_id.\'&pegawai_id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Pengangkatan TPHL Pegawai","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTphl\").dialog(\"open\");", ))',
                                    'htmlOptions'=>array('style'=>'text-align: left; width:60px'),
                            ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array('model'=>$model)); ?>
    </fieldset>
</div>
<?php
// ===========================Dialog Details Penggajian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetailsTphl',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Detail Pengangkatan TPHL',
                        'autoOpen'=>false,
                        'width'=>1000,
						'height'=>500,
                        'resizable'=>true,
                        'scroll'=>false    
                         ),
                    ));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Penggajian================================
?>