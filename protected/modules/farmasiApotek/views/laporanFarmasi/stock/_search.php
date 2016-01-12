<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        #penjamin, #ruangan, #statusBayar{
            width:250px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox, #statusBayar label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style>
    <div class="row-fluid">
        <div class="span12">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<table width="100%">
				<tr>
					<td colspan="2">
						<?php echo $form->dropDownListRow($model, 'jenisobatalkes_id', CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
					</td>
					<td colspan="2">
						<?php echo $form->textFieldRow($model, 'obatalkes_nama',array('class'=>'span3')); ?>
					</td>
					<td colspan="2">
						<?php echo $form->textFieldRow($model, 'obatalkes_kode',array('class'=>'span3')); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="controls">
							<?php echo CHtml::checkBox('FAInfostokobatalkesruanganV[qtystok_in]', true, array('value' => 0));?>
							<?php echo CHtml::label('Stok Masuk 0', 'qtystok_in');?>
						</div>
						<div class="controls">
							<?php echo CHtml::checkBox('FAInfostokobatalkesruanganV[qtystok_out]', true, array('value' => 0));?>
							<?php echo CHtml::label('Stok Keluar 0', 'qtystok_out');?>
						</div>

					</td>   
				</tr>
			</table>
        </div>
    </div>       
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'));
        ?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanPenjualanObat', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD); ?>
