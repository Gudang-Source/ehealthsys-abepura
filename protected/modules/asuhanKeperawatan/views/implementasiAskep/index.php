<div class="white-container">
    <legend class="rim2">Transaksi Implementasi <b>Keperawatan</b></legend>
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
			'onsubmit' => 'return requiredCheck(this);'
		// 'onsubmit'=>'return cekOtorisasi();'
		),
	));
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php //echo $form->errorSummary(array($modRetur,$modBuktiKeluar)); ?>
	<fieldset class="box">
		<legend class="rim">Data Rencana</legend>
		<?php $this->renderPartial('_dataRencana', array('modRencana' => $modRencana, 'form' => $form)); ?>
	</fieldset>
	<?php $this->renderPartial('_ringkasDataPasien', array('modPasien' => $modPasien)); ?>
	<fieldset class="box">
		<legend class="rim">Data Implementasi</legend>
		<?php $this->renderPartial('_dataImplementasi', array('model' => $model, 'form' => $form)); ?>
	</fieldset>
	<fieldset class="box">
		<legend class="rim">Implementasi Keperawatan</legend>
		<div class="row-fluid block-tabel">
			<table id="table-rencana" class="table table-striped table-bordered table-condensed">
				<thead>
				<th>Diagnosa Keperawatan</th>
				<th>Rencana Intervensi</th>
				<th>Implementasi</th>
				<th>Kolaborasi</th>
				</thead>
				<tbody>
					<?php
					$trImplementasi = $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail,'modPilih'=>  $modPilih), true);
					echo $trImplementasi;
					?>
                </tbody>
			</table>
		</div>
	</fieldset>
    <div class="form-actions">
		<?php
		if ($model->isNewRecord) {
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
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
		<?php
		echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/implementasiKeperawatan/index'), array('class' => 'btn btn-danger',
			'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
		?>
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
    window.open("${urlPrint}/&implementasiaskep_id="+$model->implementasiaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
		Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
		?>
    </div>

	<?php $this->endWidget(); ?>
</div>
<?php
$this->renderPartial('_jsFunctions', array(
	'model'=>$model,
	'modDetail' => $modDetail,
	'modRencana' => $modRencana,
	'form' => $form));
?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogDiagnosa',
	'options' => array(
		'title' => 'Diagnosa Keperawatan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 800,
		'height' => 500,
		'resizable' => false,
	),
));

$modDiagnosaKep = new ASDiagnosakepM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['ASDiagnosakepM'])) {
	$modDiagnosaKep->attributes = $_GET['ASDiagnosakepM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'diagnosakep-m-grid',
	'dataProvider' => $modDiagnosaKep->search(),
	'filter' => $modDiagnosaKep,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
									setDiagnosaAuto($data->diagnosakep_id);
									"))'
		),
		array(
			'header' => 'Kode Diagnosa',
			'name' => 'diagnosakep_kode',
			'value' => '$data->diagnosakep_kode',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'type' => 'raw',
			'name' => 'diagnosakep_nama',
			'value' => '$data->diagnosakep_nama',
		),
		array(
			'header' => 'Deskripsi',
			'name' => 'diagnosakep_deskripsi',
			'value' => '$data->diagnosakep_deskripsi',
		),
		array(
			'header' => 'Status',
			'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
			'filter' => CHtml::dropDownList(
					'diagnosakep_aktif', $modDiagnosaKep->diagnosakep_aktif, array('1' => 'Aktif',
				'0' => 'Tidak Aktif',), array('empty' => '--Pilih--'))
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Rencana Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>

