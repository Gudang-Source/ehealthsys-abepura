<div class="white-container">
    <legend class="rim2">Informasi <b>Mutasi Barang</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gumutasibrg-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Mutasi Barang</b></h6>
        <?php echo $this->renderPartial($this->path_view.'_table', array('model'=>$model));  ?> 
    </div>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </fieldset><!-- search-form -->

    <?php 

    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    //        $this->widget('UserTips',array('type'=>'admin'));
           $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
           $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
           $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>

    <?php
    //========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Mutasi Barang',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    echo '<iframe src="" name="frameDetail" width="100%" height="500">
    </iframe>';

    $this->endWidget();
    ?>
</div>