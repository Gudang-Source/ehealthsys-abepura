<div class="white-container">
    <legend class="rim2">Pemanggilan Pemeriksaan <b>Medical Check Up</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
	<?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarianpasien-form').submit(function(){
            $('#pemanggilanmcu-v-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('pemanggilanmcu-v-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pemanggilan pemeriksaan medical check up berhasil disimpan !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>	
    <fieldset class="box" id="form-pasien">
        <legend class="rim"><span class='judul'>Pencarian </span></legend>
        <div class="row-fluid">    
			<?php $this->renderPartial($this->path_view . '_formPencarian', array('model' => $model, 'modPasien' => $modPasien,'modPemanggilan'=>$modPemanggilan,'modPemanggilanMcu'=>$modPemanggilanMcu)); ?>
        </div>
    </fieldset>
	
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pemanggilanmcu-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    ));
    ?>
	<?php echo $form->errorSummary($modPemanggilan); ?>
	<div class="block-tabel">
        <h6>Tabel <b>Pemanggilan Pasien MCU</b></h6>
			<?php $this->renderPartial($this->path_view . '_tabelPemanggilan', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien,'modPemanggilan'=>$modPemanggilan,'modPemanggilanMcu'=>$modPemanggilanMcu)); ?>
	</div>
	
	<fieldset class="box" id="form-pemanggilan">
        <legend class="rim"><span class='judul'>Data Pemanggilan Pemeriksaan</span></legend>
        <div class="row-fluid">    
			<?php $this->renderPartial($this->path_view . '_formPemanggilan', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien,'modPemanggilan'=>$modPemanggilan,'modPemanggilanMcu'=>$modPemanggilanMcu)); ?>
        </div>
    </fieldset>
	
	<div class="row-fluid">
		<div class="form-actions">
			
			<?php 
				$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;
                $disableSave = (!empty($_GET['no_pemanggilan'])) ? true : ($sukses > 0) ? true : false;; 
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
			<?php
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)','disabled'=>$disableSave));
			?>
			<?php
				echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
				'onclick' => 'return refreshForm(this);'));
			?>
			<?php
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            ?>
			<?php
			$content = $this->renderPartial($this->path_view . 'tips/tipsPemanggilanPemeriksaan', array(), true);
			$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
			?> 
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien,'modPemanggilan'=>$modPemanggilan,'modPemanggilanMcu'=>$modPemanggilanMcu)); ?>