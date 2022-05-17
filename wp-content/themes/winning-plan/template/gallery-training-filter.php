<?php
/*
Template Name: GL training filter 
*/
get_header('personal');

$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;

$tax_query = array();
if ($_GET['drills_сategory'] != NULL && $_GET['drills_сategory'] != 'all') {
    $tax_query = array(
        array(
            'taxonomy' => 'drills_сategory',
            'field' => 'id',
            'terms' => $_GET['drills_сategory']
        )
    );
}

$allDrills = new WP_Query([
    'post_type' => 'training',
    'posts_per_page' => -1,
    'tax_query' => $tax_query
]);

$allDrillsCount = 0;
if ($allDrills->posts) {
    $allDrillsCount = count($allDrills->posts);
}

$arr_favorits = get_user_meta($current_user_id, 'drill_favorit_user', true);
if ($arr_favorits) {
    $arr_favorits = $arr_favorits;
} else {
    $arr_favorits = array(0);
}
$favoriteDrills = new WP_Query(
    [
        'post_type' => 'training',
        'post__in' => $arr_favorits,
        'posts_per_page' => -1,
        'tax_query' => $tax_query
    ]
);
$favoriteDrillsCount = 0;
if ($favoriteDrills->posts) {
    $favoriteDrillsCount = $favoriteDrills->post_count;
}

$createdDrills = new WP_Query([
    'post_type' => 'training',
    'author' => $current_user_id,
    'posts_per_page' => -1,
    'tax_query' => $tax_query
]);
$createdDrillsCount = 0;
if ($createdDrills->posts) {
    $createdDrillsCount = count($createdDrills->posts);
}

$administrators = $user_ids = get_users([
    'role' => 'administrator',
    'fields' => 'ID'
]);

