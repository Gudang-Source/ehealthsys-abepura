<div class="white-container">
    <legend class="rim2">Setoran <b>Bendahara ke Bank</b></legend>
	
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'setoranbendahara-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
				'onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return cekValidasi(this);',
			),
    )); ?>
	
	<?php 
		if(isset($_GET['id'])){
			Yii::app()->user->setFlash('success', "Data setoran berhasil disimpan !");
		}
	?>
	
	<?php if (empty($id)) echo $this->renderPartial('sub/_infosetoran', array('form'=>$form, 'model'=>$model), true); ?>
	<?php echo $this->renderPartial($this->path_view.'sub/_formsetoran', array('form'=>$form, 'model'=>$model, 'setorbank'=>$setorbank), true); ?>
	<?php echo $this->renderPartial($this->path_view.'sub/_detailsetoran', array('form'=>$form, 'model'=>$model, 'detail'=>$detail), true); ?>
	
	<div class="row-fluid">
        <div class="form-actions">
                <?php 
                    if($model->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); //formSubmit(this,event)
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
					if($model->isNewRecord){
						echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true  ));
					} else {
						echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printSetoran(".$id.");return false",'disabled'=>FALSE  ));
					}
				?>
        </div>
    </div>
	
	<?php $this->endWidget(); ?>
</div>
<?php echo $this->renderPartial($this->path_view.'sub/_jsfunctions', array('form'=>$form, 'model'=>$model, 'detail'=>$detail), true); ?>