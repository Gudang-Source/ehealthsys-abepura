
<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.GolonganGajiMController');
class GolonganGajiMKPController extends GolonganGajiMController
{
    public $hasTab=true;
    public $path_view_tab = "kepegawaian.views.golonganGajiM.";
}
