<div class="white-container">
    <?php
    $this->breadcrumbs=array(
        'Outboxes'=>array('index'),
        'Manage',
    );

    $arrMenu = array();
    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>' Pesan Terkirim ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('sentitems-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form" style="display:none">
        <?php 

        ?>
    </div><!-- search-form -->
    <legend class="rim2">Pesan <b>Terkirim</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pesan Terkirim</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sentitems-grid',
            'dataProvider'=>$model->searchTable(),
            'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                'SendingDateTime',
                'SMSCNumber',
                'DestinationNumber',
                'TextDecoded',
                'Status',

            ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
</div>
<?php 
 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sentitems-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?> 

<script type="text/javascript">
  setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
    function(){
        $.fn.yiiGridView.update('sentitems-grid', {   // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
        data: $(this).serialize()
    });
     return false;
 }, 
 10000  // fungsi di eksekusi setiap 10 detik sekali
);
</script>
