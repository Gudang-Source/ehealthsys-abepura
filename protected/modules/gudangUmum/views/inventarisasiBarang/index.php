<div class="white-container">
	<legend class="rim2">Transaksi <b>Inventarisasi Barang</b></legend>
	<?php 
        CHtml::$hiddenDebug = true;
        
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#barang-m-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('barang-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    "); ?>
    <?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data Inventarisasi Barang berhasil disimpan !");
    }
    ?>
    <?php if (!isset($_GET['sukses']) && !isset($_GET['formulirinvbarang_id'])) { ?>
	<fieldset class="box" id="form-barang">
		<legend class="rim"><span class='judul'>Pencarian Inventarisasi Barang </span></legend>
		<div>
			<?php $this->renderPartial($this->path_view.'_pencarianBarang', array('modBarang' => $modBarang)); ?>
		</div>
	</fieldset>
	<?php } ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php
		$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
			'id' => 'invbarang-t-form',
			'enableAjaxValidation' => false,
			'type' => 'horizontal',
			'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
			'focus' => '#'.CHtml::activeId($modBarang,'barang_kode'),
		));
    ?>
	<div class="block-tabel">
        <h6><span class='judul'>Tabel <b>Inventarisasi Barang</b></span></h6>
        <div>
            <?php $this->renderPartial($this->path_view.'_listBarang', array('modBarang' => $modBarang,'model'=>$model)); ?>
        </div>
    </div>
	<fieldset class="box" id="form-inventarisasi-barang">
        <legend class="rim"><span class='judul'>Data Inventarisasi Barang</span></legend>
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <div>
            <?php $this->renderPartial($this->path_view.'_formInventarisasiBarang', array('form'=>$form,'format'=>$format,'model'=>$model)); ?>
        </div>
    </fieldset>
	<div class="form-actions">
        <?php 
                $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;
                $disableSave = (!empty($_GET['invbarang_id'])) ? true : ($sukses > 0) ? true : false;; 
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasiBarang();', 'onkeypress'=>'validasiBarang();','disabled'=>$disableSave)); //formSubmit(this,event)        
                //  jika tanpa validasiBarang
                /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                 * 
                 */
                 ?>
            <?php if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl('index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'refreshForm(this); return false;'));
            } ?>								
            <?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            ?>
            <?php
                $content = $this->renderPartial($this->path_view.'tips/tipsInventarisasiBarang',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
	<?php $this->endWidget(); ?>
	<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modBarang'=>$modBarang)); ?>
</div>

