<div class="white-container">
    <legend class="rim2">Transaksi Pengkajian <b>Keperawatan</b></legend>
	<?php
	$this->breadcrumbs = array(
		'Pembayaran',
	);
	?>


	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'pembayaran-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal',
		'focus' => '#ASPendaftaranT_no_pendaftaran',
		'htmlOptions' => array(
			'onKeyPress' => 'return disableKeyPress(event)',
			'onsubmit' => 'return cekRequired();'
		// 'onsubmit'=>'return cekOtorisasi();'
		),
	));
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php //echo $form->errorSummary(array($modRetur,$modBuktiKeluar)); ?>
	<?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
	<?php
	$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
		'id' => 'penanggungjawab',
		'content' => array(
			'content-penanggungjawab' => array(
				'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Penanggung Jawab Pasien')) . '<b> Penanggung Jawab Pasien</b>',
				'isi' => $this->renderPartial($this->path_view . '_penanggungJawab', array(
					'form' => $form,
					'modPenanggungJawab' => $modPenanggungJawab,
						), true),
				'active' => false,
			),
		),
	));
	?>
	<?php
	$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
		'id' => 'anemnesa',
		'content' => array(
			'content-anemnesa' => array(
				'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Riwayat Anamnesis')) . '<b> Riwayat Anamnesis</b>',
				'isi' => '
                                        <table class="table table-striped table-condensed table-bordered">
                                            <thead>
												<th>pilih</th>
                                                <th>Tgl. Anamnesis</th>
                                                <th>Keluhan Utama</th>
                                                <th>Keluhan Tambahan</th>
                                                <th>Riwayat Penyakit Terdahulu</th>
                                                <th>Riwayat Penyakit Keluarga</th>
                                                <th>Riwayat Imunisasi</th>
												<th>Riwayat Alergi Obat</th>
												<th>Riwayat Makanan</th>
												<th></th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=10>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
				'active' => false,
			),
		),
	));
	?>
	<?php
	$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
		'id' => 'periksafisik',
		'content' => array(
			'content-periksafisik' => array(
				'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Riwayat Pemeriksaan Fisik')) . '<b> Riwayat Pemeriksaan Fisik</b>',
				'isi' => '
                                        <table class="table table-striped table-condensed table-bordered">
                                            <thead>
												<th>Pilih</th>
                                                <th>Tgl. Periksa Fisik</th>
                                                <th>Keadaan Umum</th>
                                                <th>Berat Badan (Kg)</th>
                                                <th>Tinggi Badan (cm)</th>
                                                <th>Tekanan Darah</th>
                                                <th>Detak Nadi</th>
												<th>Suhu Tubuh</th>
												<th>Pernapasan</th>
												<th>Kesadaran / GCS (Eye / Verbal / Motorik)</th>
												<th>Kelainan Pada Bag. Tubuh</th>
												<th></th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=12>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
				'active' => false,
			),
		),
	));
	?>
	<fieldset class="box">
		<legend class="rim">Data Pengkajian</legend>
		<?php $this->renderPartial('_dataPengkajian', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
	</fieldset>
	<?php
//	$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//		'id' => 'pengkajian-askep-t',
//		'content' => array(
//			'content-pengkajian-askep-t' => array(
//				'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Data Pengkajian Keperawatan')) . '<b> Data Pengkajian Keperawatan</b>',
//				'isi' => $this->renderPartial($this->path_view . '_formPengkajian', array(
//					'form' => $form,
//					'modPengkajian' => $modPengkajian,
//						), true),
//				'active' => false,
//			),
//		),
//	));
//	?>
	<fieldset class="box">
		<legend class="rim">Data Penunjang</legend>
		<div class="row-fluid block-tabel">
			<h6>Tabel <b>Data Penunjang</b></h6>
			<table id="table-penunjang" class="table table-striped table-bordered table-condensed">
				<thead>
				<th>Tanggal</th>
				<th>Data Penunjang</th>
				</thead>
				<tbody>
                </tbody>
			</table>
		</div>
	</fieldset>

    <div class="form-actions">
		<?php
		if ($modPengkajian->isNewRecord) {
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
			echo "&nbsp;&nbsp;";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)) . "&nbsp&nbsp";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)) . "&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)) . "&nbsp&nbsp";
		} else {
			echo CHtml::htmlButton(
					Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array(
				'class' => 'btn btn-primary',
				'type' => 'submit',
				'onKeypress' => 'return formSubmit(this,event)',
				'disabled' => true
					)
			);
			echo "&nbsp;&nbsp;";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
		}
		?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/pengkajianAskep/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
		<?php
		/*
		  echo CHtml::htmlButton(
		  Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
		  array(
		  'class'=>'btn btn-danger',
		  'type'=>'reset'
		  )
		  );
		 * 
		 */
		?>
		<?php
		$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
		$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
		$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
		$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

		$js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&pengkajianaskep_id="+$modPengkajian->pengkajianaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
		Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
		?>
    </div>

	<?php $this->endWidget(); ?>
</div>
<?php
$this->renderPartial('_jsFunctions', array('modPendaftaran' => $modPendaftaran,
	'modPasien' => $modPasien,
	'modPenanggungJawab' => $modPenanggungJawab,
	'modRiwayatAnemnesa' => $modRiwayatAnemnesa,
	'modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik,
	'modPengkajian' => $modPengkajian,
	'modPenunjang' => $modPenunjang,
	'form' => $form));
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailAnamnesis',
    'options' => array(
        'title' => 'Detail Riwayat Anamnesis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetailAnamnesis" width="100%" height="500">
</iframe>';

$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailFisik',
    'options' => array(
        'title' => 'Detail Riwayat Pemeriksaan Fisik',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetailFisik" width="100%" height="500">
</iframe>';

$this->endWidget();
?>

