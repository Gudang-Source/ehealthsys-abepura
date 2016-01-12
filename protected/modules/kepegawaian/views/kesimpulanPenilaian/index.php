<div class="white-container">
    <legend class="rim2">Transaksi <b>Kesimpulan Penilaian</b></legend>
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
			Yii::app()->user->setFlash("success","Data berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<fieldset class="box" id="form-penerimaan">
        <legend class="rim"><span class='judul'>Pencarian Penilaian</span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_search', 
					array(
						'modPenilaianPegawai' => $modPenilaianPegawai, 
					)); 
			?>
        </div>
    </fieldset>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penyimpanansteril-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onSubmit'=>'return requiredCheck(this);'),
    )); ?>
	<div class="block-tabel" id="form-kesimpulan">
            <h6>Tabel <b>Penilaian</b></h6>
		<table id="tabel-kesimpulan" class="items table table-striped table-condensed">
			<thead>
				<tr>				
					<th>NIP</th>
					<th>Nama Pegawai Penilai</th>
					<th>Tanggal Penilaian</th>
					<th>Keterangan Penilaian</th>
					<th>Hasil Penilaian</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		
		<?php echo $this->renderPartial($this->path_view.'_form', array(
				'form'=>$form,	
				'modKesimpulan'=>$modKesimpulan,
				));
		?>
        </div>
   <div class="row-fluid">
        <div class="form-actions">
			<?php 
			if(isset($_GET['kesimpulanpenilaian_id'])){
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
				$content = $this->renderPartial($this->path_view.'tips/tipsKesimpulan',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKesimpulan'=>$modKesimpulan,'modPenilaianPegawai'=>$modPenilaianPegawai)); ?>
	
</div>
