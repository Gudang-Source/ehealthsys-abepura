<div class="white-container">
    <legend class="rim2">Informasi <b>Rawat Jalan</b></legend> 
    <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('ininformasiTarif-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Rawat Jalan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'ininformasiTarif-grid',
            'dataProvider'=>$modRawatJalan->searchRJ(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                        array(
                           'name'=>'tgl_pendaftaran',
                            'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran))',
                        ),
                        array(
                           'name'=>'no_pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->no_pendaftaran',
                        ),
                        array(
                           'name'=>'no_rekam_medik',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik',
                        ),
                        array(
                            'header'=>'Nama Pasien / Alias',
                            'value'=>'$data->namaNamaBin'
                        ),
                        array(
                           'name'=>'alamat_pasien',
                            'type'=>'raw',
                            'value'=>'$data->alamat_pasien',
                        ),
                        array(
                            'header'=>'Cara Bayar / Penjamin',
                            'value'=>'$data->caraBayarPenjamin',
                        ),
                        array(
                           'name'=>'Dokter',
                            'type'=>'raw',
                            'value'=>'$data->nama_pegawai',
                        ),
                        array(
                           'name'=>'Transportasi',
                            'type'=>'raw',
                            'value'=>'(!empty($data->transportasi))? $data->transportasi : "-"',
                        ),
                        array(
                           'name'=>'Cara Masuk',
                            'type'=>'raw',
                            'value'=>'(!empty($data->caramasuk_nama))? $data->caramasuk_nama : "-"',
                        ),
                        array(
                           'name'=>'Rujukan',
                            'type'=>'raw',
                            'value'=>'(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                        ),
                        array(
                            'header'=>'Kasus Penyakit / <br> Kelas Pelayanan',
                            'type'=>'raw',
                            'value'=>'"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                        ),                                        
                            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend> 
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'id'=>'search',
                'type'=>'horizontal',
        )); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($modRawatJalan,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'autofocus'=>TRUE)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($modRawatJalan,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($modRawatJalan,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                                    array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                    array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
             <?php 
               $content = $this->renderPartial('../tips/informasi',array(),true);
               $this->widget('UserTips',array('type'=>'admin','content'=>$content));
             ?>
            <?php
                // echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";                 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?> 
</div>
<?php
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintTarif');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint+"&d"+$('#search').serialize(),"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD); 
?>
<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetailsTarif',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Komponen Tarif',
                        'autoOpen'=>false,
                        'width'=>350,
                        'height'=>350,
                        'resizable'=>false,
                        'scroll'=>false    
                         ),
                    ));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
?>