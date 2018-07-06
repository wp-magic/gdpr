<?php

add_action( 'admin_post_nopriv_' . MAGIC_GDPR_COOKIE_SETTINGS_ACTION, function () {
  magic_gdpr_set_cookies();
} );

add_action( 'admin_post_' . MAGIC_GDPR_COOKIE_SETTINGS_ACTION, function() {
  magic_gdpr_set_cookies();
} );
