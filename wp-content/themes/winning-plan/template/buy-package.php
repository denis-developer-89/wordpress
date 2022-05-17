<?php
/*
Template Name: Buy package
*/
get_header();
while (have_posts()) {
    the_post();
    $post_thumbnail_id = get_post_thumbnail_id();
    $image_post_url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
?>
    <div class="page-container buy-package">
        <img class="page-container__bg" src="<?php echo custom_image_url($post_thumbnail_id, 'large'); ?>" alt="<?php the_title(); ?>">
        <div class="container">
            <div class="page-content">
                <div class="page-header">
                    <?php the_title('<h1 class="page-header__title">', '</h1>'); ?>
                </div>
            </div>
            <div class="buy-package__form">
                <?php
                if ($_GET['package'] != NULL && $_GET['package'] == 'package_coach' || $_GET['package'] == 'package_manager') {
                    $per_month = '<span> / ' . __('חודש', 'winning_plan') . '</span>';
                    $type = $_GET['package'];
                    $cost_package = (int)get_packages_data($type, 'price');

                ?>
                    <div class="buy-package__title">
                        <?php _e('רכישת מסלול "מועדון"', 'winning_plan'); ?>
                    </div>
                    <form action="" id="buy-package">
                        <?php if ($_GET['package'] == 'package_manager') { ?>
                            <input type="hidden" name="action" value="create_buy_package">
                        <?php } else { ?>
                            <input type="hidden" name="action" value="package_payment">
                            <input type="hidden" name="free_trial" value="<?php echo (int)get_packages_data($type, 'free_trial_period'); ?>">
                        <?php } ?>
                        <input type="hidden" name="package_type" value="<?php echo $_GET['package']; ?>">
                        <input id="package-cost" type="hidden" name="package_cost" value="<?php echo $cost_package; ?>">
                        <div class="buy-package__box">
                            <div class="buy-package__subtitle">
                                <?php _e('כתובת המייל שלך', 'winning_plan'); ?>
                            </div>
                            <input id="useremail" type="email" name="email" value="" placeholder="<?php _e('מייל', 'winning_plan'); ?>">
                            <div class="status status-email"></div>
                        </div>
                        <div class="buy-package__box">
                            <div class="buy-package__subtitle">
                                <?php if ($_GET['package'] == 'package_manager') { ?>
                                    <?php _e('הוספת קבוצות ובחירת כמות שחקנים', 'winning_plan'); ?>
                                <?php } else { ?>
                                    <?php _e('הגדרת משתמשים בקבוצה', 'winning_plan'); ?>
                                <?php } ?>
                            </div>
                            <div class="buy-package__msg">
                                <?php _e('לכל קבוצה מינימום 20 שחקנים', 'winning_plan'); ?>
                            </div>
                            <div class="buy-package__groups">
                                <?php if ($_GET['package'] == 'package_manager') { ?>
                                    <a class="btn-wrapper center btn-add-group" href="#">
                                        <?php _e('הוספת קבוצה', 'winning_plan'); ?>
                                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.6 5.3h4.5v1.8H6.6v4.5H4.8V7.1H.3V5.3h4.5V.8h1.8v4.5Z" fill="#2C62FF" />
                                        </svg>
                                    </a>
                                <?php } else { ?>
                                    <div class="buy-groups__box buy-groups__coach">
                                        <div class="buy-groups__players">
                                            <label>
                                                <?php _e('כמה שחקנים?', 'winning_plan'); ?>
                                            </label>
                                            <span>
                                                <a class="plus-players" href="#">
                                                    <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 6V0H6v6H0v2h6v6h2V8h6V6H8Z" fill="#091932" />
                                                    </svg>
                                                </a>
                                                <a class="minus-players" href="#">
                                                    <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 2">
                                                        <path opacity=".3" fill="#091932" d="M0 0h14v2H0z" />
                                                    </svg>
                                                </a>
                                                <input id="coach-players" readonly type="text" name="players" value="20" placeholder="">
                                            </span>
                                        </div>
                                        <div class="cost">
                                            <?php echo '₪' . '<b id="calc-coach-players">' . $cost_package * 20 . '</b>' . '.00' . $per_month; ?>
                                        </div>
                                    </div>
                                    <div class="liner"></div>
                                    <div class="buy-groups__box  buy-groups__coach">
                                        <input type="hidden" name="manager_count" value="1">
                                        <input type="hidden" name="manager_cost" value="<?php echo $cost_package; ?>">
                                        <div class="buy-groups__players">
                                            <label>
                                                <?php _e('מנהל מקצועי', 'winning_plan'); ?>
                                            </label>
                                            <span>
                                                1
                                            </span>
                                        </div>
                                        <div class="cost">
                                            <?php echo '₪' . '<b>' . $cost_package . '</b>' . '.00' . $per_month; ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($_GET['package'] == 'package_manager') { ?>
                            <button class="btn-wrapper blue center">
                                <?php _e('המשך', 'winning_plan'); ?>
                            </button>
                        <?php } else { ?>
                            <div class="buy-package__total">
                                <input id="calc-coach-cost-total-input" type="hidden" name="cost_total" value="<?php echo (($cost_package * 20) + $cost_package); ?>">
                                <div class="info">
                                    <?php _e('התשלום הקבוע שלך:', 'winning_plan'); ?>
                                </div>
                                <div class="cost">
                                    <?php echo '₪' . '<b  id="calc-coach-cost-total">' . (($cost_package * 20) + $cost_package) . '</b>' . '.00' . $per_month; ?>
                                </div>
                            </div>
                            <div class="buy-package__info">
                                <?php _e('המסלול בהתחייבות עד סוף העונה (31.6)', 'winning_plan') ?>
                            </div>
                            <div class="buy-package__msg">
                                <p>
                                    <?php _e('לאחר 14 ימים, דמי המנוי יעמדו על <span class="msg-cost-total">252</span> ₪ לחודש ל-<span class="msg-players">21</span> משתמשים.', 'winning_plan') ?>
                                </p>
                                <p>
                                    <?php _e('במהלך תקופה זו ניתן לבטל את המנוי ללא תשלום.', 'winning_plan') ?>
                                </p>
                                <p>
                                    <?php _e('ברכישה מסלול זה קיימת זכאות ל-14 ימי ניסיון חינם.', 'winning_plan') ?>
                                </p>
                            </div>
                            <div class="buy-package__agree">
                                <label class="group-item__checkbox ">
                                    <input name="agreement" type="checkbox" value="agree" data-orig-tabindex="null" tabindex="-1">
                                    <span>
                                        <a href="#">
                                            <?php _e('תנאי השימוש', 'winning_plan'); ?></a>
                                        <?php _e(' מקובלים עלי', 'winning_plan'); ?>
                                    </span>
                                </label>
                            </div>
                            <button class="btn-wrapper blue center">
                                <?php _e('המשך', 'winning_plan'); ?>
                            </button>
                        <?php } ?>
                    </form>
                    <div class="buy-groups__box template-buy-group" style="display: none">
                        <a class="buy-groups__delete" href="#">
                            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
                                <path d="m2 2 8 8m0-8-8 8" stroke="#FA8585" stroke-width="3" stroke-linecap="round" />
                            </svg>
                        </a>
                        <div class="buy-groups__name">
                            <label>
                                <?php _e('קבוצה', 'winning_plan'); ?>
                            </label>
                            <span>
                                <input type="text" name="title" value="" placeholder="">
                            </span>
                        </div>
                        <div class="buy-groups__players">
                            <label>
                                <?php _e('כמה שחקנים?', 'winning_plan'); ?>
                            </label>
                            <span>
                                <a class="plus-players" href="#">
                                    <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 6V0H6v6H0v2h6v6h2V8h6V6H8Z" fill="#091932" />
                                    </svg>
                                </a>
                                <a class="minus-players" href="#">
                                    <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 2">
                                        <path opacity=".3" fill="#091932" d="M0 0h14v2H0z" />
                                    </svg>
                                </a>
                                <input readonly type="text" name="players" value="20" placeholder="">
                            </span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="buy-package__title">
                        <?php _e('Content is not available because you have not selected a package.', 'winning_plan'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php get_footer();
