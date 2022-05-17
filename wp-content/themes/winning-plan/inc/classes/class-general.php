<?php

/**
 * General Class
 */
class General
{

    private static $instance;


    public function __construct()
    {
        $this->setup_ajax_handlers();
    }


    public function wp_ajax_action($action)
    {
        add_action('wp_ajax_' . $action, [$this, $action]);
        add_action('wp_ajax_nopriv_' . $action, [$this, $action]);
    }

    public function setup_ajax_handlers()
    {
    }

    public static function get_post_author($post_id = '')
    {
        $post_data = get_post($post_id);
        $author_id = $post_data->post_author;
        $user_meta = get_userdata($author_id);
        echo $user_meta->display_name;
    }

    public function get_svg_file($name_file)
    {
        return file_get_contents(THEME_DIR . '/images/svg/' . $name_file . '.svg');
    }

    public function get_svg_from_path($path)
    {
        return file_get_contents(THEME_DIR . $path);
    }

    public static function get_instance()
    {
        // Check is $_instance has been set
        if (!isset(self::$instance)) {
            // Creates sets object to instance
            self::$instance = new General();
        }

        // Returns the instance
        return self::$instance;
    }

    public function get_drills_categories($parent = 0, $type = '', $goal = '', $checked_categories = [])
    {
?>
        <?php ob_start(); ?>
        <div class="categories">
            <?php
            $meta_query = array();

            if ($type) {
                if (is_array($type)) {
                    foreach ($type as $value) {
                        $meta_query[] = array(
                            'key' => 'type',
                            'value' => $value,
                            'compare' => 'LIKE'
                        );
                    }
                } else {
                    $meta_query[] = array(
                        'key' => 'type',
                        'value' => $type,
                        'compare' => 'LIKE'
                    );
                }
            }

            if ($goal) {
                if (is_array($goal)) {
                    foreach ($goal as $value) {
                        $meta_query[] = array(
                            'key' => 'goal',
                            'value' => $value,
                            'compare' => 'LIKE'
                        );
                    }
                } else {
                    $meta_query[] = array(
                        'key' => 'goal',
                        'value' => $goal,
                        'compare' => 'LIKE'
                    );
                }
            }

            if ($parent == 0) :
                $args = array(
                    'taxonomy' => array('drills_сategory'),
                    'hide_empty' => false,
                    'count' => true,
                    'parent' => $parent,
                );

                if ($meta_query) {
                    $args['meta_query'] = $meta_query;
                }


                $terms = get_terms($args);
            ?>
                <?php foreach ($terms as $term) : ?>
                    <div class="category">
                        <div class="category-header">
                            <?php if (in_array($term->term_id, $checked_categories)) : ?>
                                <div class="checkbox">
                                    <input type="checkbox" id="category-<?php echo $term->term_id; ?>" name="category[]" value="<?php echo $term->term_id; ?>" checked>
                                    <label for="category-<?php echo $term->term_id; ?>">
                                        <?php echo $term->name; ?></label>
                                </div>
                            <?php else : ?>
                                <div class="checkbox">
                                    <input type="checkbox" id="category-<?php echo $term->term_id; ?>" name="category[]" value="<?php echo $term->term_id; ?>">
                                    <label for="category-<?php echo $term->term_id; ?>">
                                        <?php echo $term->name; ?></label>
                                </div>
                            <?php endif; ?>
                            <div class="arrow"><i class="fal fa-angle-down"></i></div>
                        </div>
                        <div class="category-content">
                            <div class="sub-categories">
                                <?php $args_sub_second_categories = array(
                                    'taxonomy' => array('drills_сategory'),
                                    'hide_empty' => false,
                                    'count' => true,
                                    'parent' => $term->term_id
                                );
                                ?>
                                <?php $terms_sub_second_categories = get_terms($args_sub_second_categories); ?>
                                <?php foreach ($terms_sub_second_categories as $term_sub_second_category) : ?>
                                    <div class="sub-category">
                                        <div class="sub-category-header">
                                            <?php if (in_array($term_sub_second_category->term_id, $checked_categories)) : ?>
                                                <div class="checkbox">
                                                    <input type="checkbox" id="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>" name="sub-second-category[]" value="<?php echo $term_sub_second_category->term_id; ?>" checked>
                                                    <label for="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>">
                                                        <?php echo $term_sub_second_category->name; ?></label>
                                                </div>
                                            <?php else : ?>
                                                <div class="checkbox">
                                                    <input type="checkbox" id="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>" name="sub-second-category[]" value="<?php echo $term_sub_second_category->term_id; ?>">
                                                    <label for="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>">
                                                        <?php echo $term_sub_second_category->name; ?></label>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="sub-category-content">
                                            <?php $args_sub_third_categories = array(
                                                'taxonomy' => array('drills_сategory'),
                                                'hide_empty' => false,
                                                'count' => true,
                                                'parent' => $term_sub_second_category->term_id
                                            );
                                            $terms_sub_third_categories = get_terms($args_sub_third_categories);
                                            ?>
                                            <div class="checkbox-group">
                                                <?php foreach ($terms_sub_third_categories as $terms_sub_third_category) : ?>
                                                    <?php if (in_array($terms_sub_third_category->term_id, $checked_categories)) : ?>
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>" name="sub-third-category[]" value="<?php echo $terms_sub_third_category->term_id; ?>" checked>
                                                            <label for="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>">
                                                                <?php echo $terms_sub_third_category->name ?></label>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>" name="sub-third-category[]" value="<?php echo $terms_sub_third_category->term_id; ?>">
                                                            <label for="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>">
                                                                <?php echo $terms_sub_third_category->name ?></label>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="category">
            <div class="category-header">
                <?php $args_sub_second_categories = array(
                    'taxonomy' => array('drills_сategory'),
                    'hide_empty' => false,
                    'count' => true,
                    'parent' => $parent
                );
                ?>
                <?php $terms_sub_second_categories = get_terms($args_sub_second_categories); ?>
                <?php foreach ($terms_sub_second_categories as $term_sub_second_category) : ?>
                    <div class="sub-category">
                        <div class="sub-category-header">
                            <?php if (in_array($term_sub_second_category->term_id, $checked_categories)) : ?>
                                <div class="checkbox">
                                    <input type="checkbox" id="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>" name="sub-second-category[]" value="<?php echo $term_sub_second_category->term_id; ?>" checked>
                                    <label for="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>">
                                        <?php echo $term_sub_second_category->name; ?></label>
                                </div>
                            <?php else : ?>
                                <div class="checkbox">
                                    <input type="checkbox" id="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>" name="sub-second-category[]" value="<?php echo $term_sub_second_category->term_id; ?>">
                                    <label for="sub-second-category-<?php echo $term_sub_second_category->term_id; ?>">
                                        <?php echo $term_sub_second_category->name; ?></label>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="sub-category-content">
                            <?php $args_sub_third_categories = array(
                                'taxonomy' => array('drills_сategory'),
                                'hide_empty' => false,
                                'count' => true,
                                'parent' => $term_sub_second_category->term_id
                            );
                            $terms_sub_third_categories = get_terms($args_sub_third_categories);
                            ?>
                            <div class="checkbox-group">
                                <?php foreach ($terms_sub_third_categories as $terms_sub_third_category) : ?>
                                    <?php if (in_array($terms_sub_third_category->term_id, $checked_categories)) : ?>
                                        <div class="checkbox">
                                            <input type="checkbox" id="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>" name="sub-third-category[]" value="<?php echo $terms_sub_third_category->term_id; ?>" checked>
                                            <label for="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>">
                                                <?php echo $terms_sub_third_category->name ?></label>
                                        </div>
                                    <?php else : ?>
                                        <div class="checkbox">
                                            <input type="checkbox" id="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>" name="sub-third-category[]" value="<?php echo $terms_sub_third_category->term_id; ?>">
                                            <label for="sub-third-category-<?php echo $terms_sub_third_category->term_id; ?>">
                                                <?php echo $terms_sub_third_category->name ?></label>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php return ob_get_clean(); ?>
    <?php
    }

