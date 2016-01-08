<div class="white-container">
	<?php
		$sukses = null;
		if(isset($_GET['sukses'])){
			$sukses = $_GET['sukses'];
		}
		if($sukses > 0){ 
			Yii::app()->user->setFlash('success',"Data Permohonan Tukar Dinas berhasil disimpan !");
			$this->widget('bootstrap.widgets.BootAlert');
		}
	?>
	<legend class="rim2">Permohonan <b>Tukar Dinas</b></legend>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'kppenjadwalan-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
		'focus'=>'#',
	)); ?>
	<?php echo $form->errorSummary($model); ?>
	
	<fieldset class="box">
		<legend class="rim">Data Permohonan Tukar Dinas</legend>
		<?php $this->renderPartial('_dataPertukaran',array('form'=>$form,'model'=>$model)); ?>
	</fieldset>
	
	<div class="block-tabel">
                <h6>Tabel Permohon <b>Tukar Dinas</b></h6>
		<?php $this->renderPartial('_detailPertukaran',array('form'=>$form,'model'=>$model,'modDetail'=>$modDetail)); ?>
		<hr />
                <?php $this->renderPartial('_dataPengaju',array('form'=>$form,'model'=>$model,'modDetail'=>$modDetail)); ?>		
	</div>
	<div class="form-actions">
        <div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['pertukaranjadwal_id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasiCek();', 'onkeypress'=>'validasiCek();','disabled'=>$disableSave,)); ?>
		<?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
		?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
		<?php	$content = $this->renderPartial('tips/tipsTransaksi',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
    </div>	
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modDetail'=>$modDetail)); ?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialog_pegawai',
        'options'=>array(
            'title'=>'Daftar Pegawai',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>860,
            'height'=>380,
            'resizable'=>false,
        ),
    )
);
echo CHtml::hiddenField('pegawai_untuk',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukid',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untuknm',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untuktgl',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukshift',"",array('readonly'=>true));
echo CHtml::hiddenField('pegawai_untukjadwalid',"",array('readonly'=>true));
$modDokter = new KPPegawaiV('search');
$modDokter->unsetAttributes();
if (isset($_GET['KPPegawaiV'])){
    $modDokter->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'pegawai-grid',
        'dataProvider'=>$modDokter->search(),
        'filter'=>$modDokter,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                . '"onClick" => "pilihPegawai(\"$data->pegawai_id\",\"$data->NamaLengkap\",\"$data->nomorindukpegawai\");
                    $(\"#dialog_pegawai\").dialog(\"close\");
                    return false;"))',
            ),
            'gelardepan',
            'nama_pegawai',
            'gelarbelakang_nama',
            'jeniskelamin',
            'agama',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>