<footer class="wrapper-personal__footer">
    <div class="container">
        <div class="copyright">
            <?php _e('© 2021 כל הזכויות שמורות ל-WinningPlan בע״מ', 'winning_plan'); ?>
        </div>
        <div class="development">
            <?php _e('איפיון, עיצוב ופיתוח', 'winning_plan'); ?>
            <img src="<?php echo THEME_DIR; ?>/images/svg/omnis-logo-gray.svg" alt="omnis">
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
