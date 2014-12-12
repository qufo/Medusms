<?php namespace Qufo\Medusms\Facades;

use Illuminate\Support\Facades\Facade;

class Medusms extends Facade {
    
    protected static function getFacadeAccessor(){
        return 'medusms';
    }
}
  
?>
