<?php
    $this->breadcrumbs = array(
        $this->module->id,
    );
?>

<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'search-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#isPasienLama',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)'
            ),
        )
    );
?>
<style>
    #menu li
    {
        display: block;
        float:left;
        width:150px;
        height:83px;
        border:1px solid #559DCF;
        border-radius:3px;
        text-align: center;
        text-decoration:none;
        margin:5px;
    }
    
    #menu a
    {
        padding:1px;
        text-decoration:none;
        color:#6D6D6D;
    }
    
    #menu img
    {
        border:none;
        margin-left:auto;
        margin-right:auto;
        margin-top:0;
        display:block;
    }
    
    .rl_satu
    {
        background-color:lightyellow;
    }
    
    .rl_dua
    {
        background-color:#d9edf7;
    }
    
    .rl_tiga
    {
        background-color:#e1f1c0;
    }
    
    .rl_empat
    {
        background-color:#eed3d7;
    }
    
    .rl_lima
    {
        background-color:lavender;
    }
    
    .clear
    {
        clear:both;
    }
    
    .selected
    {
        background: #58BD49;
        color: #ffffff !important;
        border: 1px solid #42A534 !important;
        font-weight: bold;
        box-shadow: 0 0 4px #7A5959;
    }
    #satu, #dua, #tiga, #empat, #lima {margin-bottom:15px}
</style>
<div class="white-container">
    <div style="display:table;">
        <legend class="rim2">Laporan <b>RL</b></legend>
        <table border="1">
            <tr>
                <td>
                    <div class="control-group ">
                        <label class="control-label" for="RJInfokunjunganrjV_tgl_pendaftaran">
                            Periode Laporan
                        </label>
                        <div class="controls">
                            <div style="float:left;">
                                <?php
                                    echo CHtml::dropDownList('periode','', 
                                        array('hari'=>'Hari Ini',
                                        'bulan'=>'Bulan',
                                        'tahun'=>'Tahun',), array('class'=>'span2', 'onChange'=>'autoPeriode(this)'));
                                ?>
                            </div>
                            <div style="float:left;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            <div style="float:left;">
                                <?php
                                    $date = date('d M Y') . ' 00:00:00';
                                    $this->widget('MyDateTimePicker',
                                        array(
                                            'name'=>'tgl_awal',
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'datetime',
                                            'value'=>$date,
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                        )
                                    ); 
                                ?>
                            </div>
                            <div style="float:left;">&nbsp;&nbsp;Sampai Dengan&nbsp;&nbsp;</div>
                            <div style="float:left;">
                                <?php
                                    $date = date('d M Y') . ' 23:59:59';
                                    $this->widget('MyDateTimePicker',
                                        array(
                                            'name'=>'tgl_akhir',
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'datetime',
                                            'value'=>$date,
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                        )
                                    ); 
                                ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <!--
            <?php
                echo CHtml::htmlButton(
                    Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit')
                );
            ?>
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                    Yii::app()->createUrl($this->module->id.'/'.$this->id), 
                    array(
                        'class'=>'btn btn-danger',
                        'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;'
                    )
                );
            ?>
            -->
        </div>
        <?php
            $this->endWidget();
        ?>
        <div id="menu_laporan">
            <div class="dashboard" id="satu">
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/dataDasarRS'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL1.1.png'?>"></img>
                    <span>Data Dasar Rumah Sakit</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanPelayananRS'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL1.2.png'?>"></img>
                    <span>Indikator Pelayanan Rumah Sakit</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/tempatTidurRI'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL1.3.png'?>"></img>
                    <span>Fasilitas Tempat Tidur Rawat Inap</span>
                </a>
            </div>

            <div class="dashboard" id="dua">
                 <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/ketenagaan'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL2.png'?>"></img>
                    <span>Ketenagaan</span>
                </a>
            </div>
            <div class="dashboard" id="tiga">
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanPelayananRawatInap'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.1.png'?>"></img>
                    <span>Rawat Inap</span>
                </a>

                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/kunjunganRD'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.2.png'?>"></img>
                    <span>Rawat Darurat</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/gigiMulut'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.3.png'?>"></img>
                    <span>Gigi Dan Mulut</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanKebidanan'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.4.png'?>"></img>
                    <span>Kebidanan</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanPerinatologi'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.5.png'?>"></img>
                    <span>Perinatologi</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/kegiatanPembedahan'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.6.png'?>"></img>
                    <span>Pembedahan</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/kegiatanRadiologi'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.7.png'?>"></img>
                    <span>Radiologi</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/PemeriksaanLaboratorium'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.8.png'?>"></img>
                    <span>Laboratorium</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/PelayananRehabMedik'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.9.png'?>"></img>
                    <span>Rehabilitasi Medik</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanPelayananKhusus'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.10.png'?>"></img>
                    <span>Pelayanan Khusus</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanKesehatanJiwa'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.11.png'?>"></img>
                    <span>Kesejahteraan Jiwa</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanKeluargaBerencana'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.12.png'?>"></img>
                    <span>Keluarga Berencana</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/PengadaanObatResep'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.13.png'?>"></img>
                    <span>Farmasi Rumah Sakit</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/KegiatanRujukan'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.14.png'?>"></img>
                    <span>Rujukan</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/CaraBayar'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL3.15.png'?>"></img>
                    <span>Cara Bayar</span>
                </a>
            </div>

            <div class="dashboard" id="empat">
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/morbiditasRawatInap'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL4A.png'?>"></img>
                    <span>Data Keadaan Morbiditas Pasien Rawat Inap</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/morbiditasRawatJalan'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL4B.png'?>"></img>
                    <span>Data Keadaan Morbiditas Pasien Rawat Jalan</span>
                </a>
            </div>

            <div class="dashboard" id="lima">
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/pengunjungRUmahSakit'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL5.1.png'?>"></img>
                    <span>Pengunjung Rumah Sakit</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/kunjunganRawatJalan'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL5.2.png'?>"></img>
                    <span>Kunjungan Rawat Jalan</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/10besarPenyakitRawatInap'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL5.3.png'?>"></img>
                    <span>Daftar 10 Besar Rawat Inap</span>
                </a>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/10besarPenyakitRawatJalan'); ?>">
                    <img src="<?php echo Params::urliconmenu().'RL5.4.png'?>"></img>
                    <span>Daftar 10 Besar Rawat Jalan</span>
                </a>
            </div>
        </div>
        <div class="form-actions">
            <div style="float:left;">
                <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printLaporan(\'PRINT\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printLaporan(\'PDF\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printLaporan(\'EXCEL\')'))."&nbsp&nbsp";
           ?>
            </div>
            <div style="float:left;">
                <?php
                    $content = $this->renderPartial('tips',array(),true);
        //            $this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content)); 
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

