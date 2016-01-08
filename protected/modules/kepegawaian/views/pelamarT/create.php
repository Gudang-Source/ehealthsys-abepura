<?php
$sukses = null;
if(isset($_GET['id'])){
$sukses = $_GET['id'];
}
if($sukses > 0)
	Yii::app()->user->setFlash('success',"Data Pencatatan Pelamar berhasil disimpan !");

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fileupload/fileupload.js'); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pelamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'noidentitas'),
)); ?>

<div class="white-container">
    <legend class="rim2">Pencatatan <b>Pelamar</b></legend>
    <?php echo $form->errorSummary(array($model, $modBahasa, $modLingkunganKerja)); ?>
    <fieldset class='box row-fluid'>
        <legend class="rim">Data Pelamar</legend>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $this->renderPartial('_formPelamar', array('model'=>$model, 'form'=>$form)); ?> 
    </fieldset>
    <!--================================================================================== INPUT KEMAMPUAN SKILL PELAMAR ===============================-->
    <div class="block-tabel">
        <h6>Data Kemampuan <b>Kemampuan / Skill Pelamar</b></h6>
        <table class="items table table-striped table-condensed" id="tblInputSkill">
            <thead>
                <th>No</th>
                <th>Kemampuan / Skill</th>
                <th>Tingkat / Level</th>
                <th>&nbsp;</th>
            </thead>
            <?php
                echo $this->renderPartial('_addSkill',array('modKemampuanPelamars'=>$modKemampuanPelamars,'modKemampuanPelamar'=>$modKemampuanPelamar,'form'=>$form,'btnHapus'=>false),true); 
            ?>

        </table>
    </div>

    <!--================================================================================== AKHIR KEMAMPUAN SKILL BAHASA===============================-->
    <!--================================================================================== INPUT KEMAMPUAN BAHASA PELAMAR ===============================-->
    <div class="block-tabel">
        <h6>Data Kemampuan <b>Bahasa Pelamar</b></h6>
        <table class="items table table-striped table-condensed" id="tblInputBahasa">
            <thead>
                <th>No</th>
                <th>Bahasa</th>
                <th>Mengerti</th>
                <th>Berbicara</th>
                <th>Menulis</th>
                <th>&nbsp;</th>
            </thead>
            <?php
                echo $this->renderPartial('_addBahasa',array('modBahasa'=>$modBahasa,'modBahasas'=>$modBahasas,'form'=>$form,'btnHapus'=>false),true); 
            ?>

        </table>
    </div>

    <!--================================================================================== AKHIR INPUT KEMAMPUAN BAHASA===============================-->

    <!--================================================================================== INPUT LINGKUNGAN KERJA PELAMAR ===============================-->
    <div class="block-tabel">
        <h6>Data Lingkungan <b>Kerja Pelamar</b></h6>
        <table class="items table table-striped table-condensed" id="tblInputLingkunganKerja">
            <thead>
                <th>No</th>
                <th>Dengan Lingkungan</th>
                <th>Keterangan</th>
                <th>&nbsp;</th>
            </thead>
            <?php
                echo $this->renderPartial('_addLingkunganKerja',array('modLingkunganKerja'=>$modLingkunganKerja,'modLingkunganKerjas'=>$modLingkunganKerjas,'form'=>$form, 'btnHapus'=>false),true); 
            ?>

        </table>
    </div>
    <!--================================================================================== AKHIR INPUT LINGKUNGAN KERJA===============================-->
    <div class="form-actions">
        <?php 
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasiPelamar();', 'onkeypress'=>'validasiPelamar();','disabled'=>$disableSave)); //formSubmit(this,event)        
                    //  jika tanpa validasiPelamar 
                    /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                     * 
                     */
             ?>
        <?php if(!isset($_GET['frame'])){
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                    $this->createUrl($this->id.'/create'), 
                                                    array('class'=>'btn btn-danger',
                                                              'onclick'=>'return refreshForm(this);'));
        } ?>
        <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        ?>
        <?php
            $content = $this->renderPartial('tips/tipsPelamar',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
//========================================================== ADD ROW KEMAMPUAN
function addRowSkill(obj)
{
    if(validasiDetailSkill()){
        var trAddSkill=new String(<?php echo CJSON::encode($this->renderPartial('_addSkill',array('modKemampuanPelamar'=>$modKemampuanPelamar,'form'=>$form,'btnHapus'=>true),true));?>);
        $(obj).parents('table').children('tbody').append(trAddSkill.replace());
        renameInput($("#tblInputSkill"));
    }
}

function batalSkill(obj)
{
	myConfirm("Apakah anda akan membatalkan obat ini?",
	"Perhatian!",
	function(r){
		if(r){
			$(obj).parents('tr').detach();
			renameInput($("#tblInputSkill"));
		}
	}); 
}
function renameInput(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
}

function addRowBahasa(obj)
{
    if(validasiDetailBahasa()){
        var trAddBahasa=new String(<?php echo CJSON::encode($this->renderPartial('_addBahasa',array('modBahasa'=>$modBahasa,'modBahasas'=>$modBahasas,'form'=>$form,'btnHapus'=>true),true));?>);
        $(obj).parents('table').children('tbody').append(trAddBahasa.replace());
        <?php 
            $attributes = $modBahasa->attributeNames(); 
            foreach($attributes as $i=>$attribute){
                echo "renameInputBahasa('KPKemampuanBahasaR','$attribute');";
            }
        ?>
        renameInputBahasa('KPKemampuanBahasaR','no_urut');
        renameInputBahasa('KPKemampuanBahasaR','bahasa');
        renameInputBahasa('KPKemampuanBahasaR','mengerti_l');
        renameInputBahasa('KPKemampuanBahasaR','berbicara_l');
        renameInputBahasa('KPKemampuanBahasaR','menulis_l');
    }
}

function batalBahasa(obj)
{
    if(confirm('Apakah anda yakin akan membatalkan data ini?')){
        $(obj).parents('tr').next('tr').detach();
        $(obj).parents('tr').detach();
        
    }
}
function renameInputBahasa(modelName,attributeName)
{
    var trLength = $('#tblInputBahasa tr').length;
    var i = -1;
    $('#tblInputBahasa tr').each(function(){
        if($(this).has('input[name$="[bahasa]"]').length){
            i++;
            $("#KPKemampuanBahasaR_"+i+"_no_urut").val((i+1));
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        
       
    });
}
//INI UNTUK LINGKUNGAN KERJA
function addRowLingkunganKerja(obj)
{
    if(validasiDetailLingker()){
        var trAddLingkunganKerja=new String(<?php echo CJSON::encode($this->renderPartial('_addLingkunganKerja',array('modLingkunganKerja'=>$modLingkunganKerja,'modLingkunganKerjas'=>$modLingkunganKerjas ,'form'=>$form,'btnHapus'=>true),true));?>);
        $(obj).parents('table').children('tbody').append(trAddLingkunganKerja.replace());
        <?php 
            $attributes = $modLingkunganKerja->attributeNames(); 
            foreach($attributes as $i=>$attribute){
                echo "renameInputLingkunganKerja('LingkungankerjaR','$attribute');";
            }
        ?>
        renameInputLingkunganKerja('LingkungankerjaR','dgnlingkungan_l');
        renameInputLingkunganKerja('LingkungankerjaR','keterangan');
        renameInputLingkunganKerja('LingkungankerjaR','nourut');
    }
}

function batalLingkunganKerja(obj)
{
    if(confirm('Apakah anda yakin akan membatalkan data ini?')){
        $(obj).parents('tr').next('tr').detach();
        $(obj).parents('tr').detach();
        
    }
}
function renameInputLingkunganKerja(modelName,attributeName)
{
    var trLength = $('#tblInputLingkunganKerja tr').length;
    var i = -1;
    $('#tblInputLingkunganKerja tr').each(function(){
        if($(this).has('select[name$="[dgnlingkungan_l]"]').length){
            i++;
            $("#LingkungankerjaR_"+i+"_nourut").val((i+1));
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(130)
                .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function validasiPelamar(){
    if(requiredCheck($("form"))){
        if(validasiDetail()){
            $('#pelamar-t-form').submit();
        }else{
            return false;
        }
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
        
}
function validasiDetail(){
    if(validasiDetailBahasa() && validasiDetailLingker())
        return true;
    else
        return false
}
function validasiDetailBahasa(){
    var detailReq = document.getElementsByClassName("isDetailReq");
    var jml = detailReq.length;
    var adaKosong = false;
    for(i=0;i<jml;i++){
        if(detailReq[i].value == ""){
            myAlert('Silahkan lengkapi semua Data Kemampuan Bahasa !');
            adaKosong = true;
            break;
        }
    }
    if(adaKosong)
        return false;
    else
        return true;
}
function validasiDetailSkill(){
    var detailReq = document.getElementsByClassName("isDetailReq3");
    var jml = detailReq.length;
    var adaKosong = false;
    for(i=0;i<jml;i++){
        if(detailReq[i].value == ""){
            myAlert('Silahkan lengkapi semua Data Kemampuan Skill !');
            adaKosong = true;
            break;
        }
    }
    if(adaKosong)
        return false;
    else
        return true;
}
function validasiDetailLingker(){
    var detailReq = document.getElementsByClassName("isDetailReq2");
    var jml = detailReq.length;
    var adaKosong = false;
    for(i=0;i<jml;i++){
        if(detailReq[i].value == ""){
            myAlert('Silahkan Isi Field \'Dengan Lingkungan\' ! ');
            adaKosong = true;
            break;
        }
    }
    if(adaKosong)
        return false;
    else
        return true;
}

function konfirmasi()
{
    location.reload();
}

function print(caraPrint)
{
    var pelamar_id = '<?php echo isset($model->pelamar_id) ? $model->pelamar_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pelamar_id='+pelamar_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}


$(document).ready(function(){
	renameInput($("#tblInputSkill"));
});
</script>