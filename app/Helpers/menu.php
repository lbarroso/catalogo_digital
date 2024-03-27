<?php

use App\Models\Category;

if(!function_exists('asset_admin')){
    function asset_admin($url){
        return asset("assets/admin/$url");
    }
}

if(!function_exists('active_menu')){
    function active_menu($url){
        return request()->url() == $url ? 'active' : '';
    }
}

if(!function_exists('fullname')){
    function fullname(){
        return auth()->user()->profile->name." ".auth()->user()->profile->first_lastname." ".auth()->user()->profile->second_lastname;
    }
}

if(!function_exists('menu_open')){
    function menu_open($url,$type){
        if($type == 1){
            return request()->is($url) ? 'menu-open' : '';
        }
        return request()->is($url) ? 'active' : '';

    }
}

if(!function_exists('asset_app')){
    function asset_app($url){
        return asset("assets/app/$url");
    }
}


if(!function_exists('categories')){
    function categories(){
        return Category::has('products')->get();
    }
}


if(!function_exists('getImageProfile')){
    function getImageProfile(){
        if(auth()->user()->profile->path){
            return auth()->user()->profile->url;
        }
        return asset_admin('dist/img/user2-160x160.jpg');
    }
}


