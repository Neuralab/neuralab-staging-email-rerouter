<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$enable = !empty($_POST['enable_reroute']) && sanitize_text_field($_POST['enable_reroute']) ? 1 : 0;
		$email = !empty($_POST['email_address']) ? sanitize_text_field($_POST['email_address']) : '';

		$error = false;

		if ($enable) {
			if (!$email) {
				print '<div id="message" class="error fade"><p>'. __('Enter at least one email address.', 'nrlbreroute') . '</p></div>';
				$error = true;
			} else {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					print '<div id="message" class="error fade"><p>'. __('Enter a valid email.', 'nrlbreroute') . '</p></div>';
					$error = true;
				}
			}
		}

		if(!$error){
			update_option('nrlb_reroute_enable', $enable);
			update_option('nrlb_reroute_address', $email);
			print '<div id="message" class="updated fade"><p>'. __('Settings saved.', 'nrlbreroute') . '</p></div>';
		}
	}
	else{
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
					<th scope="row"><?php  _e('Enable rerouting', 'nrlbreroute'); ?></th>
					<td>
						<input type="checkbox" <?php print $enable ? 'checked="checked"' : ''; ?> value="1" name="enable_reroute" id="enable_reroute">
						<label class="description" for="enable_reroute"><?php  _e('Check this box if you want to enable email rerouting. Uncheck to disable rerouting.', 'nrlbreroute'); ?></label>
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
							<input id="reroute-email" type="text" name="email_address" size="70" value="<?php print $email; ?>" placeholder="Enter email adress to reroute to...">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<p class="submit"><input id="submit" type="submit" value="<?php  _e('Save Changes', 'nrlbreroute'); ?>"></p>
	</form>
</div>
