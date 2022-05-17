<?php

// Configuration common to all environments
include_once __DIR__ . '/wp-config.common.php';

/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'wordpress');

/** Имя пользователя базы данных */
define('DB_USER', 'root');

/** Пароль к базе данных */
define('DB_PASSWORD', 'root');

/** Имя сервера базы данных */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '>!hN2>TAzW@<E3i/Dbz,mqk20yi:%bdY]yt_EJ:3|=:0K#PwWXtdF-3Z),OJ>d?4');
define('SECURE_AUTH_KEY',  'I3lSJ[CXb?CQYu)u.o.UCCm`h2O^NA+*#85f!~c}< -r.sdF}NUu9}Ys`||=0>X;');
define('LOGGED_IN_KEY',    '+p`ULiuLY&bRFJ|?ay~GfY9ukrke5Xk8d+]i`}MX=k&ShQnY6Xab%dp^Gv_VkItr');
define('NONCE_KEY',        '9dH3,3rnqxKp>g^zEr#6p9Uqw|V_,G^D0#ny?d$CYk6=,w$z;}AOvC=X8a.kxl-s');
define('AUTH_SALT',        'zb=Dlj,Hl?QTF*z^:mI~u6U*cs?RTk;E7ez:15UgS5u93mC&Rs%0 B60hoC#W?rq');
define('SECURE_AUTH_SALT', '=7?hpdXhM3c2NyGJcHI^*vSCZ+XL1-al$.K0.rcEIg-?+C~b8L-r1)T)[!{Vm^^-');
define('LOGGED_IN_SALT',   'mC*yi_zn0tv+!XIMK4uw{!X5@S8B^RV9d:&*E!-Y>*ND,DX+.JM%q/G~Y6{d;H<^');
define('NONCE_SALT',       'h}L+MQc{IBLK_cztM>[psG&?Bm_$d)g}v0HKx;aW~r8gnDP(!=`67c$|K3tmWLxe');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);
define('VP_GIT_BINARY', 'C:\Program Files\Git\bin\git.exe');
/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



define('VP_ENVIRONMENT', 'production');
/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