    public function get_drills_categories_ids($parent = 0, $type = '', $goal = '', $checked_categories = [])
    {
        $categories_ids = array();
        $meta_query = array();
        if ($type) {
            if (is_array($type)) {
                foreach ($type as $value) {
                    $meta_query[] = array(
                        'key' => 'type',
                        'value' => $value,
                        'compare' => 'LIKE'
                    );
                }
            } else {
                $meta_query[] = array(
                    'key' => 'type',
                    'value' => $type,
                    'compare' => 'LIKE'
                );
            }
        }
        if ($goal) {
            if (is_array($goal)) {
                foreach ($goal as $value) {
                    $meta_query[] = array(
                        'key' => 'goal',
                        'value' => $value,
                        'compare' => 'LIKE'
                    );
                }
            } else {
                $meta_query[] = array(
                    'key' => 'goal',
                    'value' => $goal,
                    'compare' => 'LIKE'
                );
            }
        }
        if ($parent == 0) :
            $args = array(
                'taxonomy' => array('drills_сategory'),
                'hide_empty' => false,
                'count' => true,
                'parent' => $parent,
            );
            if ($meta_query) {
                $args['meta_query'] = $meta_query;
            }
            $terms = get_terms($args);
            foreach ($terms as $term) :
                if (in_array($term->term_id, $checked_categories)) :
                    $categories_ids[] = $term->term_id;
                else :
                    $categories_ids[] = $term->term_id;
                endif;
                $args_sub_second_categories = array(
                    'taxonomy' => array('drills_сategory'),
                    'hide_empty' => false,
                    'count' => true,
                    'parent' => $term->term_id
                );
                $terms_sub_second_categories = get_terms($args_sub_second_categories);
                foreach ($terms_sub_second_categories as $term_sub_second_category) :
                    if (in_array($term_sub_second_category->term_id, $checked_categories)) :
                        $categories_ids[] = $term_sub_second_category->term_id;
                    else :
                        $categories_ids[] = $term_sub_second_category->term_id;
                    endif;
                    $args_sub_third_categories = array(
                        'taxonomy' => array('drills_сategory'),
                        'hide_empty' => false,
                        'count' => true,
                        'parent' => $term_sub_second_category->term_id
                    );
                    $terms_sub_third_categories = get_terms($args_sub_third_categories);
                    foreach ($terms_sub_third_categories as $terms_sub_third_category) :
                        if (in_array($terms_sub_third_category->term_id, $checked_categories)) :
                            $categories_ids[] = $terms_sub_third_category->term_id;
                        else :
                            $categories_ids[] = $terms_sub_third_category->term_id;
                        endif;
                    endforeach;
                endforeach;
            endforeach;
        else :
            $args_sub_second_categories = array(
                'taxonomy' => array('drills_сategory'),
                'hide_empty' => false,
                'count' => true,
                'parent' => $parent
            );
            $terms_sub_second_categories = get_terms($args_sub_second_categories);
            foreach ($terms_sub_second_categories as $term_sub_second_category) :
                if (in_array($term_sub_second_category->term_id, $checked_categories)) :
                    $categories_ids[] = $term_sub_second_category->term_id;
                else :
                    $categories_ids[] = $term_sub_second_category->term_id;
                endif;
                $args_sub_third_categories = array(
                    'taxonomy' => array('drills_сategory'),
                    'hide_empty' => false,
                    'count' => true,
                    'parent' => $term_sub_second_category->term_id
                );
                $terms_sub_third_categories = get_terms($args_sub_third_categories);
                foreach ($terms_sub_third_categories as $terms_sub_third_category) :
                    if (in_array($terms_sub_third_category->term_id, $checked_categories)) :
                        $categories_ids[] = $terms_sub_third_category->term_id;
                    else :
                        $categories_ids[] = $terms_sub_third_category->term_id;
                    endif;
                endforeach;
            endforeach;
        endif;
        return $categories_ids;
    }

