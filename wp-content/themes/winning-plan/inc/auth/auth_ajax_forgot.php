<?php

// Shortcode ajax forgot 
// Ajax funcion forgot 
// Ajax funcion forgot - approve

function auth_form_forgot()
{
   
        if (isset($_GET["forgot_key"]) && $_GET["forgot_key"] == get_user_meta($_GET["user_id"], 'forgot_key', true)) {
            // Create new password
            $html = '
        <div class="auth__forgot">
             <div class="title">' . __('Create new password', 'winning_plan') . '</div>
             <form id="auth__forgot" action="login" method="post">  
                <p class="status"></p>
                <input type="hidden" class="form-control" name="user_id" autocomplete="off" value="' . $_GET["user_id"] . '" required="">
                <div class="group-item">
                    <label class="title">' . __('New password', 'winning_plan') . '</label>
                    <input type="password" class="form-control" name="password" autocomplete="off" required="">
                    <span class="show-password">
                        <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g fill="#233537"><path d="M10.287 8c0 1.289-.95 2.333-2.123 2.333C6.99 10.333 6.04 9.29 6.04 8c0-1.289.95-2.333 2.123-2.333 1.172 0 2.123 1.044 2.123 2.333Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.164 2.333c-2.082 0-3.715 1.023-4.885 2.16-1.168 1.136-1.9 2.408-2.194 2.975a1.16 1.16 0 0 0 0 1.065c.294.566 1.026 1.838 2.194 2.973 1.17 1.138 2.803 2.16 4.885 2.16s3.715-1.022 4.885-2.16c1.168-1.135 1.9-2.407 2.194-2.973a1.16 1.16 0 0 0 0-1.065c-.294-.567-1.026-1.839-2.194-2.974-1.17-1.138-2.803-2.16-4.885-2.16Zm-6.289 5.63c.268-.516.941-1.685 2.006-2.72 1.063-1.033 2.49-1.91 4.283-1.91 1.792 0 3.22.877 4.282 1.91 1.065 1.035 1.739 2.204 2.006 2.72.008.015.01.028.01.037 0 .01-.002.022-.01.037-.268.516-.94 1.685-2.006 2.72-1.062 1.033-2.49 1.91-4.282 1.91-1.793 0-3.22-.877-4.283-1.91-1.065-1.035-1.738-2.204-2.006-2.72A.08.08 0 0 1 1.865 8a.08.08 0 0 1 .01-.037Z"/></g></svg>
                    </span>
                </div>
                <div class="group-item">
                    <label class="title">' . __('Confirm password', 'winning_plan') . '</label>
                    <input type="password" class="form-control" name="confirm_password" autocomplete="off" required="">
                    <span class="show-password">
                        <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g fill="#233537"><path d="M10.287 8c0 1.289-.95 2.333-2.123 2.333C6.99 10.333 6.04 9.29 6.04 8c0-1.289.95-2.333 2.123-2.333 1.172 0 2.123 1.044 2.123 2.333Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.164 2.333c-2.082 0-3.715 1.023-4.885 2.16-1.168 1.136-1.9 2.408-2.194 2.975a1.16 1.16 0 0 0 0 1.065c.294.566 1.026 1.838 2.194 2.973 1.17 1.138 2.803 2.16 4.885 2.16s3.715-1.022 4.885-2.16c1.168-1.135 1.9-2.407 2.194-2.973a1.16 1.16 0 0 0 0-1.065c-.294-.567-1.026-1.839-2.194-2.974-1.17-1.138-2.803-2.16-4.885-2.16Zm-6.289 5.63c.268-.516.941-1.685 2.006-2.72 1.063-1.033 2.49-1.91 4.283-1.91 1.792 0 3.22.877 4.282 1.91 1.065 1.035 1.739 2.204 2.006 2.72.008.015.01.028.01.037 0 .01-.002.022-.01.037-.268.516-.94 1.685-2.006 2.72-1.062 1.033-2.49 1.91-4.282 1.91-1.793 0-3.22-.877-4.283-1.91-1.065-1.035-1.738-2.204-2.006-2.72A.08.08 0 0 1 1.865 8a.08.08 0 0 1 .01-.037Z"/></g></svg>
                    </span>
                </div>
                <div class="group-btn">
                    <button>' . __('Create password', 'winning_plan') . '</button>
                </div>
            </form>
        </div>';
        } else {
            // Forgot password
            $html = '
        <div class="auth__forgot">
            <div class="description">' . __('Please enter your email, and we will send you a link to create a new password', 'winning_plan') . '</div>
            <form id="auth__forgot" action="login" method="post">  
                <p class="status"></p>
                <div class="group-item">
                    <label class="title">' . __('Email', 'winning_plan') . '</label>
                    <input id="user_email" type="email" class="form-control" name="user_email" autocomplete="off" required="">
                </div>
                <div class="group-btn">
                    <button>' . __('Reset password', 'winning_plan') . '</button>
                </div>
            </form>
        </div>';
        }
 
    return $html;
}

add_shortcode('auth-forgot', 'auth_form_forgot');

function action_auth_ajax_forgot()
{
    if (wp_verify_nonce($_POST['security'], LEARNING_NONCE_CODE)) {
        $user_email = $_POST['user_email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password) {
            if ($password == $confirm_password) {
                $update_user = wp_update_user(array(
                    'ID' => $_POST['user_id'],
                    'user_pass' => $password
                ));
                if (is_wp_error($update_user)) {
                    $data = array(
                        'status' => false,
                        'message' => __('An error has occurred, the user may not exist.', 'winning_plan')
                    );
                } else {
                    update_user_meta($update_user, 'forgot_key', 'NULL');
                    $data = array(
                        'status'  => true,
                        'message' => __('Password changed successfully.', 'winning_plan'),
                        'changed' => true
                    );
                }
            } else {
                $data = array(
                    'status' => false,
                    'message' => __('The passwords you entered do not match! Check if the entry is correct.', 'winning_plan')
                );
            }
        } else {
            if (email_exists($user_email)) {
                $get_user = get_user_by('email',  $user_email);
                $user_id = $get_user->ID;

                $forgot_key = wp_generate_password(25, false);
                update_user_meta($user_id, 'forgot_key', $forgot_key);

                $data = array(
                    'status' => true,
                    'message' => __('You have received an email to confirm your password change.', 'winning_plan'),
                    'user_id' => $user_id,
                    'forgot_key' => $forgot_key
                );

                $headers = wp_mail_headers();
                wp_mail(
                    $user_email,
                    'New forgot',
                    'You have requested a password reset. To confirm, send the link - <a href="' .  FARGOT_URL . '?forgot_key=' . $forgot_key . '&user_id=' . $user_id . '">clik me</a>',
                    $headers
                );

            } else {
                $data = array(
                    'status' => false,
                    'message' => __('Sorry. This email is not registered in the system.', 'winning_plan')
                );
            }
        };
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_nopriv_action_auth_ajax_forgot', 'action_auth_ajax_forgot');
add_action('wp_ajax_action_auth_ajax_forgot', 'action_auth_ajax_forgot');