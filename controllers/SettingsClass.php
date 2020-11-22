<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingsClass
 *
 * @author dmitry
 */
include 'models/Db.php';
class SettingsClass extends Db{
    public function getSettings(){
        $result = $this->setQuery("SELECT NAME, ADRES, INN, TELEPHONE, CEK_TEXT, DOSTAVKA_SUMM FROM setting_pr");
        return $result;
    }
}
