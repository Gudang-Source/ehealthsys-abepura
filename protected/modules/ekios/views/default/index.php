<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.infinitecarousel.js"></script>
<script type="text/javascript">

$(function(){
	$("#fasilitas").hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$('#carousel-kiosk').infiniteCarousel({
		displayTime: 6000,
		textholderHeight : .25
	});
	
	// $('#contentKamar').find('div class="paket"').each(
	// 	function(){
	// 		myAlert(1)
	// 	}
	// );

	
	
});

function ekios_home(){
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$('#slider').fadeIn();
}

// $('#fasilitas').hide();
function fasilitas(){
	//myAlert("Menuju Tampilan Fasilitas");
	$('#slider').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$('#fasilitas').fadeIn();
}

function asuransi(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").fadeIn();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$("#infokamar").hide();
}

function kamarperawatan(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").fadeIn();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$("#infokamar").hide();
}

function jadwaldokter(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").fadeIn();
	$("#paketpelayanan").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$("#infokamar").hide();
}

function paketpelayanan(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").fadeIn();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$("#infokamar").hide();
}

function infokamar(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").fadeIn();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
	$("#isi").hide();
	$("#kamarruangan").show();
}

function kritiksaran(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").hide();
	$("#kritiksaran").fadeIn();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").hide();
}

function buatjanji(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").fadeIn();
	$("#bookingkamar").hide();
	$("#denah").hide();
}

function bookingkamar(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").fadeIn();
	$("#denah").hide();
}

function denah(){
	$('#slider').hide();
	$('#fasilitas').hide();
	$("#asuransi").hide();
	$("#kamarperawatan").hide();
	$("#jadwaldokter").hide();
	$("#paketpelayanan").hide();
	$("#infokamar").hide();
	$("#kritiksaran").hide();
	$("#buatjanji").hide();
	$("#bookingkamar").hide();
	$("#denah").fadeIn();
}

</script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/infiniteCarousel.css" type="text/css" />

<!--
<legend class="rim2">KIOSK</legend>-->


	<div id="content">

			<div name="block-kiosk" style="position: relative; overflow: auto; text-align: left; margin: 9px 10px 10px 230px; width: 975px;">
				<?php $this->renderPartial('_slide_picture',array(
					'model'=>$model,
				)); ?>
				<?/**php $this->renderPartial('_fasilitas',array(
					'model'=>$model,
				)); **/?>
				<?/**php $this->renderPartial('_asuransi',array(
					'model'=>$model,
				)); **/?>
				<?/**php $this->renderPartial('_kamarperawatan',array(
					'model'=>$model,
				)); **/?>
				<?/**php $this->renderPartial('_jadwaldokter',array(
					'model'=>$model,
					'format'=>$format,
				)); **/?>
				<?/**php $this->renderPartial('_paketpelayanan',array(
					'model'=>$model,
				)); **/?>
				<?/**php $this->renderPartial('_infokamar',array(
					'model'=>$model,
					'row'=>$row,
				)); **/?>
				<?/**php $this->renderPartial('_kritiksaran',array(
					'model'=>$modKomentar,
				)); **/?>
				<?/**php $this->renderPartial('_buatjanji',array(
					'format'=>$format,
					'model'=>$model,
				)); **/?>
				<?/**php $this->renderPartial('_bookingkamar',array(
					'format'=>$format,
					'model'=>$model,
				)); **/?>
				<?/**php $this->renderPartial('_denah',array(
					'model'=>$model,
				)); **/?>

		</div>
		<!--<div class="dashboard">
			<div class="block-menukiosk">

					<a class="shortcut-home" href="#" onClick="ekios_home()"></a>
					<a class="shortcut-fasilitas" href="#" onClick="fasilitas()"></a>
					<a class="shortcut-asuransi" href="#" onClick="asuransi()"></a>
					<a class="shortcut-perawatan" href="#" onClick="kamarperawatan()"></a>
					<a class="shortcut-jadwal" href="#" onClick="jadwaldokter()"></a>
					<a class="shortcut-pelayanan" href="#" onClick="paketpelayanan()"></a>
					<a class="shortcut-kamar" href="#" onClick="infokamar()"></a>
					<a class="shortcut-saran" href="#" onClick="kritiksaran()"></a>
					<a class="shortcut-janji" href="#" onClick="buatjanji()"></a>
					<a class="shortcut-booking" href="#" onClick="bookingkamar()"></a>
					<a class="shortcut-denah" href="#" onClick="denah()"></a>
			</div>
		</div>-->	
	</div><!-- content -->

<div class="new-container">
    <div class="dashboard">
            <div class="block">
                    <div><h6><?php echo $this->module->id; ?></h6></div>
                    <?php 
                    $menus = $this->module->menu;
                    foreach($menus AS $i => $menu){
                        if($menu->kelmenu_id == Params::KELMENU_ID_DASHBOARD){
                            echo "<a href=".Yii::app()->createUrl($menu->menu_url,array('modul_id'=>$menu->modul_id))." class='shortcut'>";
                            echo "<img height='48' width='48' alt='' src='".Params::urlIconModulDirectory().(empty($menu->menu_icon) ? "images/asuransi_A.jpg" : $menu->menu_icon)."'>";
                            echo "$menu->menu_namalainnya</a>";							
						}
                    } ?>
            </div>
    </div>
</div>

