<div class="white-container">
    <legend class="rim2">Transaksi Pengiriman <b>Linen</b></legend>
    <?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash("success","Data pengiriman linen berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pengirimanlinen-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),
    )); ?>

	<fieldset class="box" id="form-perawatanlinen">
		<legend class="rim">Data Pengiriman</legend>
		<?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'modPengirimanLinen'=>$modPengirimanLinen, 'ruanganTujuans'=>$ruanganTujuans)); ?>
	</fieldset>
	
	<fieldset class="box" id="form-bahan">
		<legend class="rim">Linen</legend>
		<?php echo $this->renderPartial($this->path_view.'_formPilihLinen', array('form'=>$form,'modPengirimanLinen'=>$modPengirimanLinen, 'ruanganTujuans'=>$ruanganTujuans)); ?>
		<div class="block-tabel">
            <h6>Tabel <b>Linen</b></h6>
            <table class="items table table-striped table-condensed" id="table-detaillinen">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Inventaris</th>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
						if(count($modPengirimanLinenDetail) > 0){
							foreach($modPengirimanLinenDetail AS $i=>$modDetail){
								echo $this->renderPartial($this->path_view.'_rowPengirimanLinen',array('modDetail'=>$modDetail));
							}
						}
                    ?>
                </tbody>
            </table>
        </div>
	</fieldset>
    <div class="row-fluid">
        <div class="form-actions">
			<?php 
			if(isset($_GET['pengirimanlinen_id'])){
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
			$content = $this->renderPartial($this->path_view.'tips/tipsPengirimanLinen',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPengirimanLinen'=>$modPengirimanLinen,'modPengirimanLinenDeteail'=>$modPengirimanLinenDetail)); ?>
</div>