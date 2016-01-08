<?php

class SAKomponentarifM extends KomponentarifM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getItemsList() {
        $criteria = new CDbCriteria();
        $criteria->addCondition("komponentarif_aktif = TRUE");
        $criteria->order = "komponentarif_nama";

        return self::model()->findAll($criteria);
    }

}

?>
