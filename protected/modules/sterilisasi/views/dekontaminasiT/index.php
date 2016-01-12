<div class="white-container">
	<div style='display:none;'>
		<?php
//			UNTUK LOAD assets FCBKComplete
			$this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
				'name'=>'nama',   
				'debugMode'=>true,
				'options'=>array(
					//'bricket'=>false,
					'json_url'=>$this->createUrl('MasterBahanSterilisasi'),
					'addontab'=> true, 
					'maxitems'=> 10,
					'input_min_size'=> 0,
					'cache'=> true,
					'newel'=> true,
					'addoncomma'=>true,
					'select_all_text'=> "", 
					'autoFocus'=>true,
					'id'=>'STDekontaminasidetailT_0_bahansterilisasi_nama',
				),
			));
		?>
	</div>
    <legend class="rim2">Transaksi <b>Dekontaminasi</b></legend>
	<?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#penerimaansterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('penerimaansterilisasi-grid', {
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
            <?php $this->renderPartial($this->path_view.'_pencarian', array('modPenerimaanSterilisasi' => $modPenerimaanSterilisasi, 'modPenerimaanSterilisasiDetail'=>$modPenerimaanSterilisasiDetail,'instalasiTujuans'=>$instalasiTujuans,'ruanganTujuans'=>$ruanganTujuans)); ?>
        </div>
    </fieldset>
    
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'dekontaminasi-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onSubmit'=>'return requiredCheck(this);'),
    )); ?>

    <div class="block-tabel" id="form-penerimaanlinen">
        <h6><b>Linen</b></h6>
		<table id="tabel-penerimaansterilisasi" class="items table table-striped table-condensed">
			<thead>
				<tr>
					<th>Pilih
						<?php echo CHtml::checkBox('check_semua',true,array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked')) ?>
					</th>
					<th>Tanggal Penerimaan /<br/>No. Penerimaan Sterilisasi</th>
					<th>Ruangan Asal</th>
					<th>Nama Peralatan</th>
					<th>Jumlah</th>
					<th>Bahan yang digunakan</th>
					<th>Lama Dekontaminasi</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(count($modDekontaminasiDetail) > 0){
						foreach($modDekontaminasiDetail as $i=>$penerimaan){
							$penerimaan->barang_nama = $penerimaan->barang->barang_nama;
							$penerimaan->ruangan_nama = $penerimaan->ruangan->ruangan_nama;
							$penerimaan->penerimaansterilisasi_no = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_no;
							$penerimaan->penerimaansterilisasi_tgl = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_tgl;
							echo $this->renderPartial($this->path_view.'_rowDetailDekontaminasi',array('penerimaan'=>$penerimaan));
						}
					}
				?>
			</tbody>
		</table>
    </div>
	
	<fieldset class="box" id="form-dekontaminasi">
		<legend class="rim">Data Dekontaminasi</legend>
		<?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'modDekontaminasi'=>$modDekontaminasi, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans)); ?>
	</fieldset>
	
    <div class="row-fluid">
        <div class="form-actions">
			<?php 
			if(isset($_GET['dekontaminasi_id'])){
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
			$content = $this->renderPartial($this->path_view.'tips/tipsDekontaminasi',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenerimaanSterilisasi'=>$modPenerimaanSterilisasi,'modDekontaminasi'=>$modDekontaminasi,'modDekontaminasiDetail'=>$modDekontaminasiDetail)); ?>
</div>