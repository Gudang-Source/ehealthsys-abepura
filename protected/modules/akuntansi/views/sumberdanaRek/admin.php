<div class='white-container'>
    <legend class='rim2'>Pengaturan Jurnal <b>Rekening Sumber Dana</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Jenis Sumber Dana Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //	(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Sumber Dana ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;                
    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#AKSumberdanaRekM_sumberdana_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sumberdanarek-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel Jurnal <b>Rekening Sumber Dana</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sumberdanarek-m-grid',
            'dataProvider'=>$model->searchIndex(NULL),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No',
                            'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',  
                    ),

                    array(
                            'header'=>'Nama Sumber Dana',
                            'name'=>'sumberdana_nama',
                            'value'=>'$data->sumberdana->sumberdana_nama',  
                    ),

                    array(
                            'header'=>'Rekening Debit',
                            'type'=>'raw',
                            'name'=>'rekDebit',
                            'value'=>'$this->grid->owner->renderPartial("_rek_debet",array("rekening5_nb"=>"D","sumberdana_id"=>$data->sumberdana_id),true)',
                    ),

                    array(
                            'header'=>'Rekening Kredit',
                            'type'=>'raw',
                            'name'=>'rekKredit',
                            'value'=>'$this->grid->owner->renderPartial("_rek_kredit",array("rekening5_nb"=>"K","sumberdana_id"=>$data->sumberdana_id),true)',
                    ), 

                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                    'view' => array (
                                            'label'=>"<i class='icon-view'></i>",
                                            'options'=>array('title'=>Yii::t('mds','View')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->sumberdana_id"))',

                                    ),
                            ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                            'remove' => array (
                                                    'label'=>"<i class='icon-remove'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->sumberdana_id"))',
                                                    'visible'=>'($data->sumberdana_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                                    'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                            ),
                                            'delete' => array (
                                                    'label'=>"<i class='icon-delete'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Delete')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->sumberdana_id"))',               
                                             ),
                            )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jurnal Rekening Sumber Dana ', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 

    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 

    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    ?>
    <?php
    $content = $this->renderPartial('../tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sumberdanarek-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
</div>
<?php 
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogUbahRekeningDebitKredit',
    'options'=>array(
        'title'=>'Ubah Data Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>400,
        'resizable'=>false,
        'close'=>'js:function(){
            $.fn.yiiGridView.update(\'sumberdanarek-m-grid\',{})
        }',
    ),
));
?>
<iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300" >
</iframe>
<?php $this->endWidget(); ?>