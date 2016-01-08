<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'search',
        'type'=>'horizontal',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <div class="control-group">
                 <?php echo CHtml::label('Sumberdana','', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 
                        echo $form->textField($model,'sumberdana_nama',array('class'=>'span3'));
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Rekening Debit','', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        echo $form->textField($model,'rekDebit',array('class'=>'span3'));
                    ?>
                    
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Rekening Kredit','', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        echo $form->textField($model,'rekKredit',array('class'=>'span3'));
                    ?>
                    
                </div>
            </div>           
        </td>
    </tr>
</table>

    <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit')); 
                ?>
                
    </div>

<?php $this->endWidget(); ?>
