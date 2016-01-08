<?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'search',
            'type'=>'horizontal',
            'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

    )); 
?>

<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table  class="table-condensed">
        <tr>
            <td>
                 <?php echo $form->textFieldRow($modKomposisiBahanMakanan,'namabahanmakanan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'autofocus'=>true, 'placeholder'=>'Ketik nama bahan makanan')); ?>
                 <?php //echo $form->textFieldRow($modKomposisiBahanMakanan,'zatgizi_nama',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
               
            </td>
            
        </tr>
    </table>
    <div class="form-actions">
        <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
                echo "&nbsp;";
                echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); 
        ?>
        <?php 
                $content = $this->renderPartial('../tips/informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
        ?>

    </div>
</fieldset>  
<?php $this->endWidget();?>
