<legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchInfoKunjungan',
    'focus'=>'#'.CHtml::activeId($model,'instalasi_id'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        ));
?>
<style>
    table{
        margin-bottom: 0px;
    }
    .form-actions{
        padding:4px;
        margin-top:5px;
    }
    #ruangan label{
        width: 120px;
        display:inline-block;
    }
    .nav-tabs>li>a{display:block; cursor:pointer;}
</style>
<div class="row-fluid">
	<div class="span6">
		<?php echo CHtml::hiddenField('type', ''); ?>
		<?php //echo CHtml::hiddenField('src', ''); ?>
		<div class = 'control-label'>Tanggal Kunjungan</div>
		<div class="controls">
			 <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
			 <?php
			 $this->widget('MyDateTimePicker', array(
				 'model' => $model,
				 'attribute' => 'tgl_awal',
				 'mode' => 'date',
//                                          'maxDate'=>'d',
				 'options' => array(
				 'dateFormat' => Params::DATE_FORMAT,
					'maxDate'=>'d',
				 ),
				 'htmlOptions' => array('readonly' => true,
				 'class'=>'span3',
				 'onkeypress' => "return $(this).focusNextInputField(event)"),
			 ));
			 ?>
			<?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
		</div>
	</div>
	<div class="span6">
		<?php echo CHtml::label(' sampai dengan', ' s/d', array('class' => 'control-label')) ?>
		<div class="controls">  
			<?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
			<?php
			$this->widget('MyDateTimePicker', array(
				'model' => $model,
				'attribute' => 'tgl_akhir',
				'mode' => 'date',
//                                         'maxdate'=>'d',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
					'maxDate'=>'d',
				),
				'htmlOptions' => array('readonly' => true,
				'class'=>'span3',
					'onkeypress' => "return $(this).focusNextInputField(event)"),
			));
			?>
			<?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
		</div> 
	</div>
</div>

<table width="100%" border="0">
<tr>
<td><div id='searching'>
		<fieldset>
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
						'id'=>'big',
						'slide'=>false,
						'content'=>array(
							'content2'=>array(
							'header'=>'Berdasarkan Instalasi dan Ruangan',
							'isi'=>'<table>
										<tr>
											<td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Instalasi</label></td>
											<td>'.$form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
												'ajax' => array('type' => 'POST',
													'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.get_class($model).'')),
													'update' => '#ruangan',  //selector to update
												),
											)).'
											</td>
										</tr>
										<tr>
											<td>
												<label>Ruangan</label>
											</td>
											<td>
												<div id="ruangan">
													<label>Data Tidak Ditemukan</label>
												</div>
											</td>
										</tr>
									 </table>',
							 'active'=>true
							),
						),
//                                    'htmlOptions'=>array('class'=>'aw',)
				)); ?>
	 </fieldset> 
	</div>
  </td>
<td> <div id='searching'>
                <fieldset>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                'id'=>'kunjungan',
                                'slide'=>false,
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                                'content'=>array(
                                    'content3'=>array(
                                        'header'=>'Jenis Pengunjung/Kunjungan',
                                        'isi'=>'<table>
                                                    <tr>
                                                    <td>'.
                                                    $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
                                        'active'=>true,
                                        ),
                                ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        )); ?>
                </fieldset>
                    </div></td>
</tr>
</table>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
</div>
<?php //$this->widget('UserTips', array('type' => 'create')); ?>  
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<script>
    function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    }
</script>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>