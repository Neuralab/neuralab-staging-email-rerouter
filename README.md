# Neuralab staging email rerouter #

Simple rerouter plugin that reroutes WordPress emails to a specified address.

It's made for developers to test WordPress default mails and it's recommended to use only on development and staging environments.

Neuralab Reroute is a plugin used to reroute all your outgoing emails sent by WordPress (order mails, registration, etc.).
It catches emails and reroutes them to a specified email address you want.
The idea behind it is that you do not spam your clients emails when testing out if it all works correctly.

## Installation ##

1. Download the files and copy them to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to NRLB Reroute in admin menu.
1. Check the "Check this box if you want to enable email rerouting" checkbox to enable the plugin.
1. In the "Email Address" input field enter a email address to where you want to redirect WordPress emails.
