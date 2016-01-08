<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'jenispenerimaan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>

        <table>
            <tr>
                <td>
                    <div class='control-group'>
                                  <?php echo $form->labelEx($model,'jenispenerimaan_kode', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php echo $form->textField($model,'jenispenerimaan_kode',array('class'=>'span3','maxlength'=>50)); ?>
                             </div>
                   </div>

                   <div class='control-group'>
                                  <?php echo $form->labelEx($model,'jenispenerimaan_nama', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php echo $form->textField($model,'jenispenerimaan_nama',array('class'=>'span3','maxlength'=>50)); ?>
                             </div>
                   </div>

                   <div class='control-group'>
                                  <?php echo $form->labelEx($model,'jenispenerimaan_namalain', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php echo $form->textField($model,'jenispenerimaan_namalain',array('class'=>'span3','maxlength'=>50)); ?>
                             </div>
                   </div>
                    
                   <div class='control-group'>
                                    <?php echo $form->checkBoxRow($model,'jenispenerimaan_aktif',array('checked'=>'checked')); ?>
                   </div>
                </td>
            </tr>
        </table>
        
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/jurnalRekPenerimaan/admin'), 
                            array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
                ?>       
                <?php $this->widget('UserTips',array('type'=>'update'));?>
	</div>

<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>700,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->search(),
	'filter'=>$modRekDebit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Kode Rekening</center>',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Saldo Normal</center>',
                'start'=>8, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                array(
                    'header'=>'No. Urut',
                    'value'=>'$data->nourutrek',
                ),
                array(
                    'header'=>'Rek. 1',
                    'value'=>'$data->kdstruktur',
                ),
                array(
                    'header'=>'Rek. 2',
                    'value'=>'$data->kdkelompok',
                ),
                array(
                    'header'=>'Rek. 3',
                    'value'=>'$data->kdjenis',
                ),
                array(
                    'header'=>'Rek. 4',
                    'value'=>'$data->kdobyek',
                ),
                array(
                    'header'=>'Rek. 5',
                    'value'=>'$data->kdrincianobyek',
                ),
                array(
                    'header'=>'Nama Rekening',
                    'value'=>'$data->nmrincianobyek',
                ),
                array(
                    'header'=>'Nama Lain',
                    'value'=>'$data->nmrincianobyeklain',
                ),
                array(
                    'header'=>'Saldo Normal',
                    'value'=>'$data->rincianobyek_nb',
                ),
            
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#AKJenispenerimaanM_rekeningdebit_id\").val(\"$data->rincianobyek_id\");
                                                $(\"#AKJenispenerimaanM_rekDebit\").val(\"$data->nmrincianobyek\");                                                
                                                $(\"#dialogRekDebit\").dialog(\"close\");    
                                                return false;
                            "))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
  