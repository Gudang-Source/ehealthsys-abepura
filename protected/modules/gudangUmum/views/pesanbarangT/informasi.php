<div class="white-container">
    <legend class="rim2">Informasi <b>Pemesanan Barang</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gupesanbarang-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemesanan Barang</b></h6>
        <?php echo $this->renderPartial('gudangUmum.views.pesanbarangT._table', array('model'=>$model)); ?>
    </div>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('gudangUmum.views.pesanbarangT._search',array(
                'model'=>$model,'format'=>$format
        )); ?>
    </fieldset>
<?php 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pemesanan Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => true,
    ),
));

echo '<iframe src="" name="iframeDetail" width="100%" id="iframeDetail" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,\'iframeDetail\')"></iframe>';

$this->endWidget();
?>
</div>
<script>
// untuk me-resize ukuran dalog box
    function resetIframe(obj) {
        obj.style.height = 10 + 'px';
    }
    function autoResizeIframe(obj,id){
            var frameObj = document.getElementById(id);
            resetIframe(frameObj);
            obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }    
</script>