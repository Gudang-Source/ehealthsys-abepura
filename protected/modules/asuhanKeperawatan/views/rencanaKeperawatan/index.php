<div class="white-container">
    <legend class="rim2">Transaksi Rencana <b>Keperawatan</b></legend>
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
	<?php 
            if (isset($_GET['status']))
            {
                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                $this->widget('bootstrap.widgets.BootAlert'); 
            }
        ?>
	<?php //echo $form->errorSummary(array($modRetur,$modBuktiKeluar)); ?>
	<fieldset class="box">
		<legend class="rim">Data Pengkajian</legend>
		<?php $this->renderPartial('_dataPengkajian', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
	</fieldset>
	<?php $this->renderPartial('_ringkasDataPasien', array('model'=>$model,'modPasien' => $modPasien)); ?>
	<fieldset class="box">
		<legend class="rim">Data Rencana</legend>
		<?php $this->renderPartial('_dataRencana', array('model' => $model, 'form' => $form)); ?>
	</fieldset>
	<fieldset class="box">
		<legend class="rim">Rencana Keperawatan</legend>
		<div class="row-fluid block-tabel">
			<table id="table-rencana" class="table table-striped table-bordered table-condensed">
				<thead>
				<th>Diagnosa Keperawatan</th>
				<th>Tanda dan Gejala</th>
				<th>Tujuan</th>
				<th>Kriteria Hasil</th>
				<th>Intervensi</th>
				<th>Kolaborasi</th>
				<th></th>
				</thead>
				<tbody>
					<?php
					$trRencana = $this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail,'modPilih'=>  $modPilih), true);
					echo $trRencana;
					?>
                </tbody>
			</table>
		</div>
	</fieldset>
    <div class="form-actions">
		<?php
		if ($modPengkajian->isNewRecord) {
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
			echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id.'/index').'";}); return false;'));
                        echo "&nbsp;";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)) . "&nbsp&nbsp";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)) . "&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)) . "";
		} else {
			echo CHtml::htmlButton(
					Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
				'class' => 'btn btn-primary',
				'type' => 'submit',
				'onKeypress' => 'return formSubmit(this,event)',
				'disabled' => true
					)
			);
			echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id.'/index').'";}); return false;'));
                        echo "&nbsp;";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
//			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "";
		}
		?>
		 <?php
                    $tips = array(
                        '0' => 'autocomplete-search',                        
                        '1' => 'waktutime',                                               
                        '2' => 'simpan',
                        '3' => 'ulang',
                        '4' => 'print',
                        '5' => 'status_print',
                        '6' => 'detail',
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
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
    window.open("${urlPrint}/&rencanaaskep_id="+$model->rencanaaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
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
	'modPasien' => $modPasien,
//	'modPenanggungJawab' => $modPenanggungJawab,
//	'modRiwayatAnemnesa' => $modRiwayatAnemnesa,
//	'modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik,
	'modPengkajian' => $modPengkajian,
//	'modPenunjang' => $modPenunjang,
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
	'dataProvider' => $modDiagnosaKep->searchDialog(),
	'filter' => $modDiagnosaKep,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
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
        'title' => 'Detail Pengkajian Keperawatan',
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

