<style>
    #ruangan label{
        width: 200px;
        display:inline-block;
    }
	
	.radio input[type="radio"], .checkbox input[type="checkbox"] {
		float: none;
		margin-left: -18px;
	}
	
	input.multiselect-search{
		/*width:100px;*/
	}
	
	.btn-group .btn {
		position: relative;
		float: none;		
	}
	
	.collapse.in, .collapse{
		z-index: 0;
		
	  }
	  
	  .caret{
		  margin:6px;
	  }
</style>
<script type="text/javascript">
    function reseting()
    {
        setTimeout(function(){
            $.fn.yiiGridView.update('lapegawai-m-grid', {
                    data: $('#lapegawai-m-search').serialize()
            });
        },1000);

    }   
</script>
<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/css/bootstrap-multiselect.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);

?>
<fieldset class="box">
    
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'lapegawai-m-search',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'nomorindukpegawai'),
        )
    );
    ?>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                       // $format = new MyFormatter();
                       // $tgl_awal = date('Y-m-d', strtotime($model->tglpresensi));
                       // $model->tglpresensi= $format->formatDateTimeForUser($tgl_awal);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?> 
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        //$tgl_akhir = date('Y-m-d', strtotime($model->tglpresensi_akhir));
                        //$model->tglpresensi_akhir= $format->formatDateTimeForUser($tgl_akhir);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi_akhir',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?>
                </div>
            </div>  
                <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3','maxlength'=>30)); ?>
                <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>50)); ?>
                <?php
                    /*echo $form->dropDownListRow(
                        $model,'unit_perusahaan',LookupM::getItems('unit_perusahaan'),
                        array('class'=>'span3', 'empty'=>'-- Pilih --')
                    );*/
                ?>
            </td>
            <td>
				 <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true ORDER BY kelompokpegawai_nama ASC'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --','ajax'=>array(
					'type'=>'POST',
						'url'=>  CController::createUrl('/ActionDynamic/AllPegawai'),
						'success'=>'function(data) {updatePegawai(data);}'))); ?>     
                <?php echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'),array('class'=>'span3','maxlength'=>50, 'empty'=>'-- Pilih --',
					'ajax'=>array(
					'type'=>'POST',
						'url'=>  CController::createUrl('/ActionDynamic/AllPegawai'),
						'success'=>'function(data) {updatePegawai(data);}'))); ?>     
                <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array(
					'class'=>'span3',
					'maxlength'=>50, 
					'empty'=>'-- Pilih --',
					'ajax'=>array(
					'type'=>'POST',
						'url'=>  CController::createUrl('/ActionDynamic/AllPegawai'),
						'success'=>'function(data) {updatePegawai(data);}'))); ?>                
				
				<div class="multiple-pegawai">
				<?php 
					echo $form->dropDownListRow($model,'pegawai_id',  CHtml::listData(PegawaiV::model()->findAll("pegawai_aktif = TRUE ORDER BY nama_pegawai"), 'pegawai_id', 'namaLengkap'), 
						array( 'multiple'=>'multiple'));
				?>                
				</div>
            </td>
            <td>
               
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
            echo "&nbsp;";
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('Laporan/LaporanPegawai'), array('class'=>'btn btn-danger'));
                 
         ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#lapegawai-m-search').submit(function(){
    $.fn.yiiGridView.update('lapegawai-m-grid', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<script>
$(document).ready(function() {
	jQuery("#PegawaiM_pegawai_id").multiselect({
		includeSelectAllOption: true,
		buttonClass: "btn-dropdown",
		maxHeight: 300,
		buttonWidth: '140px',
		enableCaseInsensitiveFiltering: true,
	}).hide();			
});

function updatePegawai(data){
	
	$('#PegawaiM_pegawai_id').html(data);
	$('#PegawaiM_pegawai_id').multiselect('rebuild');
	jQuery("#PegawaiM_pegawai_id").multiselect({
		includeSelectAllOption: true,
		buttonClass: "btn-dropdown",
		maxHeight: 300,
		buttonWidth: '140px',
		enableCaseInsensitiveFiltering: true,
	}).hide();		
}
</script>