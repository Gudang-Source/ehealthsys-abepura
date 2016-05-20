<style>
    .cols_hide{
        display:none;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'satanggunganpenjamin-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php 
if (isset($modTanggung)) {
    echo $form->errorSummary($modTanggung); 
}
?>
<div class="row">
    <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true), array('order' => 'kelaspelayanan_nama')), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- pilih --', 'onchange'=>'setPenjamin()', 'class' => 'span3 isRequired', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true), array('order' => 'carabayar_nama')), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- pilih --', 'class' => 'span3', 'onchange'=>'setPenjamin()', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->hiddenField($model, 'carabayar_id', array('class' => 'idCaraBayar')); ?>
    <?php //echo $form->textFieldRow($model,'penjamin_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    
    <?php //echo $form->textFieldRow($model,'tipenonpaket_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'subsidiasuransitind',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'subsidipemerintahtind',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'subsidirumahsakittind',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'iurbiayatind',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'subsidiasuransioa',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'subsidipemerintahoa',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'subsidirumahsakitoa',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'iurbiayaoa',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'persentanggcytopel',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'makstanggpel',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
    <?php if (count($dataTanggunganPenjamin) > 0) { ?>
    <?php echo $form->checkBoxRow($model, 'tanggunganpenjamin_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php }?>
</div>
<br/>
<style>
    .table thead tr th{
        vertical-align: middle;
    }
</style>
<table id="tableTanggunganPenjamin" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th rowspan='2'>No.Urut</th>
            <th rowspan='2'>Nama Penjamin</th>
            <th colspan='4'><center>Tindakan (%)</center></th>
            <th colspan='4'><center>Obat dan Alkes (%)</center></th>
            <th rowspan='2'>Cyto Tanggungan Penjamin (%)</th>
            <th rowspan='2'>Maks Tanggungan Penjamin (Rp.)</th>
            <th rowspan='2'>Batal</th>
        </tr>
        <tr>
            <th>Subsidi Asuransi</th>
            <th>Subsidi Pemerintah</th>
            <th>Subsidi Rumah Sakit</th>
            <th>Persen Iur Biaya</th>
            <th>Subsidi Asuransi</th>
            <th>Subsidi Pemerintah</th>
            <th>Subsidi Rumah Sakit</th>
            <th>Persen Iur Biaya</th>
        </tr>
        </thead>
        <?php if (count($modTanggung) > 0) { ?>
            <tbody>
                <?php
//                $modTanggunganPenjamin = new TanggunganpenjaminM();
                $i = 1;
                foreach ($modTanggung as $i=>$tampilDetail) {
                    ?>
                    <?php
                    echo "<tr>
                                <td>".CHtml::TextField('noUrut',($i+1),array('class'=>'span1 noUrut','readonly'=>TRUE)).
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']penjamin_id') .
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']carabayar_id') .
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']kelaspelayanan_id') .
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']tanggunganpenjamin_id') .
                               "</td>
                                <td>".$tampilDetail->penjamin->penjamin_nama."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidiasuransitind',array('group'=>'group1','class'=>'span1 asuransitind numbersOnly', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidipemerintahtind',array('group'=>'group1','class'=>'span1 numbersOnly pemerintahtind', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidirumahsakittind',array('group'=>'group1','class'=>'span1 numbersOnly rumahsakittind', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']iurbiayatind',array('group'=>'group1','class'=>'span1 numbersOnly iurbiayatind', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidiasuransioa',array('group'=>'group2','class'=>'span1 numbersOnly asuransioa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidipemerintahoa',array('group'=>'group2','class'=>'span1 numbersOnly pemerintahoa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidirumahsakitoa',array('group'=>'group2','class'=>'span1 numbersOnly rumahsakitoa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']iurbiayaoa',array('group'=>'group2','class'=>'span1 numbersOnly iurbiayaoa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']persentanggcytopel',array('group'=>'group3','class'=>'span1 numbersOnly persentanggung', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']makstanggpel',array('class'=>'span1 numbersOnly makstanggpel', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::link("<i class='icon-remove'></i>", '', array('href'=>'','onclick'=>'delRow(this);return false;'))."</td>
                            </tr>
                            ";
                    $i++;
                }
                ?>
            </tbody>
        <?php } ?>
        </table>

<br/>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'))."&nbsp";
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tanggungan Penjamin', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));

    ?>
	<?php
$content = $this->renderPartial($this->path_view.'tips/tipsCreate',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>

<?php $this->endWidget(); ?>
<?php
$notif = Yii::t('mds','Do You want to cancel?');
$idCaraBayar = CHtml::activeId($model, 'carabayar_id');
$urlGetPenjamin = $this->createUrl('getPenjamin');
$idKelasPelayanan = CHtml::activeId($model, 'kelaspelayanan_id');
$JSTanggunganPenjamin = <<< JS
    $(document).ready(function(){
        $('#${idCaraBayar}').focus();
                
        $('form').submit(function(){
                
                if (cekValidasi() == false)
                    return false;
                else{
                    return true;
                }
        });
    });
        
    function setPenjamin(){
        $('#tableTanggunganPenjamin tbody').remove();
        var idCaraBayar = $('#${idCaraBayar}').val();
        var idKelasPelayanan = $("#${idKelasPelayanan}").val();
        if (!jQuery.isNumeric(idKelasPelayanan))
        {
            myAlert("Kelas Pelayanan harus diisi");
        }
        
        if (jQuery.isNumeric(idCaraBayar)){
            $('#${idKelasPelayanan}').focus();
            $('.idCaraBayar').val(idCaraBayar);
            $(this).attr('disabled', 'disabled');
            $.post('${urlGetPenjamin}',{idCaraBayar:idCaraBayar, idKelasPelayanan:idKelasPelayanan},function(data){
                $('#tableTanggunganPenjamin').append(data.tr);
                $(".numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
            }, "json");
        }
    }
            
    function setUrutan(){
        noUrut = 1;
        $('.noUrut').each(function() {
              $(this).val(noUrut);
              noUrut = noUrut + 1;
        });
    }
            
    function delRow(obj){
		myConfirm("${notif}",'Perhatian!',function(r){
			if(!r) {
				return false;
			}else{
				$(obj).parents('tr').remove();
				setUrutan();
				return false;
			}
		});
    }
                
    function change(obj){
        var value = parseFloat($(obj).val());
        var khas = $(obj).attr('id');
        var group = $(obj).attr('group');        
        var sum = parseFloat(0);
        $(obj).parents('tr').find('input[group='+group+']').each(function(){
            var value = parseFloat($(this).val());
            sum += value;
        });      
        
        if (sum > 100){
            $(obj).val(100-(sum - value));
        }
        else{
        }
    }
    
    function cekValidasi(){
          banyaknyaPenjamin = $('.noUrut').length;
                
          if ($('.isRequired').val()==''){
              myAlert ('Harap Isi Semua Data Yang Bertanda *');
                return false;
          }else if ($('#${idKelasPelayanan}').val()==''){
              myAlert ('Harap Isi Semua Data Yang Bertanda *');
              return false;
          }else if(banyaknyaPenjamin<1){
             myAlert('Anda Belum memimilih Penjamin');   
             return false;
          }else if(jumlahCek<1){
             myAlert('Anda Belum memimilih Penjamin');   
             return false;
          }else{
             return true;
          }
    }
    
    function cekGroup(obj){
        var group = $(obj).attr('group');
        var valueObj = parseFloat($(obj).val());
        var sum = parseFloat(0);
        $(obj).parents('tr').find('input[group='+group+']').each(function(){
            var value = parseFloat($(this).val());
            sum += value;
        });
        
        if (sum > 100){
            myAlert('tidak Boleh lebih dari 100');
            $(obj).val(100-(sum-valueObj))
        }
        
    }
JS;
Yii::app()->clientScript->registerScript('jsTanggungan', $JSTanggunganPenjamin, CClientScript::POS_HEAD);
?>


<?php 

$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>
