<?php

// Ajax funcion register
// Shortcode ajax register

function action_auth_ajax_register()
{
    if (wp_verify_nonce($_POST['security'], LEARNING_NONCE_CODE)) {
        $first_name = stripcslashes($_POST['first_name']);
        $last_name = stripcslashes($_POST['last_name']);
        $timezone_user = $_POST['timezone_string'];
        $user_email = $_POST['user_email'];
        $user_login = $user_email;
        $parental_user_email = $_POST['parental_user_email'];
        $subscription_plan = $_POST['subscription_plan'];

        if (email_exists($user_email)) {
            $data = array(
                'status' => false,
                'message' => __('This email is already registered. Please use another one', 'winning_plan')
            );
            wp_send_json_success($data);
        }

        if ($_POST['password']) {
            $random_password = $_POST['password'];
        } else {
            $random_password = wp_generate_password(15, false);
        }

        $user_data = array(
            'user_login' => $user_login,                                              // required
            'user_email' => $user_email,
            'display_name' => $first_name . $last_name,
            'role' => 'student',   // student    // teacher
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_pass' => $random_password,                                          // required
        );

        $user_id = wp_insert_user($user_data);

        if (!is_wp_error($user_id)) {

            // Update field new user - form registration
            update_user_meta($user_id, 'show_admin_bar_front', 'false');
            update_user_meta($user_id, 'random_pas', $random_password);
            update_user_meta($user_id, 'timezone_user', $timezone_user);
            update_user_meta($user_id, 'parental_user_email', $parental_user_email);
            update_user_meta($user_id, 'subscription_plan', $subscription_plan);

            $headers = wp_mail_headers();
            // send email to new register user
            $to_user = $user_email;
            $subject_user = __('Thank you for registering', 'winning_plan');
            $message_user = __('Login details', 'winning_plan');
            $message_user .= '<br><b>' . __('Login:', 'winning_plan') . '</b> - ' . $user_login . ' ';
            $message_user .= '<br><b>' . __('Password:', 'winning_plan') . '</b> - ' . $random_password . ' ';
            wp_mail($to_user, $subject_user, $message_user, $headers);

            $authenticate_data = array(
                'user_login' => $user_login,
                'user_password' => $random_password,
                'remember' => true,
            );
            $authenticate_user = wp_signon($authenticate_data, false);

            if (is_wp_error($authenticate_user)) {
                $data = array(
                    'status' => false,
                    'message' => $authenticate_user->get_error_message()
                );
            } else {
                $data = array(
                    'status' => true,
                    'message' => __('Thank you. You have successfully registered.', 'winning_plan')
                );
            }
        } else {
            $data = array(
                'status' => false,
                'message' => $user_id->get_error_message(),
                'data' => $user_data
            );
        }
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_nopriv_action_auth_ajax_register', 'action_auth_ajax_register');
add_action('wp_ajax_action_auth_ajax_register', 'action_auth_ajax_register');


function check_user_email_callback()
{

    $users_emails = email_exists($_POST['email']);
    if ($users_emails == false) {
        echo '';
    } else {
        echo __('This email is already registered. Please use another one', 'winning_plan');
    }

    die;
}

add_action('wp_ajax_check_user_email_callback', 'check_user_email_callback');
add_action('wp_ajax_nopriv_check_user_email_callback', 'check_user_email_callback');

function auth_form_register_progress($step)
{
    $class_1 = 'active';
    $class_2 = '';
    $class_3 = '';

    if ($step == 2) {
        $class_1 = 'active';
        $class_2 = 'active';
        $class_3 = '';
    }
    if ($step == 3) {
        $class_1 = 'active';
        $class_2 = 'active';
        $class_3 = 'active';
    }

    return '
        <div class="register-progress">
             <span class="register-progress__item ' . $class_1 . '">1</span>
             <span class="register-progress__liner ' . $class_2 . '"></span>
             <span class="register-progress__item ' . $class_2 . '">2</span>
             <span class="register-progress__liner ' . $class_3 . '"></span>
             <span class="register-progress__item ' . $class_3 . '">3</span>
        </div>';
}


function auth_form_register()
{

    $timezone = wp_timezone();
    $selected_zone = $timezone->getName(); // wp_timezone_string()
    $locale = get_locale();


    if (!is_user_logged_in()) {
        if (isset($_GET["plan"])) {
            $plan = $_GET["plan"];
        } else {
            $plan = 'classic';
        }

        if ($_GET["age"] == 'under') {
            $parental_email = '<div class="group-item  w-50">
                <label class="title">' . __('Parental e-mail', 'winning_plan') . '</label>
                <input placeholder="' . __('example@mail.com', 'winning_plan') . '" id="parental_user_email" type="email" class="form-control" name="parental_user_email" autocomplete="off" >
            </div>';
        } else {
            $parental_email = '';
        }

        $html = '
            <div class="auth__register" xmlns="http://www.w3.org/1999/html">     
            
              ' . apply_filters('auth_before_form_register_action', '') . '
              ' . auth_form_register_progress('1') . ' 
                <form id="auth__register" action="" method="post">
                    <input type="hidden" name="subscription_plan" autocomplete="off" value="' . $plan . '">
                    <p class="status"></p>
                    <div class="group-row">
                        <div class="group-item w-50">
                            <label class="title">' . __('First name', 'winning_plan') . '</label>
                            <input placeholder="' . __('Enter your first name', 'winning_plan') . '" type="text" class="form-control" name="first_name" autocomplete="off" required="">
                        </div>
                        <div class="group-item w-50">
                            <label class="title">' . __('Last name', 'winning_plan') . '</label>
                            <input placeholder="' . __('Enter your last name', 'winning_plan') . '" type="text" class="form-control" name="last_name" autocomplete="off" required="">
                        </div>
                    </div>
                     <div class="group-row">
                        ' . $parental_email . '
                        <div class="group-item '.void_check_class($parental_email, 'w-50').'">
                            <label class="title">' . __('E-mail', 'winning_plan') . '</label>
                            <input placeholder="' . __('example@mail.com', 'winning_plan') . '" id="user_email" type="email" class="form-control" name="user_email" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="group-item">
                        <label class="title">' . __('Password', 'winning_plan') . '</label>
						<input placeholder="' . __('Should consist of at least of 8 characters', 'winning_plan') . '" type="password" class="form-control" name="password" autocomplete="off" required="">
                        <span class="show-password">
                            <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g fill="#233537"><path d="M10.287 8c0 1.289-.95 2.333-2.123 2.333C6.99 10.333 6.04 9.29 6.04 8c0-1.289.95-2.333 2.123-2.333 1.172 0 2.123 1.044 2.123 2.333Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.164 2.333c-2.082 0-3.715 1.023-4.885 2.16-1.168 1.136-1.9 2.408-2.194 2.975a1.16 1.16 0 0 0 0 1.065c.294.566 1.026 1.838 2.194 2.973 1.17 1.138 2.803 2.16 4.885 2.16s3.715-1.022 4.885-2.16c1.168-1.135 1.9-2.407 2.194-2.973a1.16 1.16 0 0 0 0-1.065c-.294-.567-1.026-1.839-2.194-2.974-1.17-1.138-2.803-2.16-4.885-2.16Zm-6.289 5.63c.268-.516.941-1.685 2.006-2.72 1.063-1.033 2.49-1.91 4.283-1.91 1.792 0 3.22.877 4.282 1.91 1.065 1.035 1.739 2.204 2.006 2.72.008.015.01.028.01.037 0 .01-.002.022-.01.037-.268.516-.94 1.685-2.006 2.72-1.062 1.033-2.49 1.91-4.282 1.91-1.793 0-3.22-.877-4.283-1.91-1.065-1.035-1.738-2.204-2.006-2.72A.08.08 0 0 1 1.865 8a.08.08 0 0 1 .01-.037Z"/></g></svg>
                        </span>
                    </div>
                    <div class="group-item">
                        <label class="title current-time__box">
                            ' . __('Time zone:', 'winning_plan') . '
                            <span>
                            ' . __('Current time ', 'winning_plan') . '
                            ' . date('G:i') . '    
                            </span>
                        </label>
                        <select id="timezone_string" name="timezone_string" aria-describedby="timezone-description">
                            ' . wp_timezone_choice($selected_zone, $locale) . '
                        </select>
                    </div>
                    <div class="group-informer">
                       <label class="group-item__checkbox indentation">
                            <input required="" name="privacy_policy" type="checkbox" id="privacy_policy"  value="">
                            <span>
                                 ' . __('By continuing you agree to our ', 'winning_plan') . '
                                <a target="blank" href="' . get_the_permalink(get_learning_option('terms_of_service')) . '">
                                    ' . __('Terms of Service', 'winning_plan') . '</a> 
                                    ' . __('and', 'winning_plan') . '
                                <a target="blank" href="' . get_the_permalink(get_learning_option('privacy_policy')) . '">
                                    ' . __('Privacy Policy', 'winning_plan') . '
                                </a>
                            </span>
                        </label>
                    </div>
                    <div class="group-btn">
                        <button>' . __('Register', 'winning_plan') . '</button>
                    </div>
                </form>
                
                ' . apply_filters('auth_after_form_register_action', '') . '
                
                <div class="group-description">
                    ' . __('Already have an account?', 'winning_plan') . '
                    <a href="' . get_the_permalink(get_learning_option('login_page')) . '">
                        ' . __('Sign In', 'winning_plan') . '
                    </a>
                </div>
                
            </div>';
    } else {
        $html = '<div class="auth__message"><p>' . __('The registration form is available to users who are not logged in.', 'winning_plan') . '</p><a class="auth__btn" href="' . wp_logout_url(home_url()) . '">' . __('Logout', 'winning_plan') . '</a></div>';
    }
    return $html;
}

add_shortcode('auth-register', 'auth_form_register');