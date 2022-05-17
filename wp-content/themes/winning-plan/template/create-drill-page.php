<?php
/*
Template Name: Сreate drill page
*/
?>
<?php get_header("personal"); ?>
<?php
// $current_post_id = get_user_meta(get_current_user_id(), 'current_post_id', true);


$current_post_id = '';
if (isset($_GET['edit_id'])) {
    $current_post_id = $_GET['edit_id'];
}
$current_step = get_field('step', $current_post_id);

// var_dump_pre($current_post_id);
// var_dump_pre($current_step);
?>
<main>
    <div class="create-drill-page" data-post-id="<?php echo $current_post_id ? $current_post_id : null ?>" data-step="<?php echo $current_step ? $current_step : 0 ?>">
        <div class="container">
            <h1 class="title">יצירת תרגיל</h1>
            <div class="form">
                <div class="first-step">
                    <div class="accordion">
                        <div class="create">
                            <div class="header">
                                <div class="title">
                                    <div class="number">1</div>
                                    <h2>טי התרגיל</h2>
                                </div>
                                <div class="arrow"><i class="fal fa-angle-down"></i></div>
                            </div>
                            <div class="content">
                                <div class="form">
                                    <form id="form-first-step">
                                        <div class="input">
                                            <label for="">שם התרגיל *:</label>
                                            <input type="text" placeholder="שם המערך... " name="title" value="<?php echo $current_post_id ? get_the_title($current_post_id) : '' ?>">
                                        </div>
                                        <div class="textarea">
                                            <label for="description">תקציר* :</label>
                                            <textarea id="description" placeholder="שם המערך... " name="description"><?php echo $current_post_id ? get_field('short-description', $current_post_id) : '' ?></textarea>
                                        </div>
                                        <div class="checkboxes">
                                            <label for="">גיל:</label>
                                            <div class="checkbox-group">
                                                <?php
                                                $field = get_field_object('field_621398326160f');
                                                $values = get_field('field_621398326160f', $current_post_id);
                                                ?>
                                                <?php foreach ($field['choices'] as $key => $value) : ?>
                                                    <?php if (in_array($key, $values)) : ?>
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="<?php echo $value; ?>" name="age[]" value="<?php echo $value; ?>" checked>
                                                            <label for="<?php echo $value; ?>">
                                                                <?php echo $value; ?></label>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="<?php echo $value; ?>" name="age[]" value="<?php echo $value; ?>">
                                                            <label for="<?php echo $value; ?>">
                                                                <?php echo $value; ?></label>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="checkboxes">
                                            <label for="">סוג האימון*:</label>
                                            <div class="types">
                                                <div class="radio-group">
                                                    <div class="radio">
                                                        <input type="radio" id="all" name="type" value="" checked>
                                                        <label for="all">
                                                            כללי - בחירה חופשית</label>
                                                    </div>
                                                    <?php $args = array(
                                                        'taxonomy' => 'type',
                                                        'hide_empty' => false,
                                                        'orderby' => 'id',
                                                        'order' => 'DESC'
                                                    );
                                                    $terms = get_terms($args); ?>
                                                    <?php foreach ($terms as $term) : ?>
                                                        <div class="radio">
                                                            <input type="radio" id="<?php echo $term->slug ?>" name="type" value="<?php echo $term->term_id ?>" <?php echo $term->slug == 'all' ? 'checked' : '' ?>>
                                                            <label for="<?php echo $term->slug ?>">
                                                                <?php echo $term->name ?></label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="checkboxes">
                                            <label for="">מטרה:</label>
                                            <div class="goals">
                                                <div class="checkbox-group">
                                                    <?php $args = array(
                                                        'taxonomy' => 'goal',
                                                        'hide_empty' => false,
                                                        'orderby' => 'id',
                                                        'order' => 'ASC'
                                                    );
                                                    $terms = get_terms($args); ?>
                                                    <?php $values = wp_get_object_terms($current_post_id, 'goal', array('fields' => 'ids')); ?>
                                                    <?php foreach ($terms as $term) : ?>
                                                        <?php if (in_array($term->term_id, $values)) : ?>
                                                            <div class="checkbox">
                                                                <input type="checkbox" id="<?php echo $term->slug ?>" name="goal[]" value="<?php echo $term->term_id ?>" checked>
                                                                <label for="<?php echo $term->slug ?>">
                                                                    <?php echo $term->name ?></label>
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="checkbox">
                                                                <input type="checkbox" id="<?php echo $term->slug ?>" name="goal[]" value="<?php echo $term->term_id ?>">
                                                                <label for="<?php echo $term->slug ?>">
                                                                    <?php echo $term->name ?></label>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit">
                                            <button type="submit" class="btn-blue" data-step="1">ךשמה</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="edit">
                            <div class="header">
                                <div class="title">
                                    <div class="number">1</div>
                                    <h2>טי התרגיל </h2>
                                </div>
                                <button type="button" class="btn-transparent-small" data-step="1">
                                    <span>עריכה</span><i class="fa fa-pen"></i>
                                </button>
                            </div>
                            <div class="content">
                                <div class="form">
                                    <div class="title">
                                        <?php echo get_the_title($current_post_id); ?>
                                    </div>
                                    <div class="description">
                                        <?php echo get_field("short-description", $current_post_id); ?>
                                    </div>
                                    <div class="breadcrumbs">
                                        <?php $types = wp_get_object_terms($current_post_id, 'type', array('fields' => 'names')); ?>
                                        <?php if ($types) : ?>
                                            <div class="type">סוג:
                                                <?php foreach ($types as $value) {
                                                    echo $value;
                                                }; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php $goals = wp_get_object_terms($current_post_id, 'goal', array('fields' => 'names')); ?>
                                        <?php if ($goals) : ?>
                                            <div class="goals">מטרה:
                                                <?php foreach ($goals as $key => $value) {
                                                    echo $key > 0 ? " | " . $value : $value;
                                                } ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php $categories = wp_get_object_terms($current_post_id, 'drills_сategory', array('fields' => 'names')); ?>
                                        <?php if ($categories) : ?>
                                            <div class="categories">
                                                קטגוריות:
                                                <?php foreach ($categories as $key => $value) {
                                                    echo $key > 0 ? " | " . $value : $value;
                                                } ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="meta">
                                        <div class="author">
                                            <span> שם היוצר :</span><span>
                                                <?php General::get_post_author($current_post_id); ?>
                                        </div>
                                        <div class="age">
                                            <?php $age = get_field("field_621398326160f", $current_post_id); ?>
                                            <?php if ($age) : ?>
                                                <span>גיל : </span><span>
                                                    <?php foreach ($age as $key => $value) {
                                                        echo $key > 0 ? " | " . $value : $value;
                                                    } ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="date">
                                            <span>תאריך :</span><span>
                                                <?php echo get_the_date('d/m/y', $current_post_id) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second-step">
                    <div class="accordion">
                        <div class="create">
                            <div class="header">
                                <div class="title">
                                    <div class="number">2</div>
                                    <h2>מאפייני תרגיל</h2>
                                </div>
                                <div class="arrow"><i class="fal fa-angle-down"></i></div>
                            </div>
                            <div class="content">
                                <div class="form">
                                    <form id="form-second-step">
                                        <?php
                                        if ($current_post_id) {
                                            $type = wp_get_object_terms($current_post_id, 'type', array('fields' => 'names'));
                                            $goal = wp_get_object_terms($current_post_id, 'goal', array('fields' => 'ids'));
                                            $drills_сategory = wp_get_object_terms($current_post_id, 'drills_сategory', array('fields' => 'ids'));
                                            echo General::get_drills_categories(0, '', $goal, $drills_сategory);
                                        } else {
                                            echo General::get_drills_categories();
                                        }
                                        ?>
                                        <div class="submit">
                                            <button type="submit" class="btn-blue" data-step="2">ךשמה</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="third-step">
                    <div class="accordion">
                        <div class="create">
                            <div class="header">
                                <div class="title">
                                    <div class="number">3</div>
                                    <h2>בניית התרגיל</h2>
                                </div>
                                <div class="arrow"><i class="fal fa-angle-down"></i></div>
                            </div>
                            <div class="content">
                                <div class="form">
                                    <div class="switcher">
                                        <div class="switcher-header">
                                            <div class="switcher-tab ">יצירת תרשים</div>
                                            <div class="switcher-tab active">עלה תמונת תרגיל</div>
                                        </div>
                                        <div class="switchers-content">
                                            <div class="switcher-content">
                                                <form id="form-third-step-canvas-area">
                                                    <div class="canvas-area">
                                                        <div class="tabs">
                                                            <div class="tabs-header">
                                                                <div class="tab active">גרשים</div>
                                                                <div class="tab">שחקנים</div>
                                                                <div class="tab">סימונים</div>
                                                                <div class="tab">חפצים</div>
                                                                <div class="tab">קווים וחיצים</div>
                                                            </div>
                                                            <div class="tabs-content">
                                                                <div class="tab-content active">
                                                                    <div class="exchanges">
                                                                        <div class="slider">
                                                                            <div class="swiper">
                                                                                <div class="swiper-wrapper">
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild active">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-1.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-2.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-3.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-4.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-5.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-6.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-7.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-8.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-9.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="swiper-slide">
                                                                                        <div class="fild">
                                                                                            <img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/exchanges/slider/filds-10.svg" alt="filds">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="swiper-navigation">
                                                                                <div class="swiper-button-prev"></div>
                                                                                <div class="swiper-button-next"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-content">
                                                                    <div class="football-players">
                                                                        <div class="players">
                                                                            <div class="content">
                                                                                <div class="options">
                                                                                    <div class="color">
                                                                                        <div class="current-color">
                                                                                        </div>
                                                                                        <div class="choose-color">
                                                                                            <div class="radio active">
                                                                                                <input type="radio" name="color" id="football-players-blue" value="#2C62FF">
                                                                                                <label for="football-players-blue" style="background-color:#2C62FF"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="football-players-red" value="#ff0000">
                                                                                                <label for="football-players-red" style="background-color:red"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="football-players-orange" value="#ffa500">
                                                                                                <label for="football-players-orange" style="background-color:orange"></></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="football-players-yellow" value="#ffff00">
                                                                                                <label for="football-players-yellow" style="background-color:yellow"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="football-players-white" value="#ffffff">
                                                                                                <label for="football-players-white" style="background-color:white"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="football-players-grey" value="#808080">
                                                                                                <label for="football-players-grey" style="background-color:grey"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="trun-over"><img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/players/options/turn-over.svg" alt=""></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="players">
                                                                            <div class="heading">כדרור</div>
                                                                            <div class="content">
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/dribbling/dribbling-player-1.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/dribbling/dribbling-player-2.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/dribbling/dribbling-player-3.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/dribbling/dribbling-player-4.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/dribbling/dribbling-player-5.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/dribbling/dribbling-player-6.svg")); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="players">
                                                                            <div class="heading">שוערים</div>
                                                                            <div class="content">
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/goalkeepers/goalkeepers-player-1.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/goalkeepers/goalkeepers-player-2.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/goalkeepers/goalkeepers-player-3.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/goalkeepers/goalkeepers-player-4.svg")); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="players">
                                                                            <div class="heading">ספציפי</div>
                                                                            <div class="content">
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/specific/specific-player-1.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/specific/specific-player-2.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/specific/specific-player-3.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/specific/specific-player-4.svg")); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="players">
                                                                            <div class="heading">ריצה/עמידה</div>
                                                                            <div class="content">
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/running-standing/running-standing-player-1.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/running-standing/running-standing-player-2.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/running-standing/running-standing-player-3.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/running-standing/running-standing-player-5.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/running-standing/running-standing-player-6.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/running-standing/running-standing-player-7.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/running-standing/running-standing-player-8.svg")); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="players">
                                                                            <div class="heading">מסירה/בעיטה</div>
                                                                            <div class="content">
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-1.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-2.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-3.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-4.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-5.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-6.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-7.svg")); ?>
                                                                                </div>
                                                                                <div class="player">
                                                                                    <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/tabs/players/delivery-kick/delivery-kick-player-8.svg")); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-content">
                                                                    <div class="markings">
                                                                        <div class="marks">
                                                                            <div class="content">
                                                                                <div class="options">
                                                                                    <div class="color">
                                                                                        <div class="current-color">
                                                                                        </div>
                                                                                        <div class="choose-color">
                                                                                            <div class="radio active">
                                                                                                <input type="radio" name="color" id="markings-blue" value="#2C62FF">
                                                                                                <label for="markings-blue" style="background-color:#2C62FF"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="markings-red" value="#ff0000">
                                                                                                <label for="markings-red" style="background-color:red"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="markings-orange" value="#ffa500">
                                                                                                <label for="markings-orange" style="background-color:orange"></></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="ymarkings-yellow" value="#ffff00">
                                                                                                <label for="markings-yellow" style="background-color:yellow"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="markings-white" value="#ffffff">
                                                                                                <label for="markings-white" style="background-color:white"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="markings-grey" value="#808080">
                                                                                                <label for="markings-grey" style="background-color:grey"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="trun-over"><img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/markings/options/turn-over.svg" alt="turn-over">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="marks">
                                                                            <div class="heading">מספרים</div>
                                                                            <div class="content">
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/one.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/two.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/three.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/four.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/five.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/six.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/seven.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/eight.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/nine.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/ten.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/eleven.svg'); ?>
                                                                                </div>
                                                                                <div class="number">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/numbers/twelve.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="marks">
                                                                            <div class="heading">תויתוא</div>
                                                                            <div class="content">
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/a.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/b.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/c.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/d.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/e.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/f.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/g.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/h.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/i.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/j.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/k.svg'); ?>
                                                                                </div>
                                                                                <div class="letter">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/letters/l.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="marks">
                                                                            <div class="heading">ישפוח טסקט</div>
                                                                            <div class="content">
                                                                                <div class="text">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/markings/options/text.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-content">
                                                                    <div class="things">
                                                                        <div class="thing">
                                                                            <div class="content">
                                                                                <div class="options">
                                                                                    <div class="color">
                                                                                        <div class="current-color">
                                                                                        </div>
                                                                                        <div class="choose-color">
                                                                                            <div class="radio active">
                                                                                                <input type="radio" name="color" id="things-blue" value="#2c62ff">
                                                                                                <label for="things-blue" style="background-color:#2c62ff"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="things-red" value="#ff0000">
                                                                                                <label for="things-red" style="background-color:red"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="things-orange" value="#ffa500">
                                                                                                <label for="things-orange" style="background-color:orange"></></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="things-yellow" value="#ffff00">
                                                                                                <label for="things-yellow" style="background-color:yellow"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="things-white" value="#ffffff">
                                                                                                <label for="things-white" style="background-color:white"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="things-grey" value="#808080">
                                                                                                <label for="things-grey" style="background-color:grey"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="trun-over"><img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/things/options/turn-over.svg" alt="turn-over">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="thing">
                                                                            <div class="heading">שערים</div>
                                                                            <div class="content">
                                                                                <div class="gate">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/gates/gate-1.svg'); ?>
                                                                                </div>
                                                                                <div class="gate">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/gates/gate-2.svg'); ?>
                                                                                </div>
                                                                                <div class="gate">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/gates/gate-3.svg'); ?>
                                                                                </div>
                                                                                <div class="gate">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/gates/gate-4.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="thing">
                                                                            <div class="heading">חישוקים</div>
                                                                            <div class="content">
                                                                                <div class="figure">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/figures/figure-2.svg'); ?>
                                                                                </div>
                                                                                <div class="figure">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/figures/figure-3.svg'); ?>
                                                                                </div>
                                                                                <div class="figure">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/figures/figure-4.svg'); ?>
                                                                                </div>
                                                                                <div class="figure">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/figures/figure-5.svg'); ?>
                                                                                </div>
                                                                                <div class="figure">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/figures/figure-6.svg'); ?>
                                                                                </div>
                                                                                <div class="figure">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/figures/figure-7.svg'); ?>
                                                                                </div>
                                                                                <div class="figure stairs">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/figures/figure-1.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="thing">
                                                                            <div class="heading">מוטות, דמויות
                                                                                וקונוסים
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="hoop">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/hoops/hoop-1.svg'); ?>
                                                                                </div>
                                                                                <div class="hoop">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/hoops/hoop-2.svg'); ?>
                                                                                </div>
                                                                                <div class="hoop">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/hoops/hoop-3.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="thing">
                                                                            <div class="heading">מוטות, דמויות
                                                                                וקונוסים
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/objects/object-1.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/objects/object-2.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/objects/object-3.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/things/objects/object-4.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-content">
                                                                    <div class="arrows">
                                                                        <div class="arrow">
                                                                            <div class="content">
                                                                                <div class="options">
                                                                                    <div class="color">
                                                                                        <div class="current-color">
                                                                                        </div>
                                                                                        <div class="choose-color">
                                                                                            <div class="radio active">
                                                                                                <input type="radio" name="color" id="arrows-blue" value="#2c62ff">
                                                                                                <label for="arrows-blue" style="background-color:#2c62ff"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="arrows-red" value="#ff0000">
                                                                                                <label for="arrows-red" style="background-color:red"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="arrows-orange" value="#ffa500">
                                                                                                <label for="arrows-orange" style="background-color:orange"></></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="yarrows-yellow" value="#ffff00">
                                                                                                <label for="arrows-yellow" style="background-color:yellow"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="arrows-white" value="#ffffff">
                                                                                                <label for="arrows-white" style="background-color:white"></label>
                                                                                            </div>
                                                                                            <div class="radio">
                                                                                                <input type="radio" name="color" id="arrows-grey" value="#808080">
                                                                                                <label for="arrows-grey" style="background-color:grey"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="trun-over"><img src="<?php echo get_template_directory_uri() ?>/images/create-drill-page/third-step/tabs/arrows/options/turn-over.svg" alt="turn-over">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="arrow">
                                                                            <div class="heading">קווים וחיצים</div>
                                                                            <div class="content">
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-1.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-2.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-3.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-4.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-5.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-6.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-7.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/arrow/arrow-8.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="arrow">
                                                                            <div class="heading">מגרשים</div>
                                                                            <div class="content">
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/areas/area-1.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/areas/area-2.svg'); ?>
                                                                                </div>
                                                                                <div class="object">
                                                                                    <?php echo General::get_svg_from_path('/images/create-drill-page/third-step/tabs/arrows/areas/area-3.svg'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="canvas">
                                                                    <canvas id="canvas"></canvas>
                                                                </div>
                                                                <div class="nav">
                                                                    <div class="history">
                                                                        <button type="button" class="undo">
                                                                            <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/canvas/undo-arrow.svg")); ?>
                                                                        </button>
                                                                        <button type="button" class="redo">
                                                                            <?php echo file_get_contents(esc_url(get_template_directory_uri() . "/images/create-drill-page/third-step/canvas/redo-arrow.svg")); ?>
                                                                        </button>
                                                                    </div>
                                                                    <div class="clear">
                                                                        <a href="#">איפוס</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="submit">
                                                        <button type="submit" class="btn-blue" data-step="3">ךשמה
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="switcher-content active">
                                                <form id="form-third-step-upload">
                                                    <div class="upload">
                                                        <div class="file-upload">
                                                            <span class="file-name">בחירת קובץ</span>
                                                            <button type="button">בחירה</button>
                                                            <input type="file" name="file">
                                                        </div>
                                                        <div class="upload-image-preview">
                                                            <?php if (has_post_thumbnail($current_post_id)) : ?>
                                                                <?php echo get_the_post_thumbnail($current_post_id); ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="clear">
                                                            <a href="#">איפוס</a>
                                                        </div>
                                                    </div>
                                                    <div class="submit">
                                                        <button type="submit" class="btn-blue" data-step="3">ךשמה
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="edit">
                            <div class="header">
                                <div class="title">
                                    <div class="number">3</div>
                                    <h2>בניית התרגיל</h2>
                                </div>
                                <button type="button" class="btn-transparent-small" data-step="3">
                                    <span>עריכה</span><i class="fa fa-pen"></i>
                                </button>
                            </div>
                            <div class="content">
                                <div class="form">
                                    <div class="thumbnail">
                                        <?php if (has_post_thumbnail($current_post_id)) : ?>
                                            <?php echo get_the_post_thumbnail($current_post_id); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fouth-step">
                    <div class="accordion">
                        <div class="create">
                            <div class="header">
                                <div class="title">
                                    <div class="number">4</div>
                                    <h2>הרכב התרגיל</h2>
                                </div>
                                <div class="arrow"><i class="fal fa-angle-down"></i></div>
                            </div>
                            <div class="content">
                                <div class="form">
                                    <form id="form-fouth-step">
                                        <div class="textarea">
                                            <label for="">מטרות</label>
                                            <textarea name="description-goals" placeholder="כנה טכנית ל 1 נגד 1 "><?php the_field("description_goals", $current_post_id) ?></textarea>
                                        </div>
                                        <div class="textarea">
                                            <label for="">מבנה</label>
                                            <textarea name="description-building" placeholder="יחס שחקנים 5-4 שחקנים בכל מבנה "><?php the_field("description_building", $current_post_id) ?></textarea>
                                        </div>
                                        <div class="textarea">
                                            <label for="">הסבר</label>
                                            <textarea name="description-explanation" placeholder="תקציר ..."><?php the_field("description_explanation", $current_post_id) ?></textarea>
                                        </div>
                                        <div class="dynamic-inputs">
                                            <script type="text/html" id="template">
                                                <div class="input">
                                                    <div class="number">0</div>
                                                    <input type="text" name="description-emphasis[]">
                                                    <div class="delete">
                                                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
                                                            <path d="m2 2 8 8m0-8-8 8" stroke="#FA8585" stroke-width="3" stroke-linecap="round" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </script>
                                            <label for="">דגשים</label>
                                            <?php $i = 1; ?>
                                            <?php if (have_rows('description_emphasis', $current_post_id)) : ?>
                                                <?php while (have_rows('description_emphasis', $current_post_id)) : the_row(); ?>
                                                    <div class="input">
                                                        <div class="number"><?php echo $i ?></div>
                                                        <input type="text" name="description-emphasis[]" value="<?php the_sub_field('title'); ?>">
                                                        <div class="delete">
                                                            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
                                                                <path d="m2 2 8 8m0-8-8 8" stroke="#FA8585" stroke-width="3" stroke-linecap="round" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <?php $i++; ?>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                            <div class="add-more">
                                                <button type="button" class="btn-transparent-small">הוספת דגש<i class="fal fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="video">
                                            <div class="input">
                                                <label for="">אנימציה</label>
                                                <?php if (have_rows('video_animation', $current_post_id)) : ?>
                                                    <?php while (have_rows('video_animation', $current_post_id)) : the_row(); ?>
                                                        <input type="text" name="video-url-animation" value="<?php the_sub_field("video_url_animation") ?>">
                                                    <?php endwhile; ?>
                                                <?php else : ?>
                                                    <input type="text" name="video-url-animation">
                                                <?php endif; ?>
                                            </div>
                                            <div class="input">
                                                <label for="">וידאו</label>
                                                <div class="form-group">
                                                    <?php if (have_rows('video', $current_post_id)) : ?>
                                                        <?php while (have_rows('video', $current_post_id)) : the_row(); ?>
                                                            <input type="text" name="video-url" value="<?php the_sub_field("video_url") ?>">
                                                            <input type="text" name="site-url" value="<?php the_sub_field("site_url") ?>">
                                                        <?php endwhile; ?>
                                                    <?php else : ?>
                                                        <input type="text" name="video-url">
                                                        <input type="text" name="site-url">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="input">
                                                <label for="">וידאו ממשחק</label>
                                                <div class="form-group">
                                                    <?php if (have_rows('video_for_game', $current_post_id)) : ?>
                                                        <?php while (have_rows('video_for_game', $current_post_id)) : the_row(); ?>
                                                            <input type="text" name="video-url-for-game" value="<?php the_sub_field("video_url_for_game") ?>">
                                                            <input type="text" name="site-url-for-game" value="<?php the_sub_field("site_url_for_game") ?>">
                                                        <?php endwhile; ?>
                                                    <?php else : ?>
                                                        <input type="text" name="video-url-for-game">
                                                        <input type="text" name="site-url-for-game">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="save">
                    <button type="button" disabled class="btn-save" data-step="4">שמור תרגיל</button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer("personal"); ?>