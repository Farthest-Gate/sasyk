<?php

namespace App\Library;

use Auth;



class Icon {
    
    public static function get_icons(){
        $content = file_get_contents(public_path() . '/js/library/fontawesome.json');
        $json = json_decode($content);
        $icons = [];

        foreach ($json as $icon => $value) {
//            $icons[] = $value->unicode;
            foreach ($value->styles as $style) {
                $icons[] = 'fa'.substr($style, 0 ,1).' fa-'.$icon;
            }
        }

        return $icons;
    }
    
}