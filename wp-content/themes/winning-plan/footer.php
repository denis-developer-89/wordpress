</div>
<footer class="wrapper-footer">
    <div class="wrapper-footer__top">
        <div class="container">
            <?php for ($i = 1; $i <= 1; $i++) {
                if (is_active_sidebar('footer-' . $i)) {
                    ?>
                    <div class="footer-container__item  footer-<?php echo $i; ?>">
                        <?php dynamic_sidebar('footer-' . $i); ?>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
    <div class="wrapper-footer__info">
        <div class="container">
            <div class="wrapper-footer__contact">
                <?php if (get_field('email ', 'option')) { ?>
                    <div class="wrapper-footer__email">
                        <i>
                            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 20"><path d="M1.337 4.508c.244-.358.583-.653.985-.859a2.923 2.923 0 0 1 1.315-.316h14.546c.46.002.913.11 1.315.316.402.206.74.501.985.859L10.91 10.65 1.337 4.508ZM20.91 6.266l-6.273 4.025 6 4.942c.18-.332.273-.697.273-1.067v-7.9Zm-20 0v7.9c0 .37.094.735.273 1.067l6-4.942L.91 6.266Zm12.2 5-1.682 1.075a.967.967 0 0 1-.518.149.967.967 0 0 1-.518-.149L8.71 11.275l-6.236 5.141c.362.164.76.25 1.163.25h14.546a2.933 2.933 0 0 0 1.173-.25l-6.246-5.15Z" fill="#A8BEFF"/></svg>
                        </i>
                        <a target="_blank" href="mailto:<?php the_field('email', 'option') ?>">
                            <?php the_field('email', 'option') ?>
                        </a>
                    </div>
                <?php } ?>
                <div class="wrapper-footer__phone">
                    <i>
                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 20"><path d="M14.523 0H7.5A2.493 2.493 0 0 0 5 2.5v15C5 18.886 6.136 20 7.5 20h7.023c1.386 0 2.5-1.114 2.5-2.5v-15c0-1.386-1.114-2.5-2.5-2.5Zm-3.5 18.386c-.637 0-1.137-.5-1.137-1.136 0-.636.5-1.136 1.137-1.136.636 0 1.136.5 1.136 1.136 0 .636-.5 1.136-1.136 1.136Zm4.863-3.477h-9.75V3.341h9.75v11.568Z" fill="#A8BEFF"/></svg>
                    </i>
                    <?php if (get_field('phone_first ', 'option')) { ?>
                        <a target="_blank"
                           href="tel: <?php echo preg_replace('/[^0-9]/', '', get_field('phone_first', 'option')); ?>">
                            <?php the_field('phone_first', 'option') ?>
                        </a>
                    <?php } ?>
                    <?php if (get_field('phone_second ', 'option')) { ?>
                        <span>|</span>
                        <a target="_blank"
                           href="tel:<?php echo preg_replace('/[^0-9]/', '', get_field('phone_second', 'option')); ?>">
                            <?php the_field('phone_second', 'option') ?>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <div class="wrapper-footer__social">
                <?php if (get_field('youtube', 'option')) { ?>
                    <a class="whatsapp" target="_blank" href="<?php the_field('youtube', 'option') ?>">
                        <img src="<?php echo THEME_DIR; ?>/images/svg/youtube.svg" alt="youtube">
                    </a>
                <?php } ?>
                <?php if (get_field('whatsapp', 'option')) { ?>
                    <a target="_blank" href="<?php the_field('whatsapp', 'option') ?>">
                        <img src="<?php echo THEME_DIR; ?>/images/svg/whatsapp.svg" alt="whatsapp">
                    </a>
                <?php } ?>
                <?php if (get_field('linkedin', 'option')) { ?>
                    <a target="_blank" href="<?php the_field('linkedin', 'option') ?>">
                        <img src="<?php echo THEME_DIR; ?>/images/svg/linkedin.svg" alt="linkedin">
                    </a>
                <?php } ?>

                <?php if (get_field('facebook', 'option')) { ?>
                    <a target="_blank" href="<?php the_field('facebook', 'option') ?>">
                        <img src="<?php echo THEME_DIR; ?>/images/svg/facebook.svg" alt="facebook">
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="wrapper-footer__bottom">
        <div class="container">
            <div class="copyright">
                <?php _e('© 2021 כל הזכויות שמורות ל-WinningPlan בע״מ', 'winning_plan'); ?>
            </div>
            <div class="development">
                <?php _e('איפיון, עיצוב ופיתוח', 'winning_plan'); ?>
                <img src="<?php echo THEME_DIR; ?>/images/svg/omnis-logo.svg" alt="omnis">
            </div>
        </div>
    </div>
</footer>
</div>


<div style="display: none;" id="call-auth">
     <div class="fancybox__title">
         <?php _e('כניסה', 'winning_plan'); ?>
     </div>
    <?php echo do_shortcode('[auth-login]'); ?>
</div>


<?php wp_footer(); ?>

</body>
</html>
