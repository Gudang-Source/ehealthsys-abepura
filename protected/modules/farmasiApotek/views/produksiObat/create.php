<style>
    .integer, .float{
        text-align: right;
    }
</style>
<div class="white-container">
    <legend class="rim2">Transaksi <b>Produksi Obat</b></legend>
    <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'faproduksiobat-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
    //        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return cekInput();'),
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#FAProduksiobatT_noproduksiobt',
    )); ?>
    <?php  
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Transaksi berhasil disimpan");
    }

    ?>
    <?php echo $form->errorSummary(array($model)); ?>
    <?php echo isset($modObatalkesM) ? $form->errorSummary(array($modObatalkesM)) : ""; ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model,'modProduksiDetail'=>$modProduksiDetail,'modObatalkesM'=>$modObatalkesM,'form'=>$form)); ?>
    <?php echo $this->renderPartial('_formDetailProduksi', array('model'=>$model,'modProduksiDetail'=>$modProduksiDetail,'modObatalkesM'=>$modObatalkesM,'form'=>$form, 'dataDetails'=>$dataDetails)); ?>
    <?php echo $this->renderPartial('_formObatalkes', array('model'=>$model,'modProduksiDetail'=>$modProduksiDetail,'modObatalkesM'=>$modObatalkesM,'form'=>$form)); ?>

    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/create'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));  ?>
        <?php $this->endWidget(); ?>
        <?php $this->widget('UserTips',array('type'=>'create'));?>
    </div>   
</div>
<script>
    function cekInput()    {
        $('.float').each(function(){this.value = unformatNumber(this.value)});
        $('.integer').each(function(){this.value = unformatNumber(this.value)});
        return true;
    }
    function formatInputLoad(){
        $('.float').each(function(){this.value = formatNumber(this.value)});
        $('.integer').each(function(){this.value = formatNumber(this.value)});
    }
    formatInputLoad();
</script>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model,'modObatalkesM'=>$modObatalkesM,'form'=>$form,'modProduksiDetail'=>$modProduksiDetail)); ?>