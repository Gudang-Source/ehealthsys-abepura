<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'gzstokbahanmakanan-search',
                 'type'=>'horizontal',
)); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td style="width:1%;">
            <?php echo $form->checkBox($model,'cekTgl') ?>
        </td>
        <td>
            <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
            <div class="control-group ">
                <?php echo Chtml::label("Tanggal Terima Bahan",'tglterimabahan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $model->tgl_awal = MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($model->tgl_awal)));
                            $model->tgl_akhir = MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($model->tgl_akhir)));
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>TRUE,'class'=>'dtPicker3'),
                    )); 
                   ?> </div></div>
		<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>TRUE,'class'=>'dtPicker3'),
                    )); ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo Chtml::label("Nama Bahan Makanan",'namabahanmakanan', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'namabahanmakanan', array('class'=>'span3')); ?>
                </div>
            </div>
        </td>
        <td>
            
        </td>
        <td>            
        </td>
    </tr>
</table>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
					<?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/barangM/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo "&nbsp;";
    ?>
	<?php 
            $tips = array(
                '0' => 'tanggal',
                '1' => 'cari',
                '2' => 'ulang2',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
        ?>	
	</div>

<?php $this->endWidget(); ?>
