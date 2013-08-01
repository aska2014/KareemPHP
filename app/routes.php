<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

EasyRoute::controller('HomeController', array(

    'home' => array('home.html', 'index')

));


EasyRoute::controller('PostsController', array(

    'post' => array('post/{slug}-{id}.html', 'show')

));