<div class="white-container">
    <legend class="rim2">Transaksi Stok <b>Obat Alkes Opname</b></legend>
    <?php 
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#obatalkes-m-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('obatalkes-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    "); ?>
    <?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data Stok Obat Alkes Opname berhasil disimpan !");
    }
    ?>
    <?php if (!isset($_GET['sukses']) && !isset($_GET['formuliropname_id'])) { ?>
    <fieldset class="box" id="form-obatalkes">
        <legend class="rim"><span class='judul'>Pencarian Stok Obat Alkes Opname </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_pencarianObat', array('modObat' => $modObat)); ?>
        </div>
    </fieldset>
    <?php } ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'gfstokopname-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
            //'focus'=>'#'.CHtml::activeId($model,'jenisstokopname'),
    )); ?>
    <div class="block-tabel" id="form-obatalkes">
        <h6><span class='judul'>Tabel Stok <b>Obat Alkes Opname</b></span></h6>
        <div>
            <?php $this->renderPartial($this->path_view.'_listObat', array('modObat' => $modObat,'model'=>$model)); ?>
        </div>
    </div>

    <fieldset class="box" id="form-stokopname">
        <legend class="rim"><span class='judul'>Data Stock Opname </span></legend>
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <div>
            <?php $this->renderPartial($this->path_view.'_formStockOpname', array('form'=>$form,'format'=>$format,'model'=>$model)); ?>
        </div>
    </fieldset>

    <div class="form-actions">
    <?php 
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['stokopname_id'])) ? true : ($sukses > 0) ? true : false;; 
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
                $this->createUrl($this->id.'/index'), 
                array('class'=>'btn btn-danger',
                      'onclick'=>'return refreshForm(this);'));
        } ?>								
        <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        ?>
        <?php
            $content = $this->renderPartial($this->path_view.'tips/tipsStokOpname',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modObat'=>$modObat)); ?>
</div>