    public function get_first_step_info($post_id, $name_class = '', $all_meta = false)
    {
        $current_step = get_field('step', $post_id); ?>
        <?php ob_start(); ?>
        <div class="<?php echo $name_class; ?>">
            <div class="header">
                <div class="title">
                    <div class="number">1</div>
                    <h2>
                        <?php _e('טי התרגיל', 'winning-plan'); ?>
                    </h2>
                </div>
                <button type="button" class="btn-transparent" data-step="1">
                    <span>
                        <?php _e('עריכה', 'winning-plan'); ?>
                    </span>
                    <i class="fa fa-pen"></i>
                </button>
            </div>
            <div class="content">
                <div class="form">
                    <div class="title">
                        <?php echo get_the_title($post_id); ?>
                    </div>
                    <div class="description">
                        <?php echo get_field("short-description", $post_id); ?>
                    </div>
                    <div class="breadcrumbs">
                        <?php $types = wp_get_object_terms($post_id, 'type', array('fields' => 'names')); ?>
                        <?php if ($types) : ?>
                            <div class="type">סוג:
                                <?php foreach ($types as $value) {
                                    echo $value;
                                }; ?>
                            </div>
                        <?php endif; ?>
                        <?php $goals = wp_get_object_terms($post_id, 'goal', array('fields' => 'names')); ?>
                        <?php if ($goals) : ?>
                            <div class="goals">מטרה:
                                <?php foreach ($goals as $key => $value) {
                                    echo $key > 0 ? " | " . $value : $value;
                                } ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        $args = array(
                            'taxonomy' => array('drills_сategory'),
                            'hide_empty' => false,
                            'count' => true,
                            'parent' => 0,
                        );
                        $terms = get_terms($args);
                        $categories = wp_get_object_terms($post_id, 'drills_сategory', array('fields' => 'names'));
                        if ($categories) { ?>
                            <div class="categories">
                                <?php
                                _e('קטגוריות:', 'winning-plan');
                                foreach ($terms as $term) {
                                    foreach ($categories as $key => $value) {
                                        if ($term->term_id == $key) {
                                            echo $key > 0 ? " | " . $value : $value;
                                        }
                                    }
                                }
                                ?>
                            </div>
                        <?php }; ?>
                    </div>
                    <div class="meta">
                        <?php if ($all_meta) { ?>
                            <div class="author">
                                <span>
                                    <?php _e('שם היוצר :', 'winning-plan'); ?></span><span>
                                    <?php General::get_post_author($post_id); ?>
                            </div>
                        <?php } ?>
                        <div class="age">
                            <?php $age = get_field("field_621398326160f", $post_id); ?>
                            <?php if ($age) : ?>
                                <span>
                                    <?php _e('גיל :', 'winning-plan'); ?></span><span>
                                    <?php foreach ($age as $key => $value) {
                                        echo $key > 0 ? " | " . $value : $value;
                                    } ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($all_meta) { ?>
                            <div class="date">
                                <span>
                                    <?php _e('תאריך :', 'winning-plan'); ?></span><span>
                                    <?php echo get_the_date('d/m/y', $post_id) ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php return ob_get_clean(); ?>
    <?php
    }

    public function get_first_step_form($post_id, $name_class = '')
    {
        $current_step = get_field('step', $post_id); ?>
        <?php ob_start(); ?>
            <div class="<?php echo $name_class; ?>">
                <div class="header">
                    <div class="title">
                        <div class="number">1</div>
                        <h2>
                            <?php _e('טי התרגיל', 'winning-plan'); ?>
                        </h2>
                    </div>
                </div>
                <div class="content">
                        <div class="form">
                            <form id="form-first-step">
                                <div class="input">
                                    <label for="">
                                        <?php _e('שם התרגיל *:', 'winning-plan'); ?></label>
                                    <input type="text" placeholder="<?php _e('שם המערך...', 'winning-plan'); ?>" name="title" value="<?php echo $post_id ? get_the_title($post_id) : '' ?>">
                                </div>
                                <div class="textarea">
                                    <label for="description">
                                        <?php _e('תקציר* :', 'winning-plan'); ?></label>
                                    <textarea id="description" placeholder="<?php _e('שם המערך...', 'winning-plan'); ?>" name="description"><?php echo $post_id ? get_field('short-description', $post_id) : '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">
                                        <?php _e('גיל:', 'winning-plan'); ?></label>
                                    <div class="checkbox-group">
                                        <?php
                                        $field = get_field_object('field_621398326160f');
                                        $values = get_field('field_621398326160f', $post_id);
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
                                <div class="form-group">
                                    <label for="">
                                        <?php _e('סוג אימון:', 'winning-plan'); ?></label>
                                    <div class="types">
                                        <div class="radio-group">
                                            <div class="radio">
                                                <input checked type="radio" id="types-radio-all" name="type" value="">
                                                <label for="types-radio-all">
                                                    <?php _e('כללי - בחירה חופשית', 'winning-plan'); ?>
                                                </label>
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
                                <div class="form-group">
                                    <label for="">
                                        <?php _e('מטרה:', 'winning-plan'); ?></label>
                                    <div class="goals">
                                        <div class="checkbox-group">
                                            <?php $args = array(
                                                'taxonomy' => 'goal',
                                                'hide_empty' => false,
                                                'orderby' => 'id',
                                                'order' => 'ASC'
                                            );
                                            $terms = get_terms($args); ?>
                                            <?php
                                            $values = wp_get_object_terms($post_id, 'goal', array('fields' => 'ids'));
                                            ?>
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
                                    <div class="submit">
                                        <button type="submit" class="btn-blue trigger-save" data-step="1">
                                            <?php _e('המשך', 'winning-plan'); ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
           </div>
            <?php return ob_get_clean(); ?>
        <?php
    }

    public function get_training_session_box($post_id)
    {
        ob_start();
        $current_step = get_field('step', $post_id);
        $title = '';
        $section_drills = get_field('drill_step_list', $post_id);
        $number = 0;
        $duration_total = array(); ?>
            <div class="accordion">
                <div class="header">
                    <div class="title">
                        <div class="number">2</div>
                        <h2><?php _e('מאפייני תרגיל', 'winning-plan'); ?></h2>
                    </div>
                    <div class="arrow">
                        <i class="fal fa-angle-down"></i>
                    </div>

                    <button type="button" class="btn-transparent" data-step="2">
                        <span>
                            <?php _e('עריכה', 'winning-plan'); ?>
                        </span>
                        <i class="fa fa-pen"></i>
                    </button>
                </div>
                <div class="content">
                    <?php
                    if (is_array($section_drills)) {
                        foreach ($section_drills as $section) {
                            $number++;
                            if ($number == 4) {
                                $title = __('משחק מסכם', 'winning-plan');
                            } elseif ($number == 3) {
                                $title = __('עיקרי 2- מצבי משחק טקטיים', 'winning-plan');
                            } elseif ($number == 2) {
                                $title = __('עיקרי 1- משחקי צוות', 'winning-plan');
                            } else {
                                $title = __('מכין', 'winning-plan');
                            }

                            $duration_box = 0;
                            if (is_array($section["drills"])) {
                                foreach ($section["drills"] as $d) {
                                    $duration_box = $duration_box + strtotime($d['duration']);
                                }
                            }
                            $duration_box = date('H:i', $duration_box - strtotime("00:00:00"));
                            $duration_total[] = $duration_box;
                    ?>

                            <div class="session-box" data-number="<?php echo $number; ?>">
                                <div class="session-box__head">

                                        <div class="arrow"><i class="fal fa-angle-down"></i></div>

                                    <div class="player">
                                        <?php _e('שחקנים', 'winning-plan'); ?> <span>(0)</span></div>

                                        <a href="#" class="adding">
                                            <?php _e('הוספת תרגיל', 'winning-plan'); ?>
                                            <?php echo General::get_svg_file('plus'); ?>
                                        </a>

                                    <div class="duration">
                                        <?php echo General::get_svg_file('duration'); ?>
                                        <?php _e('משך זמן :', 'winning-plan'); ?>
                                        <span>
                                            <?php echo $duration_box; ?></span>
                                        <?php _e('דקות', 'winning-plan'); ?>
                                    </div>
                                    <div class="title">
                                        <?php _e('חלק', 'winning-plan'); ?>
                                        <?php echo $number; ?>
                                        <b>
                                            <?php echo $title; ?> </b>
                                    </div>
                                </div>
                                <div class="session-box__content">
                                    <?php
                                    if ($section["drills"]) {
                                        $cont = 0;
                                        foreach ($section["drills"] as $drill) {
                                            $cont++;
                                            $drill_id = $drill['drill'];
                                            $drill_image_id = get_post_thumbnail_id($drill_id);
                                            $drill_image_url = custom_image_url($drill_image_id, '320x180');
                                            $drill_duration = $drill['duration'];
                                            $drill_video = get_field('video', $drill_id);
                                            $class = '';
                                    ?>
                                            <div class="session-box__drill <?php echo $class ?>" data-order="<?php echo $cont ?>" data-id="<?php echo $drill_id; ?>">
                                                <div class="right">
                                                    <div class="meta">
                                                        <div class="meta-info">
                                                            <a class="shared" target="_blank" href="<?php echo get_permalink($drill_id); ?>">
                                                                <?php echo General::get_svg_file('shared'); ?>
                                                            </a>
                                                            <span>
                                                                <?php echo get_the_title($drill_id); ?>
                                                            </span>
                                                        </div>

                                                            <div class="meta-nav">
                                                                <a class="trash" href="#">
                                                                    <?php echo General::get_svg_file('trash'); ?>
                                                                </a>
                                                                <a class="order" href="#">
                                                                    <span data-guide="down">
                                                                        <?php echo General::get_svg_file('down'); ?></span>
                                                                    <span data-guide="up">
                                                                        <?php echo General::get_svg_file('up'); ?></span>
                                                                </a>
                                                            </div>

                                                    </div>
                                                    <div class="gallery">
                                                        <?php if ($drill_video) { ?>
                                                            <a data-fancybox href="https://vimeo.com/<?php echo $drill_video; ?>">
                                                                <img src="<?php echo $drill_image_url; ?>">
                                                            </a>
                                                        <?php } else { ?>
                                                            <img src="<?php echo $drill_image_url; ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="left">
                                                    <div class="drill-duration">
                                                        <?php echo General::get_svg_file('duration'); ?>
                                                        <?php _e('משך זמן :', 'winning-plan'); ?>
                                                        <?php
                                                        $durationList = ['00:10', '00:15', '00:20', '00:25', '00:30', '00:35', '00:40', '00:45', '00:50', '00:55', '01:00'];
                                                        ?>
                                                        <?php if ($current_step == 2) { ?>
                                                            <select name="drill-duration">
                                                                <?php
                                                                foreach ($durationList as $time) {
                                                                    if ($drill_duration == $time) {
                                                                        echo '<option selected  value="' . $time . '">' . $time . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $time . '">' . $time . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <i><?php echo $drill_duration; ?></i>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="tabs">
                                                        <div class="tabs-header">
                                                            <div class="tab active">
                                                                <?php _e('מטרות'); ?>
                                                            </div>
                                                            <div class="tab">
                                                                <?php _e('מבנה'); ?>
                                                            </div>
                                                            <div class="tab">
                                                                <?php _e('הסבר'); ?>
                                                            </div>
                                                            <div class="tab">
                                                                <?php _e('דגשים'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="tabs-content">
                                                            <div class="tab-content active">
                                                                <?php the_field('description_goals', $drill_id); ?>
                                                            </div>
                                                            <div class="tab-content">
                                                                <?php the_field('description_building', $drill_id); ?>
                                                            </div>
                                                            <div class="tab-content">
                                                                <?php the_field('description_explanation', $drill_id); ?>
                                                            </div>
                                                            <div class="tab-content">
                                                                <?php the_field('description_emphasis', $drill_id); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <div class="empty">
                                            <span>
                                                <?php _e('עדיין לא נוספו תרגילים', 'winning-plan'); ?></span>
                                            <img src="<?php echo THEME_DIR; ?>/images/session-empty.png">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    $duration_total_time = 0;
                    if (is_array($duration_total)) {
                        foreach ($duration_total as $time) {
                            $duration_total_time = $duration_total_time + strtotime($time);
                        }
                    }
                    $duration_total_time = date('H:i', $duration_total_time - strtotime("00:00:00"));
                    ?>

                        <div class="session-box__add">
                            <a class="btn-blue" href="#">
                                <?php _e('הוספת העשרה', 'winning-plan'); ?>
                                <?php echo General::get_svg_file('plus'); ?>
                            </a>
                        </div>

                    <div class="session-box__total">
                        <div class="duration">
                            <?php echo General::get_svg_file('duration'); ?>
                            <?php _e('משך זמן כולל:', 'winning-plan'); ?>
                            <span>
                                <?php echo $duration_total_time; ?>
                            </span>
                            <b>
                                <?php _e('שעות', 'winning-plan'); ?></b>
                        </div>
                    </div>


                        <div class="save">
                            <a href="#" class="btn-blue trigger-save" data-step="2">
                                <?php _e('המשך', 'winning-plan'); ?>
                            </a>
                        </div>

                </div>
            </div>
    <?php return ob_get_clean();
    }
}

$General = General::get_instance();
