<?php

/**
 * Create Drill Class
 */
class CreateDrill extends General
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
        $this->wp_ajax_action('edit_post');
        $this->wp_ajax_action('first_step_filter_type');
        $this->wp_ajax_action('first_step_submit');
        $this->wp_ajax_action('second_step_filter_categories_first_step_view');
        $this->wp_ajax_action('second_step_submit');
        $this->wp_ajax_action('third_step_submit');
        $this->wp_ajax_action('fouth_step_submit');
    }


    public static function get_instance()
    {
        // Check is $_instance has been set
        if (!isset(self::$instance)) {
            // Creates sets object to instance
            self::$instance = new CreateDrill();
        }

        // Returns the instance
        return self::$instance;
    }


    public function first_step_filter_type()
    {
        if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
            ob_start();

            $type = isset($_POST['type']) ? $_POST['type'] : null;
            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;

            $meta_query = array();



            if ($type) {
                $meta_query[] = array(
                    'key' => 'type',
                    'value' => $type,
                    'compare' => 'LIKE'
                );
            }

            $args = array(
                'taxonomy' => 'goal',
                'hide_empty' => false,
            );

            if ($meta_query) {
                $args['meta_query'] = $meta_query;
            }


            $terms = get_terms($args); ?>
            <?php if ($post_id) : ?>
                <?php $values = wp_get_object_terms($post_id, 'goal', array('fields' => 'ids')); ?>
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
            <?php else : ?>
                <?php foreach ($terms as $term) : ?>
                    <div class="checkbox">
                        <input type="checkbox" id="<?php echo $term->slug ?>" name="goal[]" value="<?php echo $term->term_id ?>">
                        <label for="<?php echo $term->slug ?>">
                            <?php echo $term->name ?></label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php wp_die(); ?>
            <?php return ob_get_clean(); ?>
        <?php
        }
    }



    public function edit_post()
    {
        if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {

            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
            $step = isset($_POST['step']) ? $_POST['step'] : null;

            update_user_meta($user_id, 'current_post_id', $post_id);
            update_field('step', $step, $post_id);

            return $step;
        }
    }




    public function first_step_submit()
    {
        if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
            $step = isset($_POST['step']) ? $_POST['step'] : null;


            if ($_POST['form']) {
                $form_parse = isset($_POST['form']) ? $_POST['form'] : null;
                parse_str($form_parse, $form);
            }


            $goals = array_map('intval', $form['goal']);
            $type = intval($form['type']);



            if ($post_id) {

                $post_data = array(
                    'ID' => $post_id,
                    'post_type' => 'drill',
                    'post_title' => sanitize_text_field($form['title']),
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                );

                wp_update_post($post_data);

                update_field('short-description', $form['description'], $post_id);

                update_field('age', $form['age'], $post_id);

                wp_set_object_terms($post_id, $type, 'type');

                wp_set_object_terms($post_id, $goals, 'goal');

                update_user_meta($user_id, 'current_post_id', $post_id);

                update_field('step', $step, $post_id);

                wp_send_json($post_id);
            } else {

                $post_data = array(
                    'post_type' => 'drill',
                    'post_title' => sanitize_text_field($form['title']),
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                );


                $new_post_id = wp_insert_post($post_data);

                update_field('short-description', $form['description'], $new_post_id);

                update_field('age', $form['age'], $new_post_id);

                wp_set_object_terms($new_post_id, $type, 'type');

                wp_set_object_terms($new_post_id, $goals, 'goal');

                update_user_meta($user_id, 'current_post_id', $new_post_id);

                update_field('step', $step, $new_post_id);

                wp_send_json($new_post_id);
            }
        }
    }

    public function first_step_view($post_id = '')
    {

        ob_start(); ?>
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
                        <?php $categories = wp_get_object_terms($post_id, 'drills_сategory', array('fields' => 'names')); ?>
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
                                <?php the_author($post_id) ?></span>
                        </div>
                        <div class="age">
                            <?php $age = get_field("field_621398326160f", $post_id); ?>
                            <?php if ($age) : ?>
                                <span>גיל : </span><span>
                                    <?php foreach ($age as $key => $value) {
                                        echo $key > 0 ? " | " . $value : $value;
                                    } ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="date">
                            <span>תאריך :</span><span>
                                <?php echo get_the_date('d/m/y', $post_id) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php return ob_get_clean(); ?>
<?php


    }


    public function second_step_filter_categories_first_step_view()
    {
        if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {

            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;

            $type = wp_get_object_terms($post_id, 'type', array('fields' => 'names'));
            $goal = wp_get_object_terms($post_id, 'goal', array('fields' => 'ids'));
            $drills_сategory = wp_get_object_terms($post_id, 'drills_сategory', array('fields' => 'ids'));

            $categories = $this->get_drills_categories(0, '', $goal, $drills_сategory);

            $first_step_view = $this->first_step_view($post_id);

            $return = array(
                'first_step_view' => $first_step_view,
                'categories' => $categories
            );

            wp_send_json($return);
        }
    }



    public function second_step_submit()
    {
        if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {

            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
            $step = isset($_POST['step']) ? $_POST['step'] : null;

            if (isset($_POST['form'])) {
                parse_str($_POST['form'], $form);
            }

            $terms_to_nubers = array();
            $arrays_merged = array();

            foreach ($form as $array) {
                $arrays_merged = array_merge($arrays_merged, $array);
            }

            foreach ($arrays_merged as $value) {
                array_push($terms_to_nubers, intval($value));
            }


            update_field('step', $step, $post_id);
            wp_set_object_terms($post_id, $terms_to_nubers, 'drills_сategory');

            wp_die();
        }
    }


    public function third_step_submit()
    {
        if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {


            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
            $step = isset($_POST['step']) ? $_POST['step'] : null;
            $file = $_FILES['file'];


            if ($file) {

                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');

                $attachment_id = media_handle_upload('file', $post_id);

                if ($attachment_id) {
                    set_post_thumbnail($post_id, $attachment_id);
                }
                update_field('step', $step, $post_id);
            }

            $thumbnail = get_the_post_thumbnail($post_id);
            wp_send_json($thumbnail);
        }
    }


    public function fouth_step_submit()
    {

        if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {

            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
            $step = isset($_POST['step']) ? $_POST['step'] : null;

            if (isset($_POST['form'])) {
                parse_str($_POST['form'], $form);
            }

            $description_goals = isset($form['description-goals']) ? $form['description-goals'] : null;
            $description_building = isset($form['description-building']) ? $form['description-building'] : null;
            $description_explanation = isset($form['description-explanation']) ? $form['description-explanation'] : null;
            $description_emphasis = isset($form['description-emphasis']) ? $form['description-emphasis'] : null;
            $video_url_animation = isset($form['video-url-animation']) ? $form['video-url-animation'] : null;
            $video_url = isset($form['video-url']) ? $form['video-url'] : null;
            $site_url = isset($form['site-url']) ? $form['site-url'] : null;
            $video_url_for_game = isset($form['video-url-for-game']) ? $form['video-url-for-game'] : null;
            $site_url_for_game = isset($form['site-url-for-game']) ? $form['site-url-for-game'] : null;




            update_field('description_goals', $description_goals, $post_id);
            update_field('description_building', $description_building, $post_id);
            update_field('description_explanation', $description_explanation, $post_id);

            if (is_array($description_emphasis)) {
                $rows = [];
                foreach ($description_emphasis as $value) {
                    $row = array("title" => $value);
                    array_push($rows, $row);
                }
            }
            update_field('description_emphasis', $rows,  $post_id);

            $video_animation = array(
                'video_url_animation'    =>    $video_url_animation,
            );
            update_field('video_animation', $video_animation, $post_id);

            $video = array(
                'video_url'    =>    $video_url,
                'site_url'    =>    $site_url,
            );
            update_field('video', $video, $post_id);

            $video_for_game = array(
                'video_url_for_game'    =>    $video_url_for_game,
                'site_url_for_game'    =>    $site_url_for_game,
            );
            update_field('video_for_game', $video_for_game, $post_id);

            update_field('step', $step, $post_id);


            wp_die();
        }
    }
}

$CreateDrill =  CreateDrill::get_instance();
