<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'rjruanganpegawai-m-search',
                 'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php  //echo $form->textFieldRow($model, 'ruangan_nama',array('class'=>'span3')) ?>
			<?php
					$ruanganid = Yii::app()->user->ruangan_id;
					$modruangan = RuanganM::model()->findByPK($ruanganid);
					echo CHtml::hiddenField('ruanganid',$ruanganid,array('readonly'=>true));
					echo $form->textFieldRow($model,'ruangan_nama',array('value'=>$modruangan->ruangan_nama,'readonly'=>true,'class'=>'span2',));
			?>
        </td>
        <td>
            <?php  echo $form->textFieldRow($model, 'nama_pegawai',array('class'=>'span3')) ?>
        </td>
    </tr>
</table>
<?php // echo $form->DropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --',)); ?>
<?php //echo $form->DropDownListRow($model, 'pegawai_id', CHtml::listData($model->getPegawaiItems(),'pegawai_id','namalengkap'),array('empty'=>'-- Pilih --')); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
