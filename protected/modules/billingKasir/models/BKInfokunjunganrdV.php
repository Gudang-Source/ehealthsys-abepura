<?php

class BKInfokunjunganrdV extends InfokunjunganrdV
{
        public $tglselesaiperiksa;
        public $tglpembayaran;
        public $nopembayaran;
        public $pembayaran_id;
		public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
}