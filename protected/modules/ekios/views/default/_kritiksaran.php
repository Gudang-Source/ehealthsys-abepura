<style>
	input,select,.uneditable-input{display:inline-block;width:210px;height:28px;padding:2px;margin-bottom:1px;font-size:14px;line-height:18px;color:#555555;border:1px solid #ccc;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;}
	.uneditable-textarea{width:800px;height:190px;}

	.form-horizontal .control-label{
		font-size:14px;
		font-family: monospace;
	}
	textarea.commentkritik{
		width: 800px;
		height: 200px;
		font-size:14px;
	}

	label, input, button, select{
		line-height:32px;
	}

	.form-horizontal .control-labelcoslpan{
		width: 400px;
		font-size:14px;
		font-family: monospace;
		text-align: right;
	}

	td.tombol{
		text-align: center;
	}
</style>
<script type="text/javascript">
	function cek(){
		var nama = $('#KomentarS_namakomentar').val();
		var instanasi = $('#KomentarS_instanasi').val();
		var deskripsi = $('#KomentarS_deskripsikomentat').val();
		if(nama==null || nama==''){
			myAlert('Nama Harus Diisi');
			return false;
		}else if(instanasi==null || instanasi==''){
			myAlert('Instansi Harus Diisi');
			return false;
		}else if(deskripsi==null || deskripsi==''){
			myAlert('Kritik Saran Harus Diisi');
			return false;
		}else{
			return true;
		}
		
	}
</script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/kiosk/keyboard.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/ekios/jquery.keyboard.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/ekios/jquery.mousewheel.js"></script>

	<script>
		$(function(){
			$('#KomentarS_namakomentar').keyboard();
			$('#KomentarS_instanasi').keyboard();
			$('#KomentarS_emailkomentar').keyboard();
			$('#KomentarS_websitekomentar').keyboard();
			$('#KomentarS_deskripsikomentat').keyboard();
		});
	</script>

<div class="block-kioskmodule" id="kritiksaran" name="kritiksaran">
	<legend class="rim">KRITIK DAN SARAN</legend><hr>
	<?php
	 //CHtml::link($text, $url, $htmlOptions)
	$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'action'=>Yii::app()->createUrl('ekios/Default/SimpanKomentar'),
		'method'=>'post',
        'id'=>'kritiksaran-form',
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return cek()'),

	)); ?>

<table>
	<tr>
		<td>

			<div class="control-group">
		        <label class="control-label">Nama</label>
		        <div class="controls">
		            <?php echo $form->textField($model,'namakomentar',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
		        </div>
		    </div>   

		    <div class="control-group">
		        <label class="control-label">Instansi</label>
		        <div class="controls">
		            <?php echo $form->textField($model,'instanasi',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
		        </div>
		    </div>  

    	</td> 
    	<td>

			<div class="control-group">
		        <label class="control-label">Email</label>
		        <div class="controls">
		            <?php echo $form->textField($model,'emailkomentar',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
		        </div>
		    </div>   

		    <div class="control-group">
		        <label class="control-label">Website</label>
		        <div class="controls">
		            <?php echo $form->textField($model,'websitekomentar',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
		        </div>
		    </div>  

    	</td> 
    </tr>
    <tr>
    	<td colspan="2">
		    <div class="control-group">
		        <label class="control-label">Kritik / Saran</label>
		        <div class="controls">
		            <?php echo $form->textArea($model,'deskripsikomentat',array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'commentkritik')); ?>
		        </div>
		    </div>  
		</td>
	</tr>
    <tr>
    	<td colspan="2">
		    <div class="form-actions">
				<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
		            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
		?>
				<a href="index.php?r=ekios" class="btn btn-danger">
					<i class="icon-refresh icon-white"></i>
					Batal
				</a>

		    </div>
		</td>
	</tr>
</table>
	<?php
		$this->endWidget();
		//========= end Lihat Hasil =============================
	?>
		
</div>	