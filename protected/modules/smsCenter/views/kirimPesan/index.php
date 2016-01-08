<div class="white-container">
    <?php 
    $this->breadcrumbs=array(
            // 'Sapendidikan Ms'=>array('index'),
            'Manage',
    );
    ?>
    <legend class="rim2">Kirim <b>Pesan</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
    <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll"  width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);" ></iframe>
</div>