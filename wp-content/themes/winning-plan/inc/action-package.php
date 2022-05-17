<?php

function create_buy_package()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {


        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            //
        } else {
            $data = array(
                'status' => false,
                'message' => __('אנא בדוק את כתובת האימייל שלך', 'winning_plan'),
                'error' => 'useremail',
                'error_class' => 'login-error',
            );
            wp_send_json_success($data);
        }

        $type = $_POST['package_type']; // package_manage   //   package_coach
        $cost_package = (int)get_packages_data($type, 'price');
        $players_count = 0;
        $cost_total = 0;
        $cost_coach = 0;
        $cost_manager = $cost_package;
        $cost_total = $cost_total + $cost_manager;

        $per_month = '<span> / ' . __('חודש', 'winning_plan') . '</span>';
        $html = '
        <input type="hidden" name="action" value="package_payment">
        <div class="buy-package__box">
            <div class="buy-package__subtitle">
               ' . __('פירוט משתמשים', 'winning_plan') . '
            </div>
            <div class="buy-package__details"> ';

        if ($_POST['groups']) {
            $cost_coach = count($_POST['groups']) * (int)$cost_package;
            $cost_total = $cost_total + $cost_coach;
            $count = 0;
            foreach ($_POST['groups'] as $group) {
                $count++;
                $cost = (int)$group['players'] * (int)$cost_package;
                $cost_total = $cost_total + $cost;
                $players_count = $players_count + (int)$group['players'];
                $html .= '
                       <div class="item">
                            <input type="hidden" name="groups[' . $count . '][title]" value="' . $group['title'] . '">
                            <input type="hidden" name="groups[' . $count . '][players]" value="' . $group['players'] . '">
                            <input type="hidden" name="groups[' . $count . '][cost]" value="' . $cost . '">
                            <div class="title">
                               ' . $group['title'] . '
                            </div>
                            <div class="players">
                                ' . $group['players'] . ' ' . __('שחקנים', 'winning_plan') . '
                            </div>
                            <div class="cost">
                                ₪' . $cost . '.00' . $per_month . '
                            </div>
                       </div>';
            }
        }

        $html .= ' 
                <div class="liner"></div>
                <div class="item item-coach">
                    <input type="hidden" name="coaches_count" value="' . count($_POST['groups']) . '">
                    <input type="hidden" name="coaches_cost" value="' . count($_POST['groups']) * (int)$cost_package . '">
                    <div class="title">
                        מאמנים
                    </div>
                    <div class="players">
                       ' . count($_POST['groups']) . '
                    </div>
                    <div class="cost">
                        ₪' . count($_POST['groups']) * (int)$cost_package . '.00' . $per_month . '
                    </div>
                </div>
                <div class="item item-manager">
                    <input type="hidden" name="manager_count" value="1">
                    <input type="hidden" name="manager_cost" value="' . (int)$cost_package . '">
                    <div class="title">
                        מנהל מקצועי
                    </div>
                    <div class="players">
                        1
                    </div>
                    <div class="cost">
                        ₪' . (int)$cost_package . '.00' . $per_month . '
                    </div>
                </div>
            </div>
        </div>
        <div class="buy-package__total">
            <div class="info">
            ' . __('התשלום הקבוע שלך:', 'winning_plan') . '    
            </div>
            <div class="cost">
                ₪' . $cost_total . '.00' . $per_month . '
            </div>
        </div>
        
        <input type="hidden" name="cost_total" value="' . $cost_total . '">
        <input type="hidden" name="players" value="' . $players_count . '">
        
        <div class="buy-package__info"> ' . __('המסלול בהתחייבות עד סוף העונה (31.6)', 'winning_plan') . ' </div>
        <div class="buy-package__agree">
            <label class="group-item__checkbox ">
                <input name="agreement" type="checkbox"  value="agree" data-orig-tabindex="null" tabindex="-1">
                <span><a href="#"> ' . __('תנאי השימוש', 'winning_plan') . '</a>  ' . __('מקובלים עלי', 'winning_plan') . ' </span>
            </label>
        </div>

        <button class="btn-wrapper blue center">
            ' . __('המשך לתשלום', 'winning_plan') . '
        </button>
        ';

        $data = array(
            'status' => true,
            'message' => __('', 'winning_plan'),
            'html_result' => $html
        );
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_create_buy_package', 'create_buy_package');

function package_payment()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        //var_dump($_POST);
        // useremail

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $data = array(
                'status' => true,
                'message' => __('', 'winning_plan'),
            );
        } else {
            $data = array(
                'status' => false,
                'message' => __('אנא בדוק את כתובת האימייל שלך', 'winning_plan'),
                'error' => 'useremail',
                'error_class' => 'login-error',
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

add_action('wp_ajax_package_payment', 'package_payment');
