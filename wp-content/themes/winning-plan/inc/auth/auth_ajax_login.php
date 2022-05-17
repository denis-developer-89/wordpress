<?php

define("FARGOT_URL", '#fargot');
define("AUTH_URL", '#fargot');
define("REGISTER_URL", '#fargot');

function create_authorization_code($user_id)
{
    $random_authorization_code = wp_rand(1000, 9999);
    update_user_meta($user_id, 'authorization_code', $random_authorization_code);

    $user_data = get_userdata($user_id);
    $to = $user_data->user_email;

    $subject = __('קוד לכניסה למערכת', 'winning_plan');
    $template_message = winning_plan_email_header();
    $template_message .= winning_plan_email_body('<div style="text-align: center; font-size:18px;line-height:28px;letter-spacing:0.01em;color:#091932">' . __('קוד הכניסה שלך לאתר הוא', 'winning_plan') . '<div style="text-align: center; font-weight: bold; font-size: 24px; padding: 15px 0">' . $random_authorization_code . '</div>');
    $template_message .= winning_plan_email_footer();

    winning_plan_email_send($to, $subject, $template_message);
}

function action_auth_ajax_login()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $info = array();
        $info['user_login'] = $_POST['username'];
        $info['user_password'] = $_POST['password'];
        $info['remember'] = true;

        $auth = wp_authenticate($_POST['username'], $_POST['password']);

        $html_step2 = '
                <input type="hidden" value="true" name="step_2">
                <p>
                    ' . __('קוד לכניסה למערכת. ברגעים אלו נשלח לכתובת המייל הרשומה', 'winning_plan') . '
                </p>
                <div style="text-align: center">
                    <a href="#" class="send-new-code" data-user="' . $auth->ID . '">
                        ' . __('לא קיבלתי, שלחו לי שוב', 'winning_plan') . '
                    </a>
                </div>
                <div class="auth__login-code">
                    <span>
                        <input maxlength="1" id="code-text-1" class="input_text" type="text" name="code-text-1" />
                    </span>
                    <span>
                        <input maxlength="1" id="code-text-2" class="input_text" type="text" name="code-text-2" />
                    </span>
                    <span>
                        <input maxlength="1" id="code-text-3" class="input_text" type="text" name="code-text-3" />
                    </span>
                    <span>
                        <input maxlength="1" id="code-text-4" class="input_text" type="text" name="code-text-4" />
                    </span>
                </div>
                
                <div class="status code">' . __('תלביקש דוק סנכה', 'winning_plan') . '</div>
                
                <div class="group-item center">
                    <div class="group-btn">
                        <button>' . __('כניסה', 'winning_plan') . '</button>
                    </div>
                </div>
        ';

        if (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
            if (email_exists($_POST['username'])) {
            } else {
                $data = array(
                    'status' => false,
                    'message' => __('שם משתמש לא קיים', 'winning_plan'),
                    'error' => 'username',
                    'error_class' => 'login-error',
                );
                wp_send_json_success($data);
            }
        } else {
            if (username_exists($_POST['username'])) {

            } else {
                $data = array(
                    'status' => false,
                    'message' => __('שם משתמש לא קיים', 'winning_plan'),
                    'error' => 'username',
                    'error_class' => 'login-error',
                );
                wp_send_json_success($data);
            }
        }

        if (is_wp_error($auth)) {
            $data = array(
                'status' => false,
                'message' => __('סיסמה שגויה', 'winning_plan'),
                'error' => 'password',
                'error_class' => 'password-error',
            );
        } else {
            if ($_POST['step_2'] && $_POST['code-resending'] == 'false') {
                $front_code_user = $_POST['code-text-1'] . $_POST['code-text-2'] . $_POST['code-text-3'] . $_POST['code-text-4'];
                $ver_code_user = get_user_meta($auth->ID, 'authorization_code', true);
                if ($ver_code_user == $front_code_user) {
                    wp_signon($info, false);
                    $data = array(
                        'status' => true,
                        'message' => __('בסדר גמור! מתבצע ניתוב מחדש...', 'winning_plan'),
                    );
                } else {
                    $data = array(
                        'status' => false,
                        'message' => __('קוד שגוי', 'winning_plan'),
                        'error' => 'auth_code',
                        'error_class' => 'code-error',
                        'step_2' => $html_step2
                    );
                }
            } else {
                // role administrator
                $user_meta = get_userdata($auth->ID);
                $user_roles = $user_meta->roles;
                //var_dump_pre($user_roles);
                if(in_array("administrator", $user_roles)){
                    wp_signon($info, false);
                    $data = array(
                        'status' => true,
                        'message' => __('בסדר גמור! מתבצע ניתוב מחדש...', 'winning_plan'),
                    );
                } else {
                    create_authorization_code($auth->ID);
                    $data = array(
                        'status' => false,
                        'message' => __('תלביקש דוק סנכה', 'winning_plan'),
                        'step_2' => $html_step2
                    );
                }
            }
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

add_action('wp_ajax_nopriv_action_auth_ajax_login', 'action_auth_ajax_login');
add_action('wp_ajax_action_auth_ajax_login', 'action_auth_ajax_login');

function auth_form_login()
{
    if (!is_user_logged_in()) {
        $html = '
            ' . apply_filters('auth_before_form_login_action', '') . '
            <div class="auth__login">
                <form id="auth__login" action="login" method="post">
                    <input id="code-resending" type="hidden" name="code-resending" value="false">
                    <div class="auth__login-step-1">
                        <div class="group-item">  
                            <input id="username" class="input_text" type="text" placeholder="' . __('Email address', 'winning_plan') . '" name="username" />
                        </div>
                        <div class="group-item">
                            <input id="password" class="input_text" type="password" placeholder="' . __('Password', 'winning_plan') . '" name="password" />
                            <span class="show-password">
                                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g fill="#233537"><path d="M10.287 8c0 1.289-.95 2.333-2.123 2.333C6.99 10.333 6.04 9.29 6.04 8c0-1.289.95-2.333 2.123-2.333 1.172 0 2.123 1.044 2.123 2.333Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.164 2.333c-2.082 0-3.715 1.023-4.885 2.16-1.168 1.136-1.9 2.408-2.194 2.975a1.16 1.16 0 0 0 0 1.065c.294.566 1.026 1.838 2.194 2.973 1.17 1.138 2.803 2.16 4.885 2.16s3.715-1.022 4.885-2.16c1.168-1.135 1.9-2.407 2.194-2.973a1.16 1.16 0 0 0 0-1.065c-.294-.567-1.026-1.839-2.194-2.974-1.17-1.138-2.803-2.16-4.885-2.16Zm-6.289 5.63c.268-.516.941-1.685 2.006-2.72 1.063-1.033 2.49-1.91 4.283-1.91 1.792 0 3.22.877 4.282 1.91 1.065 1.035 1.739 2.204 2.006 2.72.008.015.01.028.01.037 0 .01-.002.022-.01.037-.268.516-.94 1.685-2.006 2.72-1.062 1.033-2.49 1.91-4.282 1.91-1.793 0-3.22-.877-4.283-1.91-1.065-1.035-1.738-2.204-2.006-2.72A.08.08 0 0 1 1.865 8a.08.08 0 0 1 .01-.037Z"/></g></svg>
                            </span>
                        </div>
                        <div class="status"></div>
                        <div class="group-item fargot">
                            <a href="' . FARGOT_URL . '">
                            ' . __('Forgot password?', 'winning_plan') . '
                            </a>
                        </div>
                        <div class="group-row">
                            <div class="group-item w-50">
                                 <label class="group-item__checkbox ">
                                    <input name="rememberme" type="checkbox" id="my-rememberme" checked="checked" value="forever" />
                                    <span>' . __('Remember me', 'winning_plan') . '</span>
                                </label>
                            </div>
                            <div class="group-item w-50">
                                <div class="group-btn">
                                    <button>' . __('Log In', 'winning_plan') . '</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="auth__login-step-2">
                        
                    </div>
                </form>
                
                  ' . apply_filters('auth_after_form_login_action', '') . '
                    
            </div>';
    } else {
        $html = '<div class="auth__message">
                    <p>' . __('The log in form is available to users who are not logged in.', 'winning_plan') . '</p>
                    <a class="btn-wrapper small" href="' . wp_logout_url(home_url()) . '">' . __('Logout', 'winning_plan') . '</a>
                    <div class="create-navs">
                        <a class="green" href="'. get_home_url() .'/create-drill">
                            ' . __('יצירת תרגיל', 'winning_plan')  .'
                        </a>
                         <a class="blue" href="'. get_home_url() .'/create-training">
                              ' . __('יצירת מערך אימון', 'winning_plan')  .'
                         </a>
                    </div>
                 </div>';
    }

    return $html;
}

add_shortcode('auth-login', 'auth_form_login');