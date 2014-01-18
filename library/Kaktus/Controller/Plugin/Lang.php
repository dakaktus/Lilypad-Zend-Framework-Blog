<?php

class Kaktus_Controller_Plugin_Lang extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request){
        $locale = new Zend_Locale();
        Zend_Registry::set('Zend_Locale',$locale);
    }

}