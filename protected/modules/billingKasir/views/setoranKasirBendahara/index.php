<div class="white-container">
    <legend class="rim2">Setoran <b>Kasir ke Bendahara</b></legend>
	
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'setoranbendahara-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),
    )); ?>
	
	<?php 
		if(isset($_GET['id'])){
			Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan !");
		}
	?>
	
    <?php echo $this->renderPartial($this->path_view.'sub/_infoclosing', array('setoran'=>$setoran, 'closing'=>$closing, 'form'=>$form), true); ?>
    <?php echo $this->renderPartial($this->path_view.'sub/_setorankasir', array('setoran'=>$setoran, 'closing'=>$closing, 'form'=>$form), true); ?>
    <?php echo $this->renderPartial($this->path_view.'sub/_detailsetoran', array('setoran'=>$setoran, 'closing'=>$closing, 'form'=>$form, 'setorandet'=>$setorandet, 'tot'=>$tot), true); ?>
    
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    if($setoran->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'return cekValidasi();')); //formSubmit(this,event)
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                    }
                ?>
                <?php
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array(
                            'class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'
                    )); 
					echo "&nbsp;";
					echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printSetoran();return false",'disabled'=>FALSE  ));
                    
				?>
        </div>
    </div>
    
    <?php $this->endWidget(); ?>
</div>
<?php echo $this->renderPartial($this->path_view.'sub/_jsFunctions', array('setoran'=>$setoran, 'closing'=>$closing, 'form'=>$form), true); ?>