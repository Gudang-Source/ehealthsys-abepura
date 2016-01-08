<?php
/*
 * file setting database
 */

return array(
    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=db_server',
    'emulatePrepare' => false,
    'username' => 'postgres',
    'password' => 'postgres',
    'charset' => 'utf8',
    'autoConnect' => false,
    'class' => 'CDbConnection', //this may be the reason you get errors! always set this
)
?>
