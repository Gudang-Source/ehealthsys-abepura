<div class="white-container">
    <legend class="rim2">Informasi <b>Pelamar</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Pelamar Ts'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','List').' Data Pelamar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    //$('.search-button').click(function(){
    //	$('.search-form').toggle();
    //	return false;
    //});
    $('#pelamar-t-search').submit(function(){
            $.fn.yiiGridView.update('pelamar-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <!--<div class="search-form" style="display:none">-->

    <!--</div> search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Pelamar</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pelamar-t-grid',
            'dataProvider'=>$model->searchInfoPelamar(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'pelamar_id',
                    array(
                            'header'=>'No.',
                            'value'=>'$data->pelamar_id',
    //                        'filter'=>false,
                    ),
                    array(
                        'header' => 'Tanggal Lowongan',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgllowongan)'
                    ),
                    'nama_pelamar',
                    array(
                        'header' => 'Tempat dan Tanggal Lahir',
                        'value' => '$data->tempatlahir_pelamar.", ".MyFormatter::formatDateTimeForUser($data->tgl_lahirpelamar)'
                    ),                   
                    'jeniskelamin',
                    'alamat_pelamar',
                    array(
                        'header'=>'No Telepon / No HP',
                        'value'=>'$data->nokontakpelamar',
                    ),
                    'alamatemail',
                    array(
                        'header'=>'Status Perkawinan/ Jml Anak',
                        'value'=>'$data->statuskawin',
                    ),                                                                               
                    array(
                        'header'=>'Pendidikan',
                        'value'=>'$data->pendidikannama',
                    ),
                    
    //		array(
    //                        'header'=>Yii::t('zii','View'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{view}',
    //		),
                    array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/View",array("id"=>$data->pelamar_id)) ,array("title"=>"Klik Untuk Lihat Detail Pelamar", "target"=>"iframe", "onclick"=>"$(\"#dialogDetailPelamar\").dialog(\"open\");", ))',
                           'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
                    array(
                            'header'=>'Kontrak',
                            'type'=>'raw',
                            'value'=>function($data){
                               // $cek = KPKontrakKaryawanR::model()->find("pegawai_id = '$data->pegawai_id' ");
                                
                                if (isset($data->tglditerima)){
                                    return "PEGAWAI SUDAH DIKONTRAK";
                                }else{
                                    echo CHtml::link("<i class='icon-form-kontrakkarya'></i> ",Yii::app()->controller->createUrl(Yii::app()->controller->id.'/KontrakPelamar',array("idPelamar"=>$data->pelamar_id)) ,array("title"=>"Klik Untuk Kontrak Pelamar"));
                                }
                            },
                           'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),

    //		array(
    //                        'header'=>'Kontrak Menjadi Pegawai',
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{update}',
    //                        'buttons'=>array(
    //                            'update' => array (
    //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
    //                                        ),
    //                         ),
    //		),
    //		array(
    //                        'header'=>Yii::t('zii','Delete'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{remove} {delete}',
    //                        'buttons'=>array(
    //                                        'remove' => array (
    //                                                'label'=>"<i class='icon-remove'></i>",
    //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
    //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pelamar_id"))',
    //                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
    //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
    //                                        ),
    //                                        'delete'=> array(
    //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
    //                                        ),
    //                        )
    //		),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
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
//    window.open("${urlPrint}/"+$('#pelamar-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php
        // ===========================Dialog Detail Pelamar=========================================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogDetailPelamar',
                // additional javascript options for the dialog plugin
                'options'=>array(
                'title'=>'Detail Pelamar',
                'autoOpen'=>false,
                'width'=>800,
                'height'=>500,
                'resizable'=>false,
                'scroll'=>true    
                 ),
        ));
        ?>
        <iframe src="" name="iframe" width="100%" height="100%">
        </iframe>
        <?php    
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        //===============================Akhir Dialog Detail Pelamar================================