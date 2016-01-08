<div class="white-container">
    <legend class="rim2">Pengaturan <b>Paket Pelayanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapaketpelayanan Ms'=>array('index'),
            'Manage',
    );


    $arrMenu = array();
    //	(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Paket Pelayanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('satipe-paket-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Paket Pelayanan</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
            'id'=>'satipe-paket-m-grid', 
            'dataProvider'=>$modTipePaket->search(), 
            'filter'=>$modTipePaket, 
                'template'=>"{summary}\n{items}\n{pager}", 
                'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
            'columns'=>array( 
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                'tipepaket_nama',
                array(
                                'header'=>'Nama Tindakan',
                                'type'=>'raw',
                                'value'=>'$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.paketpelayananM._daftarTindakan\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
                ),
                array( 
                                'header'=>Yii::t('zii','View'), 
                    'class'=>'bootstrap.widgets.BootButtonColumn', 
                                'template'=>'{view}', 
                ), 
                array( 
                                'header'=>Yii::t('zii','Update'), 
                    'class'=>'bootstrap.widgets.BootButtonColumn', 
                                'template'=>'{update}', 
                                'buttons'=>array( 
                                        'update' => array ( 
                                        ), 
                                 ), 
                ), 
                array( 
                                'header'=>Yii::t('zii','Delete'), 
                                'class'=>'bootstrap.widgets.BootButtonColumn', 
                                'template'=>'{delete}', 
                                'buttons'=>array( 
                                        'delete'=> array( 
                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))', 
                                        ), 
                                ) 
                ), 
            ), 
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
        )); ?>
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Paket Pelayanan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('sistemAdministrator.views.tips.master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#satipe-paket-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>