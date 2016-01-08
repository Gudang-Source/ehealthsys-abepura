<?php
Yii::import('antrian.controllers.AmbilKarcisFarmasiController');
Yii::import('antrian.models.ANAntrianfarmasiT');
class AmbilKarcisFarmasiApotekController extends AmbilKarcisFarmasiController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'antrian.views.ambilKarcisFarmasi.';
}
