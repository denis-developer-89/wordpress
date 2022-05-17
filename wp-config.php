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
define( 'DB_NAME', 'wordpress' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'root' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', 'root' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'PAAZ>o}9EHufh[6(bH D{J9K:A#Ki T$yHnv^%v&#mFJOK[wEOQPhXj&CAaWE8o}' );
define( 'SECURE_AUTH_KEY',  '~wcKG+8AIzU:7=O$Rz7a?_D/@;+Kc0|*1wy:$~t*-1GyKF0*H6@$2Ul}n/mgUWQU' );
define( 'LOGGED_IN_KEY',    'MN;x,Z#/@t#1]2*Va 6#B/Fy`VG//W 1:Uwbq4j~^^u[qaD,9fB>9fmh``>__ik:' );
define( 'NONCE_KEY',        'ctnk6wb+_MW83H*/53E}}dq]5DdBJWf8:x9{u@CX6E]J~Z1?o9x0)rhdZJJMS,H^' );
define( 'AUTH_SALT',        'jf;_.0+Gv)I+g>t|9)![<+r5_wM)xU:r-BwuR19$klu<k9KN(4^1`A*LFb.tLyxx' );
define( 'SECURE_AUTH_SALT', '(sWYC&DOI~H_kuRUYa}4,_qsJS&A-Dtg%L#RJqvVbN+b]b>;W+Gd@7x)ZU[kw3Z}' );
define( 'LOGGED_IN_SALT',   '$^I~GTnOb |+?n)d*V<Kln3+CAlJix[4c-)W_=-q$C] F~1IhF+C4TP~c0uYS6?m' );
define( 'NONCE_SALT',       '? ~|Qg.F$]/N{@^l3]03v}:edw7=<j=j-wq(~L<(pP;nN(tk;nbX4}HVJ(5WhwPB' );

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
define( 'WP_DEBUG', false );
define('VP_GIT_BINARY', 'C:\Program Files\Git\bin\git.exe');
/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



define('VP_ENVIRONMENT', 'production');
/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
