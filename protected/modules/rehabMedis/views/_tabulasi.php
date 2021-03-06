<?php 
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';
$urlRoute = Yii::app()->createUrl($this->route,array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
//$urlIni = Yii::app()->createUrl($controlModule.$this->action->id);
//if (strtolower($urlRoute) == strtolower($urlIni)){
//    echo 'GGGGG';
//}
$urlAnamnesa = $this->createUrl($module.'anamnesaTRM/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlFisik = $this->createUrl($module.'PemeriksaanFisikTRM/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlLab =$this->createUrl($module.'laboratoriumTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlRad = $this->createUrl($module.'radiologiTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlRehab =  $this->createUrl($module.'rehabMedisTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlGizi = $this->createUrl($module.'konsulGiziTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlPoli = $this->createUrl($module.'konsulPoliTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlTindakan = $this->createUrl($module.'tindakanTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlDiagnosa =$this->createUrl($module.'diagnosaTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlBedah = $this->createUrl($module.'bedahSentralTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlRujukan =  $this->createUrl($module.'rujukanKeluarTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlResep = $this->createUrl($module.'resepturTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlBahan = $this->createUrl($module.'pemakaianBahanTRM/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Anamnesis', 'url' =>$urlAnamnesa, 'active' =>((strtolower($urlRoute) == strtolower($urlAnamnesa)) ? true : false)),
        array('label' => 'Periksa Fisik', 'url' =>$urlFisik, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' =>((strtolower($urlRoute) == strtolower($urlFisik)) ? true : false)),
        array('label' => 'Laboratorium', 'url' => $urlLab, 'active' => (strtolower($urlRoute) == strtolower($urlLab)) ? true : false),
        array('label' => 'Radiologi', 'url' => $urlRad, 'active' => (strtolower($urlRoute) == strtolower($urlRad)) ? true : false),
        array('label' => 'Rehab Medis', 'url' =>$urlRehab, 'active' => (strtolower($urlRoute) == strtolower($urlRehab)) ? true : false),
        array('label' => 'Konsultasi Gizi', 'url' => $urlGizi, 'active' => (strtolower($urlRoute) == strtolower($urlGizi)) ? true : false),
        array('label' => 'Konsul Poliklinik', 'url' => $urlPoli, 'active' => (strtolower($urlRoute) == strtolower($urlPoli)) ? true : false),
        array('label' => 'Tindakan', 'url' => $urlTindakan, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlTindakan)) ? true : false),
        array('label' => 'Diagnosis', 'url' => $urlDiagnosa, 'active' => (strtolower($urlRoute) == strtolower($urlDiagnosa)) ? true : false),
        array('label' => 'Bedah Sentral', 'url' =>$urlBedah, 'active' => (strtolower($urlRoute) == strtolower($urlBedah)) ? true : false),
        array('label' => 'Rujukan Ke Luar', 'url' =>$urlRujukan, 'active' => (strtolower($urlRoute) == strtolower($urlRujukan)) ? true : false),
        array('label' => 'Reseptur', 'url' => $urlResep, 'active' => (strtolower($urlRoute) == strtolower($urlResep)) ? true : false),
        array('label' => 'Pemakaian Bahan', 'url' => $urlBahan, 'active' => (strtolower($urlRoute) == strtolower($urlBahan)) ? true : false),
    ),
));