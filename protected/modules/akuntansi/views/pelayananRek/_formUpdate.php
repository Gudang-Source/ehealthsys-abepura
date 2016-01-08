<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp ',
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'penjaminpasien-m-form',
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
                    <div class="control-group">
                         <?php echo CHtml::label('Cara Bayar','', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,
                                        array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'AKPenjaminpasienM')), 
                                                    'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
                                                ),
                                    )); 
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                         <?php echo CHtml::label('Penjamin','', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,
                                        array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
                            ?>
                        </div>
                    </div> 
                    
                     <div class='control-group'>
                                  <?php echo $form->labelEx($model,'rekeningdebit_id', array('class'=>'control-label')) ?>
                             <div class="controls">
                                 <?php echo $form->hiddenField($model,'rekeningdebit_id',array('class'=>'span3','maxlength'=>50));  ?>
                                    <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'attribute' => 'rekDebit',
                                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.nmstruktur);
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) {
                                                                $(this).val(ui.item.nmrincianobyek);
                                                                $("#' . CHtml::activeId($model, 'rekeningdebit_id') . '").val(ui.item.rincianobyek_id);
                                                                    return false;
                                                              }'
                                            ),
                                            'htmlOptions' => array(
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'placeholder'=>'Ketikan Nama Rekening',
                                                'class'=>'span3',
                                                'style'=>'width:150px;',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                                        ));
                                    ?>
                             </div>
                   </div>
                    
                   <div class='control-group'>
                                  <?php echo $form->labelEx($model,'rekeningkredit_id', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php echo $form->hiddenField($model,'rekeningkredit_id',array('class'=>'span3','maxlength'=>50));  ?>
                                    <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'attribute' => 'rekKredit',
                                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.nmstruktur);
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) {
                                                                $(this).val(ui.item.nmrincianobyek);
                                                                $("#' . CHtml::activeId($model, 'rekeningkredit_id') . '").val(ui.item.rincianobyek_id);
                                                                    return false;
                                                              }'
                                            ),
                                            'htmlOptions' => array(
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'placeholder'=>'Ketikan Nama Rekening',
                                                'class'=>'span3',
                                                'style'=>'width:150px;',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
                                        ));
                                    ?>
                             </div>
                   </div>
                </td>
            </tr>
        </table>
           <div class="form-actions">
                <?php 
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
                ?>
                <?php 
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.jurnalRekPenjamin.'/admin'), 
                                array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
                ?>
               <?php
                    $content = $this->renderPartial('../tips/transaksi',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
               
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
                                                $(\"#AKPenjaminpasienM_rekeningdebit_id\").val(\"$data->rincianobyek_id\");
                                                $(\"#AKPenjaminpasienM_rekDebit\").val(\"$data->nmrincianobyek\");                                                
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
        
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->search(),
	'filter'=>$modRekKredit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Kode Rekening</center>',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
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
                                                $(\"#AKPenjaminpasienM_rekeningkredit_id\").val(\"$data->rincianobyek_id\");
                                                $(\"#AKPenjaminpasienM_rekKredit\").val(\"$data->nmrincianobyek\");
                                                $(\"#dialogRekKredit\").dialog(\"close\");    
                                                return false;
                            "))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>