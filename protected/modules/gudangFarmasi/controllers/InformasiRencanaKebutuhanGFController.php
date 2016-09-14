<?php
Yii::import("pengadaan.controllers.InformasiRencanaKebutuhanController");
Yii::import("pengadaan.models.*");
class InformasiRencanaKebutuhanGFController extends InformasiRencanaKebutuhanController {
    public $path_permintaan = 'PermintaanPembelianGF';
    public $path_penawaran = 'PermintaanPenawaranGF';
    public $path_rencana = 'RencanaKebutuhanGF';
}
