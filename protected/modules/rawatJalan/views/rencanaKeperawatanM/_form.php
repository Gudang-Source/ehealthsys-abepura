
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sarencana-keperawatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return validasi()'),
        'focus'=>'#',
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

            <?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'rencana_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php //echo $form->textAreaRow($model,'rencana_intervensi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textAreaRow($model,'rencana_rasionalisasi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->checkBoxRow($model,'iskolaborasiintervensi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<table>
    <thead>
        <tr>
            <td>Diagnosa Keperawatan <span class="required">*</span></td>
            <td>
            <?php 
               echo CHtml::activeHiddenField($model, 'diagnosakeperawatan_id');
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'name'=>'DiagnosakeperawatanM[diagnosakeperawatan_kode]',
                                    // 'value'=>$modDiagnosa->diagnosakeperawatan_id,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/DiagnosaKeperawatan').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                     'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'diagnosakeperawatan_id').'").val(ui.item.diagnosakeperawatan_id)
                                                return false;
                                            }',
                                    ),
                                      'htmlOptions'=>array('class'=>'required'),
                                )); 
                ?>  
                <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
                            array('onclick'=>'$("#dialogDiagnosaKeperawatan").dialog("open");return false;',
                                  'class'=>'btn btn-primary',
                                  'onkeypress'=>"return $(this).focusNextInputField(event)",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari diagnosa keperawatan",)); ?>
                
                <?php 
// Dialog buat nambah data diagnosa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDiagnosaKeperawatan',
    'options'=>array(
        'title'=>'Menambah data Diagnosa Keperawatan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>600,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

 $modDiagnosakeperawatan =new RJDiagnosakeperawatanM;
$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'sadiagnosakeperawatan-m-grid', 
    'dataProvider'=>$modDiagnosakeperawatan->search(), 
    'filter'=>$modDiagnosakeperawatan, 
        'template'=>"{summary}\n{items}{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array(
        array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'',
            
            'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectDiagnosaKeperawatan",
                                                      "onClick"=>"
                                                        $(\"#idDiagnosakeperawatan\").val(\"$data->diagnosakeperawatan_id\");
                                                        $(\"#'.CHtml::activeId($model,'diagnosakeperawatan_id').'\").val(\"$data->diagnosakeperawatan_id\");
                                                        $(\"#DiagnosakeperawatanM_diagnosakeperawatan_kode\").val(\"$data->diagnosakeperawatan_kode\");
                                                        $(\"#dialogDiagnosaKeperawatan\").dialog(\"close\");    
                                                        "
                                                 ))',
                ), 
        ////'diagnosa_id',
        array( 
                        'name'=>'diagnosakeperawatan_kode', 
                        'value'=>'$data->diagnosakeperawatan_kode', 
                        'filter'=>false, 
                ),
        //'diagnosakeperawatan_kode',
        'diagnosa_medis',
        
        /*
        'diagnosa_imunisasi',
        'diagnosa_aktif',
        */
       ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

                <?php $this->endWidget(); ?>
        </table>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
            <table id="tbl-RencanaKeperawatan" class="table table-striped table-bordered table-condensed">
           <thead>
            <tr>
               
                <th>Kode</th>
                <th>Rencana Intervensi</th>
                <th>Rencana Rasionalisasi</th>
                <th>Kolaborasi Intervensi</th>
                <th>Tambah</th>
                
                
            </tr>
            </thead>
            
            <tr>

                <?php $isKolaborasi = array(
                                        0 => 'Tidak',
                                        1 => 'Ya'); ?>
                <td>
                    <?php echo $form->textField($model,'[1]rencana_kode',array('class'=>'span2 required', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> 
                </td>
                <td>
                    <?php echo $form->textArea($model,'[1]rencana_intervensi',array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                </td>
                <td>
                    <?php echo $form->textArea($model,'[1]rencana_rasionalisasi',array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
               <td>
                   
                   <?php echo $form->dropDownList($model,'[1]iskolaborasiintervensi',  $isKolaborasi,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)array('empty'=>'--Pilih--')")); ?>
                   
                </td>
                
                                 
                              
                        
              
                            <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                </td>
                        </div>
                    </div>      
                </td> 
            </tr>
        
        </table>
            
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/create'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('create').'";} ); return false;'));  ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Rencana Keperawatan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('rencanaKeperawatanM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                          

<?php
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
	</div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-RencanaKeperawatan tbody tr:first').html();
    $('#tbl-RencanaKeperawatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-RencanaKeperawatan tr:last td:last').append('$buttonMinus');
        
        renameInput('RencanakeperawatanM','rencana_kode');
        renameInput('RencanakeperawatanM','rencana_intervensi');
        renameInput('RencanakeperawatanM','rencana_rasionalisasi');
        renameInput('RencanakeperawatanM','iskolaborasiintervensi');
$('#tbl-RencanaKeperawatan tr:last').find('input').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-RencanaKeperawatan tbody tr').length;
    var i = 1;
    $('#tbl-RencanaKeperawatan tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();

			renameInput('RencanakeperawatanM','rencana_kode');
			renameInput('RencanakeperawatanM','rencana_intervensi');
			renameInput('RencanakeperawatanM','rencana_rasionalisasi');
			renameInput('RencanakeperawatanM','iskolaborasiintervensi');
		}
	});
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
function validasi(){
    var x = 0;
    $('input.required,textarea.required,select.required').each(function(){
        if($(this).val()==""){
            $(this).addClass("error");
            x++;
        }else{
            $(this).removeClass("error");
        }
    });
    if(x>0){
      return false;  
    }else{
        return true;
    }
    
}
</script>
