<?php

function winning_plan_email_header()
{

    $bg_head = get_template_directory_uri() . '/images/email/head-bg.jpg';
    $logo_head = get_template_directory_uri() . '/images/email/logo.png';

    return '
        <table style="table-layout: fixed;vertical-align: top;min-width: 320px;border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;background-color: #fff;width: 100%;color: #2F2F2F; direction: rtl; font-family: Arial;">
            <tr>
                <td style="text-align:center">
                        <table style="display: inline-table; width: 100%; max-width: 600px; border: #fff; text-align:right" role="presentation" >
                        <tr>
                            <td style="padding: 8px 16px;background: #091932; border-radius: 8px 8px 0px 0px;">
                                <a href="' . home_url() . '" class="logo" >
                                    <img heigt="28" src="' . $logo_head . '" >
                                </a>
                            </td>
                        </tr>   
                        <tr>    
                            <td>
                                <div style="border-radius: 0px 0px 8px 8px; height: 80px; background-color: #363636;  background-size:cover; background-position:center; background-image: url('.$bg_head.');"></div>
                            </td>
        </tr>
    </table>
                        
    ';
}

function winning_plan_email_body($content)
{
    return '
        <table style="display: inline-table; width: 100%; max-width: 600px; border: #fff; text-align:right" role="presentation" >
                <tr>
                    <td style="height: 16px"></td>
                </tr> 
                <tr>
                    <td style="background: #F7F7F7; box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.01); border-radius: 8px; padding: 30px">
                        '.$content.'
                    </td>
                </tr> 
                <tr>
                    <td style="height: 16px"></td>
                </tr>  
        </table>
    ';
}

function winning_plan_email_footer()
{

    $contacts_email = '<div style="text-align: center;">';
    if (get_field('phone_second ', 'option')) {
        $contacts_email .= '<span style="font-size: 18px; line-height: 28px;  letter-spacing: 0.01em; color: #091932;" target="_blank">
            '.get_field('phone_second', 'option').'
          </span>';
    }

    if (get_field('phone_first ', 'option')) {
        $contacts_email .= '<span style="margin: 0 10px">|</span><span style="font-size: 18px; line-height: 28px;  letter-spacing: 0.01em; color: #091932;" target="_blank">
            '.get_field('phone_first', 'option').'
          </span>';
    }

    if (get_field('email ', 'option')) {
        $contacts_email .= '<span style="margin: 0 10px">|</span><a style="font-size: 18px; line-height: 28px;  letter-spacing: 0.01em; color: #091932;" target="_blank">
            '.get_field('email', 'option').'
          </a>';
    }

    $social_email = '<div style="padding: 24px 0; text-align: center;">';
        if (get_field('youtube', 'option')) {
           $social_email .= '<a style="margin: 0 4px; text-decoration: none;" target="_blank" href="'.get_field('youtube', 'option').'">
                        <img src="'.get_template_directory_uri().'/images/email/youtube.png" alt="youtube">
                    </a>';
        }
        if (get_field('whatsapp', 'option')) {
            $social_email .= '<a style="margin: 0 4px; text-decoration: none;" target="_blank" href="'.get_field('whatsapp', 'option').'">
                            <img src="'.get_template_directory_uri().'/images/email/whatsapp.png" alt="whatsapp">
                        </a>';
        }
        if (get_field('linkedin', 'option')) {
            $social_email .= '<a style="margin: 0 4px; text-decoration: none;" target="_blank" href="'.get_field('linkedin', 'option').'">
                            <img src="'.get_template_directory_uri().'/images/email/linkedin.png" alt="linkedin">
                        </a>';
        }
        if (get_field('facebook', 'option')) {
            $social_email .= '<a style="margin: 0 4px; text-decoration: none;" target="_blank" href="'.get_field('facebook', 'option').'">
                            <img src="'.get_template_directory_uri().'/images/email/facebook.png" alt="facebook">
                        </a>';
        }
    $social_email .= '</div>';

    $return_site_email = '<div style="padding-bottom: 24px; border-bottom: 1px solid #DBDEE7; margin-bottom: 24px; text-align: center;">
        <a style="font-size: 18px; line-height: 22px;   text-decoration-line: underline;  color: #091932;" href="'.home_url().'">
            '.__('בקרו באתר שלנו','winning_plan').'
            <img style="margin-right:16px" src="'.get_template_directory_uri().'/images/email/arrow.png">
        </a>
    </div>
    <div style="font-size: 14px; text-align: center; letter-spacing: 0.04em; color: #9A9AB0;">
        <p style="margin: 0">'.__('אם אתה סבור שקיבלת אותה בטעות או אם ברצונך לבטל את ההרשמה, לחץ כאן.','winning_plan').'</p>
        <p style="margin: 0">'.__('קיבלת דואר אלקטרוני זה מכיוון שאתה מנוי על אתר זה.','winning_plan').'</p>
    </div>
    ';

    return '
                <table style="display: inline-table; width: 100%; max-width: 600px; border: #fff; text-align:right" role="presentation"> 
                    <tr>
                        <td style="background: #F7F7F7; box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.01); border-radius: 8px; padding: 30px">
                            '.$contacts_email .'                          
                            '.$social_email.'
                            '.$return_site_email.'
                        </td>
                    </tr>    
                    <tr>
                        <td style="height: 16px"></td>
                    </tr>    
                    <tr>                       
                        <td>
                            <div style="color: #9A9AB0; font-size: 14px;">
                                <a style="text-decoration-line: underline; color: #9A9AB0; font-size: 14px; float: left" href="'.home_url().'/unsubscribe">
                                    '.__('בטל את המנוי','winning_plan').'
                                </a>
                                <span style="float: right">
                                    '.__('ניתן למצוא את התנאים וההגבלות המלאים','winning_plan').' 
                                    <a style="text-decoration-line: underline; color: #2C62FF;" href="'.home_url().'/privacy-policy">'.__('כאן','winning_plan').'
                                    </a>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
             </td>
           </tr>
        </table>
    ';
}

function winning_plan_email_send($to, $subject, $template_message)
{
    $headers = array();
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: Winning Plan <yozma.testmail@gmail.com>' . "\r\n";

    wp_mail($to, strip_tags($subject), $template_message, $headers);
}