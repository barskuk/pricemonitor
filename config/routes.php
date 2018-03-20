<?php

return array(
    'cabinet/campaign/add' => 'campaign/add',
    'cabinet/campaign/([0-9]+)/products/add' => 'product/add/$1',
    'cabinet/campaign/([0-9]+)/products/all' => 'product/all/$1',
    'cabinet/campaign/([0-9]+)/products/all/([0-9]+)' => 'product/all/$1/$2',
    'cabinet/campaign/([0-9]+)/category/all' => 'category/all/$1',
    'cabinet/campaign/([0-9]+)/brands/all' => 'brand/all/$1',
    'cabinet/campaign/([0-9]+)/products/import' => 'feed/index/$1',



    'cabinet/campaign/([0-9]+)/dashboard' => 'cabinet/dashboard/$1',


    'cabinet/campaign/([0-9]+)/competitors/all' => 'cabinet/dashboard/$1',


    'cabinet/campaign/([0-9]+)/settings' => 'cabinet/dashboard/$1',


    'cabinet' => 'cabinet/index',
    'register' => 'customer/register',
    'login' => 'customer/login',
    'logout' => 'customer/logout',

    'admin' => 'admin/index',
    '' => 'site/index',

);