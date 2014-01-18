<?php

class Kaktus_Controller_Plugin_Translator extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request){
        $locale = Zend_Registry::get('Zend_Locale');

        $translations = include_once(APPLICATION_PATH.'/configs/translations/'.$locale.'.php');

        $translator = new Zend_Translate('array',$translations);

        Zend_Registry::set('Zend_Translate',$translator);
    }

}