<?php
/**
 * agar bisa menampilkan barcode tanpa perlu mendaftarkan user role di SRBAC
 */
class BarcodeController extends Controller
{
    public function actions()
    {
            return array(
                    'myBarcode'=>array(
                        'class'=>'MyBarcodeAction',
                        'canvasWidth'=>'230',
                        'type'=>'code128',
                    ),
            );
    }
}
?>