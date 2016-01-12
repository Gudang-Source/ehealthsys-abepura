<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
<div class="white-container">
    <legend class="rim2">Pengajuan <b>Pergantian Kacamata</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
                Yii::app()->user->setFlash('success', "Data pengajuan kacamata berhasil disimpan !");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencariankacamata-form').submit(function(){
            $('#gantikacamata-t-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('gantikacamata-t-grid', {
                data: $(this).serialize()
            });
				$('#is_pilihsemua').attr('checked',true);
				hitungTotal();
            return false;
        });
        ");
    ?>
    <fieldset class="box">
        <legend class="rim"><span class='judul'><i class="icon-white icon-search"></i> Pencarian</span></legend>
        <?php $this->renderPartial($this->path_view.'_pencarian', array('modGantiKacamata' => $modGantiKacamata)); ?>
    </fieldset>    
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id'=>'mcpengajuangantikm-t-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
                'focus'=>'#'.CHtml::activeId($model,'no_pengajuan'),
        ));
    ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modGantiKacamata); ?>

    <div class="block-tabel" id="form-obatalkes">
        <h6><span class='judul'>Tabel <b>Pergantian Kacamata</b></span></h6>
        <div>
            <?php $this->renderPartial($this->path_view.'_daftarGantiKacamata', array('modGantiKacamata' =>$modGantiKacamata,'model'=>$model)); ?>
            <div class="control-group">
                    <div class="control-label">Total Harga</div>
                    <div class="controls">
                            <?php echo CHtml::textField('totalharga','',array('class'=>'span3 integer','readonly'=>true)); ?>
                    </div>
            </div>				
        </div>
    </div>

    <fieldset class="box" id="form-formuliropanme">
        <legend class="rim"><span class='judul'>Data Pergantian Kacamata</span></legend>
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <div>
            <?php $this->renderPartial($this->path_view.'_formPenggantianKacamata', array('form'=>$form,'format'=>$format,'model'=>$model)); ?>
        </div>
    </fieldset>

    <div class="form-actions">
        <?php 
                $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;
                $disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
			?>
            <?php if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl('index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'refreshForm(this); return false;'));
            } ?>	
            <?php
                $content = $this->renderPartial($this->path_view.'tips/tipsPenggantianKacamata',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modGantiKacamata'=>$modGantiKacamata)); ?>
