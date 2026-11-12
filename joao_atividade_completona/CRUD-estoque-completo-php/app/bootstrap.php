<?php
declare(strict_types=1);
spl_autoload_register(function(string $class):void {
    $prefix='App\\';
    if(!str_starts_with($class,$prefix))return;
    $relative=substr($class,strlen($prefix));
    $file=__DIR__.'/'.str_replace('\\','/',$relative).'.php';
    if(is_file($file))require_once $file;
});
if(session_status()!==PHP_SESSION_ACTIVE){
    ini_set('session.use_strict_mode','1');
    session_set_cookie_params([
        'httponly'=>true,'secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off',
        'samesite'=>'Lax','path'=>'/'
    ]);
    session_start();
}
function e(?string $v):string{return htmlspecialchars((string)$v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function url(string $route,array $args=[]):string{return 'index.php?'.http_build_query(array_merge(['r'=>$route],$args));}
function go(string $route,array $args=[]):never{header('Location: '.url($route,$args));exit;}
function flash(string $type,string $message):void{$_SESSION['flash']=['type'=>$type,'message'=>$message];}
function takeFlash():?array{$f=$_SESSION['flash']??null;unset($_SESSION['flash']);return $f;}
function positiveId(mixed $v):?int{$n=filter_var($v,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);return $n===false?null:$n;}
function money(string $v):?string{
    $v=trim(str_replace(',','.',$v));
    if(!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/',$v))return null;
    return number_format((float)$v,2,'.','');
   }
   