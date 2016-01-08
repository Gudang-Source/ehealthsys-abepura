<?php 
echo CHtml::css('#isiScroll{max-height:300px;overflow-y:scroll;margin-bottom:10px;}'); 
?>
<div class="white-container">
    <legend class="rim2">Transaksi <b>Verifikasi Berkas MCU</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
	<?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencariantagihan-form').submit(function(){
            $('#rinciantagihan-v-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('rinciantagihan-v-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data verifikasi berkas medical check up berhasil disimpan !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>	
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'verifikasiberkasmcu-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    ));
    ?>
	<?php echo $form->errorSummary($model); ?>
	<fieldset class="box" id="form-infopasien">
        <legend class="rim"><span class='judul'>Data Pasien</span></legend>
        <div class="row-fluid">    
			<?php $this->renderPartial($this->path_view . '_formInfoPasien', array('modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'modVerifikasi'=>$modVerifikasi)); ?>
        </div>
    </fieldset>
	
	<div class="block-tabel">
        <h6>Tabel <b>Verifikasi Berkas MCU</b></h6>
		<div id="isiScroll">
			<table class="table table-condensed table-bordered" id="tabel-verifikasi">
				<thead>
					<tr>
						<th>No. Pendaftaran</th>
						<th>No. Rekam Medik</th>
						<th>Ruangan</th>
						<th>Nama Pasien</th>
						<th>No. Surat</th>
						<th>Tanggal Berkas Masuk</th>
						<th>Nama Rumah Sakit</th>
						<th>Jumlah Tagihan</th>
						<th>Status Berkas</th>
						<th style="text-align: center;">Verifikasi <br/>
							<?php // echo CHtml::checkBox('checkAll',false,array('class'=>'inputFormTabel lebar2','onclick'=>'cekSemua(this);')); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
//						$modVerifikasi = KUVerifikasiberkasmcuV::model()->findAll();
//						if(count($modVerifikasi) > 0){
//							foreach($modVerifikasi as $i=>$data){
//								$this->renderPartial($this->path_view . '_rowVerifikasi', array('form'=>$form, 'model' => $model,'modVerifikasi'=>$data));
//							}
//						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" style="text-align: right;">Total Tagihan</td>
						<td><?php echo CHtml::textField('total_tagihan','',array('class'=>'span2 integer')); ?></td>
						<td></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
    </div>
	
	<fieldset class="box" id="form-verifikasi">
        <legend class="rim"><span class='judul'>Data Verifikasi Berkas MCU</span></legend>
        <div class="row-fluid">    
			<?php $this->renderPartial($this->path_view . '_formVerifikasiBerkas', array('form' => $form, 'model' => $model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran)); ?>
        </div>
    </fieldset>
	
	<div class="row-fluid">
		<div class="form-actions">			
			<?php 
				$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;
                $disableSave = (!empty($_GET['noverifikasiberkasmcu'])) ? true : ($sukses > 0) ? true : false;
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
			<?php
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type'=>'button', 'onkeypress'=>'verifikasiBerkas();','onclick'=>'verifikasiBerkas();','disabled'=>$disableSave));
//				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)','disabled'=>$disableSave));
			?>
			<?php
				echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
				'onclick' => 'return refreshForm(this);'));
			?>
			<?php
//				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            ?>
			<?php
			$content = $this->renderPartial($this->path_view . 'tips/tipsVerifikasiBerkasMcu', array(), true);
			$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
			?> 
		</div>
	</div>
</div>
<?php 
//========= Dialog untuk verifikasi berkas  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogVerifikasiBerkas',
    'options'=>array(
        'title'=>'Verifikasi Berkas',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>440,
        'resizable'=>false,
    ),
));
?>
<div class="divForForm"></div>
<?php
	$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end verifikasi berkas =============================
?>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran)); ?>

 