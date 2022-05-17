<?php

function update_post_training()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $type = $_POST['type'];
        $goal = $_POST['goal'];
        $training_data = array(
            'post_type' => 'training',
            'post_title' => sanitize_text_field($_POST['title']),
            'post_status' => 'publish',
            'post_author' => $_POST['user_id'],
        );
        $training_id = $_POST['training_id'];

        if ($training_id) {
            $training_data['ID'] = $training_id;
            $training_id = wp_update_post(wp_slash($training_data));
            $data = array(
                'status' => true,
                'message' => __('Congratulations on a successfully created workout.', 'winning_plan'),
                'training_id' => $training_id,
                'step'    => 2
            );
        } else {
            $training_id = wp_insert_post($training_data);
            $data = array(
                'status' => true,
                'message' => __('Congratulations workout successfully updated.', 'winning_plan'),
                'training_id' => $training_id,
                'step'    => 2
            );
        }

        $category_ids = General::get_drills_categories_ids(0, $type, $goal);
        if ($category_ids) {
            wp_set_post_terms($training_id, $category_ids, 'drills_сategory');
        }
        if ($type) {
            wp_set_post_terms($training_id, $type, 'type');
        }
        if ($goal) {
            wp_set_post_terms($training_id, $goal, 'goal');
        }
        if ($_POST['age']) {
            update_field('age', $_POST['age'], $training_id);
        }
        if ($_POST['age']) {
            update_field('short-description', $_POST['description'], $training_id);
        }

        update_user_meta(get_current_user_id(), 'current_edit_training_id', $training_id);
        update_field('step', '2', $training_id);

        if(!get_field('drill_step_list', $training_id)){
            delete_field('drill_step_list', $training_id);
            for ($i = 1; $i <= 4; $i++) {
                add_row('drill_step_list', array(), $training_id);
            }
        }

        $data['result'] = General::get_training_session_box($training_id);

    } else {
        $data = array(
            'status'  => false,
            'message' => __('Nonce code in correctly', 'winning_plan'),
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_update_post_training', 'update_post_training');

function update_session_boxes()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $training_id = $_POST['training_id'];
        $sessionBoxes = $_POST['sessionBoxes'];


        if ($_POST['actionSession'] != 'edit') {
            delete_field('drill_step_list', $training_id);
            for ($i = 1; $i <= 4; $i++) {
                add_row('drill_step_list', array(), $training_id);
            }

            if ($sessionBoxes) {
                foreach ($sessionBoxes as $sessionBox) {
                    foreach ($sessionBox as $box) {
                        $value = array(
                            'drill' => $box['drillId'],
                            'duration' => $box['duration']
                        );
                        add_sub_row(array('drill_step_list', $box['number'], 'drills'), $value, $training_id);
                    }
                }
            }
        }

        $data = array(
            'status' => true,
        );

        if ($_POST['actionSession'] == 'sort') {
            $data['message'] = __('Sorting exercises for training is done.', 'winning_plan');
            wp_send_json_success($data);
        }

        if ($_POST['actionSession'] == 'trash') {
            $data['message'] = __('Exercise removed from session.', 'winning_plan');
            //$data['result'] = General::get_training_session_box($training_id);
            wp_send_json_success($data);
        }

        if ($_POST['actionSession'] == 'update') {
            update_field('step', 2, $training_id);
            $data['message'] = __('Training data updated.', 'winning_plan');
            $data['result'] = General::get_training_session_box($training_id);
            $data['step'] = 2;
            wp_send_json_success($data);
        }

        if ($_POST['actionSession'] == 'edit') {
            update_field('step', 2, $training_id);
            $data['message'] = __('', 'winning_plan');
            $data['result'] = General::get_training_session_box($training_id);
            $data['step'] = 2;
            wp_send_json_success($data);
        }

        if ($_POST['actionSession'] == 'save') {
            update_field('step', 3, $training_id);
            $data['message'] = __('The structure of the training was successfully preserved.', 'winning_plan');
            $data['result'] = General::get_training_session_box($training_id);
            $data['step'] = 3;
            wp_send_json_success($data);
        }

    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in correctly.', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_update_session_boxes', 'update_session_boxes');

function update_session_construction_info()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $training_id = $_POST['training_id'];

        if($_POST['data']) {
            update_field('data', $_POST['data'], $training_id);
        }

        if($_POST['time']) {
            update_field('time', $_POST['time'], $training_id);
        }

        if($_POST['players'] == 'true') {
            update_field('players', true, $training_id);
        } else {
            update_field('players', false, $training_id);
        }

        $data = array(
            'status' => true,
            'message' => __('Update session info.', 'winning_plan')
        );
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in correctly.', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_update_session_construction_info', 'update_session_construction_info');