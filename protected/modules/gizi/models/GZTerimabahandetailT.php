<?php
class GZTerimabahandetailT extends TerimabahandetailT {
    
    public $subNetto;
    public $tglterimabahan;
    public $tgl;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}