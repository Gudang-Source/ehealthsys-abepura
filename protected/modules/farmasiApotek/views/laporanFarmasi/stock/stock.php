<div class="white-container">
    <legend class="rim2"> Laporan <b>Stock</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <?php
            $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/FrameStockFarmasi&id=1');
            Yii::app()->clientScript->registerScript('searchTable', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
			});
			$('.search-form form').submit(function(){
				$('#Grafik').attr('src','').css('height','0px');
				$.fn.yiiGridView.update('laporan-grid', {
						data: $(this).serialize()
				});
				return false;
			});
			");
        ?>
        
		
        <div class="box search-form">
			<?php $this->renderPartial('stock/_search',array(
				'model'=>$model,
			)); ?>
		</div>
        
    </fieldset>
    <?php
//    $this->endWidget();
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Stock</b></h6>
        <?php $this->renderPartial('stock/_tableStock',array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintStock');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>