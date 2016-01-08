<div class="white-container">
    <legend class="rim2">Pengaturan Mapping <b>Kelas Terapi Obat</b></legend>
    <?php
    if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Kelas Terapi Obat berhasil disimpan !');
    }
    ?>
    <?php
    $this->breadcrumbs=array(
            'GFTherapimapobatM Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GFObatAlkesM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Obat Alkes ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#GFObatalkesM_obatalkes_nama').focus();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('gfobat-alkes-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div>
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel Mapping <b>Kelas Terapi Obat</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gfobat-alkes-m-grid',
            'dataProvider'=>$model->searchMapping(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                                    array(
                                                    'header'=>'No.',
                                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                                    : ($row+1)',
                                                    'type'=>'raw',
                                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
                    array(
                            'header'=>'Nama Obat',
                                                    'name'=>'obatalkes.obatalkes_nama',
                            'value'=>'$data->obatalkes->obatalkes_nama',
                            'filter'=>CHtml::activeTextField($model, 'obatalkes_nama'),
                    ),
                    array(
                            'header'=>'Nama Kelas Terapi',
                                                    'name'=>'therapiobat.therapiobat_nama',
                            'value'=>'$data->therapiobat->therapiobat_nama',
                            'filter'=>CHtml::activeTextField($model, 'therapiobat_nama'),
                    ),
                                    array(
                                                    'header'=>Yii::t('zii','View'),
                                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                                    'template'=>'{view}',
                                                    'buttons'=>array(
                                                            'view'=>array(
                                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View", array("therapiobat_id"=>"$data->therapiobat_id","obatalkes_id"=>"$data->obatalkes_id"))',
                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Obat Alkes'),
                                                            ),
                                                    ),
                                    ),
                                    array(
                                                    'header'=>Yii::t('zii','Update'),
                                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                                    'template'=>'{update}',
                                                    'buttons'=>array(
                                                            'update' => array (
                                                                                      'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/index",array("therapiobat_id"=>"$data->therapiobat_id","obatalkes_id"=>"$data->obatalkes_id"))',
                                                                                      'options'=>array('rel'=>'tooltip','title'=>'Ubah Obat Alkes'),
                                                                                    ),
                                                     ),
                                    ),
                                    array(
                                                    'header'=>'Hapus',
                                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                                    'template'=>'{delete}',
                                                    'buttons'=>array(
                                                            'delete'=>array(
                                                                       'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete", array("therapiobat_id"=>"$data->therapiobat_id","obatalkes_id"=>"$data->obatalkes_id"))',
                                                                       'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus' ),
                                                            ),
                                                    ),
                                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    <!--</div>-->
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Kelas Terapi Obat', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('index',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>