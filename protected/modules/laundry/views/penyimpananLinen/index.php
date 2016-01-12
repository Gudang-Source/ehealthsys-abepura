<div class="white-container">
    <legend class="rim2">Transaksi <b>Penyimpanan Linen</b></legend>
	<?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#pencucianlinen-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('pencucianlinen-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash("success","Data penyimpanan linen berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<fieldset class="box" id="form-penerimaan">
            <legend class="rim"><span class='judul'><i class="icon-search icon-white"></i> Pencarian</span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_pencarian', array('modInfoPencucian'=>$modInfoPencucian, 'instalasiTujuans'=>$instalasiTujuans,'ruanganTujuans'=>$ruanganTujuans)); ?>
        </div>
    </fieldset>
    
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penyimpananlinen-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    )); ?>

    <div class="block-tabel" id="form-penerimaanlinen">
        <h6><b>Linen</b></h6>
        <?php echo $this->renderPartial($this->path_view.'_rowLinen',array('modPenyimpananLinen' => $modPenyimpananLinen, 'modPenyimpananLinenDetail'=>$modPenyimpananLinenDetail, 'modInfoPencucian'=>$modInfoPencucian)); ?>
    </div>
	
	<fieldset class="box" id="form-perawatanlinen">
		<legend class="rim">Data Penyimpanan</legend>
		<?php echo $this->renderPartial($this->path_view.'_form', array('form'=>$form,'modPenyimpananLinen' => $modPenyimpananLinen, 'modPenyimpananLinenDetail'=>$modPenyimpananLinenDetail, 'modInfoPencucian'=>$modInfoPencucian, 'instalasiTujuans'=>$instalasiTujuans, 'ruanganTujuans'=>$ruanganTujuans)); ?>
	</fieldset>
	
    <div class="row-fluid">
        <div class="form-actions">
			<?php 
			if(isset($_GET['penyimpananlinen_id'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true, 'style'=>'cursor:not-allowed;'))."&nbsp;"; 
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print('PRINT');return false",'disabled'=>FALSE  ));
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onKeypress'=>'validasiCek();','onclick'=>'validasiCek();'))."&nbsp"; 
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

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenyimpananLinen'=>$modPenyimpananLinen,'modPenyimpananLinenDetail'=>$modPenyimpananLinenDetail,'modInfoPencucian'=>$modInfoPencucian)); ?>
</div>