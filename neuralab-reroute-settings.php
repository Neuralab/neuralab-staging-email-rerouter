<?php
/**
 * Create a settings page
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

/**
 * Validate for data
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $enable = !empty($_POST['enable_reroute']) && sanitize_text_field($_POST['enable_reroute']) ? 1 : 0;
  $email = !empty($_POST['email_address']) ? sanitize_text_field($_POST['email_address']) : '';

  $error = false;

  if ($enable) {
    if (!$email) {
      echo neuralab_reroute_notice('one_email', 'error');
      $error = true;
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo neuralab_reroute_notice('email_not_valid', 'error');
        $error = true;
      }
    }
  }

  if (!$error) {
    update_option('nrlb_reroute_enable', $enable);
    update_option('nrlb_reroute_address', $email);
    echo neuralab_reroute_notice('saved', 'updated');
  }
} else {
  $enable = get_option('nrlb_reroute_enable', 0);
  $email = get_option('nrlb_reroute_address', '');
}
?>

<div class="wrap">
  <h2><?php  _e('NRLB Rerouter settings', 'nrlbreroute'); ?></h2>
  <form action="" method="post">
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row"><?php _e('Enable rerouting', 'nrlbreroute'); ?></th>
          <td>
            <input type="checkbox" <?php checked($enable, 1); ?>  value="1" name="enable_reroute" id="enable_reroute">
            <label class="description" for="enable_reroute"><?php _e('Check this box if you want to enable email rerouting. Uncheck to disable rerouting.', 'nrlbreroute'); ?></label>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="settings-tables">
      <table class="form-table">
        <tbody>
          <tr>
            <th scope="row"><?php  _e('Email address', 'nrlbreroute'); ?></th>
            <td>
              <input id="reroute-email" type="text" name="email_address" size="70" value="<?php echo esc_attr($email); ?>" placeholder="<?php esc_attr_e('Enter email adress to reroute to...', 'nrlbreroute'); ?>">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="submit"><input id="submit" type="submit" class="button button-primary" value="<?php _e('Save Changes', 'nrlbreroute'); ?>"></p>
  </form>
</div>
