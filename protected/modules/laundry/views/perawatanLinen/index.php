<div class="white-container">
    <legend class="rim2">Transaksi Perawatan <b>Linen</b></legend>
	<?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#penerimaanlinendetail-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('penerimaanlinendetail-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash("success","Data perawatan linen berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<fieldset class="box" id="form-penerimaan">
        <legend class="rim"><span class='judul'>Pencarian Penerimaan Linen </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_pencarianPenerimaan', array('modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail'=>$modPenerimaanLinenDetail,'instalasiTujuans'=>$instalasiTujuans,'ruanganTujuans'=>$ruanganTujuans)); ?>
        </div>
    </fieldset>
    
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'perawatanlinen-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onSubmit'=>'return requiredCheck(this);'),
    )); ?>

    <div class="block-tabel" id="form-penerimaanlinen">
        <h6>Linen</h6>
		<?php echo $this->renderPartial($this->path_view.'_rowPenerimaanLinen',array('modPenerimaanLinen'=>$modPenerimaanLinen,'modPenerimaanLinenDetail'=>$modPenerimaanLinenDetail)); ?>
<!--        <div class="block-tabel">
            <h6>Tabel <b>Linen</b></h6>
            <table class="items table table-striped table-condensed" id="table-detailpemesanan">
                <thead>
                    <tr>
                        <th>Pilih</th>
                        <th>Ruangan Asal</th>
                        <th>No. Penerimaan</th>
                        <th>Kode Linen</th>
                        <th>Nama Linen</th>
                        <th>Keterangan</th>
						<th>Status Perawatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//						if(count($modPerawatanLinenDetail) > 0){
//							foreach($modPerawatanLinenDetail AS $i=>$modDetail){
//								echo $this->renderPartial($this->path_view.'_rowDetailPerawatanLinen',array('modDetail'=>$modDetail));
//							}
//						}
                    ?>
                </tbody>
            </table>
        </div>-->
    </div>
	
	<fieldset class="box" id="form-perawatanlinen">
		<legend class="rim">Data Perawatan</legend>
		<?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'modPerawatanLinen'=>$modPerawatanLinen, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans)); ?>
	</fieldset>
	
	<fieldset class="box" id="form-bahan">
		<legend class="rim">Bahan yang Digunakan</legend>
		<?php echo $this->renderPartial($this->path_view.'_formPilihBahan', array('form'=>$form,'modPerawatanLinen'=>$modPerawatanLinen, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans)); ?>
		<div class="block-tabel">
            <h6>Tabel <b>Bahan Perawatan</b></h6>
            <table class="items table table-striped table-condensed" id="table-detailbahan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Bahan</th>
                        <th>Jumlah Bahan</th>
                        <th>Satuan</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
						if(count($modPerawatanBahan) > 0){
							foreach($modPerawatanBahan AS $i=>$modDetail){
								echo $this->renderPartial($this->path_view.'_rowBahanLinen',array('modDetail'=>$modDetail));
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
			if(isset($_GET['perawatanlinen_id'])){
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
			$content = $this->renderPartial($this->path_view.'tips/tipsPerawatanLinen',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenerimaanLinen'=>$modPenerimaanLinen,'modPerawatanLinen'=>$modPerawatanLinen,'modPerawatanLinenDetail'=>$modPerawatanLinenDetail)); ?>
</div>