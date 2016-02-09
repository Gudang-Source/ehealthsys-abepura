<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'search-penunjangrujukan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#noPendaftaran',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); 

Yii::app()->clientScript->registerScript('search', "
$('#search-penunjangrujukan-form').submit(function(){
	$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <label for="namaPasien" class="control-label">
                    <?php //  echo CHtml::checkBox('cbTglMasuk', false, array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggal()', 'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                    Tanggal Masuk 
                </label>
                <div class="controls">
                    <?php   $format = new MyFormatter;
                            $this->widget('MyDateTimePicker',array(
                                            'name'=>'tgl_awal',
                                            'attribute'=>'tgl_awal',
                                            'value'=> date('d M Y'),
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                          ?>
                      
                   </div>
            </div>
            <div class="control-group">
                     <?php echo CHtml::label(' Sampai Dengan',' s/d', array('class'=>'control-label')) ?>

                   <div class="controls"> 
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'name'=>'tgl_akhir',
                                            'attribute'=>'tgl_akhir',
                                            'value'=> date('d M Y'),
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <label for="noPendaftaran" class="control-label">No. Pendaftaran </label>
                <div class="controls">
                    <input type="text" placeholder="Ketik No. Pendaftaran" value="" maxlength="20" id="noPendaftaran" name="noPendaftaran" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                </div>
            </div>    
            <div class="control-group ">
                <label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
                <div class="controls">
                    <input type="text"  placeholder="Ketik No. Rekam Medik" value="" maxlength="10" id="noRekamMedik" name="noRekamMedik" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                </div>
            </div>    
            <div class="control-group ">
                <label for="namaPasien" class="control-label">Nama Pasien </label>
                <div class="controls">
                    <input type="text"  placeholder="Ketik Nama Pasien" value="" maxlength="50" id="namaPasien" name="namaPasien" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                </div>
            </div> 
        </td>
    </tr>
</table>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','name'=>'submitSearch')); ?>
		<?php
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
	?>
		<?php 
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
		
    </div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    
    // document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal(){
        
        var checklist = $('#cbTglMasuk');
        var pilih = checklist.attr('checked');
     

        // var tgl_masuk = $(document)
        if(pilih){
            // document.getElementById('tgl_awal').disabled = false;
            // document.getElementById('tgl_akhir').disabled = false;
            document.getElementById('tgl_awal_date').setAttribute("style","display:block;");
            document.getElementById('tgl_akhir_date').setAttribute("style","display:block;");
        }
        else{
            // document.getElementById('tgl_awal').disabled = true;
            // document.getElementById('tgl_akhir').disabled = true;
            document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
            document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
        }
    }

</script>