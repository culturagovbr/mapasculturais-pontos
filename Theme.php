<?php
namespace PontosDeMemoria;

use BaseMinc;
use MapasCulturais\App;
use MapasCulturais\Definitions;

class Theme extends BaseMinc\Theme{


    static function getThemeFolder() {
        return __DIR__;
    }

    // function _init() {

    //     parent::_init();
    //     $app = App::i();


    // }

    protected function _getSpaceMetadata() {
        return [];
    }

}
