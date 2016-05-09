<div class="white-container">
    <legend class="rim2">Informasi <b>Pegawai</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pegawai</b></h6>
        <?php
        $this->breadcrumbs=array(
                'Sapegawai Ms'=>array('index'),
                'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('#sapegawai-m-search').submit(function(){
                $.fn.yiiGridView.update('sapegawai-m-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <!--<div class="search-form" style="display:none">-->
    <?php //$this->renderPartial('_search',array(
            //'model'=>$model,
    //)); ?>
    <!--</div> search-form -->

        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sapegawai-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(

                    array(
                            'header'=>'No. Finger Print',
                            'name'=>'nofingerprint',
                            'value'=>'$data->nofingerprint',

                    ),
                    array(
                            'header'=>'NIP',
                            'name'=>'nomorindukpegawai',
                            'value'=>'$data->nomorindukpegawai',

                    ), /*
                    array(
                            'header'=>'Gelar Depan',
                            'name'=>'gelardepan',
                            'value'=>'$data->gelardepan',

                    ), */
                    array(
                            'header'=>'Nama Pegawai',
                            'name'=>'nama_pegawai',
                            'value'=>'$data->namaLengkap',

                    ), /*
                    array(
                            'header'=>'Nama Keluarga',
                            'name'=>'nama_keluarga',
                            'value'=>'$data->nama_keluarga',

                    ), */
                    array(
                            'header'=>'Tempat, Tanggal Lahir',
                            'value'=>'$data->tempatlahir_pegawai.", ".MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)'

                    ),
                    array(
                            'header'=>'Jenis Kelamin',
                            'name'=>'jeniskelamin',
                            'value'=>'$data->jeniskelamin',
                            'filter'=>CHtml::activeDropDownList($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
                    ),
                    array(
                            'header'=>'Agama',
                            'name'=>'agama',
                            'value'=>'$data->agama',
                            'filter'=>CHtml::activeDropDownList($model, 'agama', LookupM::getItems('agama'), array('empty'=>'-- Pilih --')),
                    ),
                    array(
                            'header'=>'Status Perkawinan',
                            'name'=>'statusperkawinan',
                            'value'=>'$data->statusperkawinan',
                            'filter'=>CHtml::activeDropDownList($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty'=>'-- Pilih --')),
                    ), /*
                    array(
                            'header'=>'Alamat Pegawai',
                            'name'=>'alamat_pegawai',
                            'value'=>'$data->alamat_pegawai',

                    ), */
                    array(
                            'header'=>'Jabatan',
                            'name'=>'jabatan_id',
                            'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "")',
                            'filter'=>CHtml::activeDropDownList($model, 'jabatan_id', CHtml::listData(
                                    JabatanM::model()->findAll(array(
                                        'condition'=>'jabatan_aktif = true',
                                        'order'=>'jabatan_nama'
                                    )),
                                    'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --')),
                    ),
                    array(
							'header'=>'Lihat Riwayat',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-riwayatpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/pegawaiM/Riwayat&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Riwayat Pegawai"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:60px'),
					), 
					array(
							'header'=>'Penilaian Pegawai',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-penilaianpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/PenilaianPegawai/index&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Penilaian Pegawai"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:60px'),
					),
					array(
							'header'=>'kesimpulan dan saran penilaian',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-penilaianpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/kesimpulanPenilaian/index&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"klik untuk input kesimpulan dan saran penilaian"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:60px'),
					),				
					array(
							'header'=>'Kelola Data Pribadi Pegawai',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-kelolapegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/pencatatanRiwayat&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Kelola Data Pribadi Pegawai"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:60px'),
					),
    //                Jika pake dialog box
    //                array(
    //                       'header'=>'Ubah Pegawai',
    //                       'type'=>'raw',
    //                       'value'=>'CHtml::link("<i class=\'icon-edit\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/update",
    //                           array("id"=>$data->pegawai_id)),
    //                           array("title"=>"Klik Untuk Ubah Pegawai","target"=>"iframeUbahPegawai", "onclick"=>"$(\'#dialogUbahPegawai\').dialog(\'open\')"))', 
    //                       'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
    //                    ),
					array(
							'header'=>'Kelola Data Pekerjaan Pegawai',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-pekerjaanpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/pencatatanPekerjaan&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Kelola Data Pekerjaan Pegawai"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:60px'),
					),
					array(
                            'header'=>'Ubah Pegawai',
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array (
                                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            ),
                             ),
                    ),
    //		array(
    //                        'header'=>Yii::t('zii','View'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{view}',
    //		),
    //		
    //		array(
    //                        'header'=>Yii::t('zii','Delete'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{remove} {delete}',
    //                        'buttons'=>array(
    //                        'remove' => array (
    //                                'label'=>"<i class='icon-remove'></i>",
    //                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
    //                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pegawai_id"))',
    //                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
    //                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
    //                        ),
    //                        'delete'=> array(
    //                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
    //                        ),
    //                        )
    //		),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array('model'=>$model)); ?>
    </fieldset>
</div>
<?php 
 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//        $content = $this->renderPartial('../tips/master',array(),true);
//$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
//
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#sapegawai-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php 
// Dialog buat nambah data propinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogPenilaianPegawai',
    'options'=>array(
        'title'=>'Penilaian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>false,
        'close'=>"js:function(){ $.fn.yiiGridView.update('penilaianpegawait-grid', {
                        data: $('#penilaianpegawai-t-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframePenilaianPegawai" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>

<?php
//======================= Dialog Ubah Data Pegawai ===========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogUbahPegawai',
    'options'=>array(
        'title'=>'Ubah Data Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>1024,
        'minHeight'=>500,
        'resizable'=>false,
    ),
));
echo '<iframe src="" name="iframeUbahPegawai" width="100%" height="580"></iframe>';
$this->endWidget();

//==============================================================================
?>

<script>
function refreshGrid(){
    $.fn.yiiGridView.update('sapegawai-m-grid');
    return false;
}
</script>