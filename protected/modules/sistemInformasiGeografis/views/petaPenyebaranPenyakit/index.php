<div class="white-container">
	<legend class="rim2">Peta <b>Penyebaran Penyakit</b></legend>
	<?php Yii::app()->clientScript->registerScript('search', "
	$('#penyebearanpenyakit-peta-search').submit(function(){
		setIframePetaPenyebaranPenyakit();
		return false;
	});
	"); ?>


	<fieldset class="box search-form">
            <legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
            <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                    'format'=>$format,
                    'modDiagnosa'=>$modDiagnosa
            )); ?>
	</fieldset><!-- search-form -->

	<div class="row-fluid" id="box-peta">
		<iframe src="" id="iframe_petapenyebaranpenyakit" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>    
	</div>
	

</div>



<?php echo $this->renderPartial('_jsFunctions'); ?>
