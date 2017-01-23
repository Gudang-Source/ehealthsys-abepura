<style>
    .control-group{
        padding:5px;
    }
    td .control-group:hover{
        background-color: #B5C1D7;
    }
    .additional-text{
        display:inline-block;
        font-size: 11px;
    }
    
    .numbersOnly {
        text-align: right;
    }
</style>
<?php 
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Transaksi berhasil disimpan !");

?>
<div class='white-container'>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php // $this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,'format'=>$format)); ?>
    <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
    <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._jsFunctions',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
    
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pspersalinan-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return cekGinekologi(this);'),
        'focus' => '#',
            ));
    ?>
    
    <?php echo $this->renderPartial('_tabMenu', array(), true); ?>
    <div class='biru'>
        <div class="white">
            <?php echo Chtml::hiddenField('nomor', '0') ?>
    <?php echo $this->renderPartial('_formPersalinan', array('model' => $model, 'form'=>$form), true); ?>
    <?php //echo $this->renderPartial('_obsterikus', array('model'=>$model,'modPemeriksaan' => $modPemeriksaan, 'form'=>$form), true); ?>
    <?php echo $this->renderPartial('_obsterikusBaru', array('model'=>$model,'modPemeriksaan' => $modObsterikus, 'form'=>$form, 'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaLama' => $modPemeriksaan), true); ?>
    <?php echo $this->renderPartial('_ginekologi', array('form'=>$form, 'modRiwayatKehamilan'=>$modRiwayatKehamilan, 'modGinekologi'=>$modGinekologi, 'modRiwayatKB' => $modRiwayatKB), true); ?>
    <?php echo $this->renderPartial('_partograf', array('form'=>$form, 'modPartografObat'=>$modPartografObat, 'modPartograf'=>$modPartograf, 'model'=>$model,'modObsterikus' => $modObsterikus, ), true); ?>
        </div>
    </div>
    
    <div class="form-actions"> 
        <?php 
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id.'/daftarPasien/index'), array('class' => 'btn btn-danger',
                     'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'));
        ?>
        <?php
            $content = $this->renderPartial('../persalinanT/tips/transaksi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div> 
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function setKematian(){
        var keadaan_lahir = $('#PSPersalinanT_keadaanlahir').val();
        if (keadaan_lahir == 'Lahir Hidup'){            
            $('#PSPersalinanT_jmlkelahiranmati').attr('disabled','true');
            $('#PSPersalinanT_sebabkematian').attr('disabled','true');
            $('#PSPersalinanT_tglabortus').attr('disabled','true');
            $('#PSPersalinanT_tglabortus_date').hide();
            $('#PSPersalinanT_jmlabortus').attr('disabled','true');
        } else {
            $('#PSPersalinanT_jmlkelahiranmati').removeAttr('disabled');
            $('#PSPersalinanT_sebabkematian').removeAttr('disabled');
            $('#PSPersalinanT_tglabortus').removeAttr('disabled');
            $('#PSPersalinanT_tglabortus_date').show();
            $('#PSPersalinanT_jmlabortus').removeAttr('disabled');
        }
    }
    $(document).ready(function(){
        setKematian();
    });
    
    function setTab(obj, v)
    {
        $("#tabber li").removeClass("active");
        $(obj).addClass("active");
        if (v == 1) {
            $("#panel-partograf").hide();
            $("#panel-ginekologi").hide();
            $("#panel-obs").hide();
            $("#panel-persalinan").show();
        } else if (v == 2) {
            $("#panel-partograf").hide();
            $("#panel-ginekologi").hide();
            $("#panel-obs").show();
            $("#panel-persalinan").hide();
        } else if (v == 3) {
            $("#panel-partograf").hide();
            $("#panel-ginekologi").show();
            $("#panel-obs").hide();
            $("#panel-persalinan").hide();
        }else if (v == 4) {
            $("#panel-partograf").show();
            $("#panel-ginekologi").hide();
            $("#panel-obs").hide();
            $("#panel-persalinan").hide();
        }
    }
    
    $(document).ready(function()
    {
        var obs = $("#periksaOBS").find('tr').length;          
        for (var a = 0; a <= obs; a++){
            $("#obsP"+a+"").hide();          
            $("#obsP0").show();          
        }
        
        var partog = $("#periksaPartograf").find('tr').length;          
        for (var i =0;i<partog;i++){
            $("#parP"+i+"").hide();
            $("#parP0").show(); 
        }
        
        
        $('.numbersOnly').keyup(function() {
            var d = $(this).attr('numeric');
            var value = $(this).val();
            var orignalValue = value;
            value = value.replace(/[0-9.]*/g, "");
            var msg = "Only Integer Values allowed.";

            if (d == 'decimal') {
                value = value.replace(/\./, "");
                msg = "Only Numeric Values allowed.";
            }

            if (value != '') {
                orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
                $(this).val(orignalValue);
            }
        
        });
        
        setTimeout(function() {
            //setTekanan($("#PemeriksaanfisikT_kala4_systolic"));
        }, 500);
    });
    function setTekanan(obj, a, i)
    {
        var sis = parseFloat($(".systolic"+a+i).val());
        var dia = parseFloat($(".diastolic"+a+i).val());
        var art = 0;

        if (isNaN(sis)) sis = 0;
        if (isNaN(dia)) dia = 0;
        
        art = ((sis+(2*dia))/3);
        
        $.post('<?php echo Yii::app()->createUrl('persalinan/pemeriksaanFisikTPS/GetTextTekananDarah'); ?>', {diastolic:dia, systolic:sis}, function(data){
            if (data.text == null){
                $('#tekananDarah'+a+i).val('Tekanan Darah Tidak Ditemukan');
            } else {
                $('#tekananDarah'+a+i).val(data.text);
            }
        },'json');        
        $('#PSPemeriksaankala4T_'+a+'_'+i+'_kala4_meanarteripressure').val(Math.floor(art));        

        $(".td"+a+i).val(sis + " / " + dia);

    }
    
    /*
    function getText(){
        var dias = parseFloat($('#${diastolic}').val());
        var sys = parseFloat($('#${systolic}').val());
        var arteri = ((sys+(2*dias))/3);

        if (jQuery.isNumeric(dias)){
            if (jQuery.isNumeric(sys)){
                $.post('${getTextTekananDarah}', {diastolic:dias, systolic:sys}, function(data){
                    if (data.text == null){
                        $('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
                    } else {
                        $('#tekananDarah').val(data.text);
                    }
                },'json');
                $('#${arteriPressure}').val(arteri);
            }
        }
    }
    */
   
   function cekGinekologi(obj){
       var jeniskegiatan_persalinan = $('#PSPersalinanT_jeniskegiatanpersalinan').val();
       var paritaske = $('#PSPersalinanT_paritaske').val();
       var pemeriksa_ginekologi = $('#PSPemeriksaanginekologiT_pegawai_id').val();
       
       if ( (jeniskegiatan_persalinan != '') && (paritaske != '') )
       {
           obj.submit();           
            //return false;
       }else{           
           myConfirm("Apakah Anda yakin hanya mengisi Pemeriksaan Ginekologi ? ","Perhatian!",function(r) {
            if (r){
                if (pemeriksa_ginekologi != ''){
                    obj.submit();
                }else{
                    myAlert("Maaf, Pemeriksa Ginekologi Belum Diisi");
                    return false;
                }
            }else{
                if ( (jeniskegiatan_persalinan == '') || (paritaske == '') ){
                    myAlert("Maaf, Jenis Kegiatan Persalinan dan Paritas Wajib Diisi pada Tab Persalinan");
                    return false;
                }
            }
	   });
           return false;
       }
   }
    
</script>