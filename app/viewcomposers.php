<?php

/*
|--------------------------------------------------------------------------
| View Composers
|--------------------------------------------------------------------------
|
| Defining View Composers
*/

View::composer('*', function($view)
{
    // 全局 view 渲染数据绑定
    //$view->with('test', 123);
});