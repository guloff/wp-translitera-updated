# WP Translitera (Modern PHP 8 Fork)

WP Translitera is a WordPress plugin that transliterates permalinks, post slugs, page URLs, and taxonomy slugs to produce cleaner, more readable URLs. This fork updates the original plugin to be fully compatible with PHP 8 and adheres to modern WordPress coding standards.

## Features

- **Automatic Transliteration**: Converts Cyrillic (and other non-Latin) characters into Latin equivalents for improved URL readability.
- **Custom Transliteration Rules**: Define your own rules via the settings page to tailor transliteration to your needs.
- **WPForo Integration**: Seamlessly transliterates forum URLs when WPForo is installed.
- **Front-end & Admin Support**: Option to apply transliteration on the frontend (for bbPress, BuddyPress, WooCommerce, etc.) or only within the admin panel.
- **Modern Codebase**: Implements PHP 8 strict typing and modern best practices for improved security, performance, and maintainability.

## Requirements

- PHP 8.0 or later
- WordPress 5.8 or later (latest version recommended)
- *(Optional)* WPForo plugin for forum integration

## Installation

1. **Upload the Plugin**  
   Copy the plugin folder into your `/wp-content/plugins/` directory.

2. **Activate the Plugin**  
   Activate WP Translitera through the WordPress admin dashboard under **Plugins**.

3. **Configure Settings**  
   Go to **Settings > Translitera** to customize transliteration rules and other options.

## Usage

Once activated, WP Translitera will automatically transliterate permalinks and slugs based on your defined rules. The plugin offers two main modes:

- **Standard Transliteration**: Applies the default transliteration rules.
- **Forced Transliteration**: Overrides the original title with a transliterated version if enabled.

### Custom Transliteration Rules

- Navigate to the Translitera settings page.
- Add custom rules in the provided textarea, one rule per line, using the format `character=replacement`.
- Save your settings to apply the new transliteration rules.

## Uninstallation

To uninstall WP Translitera:

1. Deactivate the plugin via the WordPress admin dashboard.
2. Delete the plugin files from the `/wp-content/plugins/` directory.  
   The uninstall script will automatically remove all stored plugin options from your database.

## Contributing

Contributions, bug reports, and feature requests are welcome! Please submit issues or pull requests through the GitHub repository.

## License

This plugin is licensed under the [GPLv2 or later](LICENSE) license.

## Credits

This fork of WP Translitera builds upon the original plugin developed by **YurchenkoEV** (Евгений Юрченко). His work laid the foundation for the transliteration features offered here. For more information about his original project or to support his work, please visit his website at [yur4enko.com](http://yur4enko.com/).
