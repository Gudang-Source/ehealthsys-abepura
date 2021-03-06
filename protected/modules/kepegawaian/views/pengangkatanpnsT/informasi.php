
<div class="white-container">
    <legend class="rim2">Informasi Pengangkatan PNS</legend>



<?php
$this->breadcrumbs=array(
	'Kppengangkatanpns Ts'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
$('#kppengangkatanpns-t-search').submit(function(){
	$.fn.yiiGridView.update('kppengangkatanpns-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="block-tabel">
        <h6>Tabel <b>Pengangkatan PNS</b></h6>
<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'kppengangkatanpns-t-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Persetujuan Pengangkatan</center>',
                'start'=>8, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
             array(
                'name'=>'<center>Realisasi Pengangkatan</center>',
                'start'=>12, //indeks kolom 3
                'end'=>15, //indeks kolom 4
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
                        'header'=>'Tempat, Tanggal Lahir',
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
                        'header'=>'Alamat Pegawai',
                        'name'=>'alamat_pegawai',
                        'value'=>'$data->pegawai->alamat_pegawai',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                        'header'=>'Tanggal Surat Keputusan',
                        'name'=>'perspeng_id',
                        'value'=>'isset($data->perspeng->perspeng_tglsk)?MyFormatter::formatDateTimeForUser($data->perspeng->perspeng_tglsk):"-"',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                 array(
                        'header'=>'No. SK',
                        'value'=>'isset($data->perspeng->perspeng_nosk)?$data->perspeng->perspeng_nosk:"-"',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                        'header'=>'Masa Kerja',
                        'value'=>function($data){
                            $thn = isset($data->perspeng->perspeng_masakerjatahun)?$data->perspeng->perspeng_masakerjatahun." Thn":"-"; 
                            $bln = isset($data->perspeng->perspeng_masakerjabulan)?$data->perspeng->perspeng_masakerjabulan." Bln":"-";
                            
                            return $thn.' '.$bln;
                        },
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),           
                array(
                        'header'=>'Gaji Pokok',
                        'value'=>'isset($data->perspeng->perspeng_gajipokok)?"Rp".number_format($data->perspeng->perspeng_gajipokok,0,"","."):"-"',
                        'htmlOptions' => array('text-align'=>'right'),
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                        'header'=>'Realisasi Tgl. SK',
                        'value'=>'isset($data->realisasipns->realisasipns_tglsk)?MyFormatter::formatDateTimeForUser($data->realisasipns->realisasipns_tglsk):"-"',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                        'header'=>'Realisasi No. SK',
                        'value'=>'isset($data->realisasipns->realisasipns_nosk)?$data->realisasipns->realisasipns_nosk:"-"',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                        'header'=>'Realisasi Masa Kerja SK',
                        'value'=>'isset($data->realisasipns->realisasipns_masakerjatahun)?$data->realisasipns->realisasipns_masakerjatahun:"-"',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                        'header'=>'Realisasi Gaji Pokok',
                        'value'=>'isset($data->realisasipns->realisasipns_gajipokok)?"Rp".number_format($data->realisasipns->realisasipns_gajipokok,0,"","."):"-"',
                        'htmlOptions' => array('text-align'=>'right'),
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',        
)); ?>
</div>
<?php $this->renderPartial('_search',array('model'=>$model)); ?>
</div>
<?php 
// 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//        $this->widget('UserTips',array('type'=>'admin'));
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
//
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#kppengangkatanpns-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>