function printLaporan(params)
{
    var obj_selected = $('#menu_laporan').find("a[class$='selected']");
    if(obj_selected.length > 0)
    {
        window.open($(obj_selected).attr('href')+"&"+$('#search-form').serialize()+"&caraPrint="+params,"",'location=_new, width=900px, scrollbars=yes');
    }else{
        myAlert('Pilih laporan terlebih dahulu !');
    }
    return false;
}

function autoPeriode(obj)
{
    $.ajax({
        dataType:"json",
        data: {periode:$(obj).val()},
        url:"<?php  echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'. Yii::app()->controller->id .'/getPeriodeLaporan'); ?>",
        success:function(data)
        {
            $('#tgl_awal').val(data.tgl_awal);
            $('#tgl_akhir').val(data.tgl_akhir);
        }
    });
}

function linkSelect(obj)
{
    $(obj).parents('#menu_laporan').find("a[class$='selected']").each(
        function()
        {
            $(this).removeClass('selected');
        }
    );
    $(obj).addClass('selected');
    return false;
}


function setAttributes()
{
    $('#menu_laporan').find("div[class$='dashboard']").each(
        function()
        {
            if($(this).attr('id') == 'satu')
            {
                $(this).find("a").each(
                    function()
                    {
                        $(this).attr('class', 'shortcut3 rl_satu');
                        $(this).attr('onClick', 'linkSelect(this);return false;');
                    }
                );
            }
            
            if($(this).attr('id') == 'dua')
            {
                $(this).find("a").each(
                    function()
                    {
                        $(this).attr('class', 'shortcut3 rl_dua');
                        $(this).attr('onClick', 'linkSelect(this);return false;');
                    }
                );
            }
            
            if($(this).attr('id') == 'tiga')
            {
                $(this).find("a").each(
                    function()
                    {
                        $(this).attr('class', 'shortcut3 rl_tiga');
                        $(this).attr('onClick', 'linkSelect(this);return false;');
                    }
                );
            }
            
            if($(this).attr('id') == 'empat')
            {
                $(this).find("a").each(
                    function()
                    {
                        $(this).attr('class', 'shortcut3 rl_empat');
                        $(this).attr('onClick', 'linkSelect(this);return false;');
                    }
                );
            }
            
            if($(this).attr('id') == 'lima')
            {
                $(this).find("a").each(
                    function()
                    {
                        $(this).attr('class', 'shortcut3 rl_lima');
                        $(this).attr('onClick', 'linkSelect(this);return false;');
                    }
                );
            }
            
        }
    );
}
setAttributes();

</script>