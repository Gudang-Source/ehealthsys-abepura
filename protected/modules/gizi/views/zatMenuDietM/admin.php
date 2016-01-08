<div class="white-container">
    <legend class="rim2">Pengaturan Zat <b>Menu Diet</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <div class="biru">
        <div class="white">
            <?php
            $this->breadcrumbs=array(
                    'Gzzatmenudiet Ms'=>array('index'),
                    'Manage',
            );
            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Zat Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Zat Menu Diet', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Zat Menu Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#ZatMenuDietM_zatgizi_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('zat-menu-diet-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

            $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel Zat <b>Menu Diet</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'zat-menu-diet-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                            'itemsCssClass'=>'table table-striped table-condensed',
                            'template'=>"{summary}{pager}\n{items}",
                    'columns'=>array(
                            array(
                                'header'=>'ID',
                                'value'=>'$data->zatmenudiet_id',
                            ),
                            array(
                                'name'=>'zatgizi_id',
                                'filter'=>CHtml::listData($model->getZatgiziItems(),'zatgizi_id','zatgizi_nama'),
                                'value'=>'$data->zatgizi->zatgizi_nama',
                            ),
                            array(
                                'name'=>'menudiet_id',
                                'filter'=>CHtml::listData($model->getMenuDietItems(),'menudiet_id','menudiet_nama'),
                                'value'=>'$data->menudiet->menudiet_nama',
                            ),
                            'kandunganmenudiet',
                            array(
                                'header'=>Yii::t('mds','View'),
                                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                'template'=>'{view}',
                                'buttons'=>array(
                                        'view' => array(
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat zat menu diet' ),
                                                    ),
                                     ),
                            ),
                            array(
                                'header'=>Yii::t('mds','Update'),
                                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                'template'=>'{update}',
                                'buttons'=>array(
                                        'update' => array(
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah zat menu diet' ),
                                                    ),
                                     ),
                            ),
                            array(
                                'header'=>'Hapus',
                                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                'template'=>'{delete}',
                                'buttons'=>array(
                                        'delete' => array(
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus zat menu diet' ),
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
        </div>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Zat Menu Diet', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('zatMenuDietM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
        
  function cekForm(obj)
{
    $("#gzzatmenudiet-m-search :input[name='"+ obj.name +"']").val(obj.value);
}                
        
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('gzzatmenudiet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script>
$(document).ready(function(){
$("input[name='ZatMenuDietM[kandunganmenudiet]']").focus();
});
</script>