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

   label.checkbox{
            width:150px;
            display:inline-block;
        }

    </style>
	<div class="row-fluid">
		<div class="span8">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Tanggal Kunjungan</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<?php //echo CHtml::hiddenField('src', ''); ?>
				<div class = 'control-label'>Tanggal Kunjungan</div>
					<div class="controls">  
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_awal',
							'mode' => 'date',
//                                          'maxDate'=>'d',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
							),
							'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
						?>
					</div>
					<?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
					<div class="controls">  
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_akhir',
							'mode' => 'date',
//                                         'maxdate'=>'d',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
							),
							'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
						?>
					</div>
			</fieldset>
		</div>
		<div class="span4">
			<div id='searching'>
				<fieldset class="box2">
					<legend class="rim">Berdasarkan Cara Masuk</legend>
						<?php
							echo $form->radioButtonList($model, 'is_rujukan',
								array(
									'non_rujukan' => 'Berdasarkan Non Rujukan',
									'rujukan' => 'Berdasarkan Rujukan'
								),
								array(
									'onClick'=>"lihatRujukan(this);",
									'inline'=>true,
									'onkeypress' => "return $(this).focusNextInputField(event)"
								)
							);
							/*
						echo'<table style="border:1px" ><tr><td style="width:180px;">'.
								CHtml::checkBox('filter[]', true, array('value'=>'NON_RUJUKAN')).' Berdasarkan Non Rujukan', '</td>'.'<td>'.CHtml::checkBox('filter[]', true , array('value'=>Params::STATUSPERIKSA_RUJUKAN)).' Berdasarkan Rujukan <br/><br/>',''.$form->checkBoxList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'),'asalrujukan_id','asalrujukan_nama'))
						.'</table>';
							 * 
							 */
						?>
					<div id="list_rujukan" style="display:none;">
						<?php
							echo $form->checkBoxList($model, 'asalrujukan_id',
								CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'),'asalrujukan_id','asalrujukan_nama')
							);
						?>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
	
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array(
                    'class' => 'btn btn-primary', 
                    'type' => 'submit', 
                    'id' => 'btn_simpan'
                )
            );
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
					array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script type="text/javascript">
    function lihatRujukan(obj)
    {
        $("#list_rujukan").hide();
        $("#list_rujukan").find('input[type="checkbox"]').each(
            function()
            {
                $(this).attr('checked', false);
            }
        );        
        if($(obj).val() == 'rujukan')
        {
            $("#list_rujukan").show();
            $("#list_rujukan").find('input[type="checkbox"]').each(
                function()
                {
                    $(this).attr('checked', true);
                }
            );
        }
    }
</script>