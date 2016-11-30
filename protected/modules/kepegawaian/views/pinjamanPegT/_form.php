<script type="text/javascript">
    
    function hitung_pinjam(){
        var jml_pinjam  = $("#KPPinjamanPegT_jumlahpinjaman").val();
        var lama_pinjam = $("#KPPinjamanPegT_lamapinjambln").val();
        var bunga       = $("#KPPinjamanPegT_persenpinjaman").val();

        // $.ajax({
        //     url: "hitung.php",
        //     data: "jml_pinjam=" + jml_pinjam + "&lama_pinjam="+lama_pinjam,
        //     success: function(data){
        //         // jika data sukses diambil dari server, tampilkan di <select id=kota>
        //         $("#detail").html(data);
        //     }
        // });
        //myAlert(nopinjam);
        return false;
    }
    
</script>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pinjamanpeg-t-form',
	'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)',  'onsubmit'=>'return cekAngsuranPinjaman();'),
    'focus'=>'#',
)); ?>

<?php $this->renderPartial('_pegawai', array('model'=>$modPegawai, 'form'=>$form)); ?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box">
    <legend class='rim'>Data Pinjaman</legend>
    <div class="row-fluid">
        <div class="span4">
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'tglpinjampeg', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                        $model->tglpinjampeg = (!empty($model->tglpinjampeg) ? date("d/m/Y",strtotime($model->tglpinjampeg)) : null);
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpinjampeg',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'showOn' => false,
                                                    'maxDate' => 'd',
                                                    'yearRange'=> "-150:+0",
                                                ),
                                                'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($model, 'tglpinjampeg'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'tgljatuhtempo', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                        $model->tgljatuhtempo = (!empty($model->tgljatuhtempo) ? date("d/m/Y",strtotime($model->tgljatuhtempo)) : null);
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgljatuhtempo',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'showOn' => false,
                                                    // 'maxDate' => 'd',
                                                    'yearRange'=> "-150:+0",
                                                ),
                                                'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($model, 'tgljatuhtempo'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'nopinjam',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=> TRUE)); ?>
                
        </div>
        <div class="span4">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'jumlahpinjaman', array('class' => 'control-label')); ?>
                    <div class="controls">                
                        <?php echo $form->textField($model,'jumlahpinjaman',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Rupiah
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'lamapinjambln', array('class' => 'control-label')); ?>
                    <div class="controls">                
                        <?php echo $form->textField($model,'lamapinjambln',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Bulan
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'persenpinjaman', array('class' => 'control-label')); ?>
                    <div class="controls">                
                        <?php echo $form->textField($model,'persenpinjaman',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> %
                    </div>
                </div>
        </div>
        <div class="span4">
            <?php echo $form->textAreaRow($model,'untukkeperluan',array('rows'=>3, 'cols'=>30, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>3, 'cols'=>30, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?php
                if(empty($model->pinjamanpeg_id)){
            ?>
            <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>Hitung',
                array('onclick'=>'submithitung();',
                      'class'=>'btn btn-primary',
                      'onkeypress'=>"submithitung();return $(this).focusNextInputField(event);",
                      'rel'=>"tooltip",
                      'title'=>"Klik Untuk Menghitung Tabel Pembayaran",

                )); 
                } 
            ?>
        </div>
    </div>
</fieldset>
	
<?php if (isset($modPinjamDetail)) { 
    echo $form->errorSummary($modPinjamDetail);
}
?>
<div class="block-tabel">
    <h6>Tabel <b>Pinjaman Pegawai</b></h6>
    <table id="tabledetailpinjaman" class="table table-striped table-condensed">
        <thead>
        <tr>
            <th>No.</th>
            <th>Bulan Ke</th>
            <th>Tanggal Pembayaran</th>
            <th>Jumlah Bayar</th>
        </tr>
        </thead>
        <tbody>
            <?php 
                $idpinjaman = $model->pinjamanpeg_id;
                $format = new MyFormatter;
                if (isset($idpinjaman)){
                    $modPinjamDetail = KPPinjamPegDetT::model()->findAllByAttributes(array('pinjamanpeg_id'=>$idpinjaman),array('order'=>'angsuranke'));
                    // print_r(count($modPinjamDetail));
                    if (count($modPinjamDetail) > 0){
                        $tr = '';
                        $no = 1;
                        foreach ($modPinjamDetail as $key => $detail) {
                            $tr="<tr>
                                <td>". CHtml::TextField('noUrut',$no++,array('class'=>'span1 noUrut','readonly'=>TRUE)).
                                       CHtml::activeHiddenField($detail,'['.$key.']pinjampegdet_id',array('class'=>'pinjamDetail')).
                                       CHtml::activeHiddenField($detail,'['.$key.']pinjamanpeg_id'). 
                                       CHtml::activeHiddenField($detail,'['.$key.']tandabuktibayar_id').
                               "</td>

                                <td>".CHtml::activeTextField($detail,'['.$key.']angsuranke',array('class'=>'span1 numbersOnly ','readonly'=>true))."</td>
                                <td>".$format->formatDateTimeId($detail['tglakanbayar'])."</td>
                                <td>".CHtml::activeTextField($detail,'['.$key.']jmlcicilan',array('class'=>'span1 numbersOnly','readonly'=>true))."</td>".
                                "</tr>   
                            ";
                            echo $tr;
                        }

                    }
                }
            ?>

        </tbody>
    </table>
</div>
<div class="form-actions">
    <?php 
        if(isset($model->pinjamanpeg_id)){
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class'=>'btn btn-primary',  'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>true, 'style'=>'cursor:not-allowed;')); 
        }else{
    ?>
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
        }
    ?>

        <?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl($this->id.'/create'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
		?>
        <?php 
            if($model->isNewRecord){
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
            }else{
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false",'disabled'=>FALSE ));
            }
        ?>

        <?php 
            $tips = array(
                '0' => 'autocomplete-search',
                '1' => 'tanggal',
                '2' => 'simpan',
                '3' => 'ulang',
                '4' => 'print'
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                
        ?>
</div>

<?php $this->endWidget(); ?>

<?php
$urlGetObatAlkes = Yii::app()->createUrl('/GudangFarmasi/RencanaKebutuhan/getObatAlkes');
// if (!empty($modPinjamDetail)){
//     $pinjamDetail=CHtml::activeId($modPinjamDetail,'pinjamDetail');
// }

$urlPrint = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/print&id='.$model->pinjamanpeg_id);
?>
<script type="text/javascript">
    function print(string){
    window.open("<?php echo $urlPrint; ?>&caraPrint=PRINT","",'location=_new, width=900px');
}

function cekAngsuranPinjaman(){
    
    detail = $('#tabledetailpinjaman tbody').find('tr');
    
    if (detail.length > 0)
    {   
        return requiredCheck($("#pinjamanpeg-t-form"));                        
    }else{
        myAlert("Maaf, Tabel Pinjaman Pegawai Belum Diisi");
        return false;
    }
   
}

function submithitung()
{
    jumlah_pinjam   = $('#KPPinjamanPegT_jumlahpinjaman').val();
    lama_pinjam     = $('#KPPinjamanPegT_lamapinjambln').val();
    bunga_pinjam    = $('#KPPinjamanPegT_persenpinjaman').val();
    tgl_pinjam      = $('#KPPinjamanPegT_tglpinjampeg').val();
    
    n = tgl_pinjam.split("/");
    tgl = n[0];
    bln = n[1];
    thn = n[2];

    $('#tabledetailpinjaman').find('tbody').empty();
    
    if(tgl_pinjam=='')
    {
        myAlert('Silahkan isi Tanggal Peminjaman terlebih dahulu');
    }
    else if(jumlah_pinjam==''){
        myAlert('Silahkan isi Jumlah Pinjaman terlebih dahulu');
    }
    else if(lama_pinjam=='' || lama_pinjam==0)
    {
        myAlert('Silahkan isi Lama Pinjaman terlebih dahulu dan tidak boleh bernilai nol');
    }
    else if(bunga_pinjam=='')
    {
        myAlert('Silahkan isi Bunga Pinjam terlebih dahulu');
    }
    else
    {
        detailpinjaman = $("#tabledetailpinjaman tbody").find(".pinjamDetail[value="+jumlah_pinjam+"]");

        jumlah =  detailpinjaman.length;
        i = 1;
		
		jumlah_pinjam = unformatNumber(jumlah_pinjam.replace(/(\d+),(?=\d{3}(\D|$))/g, "$1"));
		
        bunga = parseFloat(unformatNumber(bunga_pinjam))/100 * parseFloat(jumlah_pinjam);
        total_pinjam = parseFloat(jumlah_pinjam) + parseFloat(bunga);
        cicilan = parseFloat(total_pinjam) / parseInt(lama_pinjam); 
        total_cicilan = 0;
		
        for(i;i<=lama_pinjam;i++){
            lastRow = $('#tabledetailpinjaman' + " tr:last");
            bln = parseInt(bln) + 1;

            if(bln>12 && bln<=24){
                bln = bln%12;
                if(bln==0){
                    bln = 12;
                }
                thn = parseInt(thn) + 1;
            }
            tgl_cicilan = cek_tanggal(tgl,bln,thn);

            tgl_jatuh_tempo     = tgl_cicilan + ' - ' + bln + ' - ' + thn;

            bln_db = bln - 1;
            tgl_jatuh_tempo_db  = new Date(thn,bln_db,tgl_cicilan);
            tgl_jatuh_tempo_view = tgl_cicilan + ' - ' + bulanangka(bln) + ' - ' + thn;
            tgl_jatuh_tempo_db2 = tgl_cicilan + '-' + bln + '-' + thn;
			
            cicilana = cicilan.toFixed(-2);
            total_cicilan = parseFloat(total_cicilan) + parseFloat(cicilana);
            sisa_bayar = parseFloat(total_pinjam) - parseFloat(total_cicilan);
            if(total_cicilan > total_pinjam){
                lebih_bayar = parseFloat(total_cicilan) - parseFloat(total_pinjam);
                cicilana  = parseFloat(cicilan.toFixed(-2)) - parseFloat(lebih_bayar);
            }else if(sisa_bayar < cicilana){
                if(sisa_bayar < 1000){
                    cicilana = (parseFloat(cicilan) + parseFloat(sisa_bayar)).toFixed(-2);
                }
            }
			
            newRow = '<tr><td><input type="text" name="no['+ i +']" value="'+ i +'" class="span1" disabled></td><td><input type="text" name="angs_visible['+ i +']" value="'+ i +'" class="span1" disabled><input type="hidden" name="angsuranke['+ i +']" value="'+ i +'"></td><td>'+ tgl_jatuh_tempo_view +'<input type="hidden" name="tglakanbayar['+ i +']" value="'+ tgl_jatuh_tempo_db2 +'"></td><td><input type="text" name="cicilan['+ i +']" value="'+ formatNumber(cicilana) +'" class="span2" disabled ><input type="hidden" name="jmlcicilan['+ i +']" value="'+ cicilana +'"></td></tr>';
            
            $('#tabledetailpinjaman tbody').append(newRow);

        }
        
    }   
}

function cek_tanggal(tgl,bln,thn){
    if(bln==4 || bln==9 || bln==6 || bln==11){
        if(tgl==31){
            tgl_skrg = 30;
        }else{
            tgl_skrg = tgl;
        }
        return tgl_skrg;
    }else if(bln==2){
        if(tgl>28){
            if(thn%4==0){
                tgl_skrg = 29;
            }else{
                tgl_skrg = 28;
            }
        }else{
            tgl_skrg = tgl;
        }
        return tgl_skrg;
    }else{
        return tgl;
    }
}

function hitungSemua()
{
     noUrut = 1;
     $('.noUrut').each(function() {
          $(this).val(noUrut);
          noUrut++;
     });

}

noUrut = 1;
     $('.noUrut').each(function() {
          $(this).val(noUrut);
          noUrut = noUrut + 1;
     });

function numberOnly(obj)
{
    var d = $(obj).attr('numeric');
    var value = $(obj).val();
    var orignalValue = value;
    value = value.replace(/[0-9]*/g, "");
    var msg = "Only Integer Values allowed.";

    if (d == 'decimal') {
    value = value.replace(/\./, "");
    msg = "Only Numeric Values allowed.";
    }

    if (value != '') {
    orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
    $(obj).val(orignalValue);
    }
}

function remove (obj) {
    $(obj).parents('tr').remove();
    hitungSemua();
}
   
function cekValidasi(event)
{   
  banyaknyaObat = $('.obatAlkes').length;
  hargaNettoPenawaran =  $('#PenawarandetailT_harganetto').val(); 
  if ($('.isRequired').val()==''){
    alert ('Harap Isi Semua Data Yang Bertanda *');
    return false;
  }else if(banyaknyaObat<1){
     myAlert('Anda belum memilih Obat Yang Akan Diminta');   
     return false;
  }else if(hargaNettoPenawaran==0){
     myAlert('Anda Belum memilih Obat Yang Akan Diminta');   
     return false;
  }else{
     $('#btn_simpan').click();
     return true;
  }
}

function angkabulan(bln){
    switch (bln) {
        case 'Jan':
            return '1';
            break;
        case 'Feb':
            return '2';
            break;
        case 'Mar':
            return '3';
            break;
        case 'Apr':
            return '4';
            break;
        case 'Mei':
            return '5';
            break;
        case 'Jun':
            return '6';
            break;
        case 'Jul':
            return '7';
            break;    
        case 'Agus':
            return '8';
            break;    
        case 'Sep':
            return '9';
            break;
        case 'Okt':
            return '10';
            break;
        case 'Nop':
            return '11';
            break;
        case 'Des':
            return '12';
            break;
        default:
            return '01';
            break;
    }
}

function bulanangka(bln){
    switch (bln) {
        case 1:
            return 'Januari';
            break;
        case 2:
            return 'Februari';
            break;
        case 3:
            return 'Maret';
            break;
        case 4:
            return 'April';
            break;
        case 5:
            return 'Mei';
            break;
        case 6:
            return 'Juni';
            break;
        case 7:
            return 'Juli';
            break;    
        case 8:
            return 'Agustus';
            break;    
        case 9:
            return 'September';
            break;
        case 10:
            return 'Oktober';
            break;
        case 11:
            return 'November';
            break;
        case 12:
            return 'Desember';
            break;
        default:
            return 'Desember';
            break;
    }
}
</script>

