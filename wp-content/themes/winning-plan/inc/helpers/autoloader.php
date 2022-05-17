<?php
function autoloader($class) {
//    var_dump_pre( THEME_DIR. '/inc/classes/' . $class . '.class.php');
     include THEME_DIR .'/inc/classes/' . $class . '.class.php';
}

spl_autoload_register('autoloader');

