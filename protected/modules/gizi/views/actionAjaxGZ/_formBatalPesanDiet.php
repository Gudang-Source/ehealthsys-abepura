<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
	'id'=>'batalpesandiet-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
    )
);

?>
<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('jenispesanmenu')); ?>:</b>
            <?php echo CHtml::encode($model->jenispesanmenu); ?>
            <br />
            <b><?php echo CHtml::encode($model->getAttributeLabel('nopesanmenu')); ?>:</b>
            <?php echo CHtml::encode($model->nopesanmenu); ?>
            <br />
            <b><?php echo CHtml::encode($model->getAttributeLabel('tglpesanmenu')); ?>:</b>
            <?php echo CHtml::encode($model->tglpesanmenu); ?>
            <br/>
            <b><?php echo CHtml::encode($model->getAttributeLabel('nama_pemesan')); ?>:</b>
            <?php echo CHtml::encode($model->nama_pemesan); ?>
            <br/>

        </td>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($model->create_time); ?>
            <br />
        </td>
    </tr>   
</table>
<style>
    .table thead tr th{
        vertical-align:middle;
    }
</style>
<p class="help-block"><?php echo "Pilih menu diet yang akan dibatalkan"?></p>
    <?php echo $form->errorSummary($modelPesan); ?>

<div>
    <?php echo CHtml::hiddenField('idPesanDiet', '', array('readonly'=>TRUE)); ?>
    <?php if(count($modDetail) > 0){ ?>
    <div>
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center;"><center><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll();"></center></th>
                    <th style="text-align:center;">Instalasi/ <br/> Ruangan</th>
                    <th style="text-align:center;">No. Pendaftaran/ <br/> No. RM </th>
                    <th style="text-align:center;">Nama Pasien</th>
                    <th style="text-align:center;">Umur</th>
                    <th style="text-align:center;">Jenis Kelamin</th>
                    <th style="text-align:center;">Menu Diet</th>
                    <th style="text-align:center;">Jumlah</th>
                    <th style="text-align:center;">Satuan URT</th>
                    <th style="text-align:center;">Jenis Makanan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($modDetail as $i=>$detail){
                ?>
                <tr>
                    <td><center>
                        <?php
                            echo CHtml::checkBox('PesanmenudetailT['.$i.'][checkList]',true,array('class'=>'cekList','onclick'=>'checkList(this)')) ;
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][pesanmenudetail_id]',$detail->pesanmenudetail_id); 
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][pendaftaran_id]',$detail->pendaftaran_id); 
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][pasienadmisi_id]',$detail->pasienadmisi_id); 
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][pasien_id]',$detail->pasien_id); 
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][satuanjml_urt]',$detail->satuanjml_urt); 
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][penjamin_id]', $detail->pendaftaran->penjamin_id);
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][jeniskasuspenyakit_id]', $detail->pendaftaran->jeniskasuspenyakit_id);
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][pesanmenudiet_id]', $detail->pesanmenudiet_id);
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][kirimmenupasien_id]', $detail->kirimmenupasien_id);
                            echo CHtml::hiddenField('PesanmenudetailT['.$i.'][menudiet_id]', $detail->menudiet_id);
                        ?>                        
                        </center></td>
                    <td><?php echo $detail->pendaftaran->instalasi->instalasi_nama."<br>".$detail->pendaftaran->ruangan->ruangan_nama; ?></td>
                    <td><?php echo $detail->pendaftaran->no_pendaftaran."<br>".$detail->pendaftaran->pasien->no_rekam_medik; ?></td>
                    <td><?php echo $detail->pasien->nama_pasien ?></td>
                    <td><?php echo $detail->pendaftaran->umur ?></td>
                    <td><?php echo $detail->pasien->jeniskelamin ?></td>
                    <td><?php echo $detail->jeniswaktu->jeniswaktu_nama." - ".$detail->menudiet->menudiet_nama ?></td>
                    <td><center><?php echo $detail->jml_pesan_porsi; ?></center></td>
                    <td><center><?php echo $detail->satuanjml_urt; ?></center></td>
                    <td><center>-</center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else if(count($modPegawai) > 0) { ?>
    <div>
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center;"><center><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll();"></center></th>
                    <th style="text-align:center;">Instalasi/ <br/> Ruangan</th>
                    <th style="text-align:center;">Nama Pegawai</th>
                    <th style="text-align:center;">Menu Diet</th>
                    <th style="text-align:center;">Jumlah</th>
                    <th style="text-align:center;">Satuan URT</th>
                    <th style="text-align:center;">Jenis Makanan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($modPegawai as $i=>$detail){
                ?>
                <tr>
                    <td><center>
                        <?php
                            echo CHtml::checkBox('PesanmenupegawaiT['.$i.'][checkList]',true,array('class'=>'cekList','onclick'=>'checkList(this)')) ;
                            echo CHtml::hiddenField('PesanmenupegawaiT['.$i.'][pesanmenupegawai_id]',$detail->pesanmenupegawai_id); 
                            echo CHtml::hiddenField('PesanmenupegawaiT['.$i.'][pegawai_id]',$detail->pegawai_id); 
                            echo CHtml::hiddenField('PesanmenupegawaiT['.$i.'][satuanjml_urt]',$detail->satuanjml_urt); 
                            echo CHtml::hiddenField('PesanmenupegawaiT['.$i.'][pesanmenudiet_id]', $detail->pesanmenudiet_id);
                            echo CHtml::hiddenField('PesanmenupegawaiT['.$i.'][kirimmenupegawai_id]', $detail->kirimmenupegawai_id);
                            echo CHtml::hiddenField('PesanmenupegawaiT['.$i.'][menudiet_id]', $detail->menudiet_id);
                        ?>
                    </td>
                    <td><?php echo $model->ruangan->instalasi->instalasi_nama."<br>".$model->ruangan->ruangan_nama; ?></td>
                    <td><?php echo $detail->pegawai->nama_pegawai; ?> </td>
                    <td><?php echo $detail->jeniswaktu->jeniswaktu_nama." - ".$detail->menudiet->menudiet_nama ?></td>
                    <td><center><?php echo $detail->jml_pesan_porsi; ?></center></td>
                    <td><center><?php $detail->satuanjml_urt; ?></center></td>
                    <td><center>-</center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else{ ?>
    <div>
        <table class="table table-bordered table-striped table-condensed">
            <tr>
                <td>Data tidak ditemukan</td>
            </tr>
        </table>
    </div>
    <?php } ?>
</div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary', 'onclick'=>'konfirmasiKirim(event);','onKeypress'=>'return formSubmit(this,event)')); ?>

        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                array('class'=>'btn btn-danger','onclick'=>'cancel();')); ?>
    </div>

    <?php $this->endWidget(); ?>  
<script>
function checkList(obj){
    if ($(obj).is(":checked")) {
           $(obj).attr('checked',true);
           $(obj).val(1);
    } else {
           $(obj).removeAttr('checked');
           $(obj).val(0);
    }
}

function checkAll(){
    if ($("#checkListUtama").is(":checked")) {
        $('.cekList').each(function(){
           $(this).attr('checked',true);
           $(this).val(1);
        })
    } else {
       $('.cekList').each(function(){
           $(this).removeAttr('checked');
           $(this).val(0);
        })
    }
}
function konfirmasiKirim(event){
//    var answer = confirm('Yakin Akan Membatalkan Pemesanan Diet ?');
    
//    if(answer){
      $('#batalpesandiet-form').submit();
      return true;
//    }else{
//        event.preventDefault();         
//        return false;
//    }
}
function cancel(){
    $('#dialogBatalPesan').dialog('close');
}
</script>