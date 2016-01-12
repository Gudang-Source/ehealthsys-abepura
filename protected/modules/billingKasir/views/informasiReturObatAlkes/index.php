<div class="white-container">
    <legend class="rim2">Informasi Retur <b>Penjualan Obat</b></legend>
    <?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'search',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'method'=>'get',
                'htmlOptions'=>array(),
        ));
    ?>
    <div class="block-tabel">
        <h6>Tabel Retur <b>Penjualan Obat</b></h6>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        Yii::app()->clientScript->registerScript('cariPasien', "
        $('#search').submit(function(){
                $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'informasipenjualanresep-grid',
                'dataProvider'=>$model->searchInformasiRetur(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Tanggal Retur Pelayanan',
                        'type'=>'raw',
                        'value'=>'$data->tglretur',
                    ),
                    array(
                        'header'=>'No. Retur Resep',
                        'type'=>'raw',
                        'value'=>'isset($data->noreturresep) ? $data->noreturresep:"-" ',
                    ),
                    array(
                        'header'=>'No. Resep',
                        'type'=>'raw',
                        'value'=>'isset($data->noresep) ? $data->noresep:"-" ',
                    ),
                    array(
                        'header'=>'Jenis Penjualan',
                        'type'=>'raw',
                        'value'=>'isset($data->jenispenjualan) ? $data->jenispenjualan:"-"',
                    ),
                    array(
                        'header'=>'Nama Pasien',
                        'type'=>'raw',
                        'value'=>'isset($data->nama_pasien) ? $data->nama_pasien:"-"',
                    ),
                    array(
                        'header'=>'Total Retur Obat',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totalretur)',
                    ),
                   array(
                       'header'=>'Mengetahui',
                       'type'=>'raw',
                       'value'=>'$data->pegawaimengetahui_gelardepan." ".$data->pegawaimengetahui_nama." ".$data->pegawaimengetahui_gelarbelakang',
                   ),
                   array(
                       'header'=>'Pegawai Retur',
                       'type'=>'raw',
                       'value'=>'$data->pegawairetur_gelardepan." ".$data->pegawairetur_nama." ".$data->pegawairetur_gelarbelakang',
                   ),
                    array(
                        'header'=>'Rincian Retur Penjualan',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-rincianretur\"></i>",Yii::app()->controller->createUrl("informasiReturObatAlkes/detailRetur",array("id"=>$data->returresep_id,"iframe"=>1)),

                                 array("class"=>"", 
                                          "target"=>"iframeRincianReturObat",
                                          "onclick"=>"$(\"#dialogRincianReturObat\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Retur Obat",
                                    ))',          
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                     array(
                        'header'=>'Pembayaran',
                        'type'=>'raw',
                        'value'=>'(empty($data->tandabuktikeluar_id) ? CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->createAbsoluteUrl("billingKasir/returObatAlkesPasien/Index",array("returresep_id"=>$data->returresep_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeReturPembayaran",
                                          "onclick"=>"$(\"#dialogReturPembayaran\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk membayar retur obat alkes",
                                    )) : "Sudah Dibayarkan")',          
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Retur','tglawal',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_awal',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                                )); 
                            ?>

                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label(' Sampai dengan','tgl_akhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_akhir',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                                )); 
                            ?>                        
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Retur','noreturresep',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'noreturresep',array('class'=>'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Resep','noresep',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'noresep',array('class'=>'span3')); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>

    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            } ?>
            <?php  
                $content = $this->renderPartial('tips/informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>

<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('',"
function printKasir(returresep_id,tandabuktibayar_id)
{
    if(idTandaBukti!=''){ 
             window.open('".Yii::app()->createUrl('billingKasir/InformasiReturObatAlkes/bayarReturPenjualanObat')."&returresep_id='+returresep_id+'&tandabuktibayar_id='+tandabuktibayar_id,'printwin','left=100,top=100,width=400,height=400,scrollbars=1');
    }     
}",  CClientScript::POS_HEAD);
?>
<?php 
//================= Dialog Rincian Retur Penjualan Obat Alkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianReturObat',
    'options'=>array(
        'title'=>'Detail Rincian Retur Obat Alkes',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeRincianReturObat" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= End dialog Rincian Retur Penjualan Obat Alkes =============================
 ?>

<?php 
//================== Dialog Rincian Pembayaran Retur Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogReturPembayaran',
    'options'=>array(
        'title'=>'Pembayaran Retur Penjualan Obat Alkes',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeReturPembayaran" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= End Dialog Rincian Pembayaran Retur Obat =============================
 ?>