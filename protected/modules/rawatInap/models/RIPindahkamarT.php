<?php

class RIPindahkamarT  extends PindahkamarT
{
    public $langsungMasukKamar = true;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PindahkamarT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}