$systemsDrills = new WP_Query([
    'post_type' => 'training',
    'author__in' => $administrators,
    'posts_per_page' => -1,
    'tax_query' => $tax_query
]);
$systemsDrillsCount = 0;
if ($systemsDrills->posts) {
    $systemsDrillsCount = count($systemsDrills->posts);
}
?>

    <div class="container">
        <?php the_title('<h1 class="wrapper-personal__title">', '</h1>'); ?>
        <form action="" id="gallery-filter">
            <input type="hidden" name="action" value="gallery_filter_drill">
            <input type="hidden" name="drills_сategory" value="all">
            <input type="hidden" name="post_type" value="training">
            <div class="gallery-filter">
                <div class="gallery-filter__form">
                    <div class="gallery-filter__item">
                        <label>
                            <?php _e('סינון', 'winning_plan'); ?>
                        </label>

                        <?php
                        $args = array(
                            'taxonomy' => array('type'),
                            'hide_empty' => false,
                            'fields' => 'all',
                            'count' => true,
                            'parent' => 0
                        );
                        $term_query = get_terms($args);
                        if ($term_query) {
                            ?>
                            <select name="type">
                                <option value="">
                                    <?php _e('סוג', 'winning_plan'); ?>
                                </option>
                                <?php foreach ($term_query as $term) {
                                    $selected = '';
                                    if ($_GET['goal'] == $term->term_id) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $term->term_id; ?>">
                                        <?php echo $term->name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php } ?>

                    </div>
                    <div class="gallery-filter__item">
                            <?php
                            $args = array(
                                'taxonomy' => array('goal'),
                                'hide_empty' => false,
                                'fields' => 'all',
                                'count' => true,
                                'parent' => 0
                            );
                            $term_query = get_terms($args);
                            if ($term_query) {
                                ?>
                                <select name="goal">
                                    <option value="">
                                        <?php _e('מטרה', 'winning_plan'); ?>
                                    </option>
                                    <?php foreach ($term_query as $term) {
                                        $selected = '';
                                        if ($_GET['goal'] == $term->term_id) {
                                            $selected = 'selected';
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value="<?php echo $term->term_id; ?>">
                                            <?php echo $term->name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                    </div>
                    <div class="gallery-filter__item">
                        <?php
                        $field_key = "field_623c4312ab74d";  // ACF / Options - training / Age *
                        $field = get_field_object($field_key);
                        if ($field) {
                            echo '<select name="age">';
                            echo '<option value="">' . __('גיל', 'winning_plan') . '</option>';
                            foreach ($field['choices'] as $k => $v) {
                                if ($_GET['age'] == $k)
                                    echo '<option selected value="' . $k . '">' . $v . '</option>';
                                else
                                    echo '<option value="' . $k . '">' . $v . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>
                    <div class="gallery-filter__item search">
                        <button>
                            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                <path d="M6.334.292a6.042 6.042 0 0 1 4.691 9.849l4.084 4.083a.625.625 0 0 1-.814.945l-.07-.06-4.084-4.084A6.043 6.043 0 1 1 6.334.292Zm0 1.25a4.792 4.792 0 1 0 0 9.583 4.792 4.792 0 0 0 0-9.583Z"
                                      fill="#fff"/>
                            </svg>
                        </button>
                        <input value="<?php echo $_GET['search']; ?>" type="text" name="search"
                               placeholder="<?php _e('ישפוח שופיח', 'winning_plan'); ?> ... ">
                    </div>
                </div>
                <a class="advanced-filtering" href="#">
                    <span><?php _e('סינון מתקדם', 'winning_plan'); ?></span>
                    <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M10.878 1.332A.727.727 0 0 0 9.849.304L6 4.154 2.15.303a.727.727 0 1 0-1.028 1.028l4.364 4.364a.727.727 0 0 0 1.028 0l4.364-4.364Z"
                              fill="#4573FF"/>
                    </svg>
                </a>

                <div class="gallery-filter__subcategory subcategory-filter">
                    <?php
                    if ($_GET['drills_сategory']) {
                        echo drill_subcategory_checkbox_list($_GET['drills_сategory']);
                    } else {
                        echo drill_subcategory_checkbox_list('');
                    }
                    ?>
                    <div class="subcategory-filter__nav">
                        <button class="btn-wrapper blue subcategory-filter__starting">
                            <?php _e('החל', 'winning_plan'); ?>
                        </button>
                        <a class="subcategory-filter__reset" href="#">
                            <?php _e('איפוס', 'winning_plan'); ?>
                        </a>
                    </div>
                </div>

            </div>

            <div class="gallery-сategory">
                <div class="gallery-сategory__title">
                <span>
                    <?php _e('מערכי התקפה', 'winning_plan'); ?>
                </span>
                </div>

                <div class="gallery-filter__sort">
                    <div class="gallery-filter__item">
                        <input checked type="radio" class="custom-radio" id="all-drills" name="drills"
                               value="all-drills">
                        <label id="all-drills-count" for="all-drills">
                            <?php _e('כל התרגילים', 'winning_plan'); ?>
                            (<i><?php echo $allDrillsCount; ?></i>)
                        </label>
                    </div>
                    <div class="gallery-filter__item">
                        <input type="radio" class="custom-radio" id="favorite-drills" name="drills"
                               value="favorite-drills">
                        <label id="favorite-drills-count" for="favorite-drills">
                            <?php _e('המועדפים שלי', 'winning_plan'); ?>
                            (<i><?php echo $favoriteDrillsCount; ?></i>)
                        </label>
                    </div>
                    <?php if (user_role_check('manager') != true) { ?>
                        <div class="gallery-filter__item">
                            <input type="radio" class="custom-radio" id="created-drills" name="drills"
                                   value="created-drills">
                            <label id="created-drills-count" for="created-drills">
                                <?php _e(' תרגילים שיצרתי', 'winning_plan'); ?>
                                (<i><?php echo $createdDrillsCount; ?></i>)
                            </label>
                        </div>
                        <div class="gallery-filter__item">
                            <input type="radio" class="custom-radio" id="systems-drills" name="drills"
                                   value="systems-drills">
                            <label id="systems-drills-count" for="systems-drills">
                                <?php _e(' תרגילי המערכת', 'winning_plan'); ?>
                                (<i><?php echo $systemsDrillsCount; ?></i>)
                            </label>
                        </div>
                    <?php } ?>
                    <div class="gallery-filter__item sort">
                        <label>
                            <?php _e('מיון לפי', 'winning_plan'); ?>
                        </label>
                        <?php
                        $field = array(['חדשים', 'date'], ['Name (Alpha-beta)', 'title'], ['Age', 'age']);
                        if ($field) {
                            echo '<select name="sort">';
                            foreach ($field as $item) {
                                if ($_GET['sort'] == $item[1])
                                    echo '<option selected value="' . $item[1] . '">' . $item[0] . '</option>';
                                else
                                    echo '<option value="' . $item[1] . '">' . $item[0] . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>
                </div>

                <?php
                $posts_per_page = 12;
                echo '<input type="hidden" name="posts_per_page" value="' . $posts_per_page . '">';
                $args = array(
                    'post_type' => 'training',
                    'posts_per_page' => $posts_per_page,
                    'paged' => 1,
                );

                if ($_GET['drills'] != NULL) {

                }

                if ($_GET['drills_сategory'] != NULL && $_GET['drills_сategory'] != 'all') {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'drills_сategory',
                            'field' => 'id',
                            'terms' => $_GET['drills_сategory']
                        )
                    );
                }


                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    ?>
                    <div id="drills-result-filter" class="gallery-drills__list gallery-training__result">
                        <?php while ($query->have_posts()) {
                            $query->the_post();
                            $post_thumbnail_id = get_post_thumbnail_id();
                            $image_post_url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                            $vimeo_video = get_field('video');
                            $class_video = '';
                            if ($vimeo_video) {
                                $class_video = 'video hover-play-video';
                            }
                            echo drill_item_box(get_the_ID());
                        } ?>
                    </div>
                    <?php

                    if ($query->max_num_pages > 1) {
                        $paged = $query->max_num_pages;
                        $current_paged = $query->query_vars['paged'];
                        //var_dump($current_paged);
                        echo '<div class="gallery-filter__nav"> ';
                        for ($i = 1; $i <= $paged; $i++) {
                            $class = '';
                            if ($current_paged == $i) {
                                $class = 'current active';
                            }
                            echo '<a href="#" data-page="' . $i . '" class="' . $class . '">
									' . $i . '
                            </a>';
                        }
                        echo '</div>';
                    }

                }
                ?>

            </div>
            <button class="start-drills-filter" style="display: none">Filter</button>
        </form>
    </div>

<?php get_footer('personal'); ?>