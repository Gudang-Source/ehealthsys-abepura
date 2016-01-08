<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modKelahiran)){
?>

    <legend>Riwayat Kelahiran <?php echo CHtml::checkBox('cekRiwayatPasien',true, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?></legend>
    <div id="divRiwayatPasien" class="control-group">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Lahir Tunggal</th>
                    <th>Tanggal Lahir</th>
                    <th>Nama Bayi</th>
                    <th>Jenis Kelamin</th>
                    <th>Berat Badan / Tinggi Badan</th>
                    <th>Interpretasi</th>
                    <th>Masa Gestasi / Paritas Ke</th>
                    <th>Denyut Jantung</th>
                    <th>Aktivitas Otot</th>
                    <th>Respon Refleks</th>
                    <th>Pernapasan</th>
                    <th>Apgar</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach($modKelahiran as $row){ ?>
                    <tr>
                        <td><?php if($row->islahirtunggal)  echo 'Ya'; else echo 'Tidak' ;?></td>
                        <td><?php echo $row->tgllahirbayi ;?></td>
                        <td><?php echo CHtml::link($row->namabayi, Yii::app()->createUrl($this->module->id.'/kelahiranbayiT/index&id='.$_GET['id'].'&bayi='.$row->kelahiranbayi_id));?></td>
                        <td><?php echo $row->jeniskelamin ;?></td>
                        <td><?php echo $row->bb_gram; ?> Gram <br/><?php echo $row->tb_cm ;?> CM</td>
                        <td><?php echo $row->interpretasi; ?></td>
                        <td><?php echo $row->warnakulit; ?></td>
                        <td><?php echo $row->denyutjantung; ?></td>
                        <td><?php echo $row->aktivitasotot; ?></td>
                        <td><?php echo $row->responrefleks; ?></td>
                        <td><?php echo $row->pernapasan; ?></td>
                        <td><?php echo CHtml::link("<i class=icon-list-alt></i>","#",array("rel"=>"tooltip",'class'=>'kelahiran','data'=>$row->kelahiranbayi_id, "title"=>"Klik Untuk Menindak Lanjuti Pasien",'onclick'=>"$('#getDataApgar').dialog('open');")); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
        
<?php
} else { //validasi dihilangkan RSN-294
//    Yii::app()->user->setFlash('error',"Tidak ada data Riwayat Kelahiran pasien");
    echo "";
    $this->widget('bootstrap.widgets.BootAlert');
}

?>

     <?php 
// Dialog untuk pasienpulang_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'getDataApgar',
    'options'=>array(
        'title'=>'Metode Apgar',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
    ),
));

echo '<div class="divForForm"></div>';


$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>

<?php $urlDataApgar = Yii::app()->createUrl('persalinan/kelahiranbayiT/dataApgar'); ?>

<?php Yii::app()->clientScript->registerScript('appgard2', "
    $(document).ready(function(){
        function getDataApgar(input){
                
                var kelahiranbayi_id = $(input).attr('data');
                $.post('${urlDataApgar}', { kelahiranbayi_id:kelahiranbayi_id },
                function(data){
                    $('#getDataApgar div.divForForm').html(data.div);
                }, 'json');
           
        }
        $('.kelahiran').click(function(){
              getDataApgar($(this));
        });
        
        $('.apgar').change(function(){
            $(this).parent().parent().css('background','#B5C1D7');
        });
    });
", CClientScript::POS_READY); ?>
