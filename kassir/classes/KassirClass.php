<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KassirClass
 *
 * @author dmitry
 */
include '../models/Db.php';
class KassirClass extends Db{
    public function getKAT() {
        $result = $this->setQuery("SELECT kategorii.ID, kategorii.KAT FROM kategorii ORDER BY KAT");
        if ($result){
            return $result;
        }
    }
}
