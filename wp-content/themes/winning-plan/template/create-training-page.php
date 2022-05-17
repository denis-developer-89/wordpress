<?php
/*
Template Name: Create training page
*/
get_header("personal");
get_user_meta(get_current_user_id(), '', true);
//$edit_training_id = get_user_meta(get_current_user_id(), 'current_edit_training_id', true);
$edit_training_id = '';
if (isset($_GET['edit_id'])) {
    $edit_training_id = $_GET['edit_id'];
}
$current_step = get_field('step', $edit_training_id);
if (!$current_step) {
    $current_step = 0;
}
?>
    <main>
        <div class="create-training-page" data-post-id="<?php echo $edit_training_id; ?>"
             data-step="<?php echo $current_step; ?>">
            <div class="container">
                <a class="create-cancelation" href="<?php echo get_home_url(); ?>">
                    <?php _e('ביטול', 'winning-plan'); ?>
                </a>
                <h1 class="wrapper-personal__title">
                    <?php the_title(); ?>
                </h1>
                <div class="accordions">
                    <div class="first-step">
                        <div class="accordion">
                            <?php echo General::get_first_step_form($edit_training_id, 'create'); ?>
                            <?php echo General::get_first_step_info($edit_training_id, 'edit'); ?>
                        </div>
                    </div>
                    <div class="second-step" id="result-session-boxes">
                        <?php echo General::get_training_session_box($edit_training_id); ?>
                    </div>
                    <div class="third-step">
                        <div class="accordion">
                            <div class="header">
                                <div class="title">
                                    <div class="number">3</div>
                                    <h2><?php _e('בניית התרגיל', 'winning-plan'); ?></h2>
                                </div>
                                <div class="arrow"><i class="fal fa-angle-down"></i></div>
                            </div>
                            <div class="content">
                                <div class="form">
                                    <div class="form-item">
                                        <label for="date-session">
                                            <?php _e('תאריך אימון:', 'winning-plan'); ?>
                                            <input type="text" name="date-session" class="datepicker" id="date-session"
                                                   value="<?php echo get_field('data', $edit_training_id) ? get_field('data', $edit_training_id) : null ?>">
                                        </label>
                                    </div>
                                    <div class="form-item">
                                        <label for="time-session">
                                            <?php _e('שעה:', 'winning-plan'); ?>
                                            <input type="text" name="time-session" id="time-session" class="timepicker"
                                                   value="<?php echo get_field('time', $edit_training_id) ? get_field('time', $edit_training_id) : null ?>"/>
                                        </label>
                                    </div>
                                    <div class="form-item">
                                        <div class="checkbox-group">
                                            <div class="checkbox">
                                                <input type="checkbox" id="players-session" name="players-session"
                                                       value="true" <?php echo get_field('players', $edit_training_id) ? 'checked' : null ?>>
                                                <label for="players-session">
                                                    <?php _e('זימון השחקנים למערך', 'winning-plan'); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="save">
                        <button type="button" class="btn-green trigger-save">
                            <?php _e('שמירת מערך', 'winning-plan'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" style="display: none" id="page-exit">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <div class="title">
                    <span>
                        <?php _e('יצירת מערך אימון', 'winning-plan'); ?>
                    </span>
                    <a href="#" class="modal-close">
                        <?php echo General::get_svg_file('close'); ?>
                    </a>
                </div>
                <div class="description">
                    <?php _e('לא סיימת לערוך את העמוד. האם לשמור את השינויים?', 'winning-plan'); ?>
                </div>

                <div class="btns">
                    <a href="#" class="save">
                        <?php _e('שמירה', 'winning-plan'); ?>
                    </a>
                    <a href="#" class="exit">
                        <?php _e('יציאה בלי לשמור', 'winning-plan'); ?>
                    </a>
                    <a href="#" class="back red">
                        <?php _e('חזרה לעמוד', 'winning-plan'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="modal" style="display: none"  id="delete-session">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <div class="title">
                    <span>
                        <?php _e('מחיקת מערך אימון', 'winning-plan'); ?>
                    </span>
                    <a href="#" class="modal-close">
                        <?php echo General::get_svg_file('close'); ?>
                    </a>
                </div>
                <div class="description">
                    <?php _e('האם ברצונך למחוק את מערך האימון לצמיתות?', 'winning-plan'); ?>
                </div>

                <div class="btns">
                    <a href="#" class="delete">
                        <?php _e('כן, ארצה למחוק', 'winning-plan'); ?>
                    </a>
                    <a href="#" class="back red">
                        <?php _e('ביטול', 'winning-plan'); ?>
                    </a>
                </div>
            </div>
        </div>


    </main>
<?php get_footer("personal"); ?>