<div class="white-container">
    <legend class="rim2">Transaksi <b>Penyimpanan Sterilisasi</b></legend>
	<?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#sterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('sterilisasi-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash("success","Data Dekontaminasi berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<fieldset class="box" id="form-penerimaan">
        <legend class="rim"><span class='judul'>Pencarian Penerimaan Sterilisasi </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_pencarian', array('modSterilisasi' => $modSterilisasi, 'modSterilisasiDetail'=>$modSterilisasiDetail,'instalasiTujuans'=>$instalasiTujuans,'ruanganTujuans'=>$ruanganTujuans)); ?>
        </div>
    </fieldset>
    
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penyimpanansteril-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onSubmit'=>'return requiredCheck(this);'),
    )); ?>

    <div class="block-tabel" id="form-sterilisasi">
        <h6><b>Linen</b></h6>
		<table id="tabel-sterilisasi" class="items table table-striped table-condensed">
			<thead>
				<tr>
					<th>Pilih
						<?php echo CHtml::checkBox('check_semua',true, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked')) ?>
					</th>					
					<th>Lokasi Penyimpanan</th>
					<th>Sub Rak</th>
					<th>No. Sterilisasi</th>
					<th>Instalasi</th>
					<th>Ruangan</th>
					<th>Nama Peralatan dan Linen</th>
					<th>Waktu Kadaluarsa</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(count($modPenyimpananSterilisasiDetail) > 0){
						foreach($modPenyimpananSterilisasiDetail as $i=>$penerimaan){
							$penerimaan->barang_nama = $penerimaan->barang_nama;
							$penerimaan->ruangan_nama = $penerimaan->ruangan_nama;
							$penerimaan->sterilisasi_no = $penerimaan->sterilisasi_no;
							$penerimaan->waktukadaluarsa = $penerimaan->waktukadaluarsa;
							echo $this->renderPartial($this->path_view.'_rowPenerimaanSterilisasi',array('penerimaan'=>$penerimaan));
						}
					}
				?>
			</tbody>
		</table>
    </div>
	
	<fieldset class="box" id="form-penyimpanansteril">
		<legend class="rim">Data Penyimpanan Sterilisasi</legend>
		<?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'modPenyimpananSterilisasi'=>$modPenyimpananSterilisasi, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans)); ?>
	</fieldset>
	
    <div class="row-fluid">
        <div class="form-actions">
			<?php 
			if(isset($_GET['penyimpanansteril_id'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true, 'style'=>'cursor:not-allowed;'))."&nbsp;"; 
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print('PRINT');return false",'disabled'=>FALSE  ));
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onKeypress'=>'validasiCek();', 'onclick'=>'validasiCek();'))."&nbsp"; 
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE,'style'=>'cursor:not-allowed;'));
			}
			?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
			<?php 
			$content = $this->renderPartial($this->path_view.'tips/tipsPenyimpananSteril',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modSterilisasi'=>$modSterilisasi,'modPenyimpananSterilisasi'=>$modPenyimpananSterilisasi,'modPenyimpananSterilisasiDetail'=>$modPenyimpananSterilisasiDetail)); ?>
</div>