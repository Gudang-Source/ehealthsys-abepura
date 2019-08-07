<?php
$this->breadcrumbs=array(
	'Informasi Pembebasan Tarif',
);

Yii::app()->clientScript->registerScript('search', "
 $('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipembebasantarif-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class = "white-container">    
    <legend class="rim2">Informasi Pembebasan Tarif</legend>
    
    <div class="block-tabel">
        <h6>Tabel Informasi <b>Pembebasan Tarif</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'informasipembebasantarif-m-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                        array(
                            'header' => 'Tanggal Pembebasan',
                            'name' => 'tglpembebasan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembebasan)'
                        ),
                        array(
                            'header' => 'No Rekam Medik',
                            'name' => 'no_rekam_medik',
                            'value' => '$data->no_rekam_medik'
                        ),
                        array(
                            'header'=>'Nama Pasien',
                            'name'=>'nama_pasien',                                                        
                            'value'=> function($data){
                                $p = RJPasienM::model()->findByPk($data->pasien_id);
                                
                                if (count($p)>0){
                                    return $p->namadepan.' '.$p->nama_pasien;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Dokter',
                            'name' => 'nama_pegawai',
                            'value' => function($data){
                                $peg = RJPegawaiM::model()->findByPk($data->pegawai_id);
                                
                                if (count($peg)>0){
                                    return $peg->namaLengkap;
                                }else{
                                    return '-';
                                }
                            }
                        ),                        
                        
                        'daftartindakan_nama',
                        'komponentarif_nama',
                        array(
                            'name'=>'jmlpembebasan',
                            'type'=>'raw',
                            'value'=>'"Rp".number_format($data->jmlpembebasan,0,"",".")',
                            'htmlOptions' => array('style'=>'text-align:right;')
                        )
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
            <div class="search-form">
            <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'id'=>'informasipembebasantarif-t-search',
                    'type'=>'horizontal',
            )); ?>
            <table>
                <tr>
                    <td>
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Pembebasan',  CHtml::activeId($model, 'tgl_awal'), array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tgl_awal',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'dateFormat'=>'dd M yy',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                            ),
                                    )); ?>
                                </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Sampai Dengan',CHtml::activeId($model, 'tgl_akhir'), array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tgl_akhir',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'dateFormat'=>'dd M yy',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                            ),
                                    )); ?>
                                </div>
                        </div>                         
                        <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3 numbers-only','maxlength'=>6)); ?>
                    </td>
                    <td>
                        <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3 hurufs-only')); ?>
                        
                        <div class = "control-group">
                            <?php echo Chtml::label('Dokter','pegawai_id', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'pegawai_id', Chtml::listData(DokterV::model()->findAll(" ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' "), 'pegawai_id', 'NamaLengkap'),array('empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                          
                    </td>
                    <td>
                        <?php echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span3 custom-only')); ?>
                    </td>
                </tr>
            </table>
            </div>
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onclick'=>'resetForm();')); ?>
        <?php  
            $tips = array(
                '0' => 'tanggal',
                '1' => 'cari',
                '2' => 'ulang2'
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
    <?php $this->endWidget(); ?>

    </fieldset>    
    <script>
    function resetForm(){
        window.open("<?php echo $this->createUrl("/".$this->route); ?>", "_self");
    }
    </script>
</div>
