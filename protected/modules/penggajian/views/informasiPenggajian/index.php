<div class="white-container">
    <legend class="rim2">Informasi Pengajuan <b>Gaji Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gjpenggajianpeg Ts'=>array('index'),
            'Manage',
    );


    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel Pengajuan <b>Gaji Pegawai</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gjpenggajianpeg-t-grid',
            'dataProvider'=>$model->search(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'NIP',
                        'name'=>'nomorindukpegawai',
                        'value'=>'$data->pegawai->nomorindukpegawai',
                    ),
                    array(
                        'header'=>'Nama Pegawai',
                        'name'=>'nama_pegawai',
                        'value'=>'$data->pegawai->nama_pegawai',
                    ),
                     array(
                        'header'=>'Jabatan',
                        'value'=>'(isset($data->pegawai->jabatan->jabatan_nama) ? $data->pegawai->jabatan->jabatan_nama : "-")',
                    ),
                    array(
                        'header'=>'NPWP',
                        'value'=>'$data->pegawai->npwp',
                    ),
                    array(
                        'name'=>'tglpenggajian',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenggajian)'
                    ),
                    'nopenggajian',
                    'keterangan',
                    'mengetahui',
                    array(
                        'header'=>'Detail',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->createUrl(\'penggajian/PenggajianpegT/detailPenggajian&id=\'.$data->pegawai_id),array("target"=>"_BLANK","rel"=>"tooltip","title"=>"Klik untuk Detail Penggajian"))',
                        'htmlOptions'=>array('style'=>'text-align: left; width:60px'),
                    ),
                    array(
                        'header'=>'Pembayaran',
                        'type'=>'raw',
                        'value'=>'(empty($data->pengeluaranumum_id) ? CHtml::link("<i class=\'icon-form-bayar\'></i>",Yii::app()->createUrl(\'penggajian/Penggajian/index&idPenggajian=\'.$data->penggajianpeg_id),array("target"=>"_BLANK","rel"=>"tooltip","title"=>"Klik untuk melakukan Pembayaran Gaji")): CHtml::link("<i class=\'icon-list-alt\'></i>","javascript:cekpembayaran()",array("rel"=>"tooltip","title"=>"Klik untuk melakukan Pembayaran Gaji")))',
                        'htmlOptions'=>array('style'=>'text-align: left; width:60px'),
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial($this->path_view. '_search',array('model'=>$model)); ?>
    </fieldset>
</div>
<?php 
 
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
//    window.open("${urlPrint}/"+$('#gjpenggajianpeg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    //validasi pembayaran
   function cekpembayaran()
   {
      myAlert("Gaji Pegawai sudah dibayarkan !");
   }
</script>