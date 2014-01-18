<?php

class Kaktus_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request){

        $aclConfig = new Zend_Config_Ini(APPLICATION_PATH.'/configs/acl/acl.ini',APPLICATION_ENV);


        $acl = new Zend_Acl();

        foreach ($aclConfig->resources as $resource){
            $acl->addResource($resource->name,$resource->parent);
        }

        foreach ($aclConfig->roles as $role){
            $acl->addRole($role->name,$role->parent);
        }

        foreach($aclConfig->rules as $type=>$roleArr){
            foreach ($roleArr as $role=>$resourceArr){
                foreach ($resourceArr as $resource => $assertArr){
                    foreach ($assertArr as $assert){
                        $acl->$type($role,$resource,$assert);
                    }
                }
            }
        }

        Zend_Registry::set('Zend_Acl',$acl);
    }

}