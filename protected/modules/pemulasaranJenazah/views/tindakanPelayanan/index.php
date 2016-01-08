<div class="white-container">
<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0){
    Yii::app()->user->setFlash('success',"Transaksi Tindakan dan Pelayanan berhasil disimpan !");
} ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Transaksi <b>Tindakan Dan Pelayanan</b></legend>
    <?php
        $this->renderPartial('_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
    ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'tindakan-pelayanan-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    )); ?>
    <div class="block-tabel row-fluid">
        <h6>Tabel <b>Tindakan</b></h6>
        <div style="display:none;">
            <?php echo Chtml::activeTextField($modPendaftaran,'pendaftaran_id',array('readonly'=>true)); ?>
            <?php echo CHtml::activeTextField($modPendaftaran,'kelaspelayanan_id', array('readonly'=>true)); ?>
            <?php echo CHtml::activeTextField($modPendaftaran,'carabayar_id',array('readonly'=>true)); ?>
            <?php echo CHtml::activeTextField($modPendaftaran,'penjamin_id',array('readonly'=>true)); ?>
            <?php echo CHtml::activeTextField($modPendaftaran,'kelompokumur_id',array('readonly'=>true)); ?>
            <?php echo Chtml::textField('pasienmasukpenunjang_id','',array('readonly'=>true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tipe Paket','tipepaket_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::dropDownList('tipepaket_id',Params::TIPEPAKET_ID_NONPAKET,(CHtml::listData($modTindakan->getTipePakets(),'tipepaket_id', 'tipepaket_nama')),array('class'=>'span3','onchange'=>'setTabelTindakanReset();')); ?>
            </div>
        </div>    
        <div class="row-fluid">
            <table id="table_tindakanpelayanan" class="table table-condensed table-bordered table-striped">
                <thead>
                    <th>No.</th>
                    <th>Poliklinik / Ruangan<br>Tanggal Tindakan</th>
                    <th>Kategori Tindakan</th>
                    <th width="40%">Nama Tindakan</th>
                    <th>Tarif Satuan</th>
                    <th>Jumlah</th>
                    <th>Satuan Tindakan</th>
                    <th>Cyto</th>
                    <th>Tarif Cyto</th>
                    <th>Jumlah Tarif</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php
    //                BENTROK DENGAN tr hasil javascript
                        if(count($dataTindakans) > 0){
                            foreach($dataTindakans AS $ii => $tindakan){
                                 echo $this->renderPartial("_rowTindakan",array('form'=>$form,'modTindakan'=>$tindakan), true); 
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:center;"></td>
                        <td colspan="7" style="text-align:right;"><b>Total Tarif Tindakan :</b></td>
                        <td><?php echo CHtml::textField('totaltariftindakan',0,array('readonly'=>true,'class'=>'integer', 'style'=>'width:100px;')); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

        </div>

        <div class="span6">
            <?php $this->renderPartial('_formPemakaianBahan',array()); ?>
        </div>
        <div class="span6">
            <?php $this->renderPartial('_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
       <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl('Index'), 
                array('class'=>'btn btn-danger',
                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('Index').'";}); return false;'));  ?>
        <?php $content = $this->renderPartial('../tips/transaksi_tindakan',array(),true);
              $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </div> 
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('form'=>$form,'modTindakan'=>$modTindakan,'modPendaftaran'=>$modPendaftaran)); ?>        
    <?php $this->endWidget(); ?>
</div>
<div style="display:none">    
<?php
    //hanya untuk memanggil asset dari jquery date
    $this->widget('MyDateTimePicker', array(
        'name'=>'untukmemanggilassetjs',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array('readonly' => true,
            'onkeyup' => "return $(this).focusNextInputField(event)"),
    ));
?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialog_tindakan',
        'options'=>array(
            'title'=>'Daftar Tindakan '.(InstalasiM::model()->findByPk($instalasi_id)->instalasi_nama),
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>860,
            'height'=>380,
            'resizable'=>false,
        ),
    )
);
echo CHtml::hiddenField('tindakan_untuk',0,array('readonly'=>true));
$modDaftarTindakan = new PJTarifTindakanPerdaRuanganV('search');
$modDaftarTindakan->penjamin_id = 0;
$modDaftarTindakan->unsetAttributes();
if (isset($_GET['PJTarifTindakanPerdaRuanganV'])){
    $modDaftarTindakan->attributes = $_GET['PJTarifTindakanPerdaRuanganV'];
    $modDaftarTindakan->tipepaket_id = $_GET['PJTarifTindakanPerdaRuanganV']['tipepaket_id'];
    $modDaftarTindakan->ruangan_id =  $_GET['PJTarifTindakanPerdaRuanganV']['ruangan_id'];
    $modDaftarTindakan->kelaspelayanan_id =  $_GET['PJTarifTindakanPerdaRuanganV']['kelaspelayanan_id'];
    $modDaftarTindakan->penjamin_id =  $_GET['PJTarifTindakanPerdaRuanganV']['penjamin_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'daftartindakan-grid',
        'dataProvider'=>$modDaftarTindakan->searchDialog(),
        'filter'=>$modDaftarTindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                . '"onClick" => "pilihTindakan(\"$data->daftartindakan_id\",\"$data->daftartindakan_nama\",\"$data->kategoritindakan_nama\",\"$data->harga_tariftindakan\",\"$data->jenistarif_id\",\"$data->persencyto_tind\");
                    $(\"#dialog_tindakan\").dialog(\"close\");
                    return false;"))',
                'filter'=>
                    CHtml::activeHiddenField($modDaftarTindakan, 'ruangan_id',array('readonly'=>true))
                    .CHtml::activeHiddenField($modDaftarTindakan, 'kelaspelayanan_id',array('readonly'=>true))
                    .CHtml::activeHiddenField($modDaftarTindakan, 'penjamin_id',array('readonly'=>true))
                    .CHtml::activeHiddenField($modDaftarTindakan, 'tipepaket_id',array('readonly'=>true))
                ,
            ),
            'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',
            array(
                'name'=>'harga_tariftindakan',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->harga_tariftindakan)',
                'filter'=>false,
                'htmlOptions'=>array('style'=>'text-align:right'),
            ),
            array(
                'name'=>'persencyto_tind',
                'type'=>'raw',
                'value'=>'MyFormatter::formatNumberForPrint($data->persencyto_tind)',
                'filter'=>false,
                'htmlOptions'=>array('style'=>'text-align:right'),
            ),
            
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialog_dokter',
        'options'=>array(
            'title'=>'Dokter / Paramedis',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>860,
            'height'=>380,
            'resizable'=>false,
        ),
    )
);
echo CHtml::hiddenField('dokter_untuk',"",array('readonly'=>true));
$modDokter = new PJDokterV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = $modPendaftaran->ruangan_id; //default
if (isset($_GET['PJDokterV'])){
    $modDokter->attributes = $_GET['PJDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'dokter-grid',
        'dataProvider'=>$modDokter->searchDialog(),
        'filter'=>$modDokter,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                . '"onClick" => "pilihDokter(\"$data->pegawai_id\",\"$data->NamaLengkap\");
                    $(\"#dialog_dokter\").dialog(\"close\");
                    return false;"))',
                'filter'=>
                    CHtml::activeHiddenField($modDokter, 'ruangan_id',array('readonly'=>true))
                ,
            ),
            'gelardepan',
            'nama_pegawai',
            'gelarbelakang_nama',
            'jeniskelamin',
            'agama',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>    


