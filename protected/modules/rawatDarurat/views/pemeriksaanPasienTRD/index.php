<div class="white-container">
    <legend class="rim2">Pemeriksaan Pasien <b><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></b></legend>

	<?php 
	$this->breadcrumbs=array(
		'Sapendidikan Ms'=>array('index'),
		'Manage',
	);
	?>
	<?php 
	$this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
	$this->renderPartial('_tabMenu',array());
	$this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien)); ?>
	<div>
	<iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
	</div>

</div>