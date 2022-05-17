<?php

// Add a custom user role

$artist = add_role('coach', __('Coach', 'winning_plan'),
    array(
        'read' => true, // true allows this capability
        'edit_posts' => false,
        'delete_posts' => false,
    )
);

$casting = add_role('manager', __('Manager', 'winning_plan'),
    array(
        'read' => true, // true allows this capability
        'edit_posts' => false,
        'delete_posts' => false,
    )
);

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function modify_contact_methods($profile_fields)
{
    // Remove profile fields
    unset($profile_fields['url']);
    unset($profile_fields['twitter']);
    unset($profile_fields['facebook']);
    unset($profile_fields['instagram']);
    unset($profile_fields['linkedin']);
    unset($profile_fields['myspace']);
    unset($profile_fields['pinterest']);
    unset($profile_fields['soundcloud']);
    unset($profile_fields['tumblr']);
    unset($profile_fields['youtube']);
    unset($profile_fields['wikipedia']);
    return $profile_fields;
}

add_filter('user_contactmethods', 'modify_contact_methods', 10, 1);

function custom_user_profile_fields($user)
{ ?>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <th><label for="image">Profile Image</label></th>
            <td class="profile-avatar">
                <div class="img" style=" display: flex; gap: 20px; margin-bottom: 15px; ">
                    <img
                        src="<?php echo esc_attr( get_the_author_meta( 'profile_image_url', $user->ID ) ); ?>"
                        style="height:180px; <?php if(get_the_author_meta( 'profile_image_url', $user->ID )){ ?>  display: block <?php } else { ?> display: none  <?php } ?>">
                    <a class="profile-avatar-delete" href="#">
                        Delete
                    </a>
                </div>
                <div class="data">
                    <input width="300" type="text" name="profile_image_url" id="profile_image_url" value="<?php echo esc_attr( get_the_author_meta( 'profile_image_url', $user->ID ) ); ?>" size="60" />
                    <button class="upload-button button">Upload Thumbnail</button>
                    <input type="hidden" name="profile_image" id="profile_image" value="<?php echo esc_attr( get_the_author_meta( 'profile_image', $user->ID ) ); ?>"/>
                </div>
            </td>
        </tr>
    </table>

    <script type="text/javascript">
        jQuery(document).ready(function() {

            jQuery(document.body).on('click', '.profile-avatar-delete', function (event) {
                event.preventDefault();
                jQuery(this).closest('.profile-avatar').find('input').val('');
                jQuery(this).closest('.profile-avatar').find('.img img').hide();
            });

            let uploadUrl = '';
            let uploadID  = '';
            let original_send_to_editor = window.send_to_editor;
            jQuery('.upload-button').click(function() {
                uploadUrl = jQuery(this).prev('input');
                uploadID  = jQuery(this).next('input');
                imgField  = jQuery(this).closest('.profile-avatar').find('.img img');
                tb_show('', 'media-upload.php?TB_iframe=true');
                uploadBAR(imgField);
                return false;
            });
            function uploadBAR() {
                window.send_to_editor = function(html) {
                    const imgurl = jQuery(jQuery.parseHTML(html)).attr('src');
                    const imgClass = jQuery(jQuery.parseHTML(html)).attr('class');
                    const imgId = imgClass.replace(/[^+\d]/g, '');
                    //let imgClassArr = imgClass.split('wp-image-');
                    //let imgClassArr = imgClass.split(' ');
                    uploadUrl.val(imgurl);
                    uploadID.val(imgId);
                    imgField.attr('src',imgurl).show();
                    tb_remove();
                    window.send_to_editor = original_send_to_editor;//restore old send to editor function
                };
            }
        });
    </script>
    <?php
}

add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');
add_action("user_new_form", "custom_user_profile_fields");


function save_custom_user_profile_fields($user_id)
{
    # again do this only if you can
    if (!current_user_can('manage_options'))
        return false;
    # save my custom field
    //update_user_meta($user_id, 'school_student', $_POST['school_student']);
    update_user_meta($user_id, 'profile_image', $_POST['profile_image']);
    update_user_meta($user_id, 'profile_image_url', $_POST['profile_image_url']);
}

add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');