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
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
        'focus' => '#',
            ));
    ?>
    
    <?php echo $this->renderPartial('_tabMenu', array(), true); ?>
    <div class='biru'>
        <div class="white">
    <?php echo $this->renderPartial('_formPersalinan', array('model' => $model, 'form'=>$form), true); ?>
    <?php echo $this->renderPartial('_obsterikus', array('model'=>$model,'modPemeriksaan' => $modPemeriksaan, 'form'=>$form), true); ?>
        </div>
    </div>
    
    <div class="form-actions"> 
        <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id.'/daftarPasien/index'), array('class' => 'btn btn-danger',
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
            $("#panel-obs").hide();
            $("#panel-persalinan").show();
        } else if (v == 2) {
            $("#panel-obs").show();
            $("#panel-persalinan").hide();
        }
    }
    
    $(document).ready(function()
    {
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
            setTekanan($("#PemeriksaanfisikT_kala4_systolic"));
        }, 500);
    });
    function setTekanan(obj)
    {
        var sis = parseFloat($(".systolic").val());
        var dia = parseFloat($(".diastolic").val());
        var art = 0;

        if (isNaN(sis)) sis = 0;
        if (isNaN(dia)) dia = 0;
        
        art = ((sis+(2*dia))/3);
        
        $.post('<?php echo Yii::app()->createUrl('persalinan/pemeriksaanFisikTPS/GetTextTekananDarah'); ?>', {diastolic:dia, systolic:sis}, function(data){
            if (data.text == null){
                $('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
            } else {
                $('#tekananDarah').val(data.text);
            }
        },'json');
        $('#PemeriksaanfisikT_kala4_meanarteripressure').val(Math.floor(art));
        

        $(".td").val(sis + " / " + dia);

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
    
</script>