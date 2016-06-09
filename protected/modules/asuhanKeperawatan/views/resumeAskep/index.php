<div class="white-container">
    <legend class="rim2">Transaksi Resume Asuhan <b>Keperawatan</b></legend>
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
	<?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPulang' => $modPulang, 'modDiagnosa' => $modDiagnosa)); ?>
	
	
	<fieldset class="box">
		<legend class="rim">Resume Asuhan Keperawatan</legend>
		<?php $this->renderPartial('_formResumeAskep', array('model'=>$model,'form' => $form)); ?>
	</fieldset>
	
	<fieldset class="box">
		<legend class="rim">Data Resume</legend>
		<?php $this->renderPartial('_dataResume', array('model' => $model, 'form' => $form)); ?>
	</fieldset>
	
    <div class="form-actions">
		<?php
		if ($model->isNewRecord) {
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
    window.open("${urlPrint}/&resumeaskep_id="+$model->resumeaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=1');
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
			'modPulang' => $modPulang,
			'modDiagnosa' => $modDiagnosa,
			'model' => $model,
	'form' => $form));
?>
<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosa = new ASDiagnosakepM('search');
$modDataDiagnosa->unsetAttributes();
if(isset($_GET['ASDiagnosakepM']))
    $modDataDiagnosa->attributes = $_GET['ASDiagnosakepM'];
    $modDataDiagnosa->diagnosakep_nama = (isset($_GET['ASDiagnosakepM']['diagnosakep_nama']) ? $_GET['ASDiagnosakepM']['diagnosakep_nama'] : "");
    $modDataDiagnosa->diagnosakep_kode = (isset($_GET['ASDiagnosakepM']['diagnosakep_kode']) ? $_GET['ASDiagnosakepM']['diagnosakep_kode'] : "");
//echo $modDataDiagnosa->diagnosa_nama;exit;
            

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosa->search(),
    'filter' => $modDataDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($model, 'diagnosakeperawatan') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($model, 'diagnosakeperawatan') . '\").val(\"$data->diagnosakep_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($model, 'diagnosakeperawatan') . '\").val(data+\", $data->diagnosakep_nama\");                                                  
                                                }
                                                $(\"#' . CHtml::activeId($model, 'diagnosakeperawatan') . '\").focus();
												$(\"#dialogDiagnosa\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosakep_kode',
        'diagnosakep_nama',
        'diagnosakep_deskripsi',
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Pencarian Data Tindakan Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataTindakan = new ASIndikatorimplkepdetM('searchDialog');
$modDataTindakan->unsetAttributes();
if(isset($_GET['ASIndikatorimplkepdetM']))
    $modDataTindakan->attributes = $_GET['ASIndikatorimplkepdetM'];
    $modDataTindakan->diagnosakep_nama = (isset($_GET['ASIndikatorimplkepdetM']['diagnosakep_nama']) ? $_GET['ASIndikatorimplkepdetM']['diagnosakep_nama'] : "");
	$modDataTindakan->indikatorimplkepdet_indikator = (isset($_GET['ASIndikatorimplkepdetM']['indikatorimplkepdet_indikator']) ? $_GET['ASIndikatorimplkepdetM']['indikatorimplkepdet_indikator'] : "");
//echo $modDataDiagnosa->diagnosa_nama;exit;
            

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tindakan-m-grid',
    'dataProvider' => $modDataTindakan->searchDialog(),
    'filter' => $modDataTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectTindakan",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($model, 'tindakankeperawatan') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($model, 'tindakankeperawatan') . '\").val(\"$data->indikatorimplkepdet_indikator\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($model, 'tindakankeperawatan') . '\").val(data+\", $data->indikatorimplkepdet_indikator\");                                                  
                                                }
                                                $(\"#' . CHtml::activeId($model, 'tindakankeperawatan') . '\").focus();
												$(\"#dialogTindakan\").dialog(\"close\");    
                                        "))',
        ),
		array(
			'header' => 'Diagnosa',
			'name' => 'diagnosakep_nama',
			'value' => '$data->diagnosakep_nama',
			'filter' => CHtml::activeDropdownList($modDataTindakan,'diagnosakep_nama',CHtml::listData(ASDiagnosakepM::model()->findAll(),'diagnosakep_nama','diagnosakep_nama'),array('empty'=>'--Pilih--')) . "<br>" .
                                    CHtml::activeHiddenField($modDataTindakan, "diagnosakep_id", array('readonly' => true))
		),
        'indikatorimplkepdet_indikator',
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
