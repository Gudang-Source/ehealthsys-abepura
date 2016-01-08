
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadaftar-tindakan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SADaftarTindakanM_komponenunit_id',
)); ?> 

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary(array($model,$modTarifTindakan)); ?>
        <table width="100%">
            <tr>
                <td width="34%">   
                    <?php echo $form->dropDownListRow($model,'komponenunit_id',  CHtml::listData($model->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model,'kelompoktindakan_id',  CHtml::listData($model->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model,'daftartindakan_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                    <?php echo $form->textFieldRow($model,'daftartindakan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                </td>
                <td width="33%">
                    <?php echo $form->dropDownListRow($model,'kategoritindakan_id',  CHtml::listData($model->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                    <?php echo $form->textFieldRow($model,'tindakanmedis_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                    <?php echo $form->textFieldRow($model,'daftartindakan_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td width="33%">
                    <fieldset class="box">
                        <legend class="rim">Tindakan</legend>
                        <div class="control-group ">
                            <div class="controls">
                                <div class="radio inline">
                                    <div class="form" style="width:50px;">
                                         <?php $status = array('Visite'=>'Visite', 'Konsul'=>'Konsul','Karcis'=>'Karcis','Akomodasi'=>'Akomodasi'); ?>

                                         <?php echo CHtml::radioButtonList('status_tindakan','status_tindakan',$status, 
                                                 array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'status_tindakan')); ?>            
                                    </div>
                               </div>
                            </div>
                        </div>
                    </fieldset>
                </td>
            </tr>
                 
<!--                <td colspan="2">
                    <fieldset>
                        <legend>Tindakan</legend>
                        
                        <table>
                            <tr>
                                <td>
                                    <?php //echo $form->checkBoxRow($model,'daftartindakan_karcis', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                                <td>
                                    <?php //echo $form->checkBoxRow($model,'daftartindakan_visite', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                   <?php //echo $form->checkBoxRow($model,'daftartindakan_konsul', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                                <td>
                                    <?php //echo $form->checkBoxRow($model,'daftartindakan_akomodasi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>-->
        </table>
	<?php
	/* pengaturan tarif ada di:
	 * sistemAdministrator/TarifTindakan/Admin
	 * karena cukup kompleks (multi tarif)
        <fieldset>
            <legend class="accord1" style="width:460px;"><?php echo CHtml::checkBox('cekTarifTindakan',true, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?> Tarif Tindakan </legend>
            <div id="divTarifTindakan" class="control-group">
                <table>
                    <tr>
                        <td>
                            <?php echo $form->hiddenfield($modTarifTindakan,'perdatarif_id',array('value'=>  Params::DEFAULT_PERDA_TARIF)); ?>
                            <?php echo $form->dropDownListRow($modTarifTindakan,'jenistarif_id',  CHtml::listData($modTarifTindakan->JenisTarifItems, 'jenistarif_id', 'jenistarif_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        </td>
                        <td>
                            <div class="control-group">
                                <?php echo $form->labelex($modTarifTindakan,'Diskon',array('class'=>"control-label required")) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modTarifTindakan,'persendiskon_tind',array('value'=>0,'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> %
                                </div>
                            </div>

                            
                            <div class="control-group">
                                <?php echo $form->labelex($modTarifTindakan,'Diskon',array('class'=>"control-label required")) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modTarifTindakan,'hargadiskon_tind',array('value'=>0,'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Rupiah
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo $form->labelex($modTarifTindakan,'Cyto',array('class'=>"control-label required")) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modTarifTindakan,'persencyto_tind',array('value'=>0,'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> %
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="table" id="divDaftartindakan">

                          <table width="500px" class="items table table-bordered table-condensed" id="tblInputTarifTindakan">
                          <thead>
                                <th>Kelas Pelayanan</th>
                                <th>Komponen Tarif</th>
                                <th>Harga Tindakan</th>
                                <th></th>
                          </thead>
                            <tbody id="tblTarifTindakan">
                                <tr>
                                    <td>
                                        <?php echo $form->dropDownList($modTarifTindakan,'[0]kelaspelayanan_id',
                                              CHtml::listData($modTarifTindakan->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                                              array('onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih Lokasi --',
                                                    'class'=>'span2')); ?>
                                        <span class="required">*</span>
                                    </td>
                                    <td>
                                        <?php 
                                            $komponen = KomponentarifM::model()->findAll('komponentarif_id != :komponentarif',array(':komponentarif'=>  Params::KOMPONENTARIF_ID_TOTAL));
                                            foreach($komponen as $hasil):
                                                $arrHasil[] = array(    
                                                  'label'=>$hasil->komponentarif_nama,
                                                  'value'=>$hasil->komponentarif_nama,
                                                  'id'=>$hasil->komponentarif_id,);
                                            endforeach;
                                         ?>
                                        <?php echo CHtml::activeHiddenField($modTarifTindakan, '[0]komponentarif_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
                                        <?php $this->widget('MyJuiAutoComplete',array(
                                                    'model'=>$modTarifTindakan,
                                                    'attribute'=>'[0]komponentarifNama',
                                                    'source'=>$arrHasil,
                                                    'options'=>array(
                                                       'showAnim'=>'fold',
                                                       'minLength' => 2,
                                                       'focus'=> 'js:function( event, ui ) {
                                                            $(this).val( ui.item.label);
                                                            return false;
                                                        }',
                                                       'select'=>'js:function( event, ui ) {
                                                           setTindakan($(this), ui.item);
                                                            return false;
                                                        }',

                                                    ),
                                                    'tombolDialog'=>array("idDialog"=>'dialogKomponenTarif','jsFunction'=>"setDialog(this);"),
                                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'),
                                        )); ?>
                                    </td>
                                     <td>
                                         
                                        <?php echo $form->textField($modTarifTindakan,'[0]harga_tariftindakan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,)); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::link("<span class='icon-plus'></span>",
                                                '',array('href'=>'','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);return false;','id'=>'row1-plus'
                                                    ,'style'=>'text-decoration:none;')); ?>
                                    </td>
                                </tr>
                            </tbody>
                          </table>
                </div> 
            </div>
        </fieldset>
	 * 
	 */?>
            <?php //echo $form->checkBoxRow($model,'daftartindakan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                 <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Daftar Tindakan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial('../tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SADaftarTindakanM_daftartindakan_namalainnya').value = nama.value.toUpperCase();
        document.getElementById('SADaftarTindakanM_tindakanmedis_nama').value = nama.value;
    }
</script>
<?php
$js = <<< JS
$('#cekTarifTindakan').change(function(){
        $('#divTarifTindakan').slideToggle(500);
});

JS;
Yii::app()->clientScript->registerScript('JStarifTindakan',$js,CClientScript::POS_READY);
?>
<?php
Yii::app()->clientScript->registerScript('resize',"
    function resizeIframe(obj){
       $('#divTarifTindakan').slideToggle(1);
       obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
",  CClientScript::POS_HEAD);
?>
<?php
/* ====================================== Widget Dialog Komponen Tarif ====================================== */
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogKomponenTarif',
        'options'=>array(
            'title'=>'Pencarian Komponen Tarif',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>400,
            'resizable'=>false,
            ),
    ));
   $modKomponenTarif = new KomponentarifM('search');
$modKomponenTarif->unsetAttributes();
if(isset($_GET['$modKomponenTarif'])){
    $modKomponenTarif->attributes = $_GET['KomponentarifM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'komponentarif-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider'=>$modKomponenTarif->search(),
    'filter'=>$modKomponenTarif,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectMenuKomponenTarif",
                                    "onClick" => "var data=[\"$data->komponentarif_id\", \"$data->komponentarif_nama\"]
                                                    setTindakanAuto(data, this);
                                                    $(\"#dialogKomponenTarif\").dialog(\"close\");
                            "))',
                ),
                array(
                    'header'=>'Komponen Tarif',
//                    'filter'=>'<input type="text" name="FilterForm[komponentarif_nama]" value="'.$_GET['FilterForm'].'" attr-route ="'.$route.'" onblur="setFilter(this);">',
                    'name'=>'komponentarif_nama',
                    'value'=>'$data->komponentarif_nama',
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Komponen Tarif ====================================== */
?>
<?php
$buttonMinus = CHtml::link('<span class="icon-minus"></span>', '#', array('onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
// $urlGetRiwayatRuangan=Yii::app()->createUrl('ActionAjax/getRiwayatRuangan');
// $tglpenetapanruangan= CHtml::activeId($modRiwayatRuangan,'tglpenetapanruangan');
// $nopenetapanruangan=CHtml::activeId($modRiwayatRuangan,'nopenetapanruangan');
// $tentangpenetapan=CHtml::activeId($modRiwayatRuangan,'tentangpenetapan');

$js = <<< JSCRIPT
function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputTarifTindakan tr').length;
    var i = -1;
    $('#tblInputTarifTindakan tr').each(function(){
        if($(this).has('input[name$="[komponentarif_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="komponentarifNama["]').attr('name','komponentarifNama['+i+']');
        $(this).find('input[name^="komponentarif_id["]').attr('id','komponentarif_id'+i+'');
        $(this).find('input[name^="kelaspelayanan_id["]').attr('id','kelaspelayanan_id'+i+'');
    });
}

function delRow(obj)
{
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();
			renameInput('SATarifTindakanM','kelaspelayanan_id');
			renameInput('SATarifTindakanM','komponentarif_id');
			renameInput('SATarifTindakanM','komponentarifNama');
			renameInput('SATarifTindakanM','harga_tariftindakan');
		}
	});
}


JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>
<script>
    function addRow(obj)
    {
        button = '<?php echo $buttonMinus; ?>';
        var tr = $('#tblTarifTindakan tr:first').html();
        $('#tblTarifTindakan tr:last').after('<tr>'+tr+'</tr>');
        $('#tblTarifTindakan tr:last td:last').append(button);
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
        jQuery('input[name$="[komponentarifNama]"]').autocomplete(
            {
                'showAnim':'fold',
                'minLength':2,
                'focus':function(event, ui )
                {
                    $(this).val( ui.item.label);
                    return false;
                },
                'select':function( event, ui )
                {
                    setTindakan(this, ui.item);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/KomponenTarif');?>",
                        dataType: "json",
                        data:{
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }
            }
        );
        renameInput('SATarifTindakanM','komponentarif_id');
        renameInput('SATarifTindakanM','kelaspelayanan_id');
        renameInput('SATarifTindakanM','komponentarifNama');
        renameInput('SATarifTindakanM','harga_tariftindakan');

    }
    function setDialog(obj){
         parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogKomponenTarif";
        $(dialog).attr("parent-dialogs",parent);
        $(dialog).dialog("open");
    }
    function setTindakanAuto(params){
        dialog = "#dialogKomponenTarif";
        parent = $(dialog).attr("parent-dialogs");
        obj = $("#"+parent);
    //    console.log(params);
        $(obj).parents('tr').find('input[name$="[komponentarif_id]"]').val(params[0]);
        $(obj).parents('tr').find('input[name$="[komponentarifNama]"]').val(params[1]);
        $(dialog).dialog("close");

    }
    function setTindakan(obj,item)
    {
//        myAlert(item);
        $(obj).parents('tr').find('input[name$="[komponentarifNama]"]').val(item.value);
        $(obj).parents('tr').find('input[name$="[komponentarif_id]"]').val(item.id);
    }
</script>