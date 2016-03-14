<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan <b>Zat Bahan Makanan</b></legend>
<!--<div class="white-container">
    <legend class="rim2">Pengaturan Zat <b>Bahan Makanan</b></legend>-->
    <?php //$this->renderPartial('_tabMenu',array()); ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php
            $this->breadcrumbs=array(
                    'Gzzatbahanmakanan Ms'=>array('index'),
                    'Manage',
            );
            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Zat Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Zat Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Zat Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#ZatBahanMakananM_zatgizi_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('zat-bahan-makanan-m-grid', {
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
                <!--<h6>Tabel Zat <b>Bahan Makanan</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'zat-bahan-makanan-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                            'itemsCssClass'=>'table table-striped table-condensed',
                            'template'=>"{summary}\n{items}{pager}",
                    'columns'=>array(
                            array(
                                'header'=>'ID',
                                'value'=>'$data->zatbahanmakan_id',
                            ),
                            array(
                                'name'=>'zatgizi_id',
                                'filter'=> CHtml::dropDownList('ZatBahanMakananM[zatgizi_id]',$model->zatgizi_id,CHtml::listData($model->getZatgiziItems(), 'zatgizi_id','zatgizi_nama'), array('empty'=>'--Pilih--')),
                                'value'=>'$data->zatgizi->zatgizi_nama',
                            ),
                            array(
                                'name'=>'bahanmakanan_id',
                                'filter'=> CHtml::dropDownList('ZatBahanMakananM[bahanmakanan_id]',$model->bahanmakanan_id,CHtml::listData($model->getBahanMakananItems(), 'bahanmakanan_id', 'namabahanmakanan'), array('empty'=>'--Pilih--')),
                                'value'=>'$data->bahanmakanan->namabahanmakanan',
                            ),
                            //'kandunganbahan',
                            array(
                                'name'=>'kandunganbahan',
                                'filter'=> CHtml::activeTextField($model, 'kandunganbahan', array('class'=>'numbersOnly')),    
                            ),
                            array(
                                'header'=>Yii::t('mds','View'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{view}',
                                'buttons'=>array(
                                    'view' => array(
                                                  'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat zat bahan makanan' ),
                                                ),
                                 ),
                            ),
                            array(
                                'header'=>Yii::t('mds','Update'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{update}',
                                'buttons'=>array(
                                    'update' => array(
                                                  'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah zat bahan makanan' ),
                                                ),
                                 ),
                            ),
                            array(
                                'header'=>'Hapus',
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{delete}',
                                'buttons'=>array(
                                    'delete' => array(
                                                  'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus zat bahan makanan' ),
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
        <!--</div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Zat Bahan Makanan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('zatBahanMakananM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
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
    window.open("${urlPrint}/"+$('#gzzatmenudiet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    
    $js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9.]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
    ?>
</div>
<script>
$(document).ready(function(){
$("input[name='ZatBahanMakananM[kandunganbahan]']").focus();
});
</script>
</fieldset>