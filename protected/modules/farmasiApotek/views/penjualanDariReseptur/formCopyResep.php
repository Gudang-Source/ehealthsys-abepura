<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'facopyresep-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert');?>

<legend class="rim2">Salin Resep</legend> 
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary(array($model)); ?>
<fieldset>    
        <table>
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modelPenjualanResep,'noresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modelPenjualanResep,'noresep',array('class'=>'span3','readonly'=>true));
                                 echo $form->hiddenField($modelPenjualanResep,'penjualanresep_id',array('class'=>'span2','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPasien,'no_rekam_medik', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modPasien,'no_rekam_medik',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                 <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modelPenjualanResep,'tglresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modelPenjualanResep,'tglresep',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modPasien,'nama_pasien',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::label('Dokter','dokter', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo CHtml::textField($modelPenjualanResep->pegawai_id,isset($modelPenjualanResep->pegawai->NamaLengkap)?$modelPenjualanResep->pegawai->NamaLengkap:'-',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPasien,'alamat_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textArea($modPasien,'alamat_pasien',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        
        <table id="table-obatalkespasien" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Resep</th>
					<th>R ke</th>
					<th>Kode / Nama Obat Pada Resep</th>
					<th width='180'>Kode / Nama Obat Dilayani</th>
					<th>Jumlah Pada Resep</th>
					<th>Jumlah Dilayani</th>
					<th>Sumber Dana</th>
					<th>Satuan Kecil</th>
					<th>Harga</th>
					<th>Sub Total</th>
					<th>Signa</th>
					<th>Etiket</th>
					<th>Tipe Racikan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modObatAlkesPasien) > 0){
                    foreach($modObatAlkesPasien AS $iii=> $modDetail){
//                        echo $this->renderPartial('_rowDetailCopyResep',array('modObatAlkesPasien'=> $modDetail));
                        echo $this->renderPartial('_rowDetailOaPasien',array('modObatAlkesPasien'=> $modDetail,'iii'=>$iii,'modDetailReseptur'=>$modDetailReseptur));
                    }
                }
                ?>
            </tbody>
        </table>
        <table>
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'keterangancopy', array()) ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                     <div class="control-group ">
                            <?php   
                                 echo $form->textArea($model,'keterangancopy',array('class'=>'span3','readonly'=>false));
                            ?>
                    </div>
                </td>
            </tr>
        </table>
</fieldset>
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Salin Resep',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary', 'type'=>'submit'))."&nbsp"; ; ?>

        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), array('class'=>'btn btn-danger','onclick'=>'ulang(this.id)'))."&nbsp"; ; ?>
        <?php if(($tersimpan == 'Ya')){ ?>
            <script>
                print(<?php echo $modelPenjualanResep->penjualanresep_id?>,'PRINT');
            </script>
		<?php } ?>
		<?php
			$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
			$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
			$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPenjualanObat');
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\''.$modelPenjualanResep->penjualanresep_id.'\',\'PRINT\')'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\''.$modelPenjualanResep->penjualanresep_id.'\',\'PDF\')'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\''.$modelPenjualanResep->penjualanresep_id.'\',\'EXCEL\')'))."&nbsp&nbsp"; 
		?>
    </div>

<?php $this->endWidget(); ?>
	
<?php // if($tersimpan=='Ya'){ ?>
<script>//
//parent.location.reload();
//</script>
<?php // } ?>
	
<?php
$urlPrintCopyResep = Yii::app()->createUrl('farmasiApotek/PenjualanDariReseptur/PrintCopyResep',array('idPenjualanResep'=>''));
$jscript = <<< JS
function print(idPenjualanResep,caraPrint)
{
    window.open("${urlPrintCopyResep}"+idPenjualanResep+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JS;
Yii::app()->clientScript->registerScript('jsCopyResep',$jscript, CClientScript::POS_BEGIN);
?>
<?php // $this->renderPartial('_jsFunctions', array('modPenjualan'=>$modelPenjualanResep)); ?>
<script type="text/javascript">
function ulang(id){
    $('#<?php echo CHtml::activeId($model,"keterangancopy"); ?>').val('');
}
$(document).ready(function(){
	formatNumberSemua();
});
</script>
