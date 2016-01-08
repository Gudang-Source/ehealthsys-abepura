<div class="white-container">
    <legend class="rim2">Formulir Stock <b>Obat Alkes Opname</b></legend>
    <?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarianobat-form').submit(function(){
            $('#obatalkes-m-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('obatalkes-m-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data Formulir Stock Obat Alkes Opname berhasil disimpan !");
    }
    ?>
    <?php if (!isset($_GET['sukses'])) { ?>
    <fieldset class="box" id="form-obatalkes">
        <legend class="rim"><span class='judul'>Pencarian Stok Obat Alkes Opname </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_pencarianObat', array('modObat' => $modObat)); ?>
        </div>
    </fieldset>
    <?php } ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gfformuliropname-r-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
        'focus' => '#'.CHtml::activeId($modObat,'obatalkes_kode'),
    ));
    ?>
    <div class="block-tabel">
        <h6><span class='judul'>Tabel Stok <b>Obat Alkes Opname</b></span></h6>
        <div>
            <?php $this->renderPartial($this->path_view.'_listObat', array('modObat' => $modObat,'model'=>$model)); ?>
        </div>
    </div>
    <fieldset class="box" id="form-formuliropanme">
        <legend class="rim"><span class='judul'>Data Formulir Stock Opname </span></legend>
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <div>
            <?php $this->renderPartial($this->path_view.'_formFormulirOpname', array('form'=>$form,'format'=>$format,'model'=>$model)); ?>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php 
                $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;
                $disableSave = (!empty($_GET['formuliropname_id'])) ? true : ($sukses > 0) ? true : false;; 
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasiObat();', 'onkeypress'=>'validasiObat();','disabled'=>$disableSave)); //formSubmit(this,event)        
                //  jika tanpa validasiObat
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
                $content = $this->renderPartial($this->path_view.'tips/tipsFormulirStock',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modObat'=>$modObat)); ?>
</div>