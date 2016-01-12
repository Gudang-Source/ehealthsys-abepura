<?php
Yii::import('laboratorium.controllers.PemakaianBahanController');
Yii::import('laboratorium.models.LBObatalkespasienT');
Yii::import('laboratorium.models.LBObatalkesM');
Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
Yii::import('laboratorium.models.LBPasienmasukpenunjangT');
Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
class PemakaianBahanRadiologiController extends PemakaianBahanController
{
    public $path_view = "laboratorium.views.pemakaianBahan.";
    public $path_view_bmhp = "laboratorium.views.pemakaianBmhp.";
    
}