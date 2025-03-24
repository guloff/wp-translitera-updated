<?php
/**
 * Plugin Name: WP Translitera Updated
 * Plugin URI: https://example.com/wp-translitera
 * Description: Plugin for transliterating permanent permalinks of posts, pages, and tags.
 * Version: 1.0.0
 * Original Author: Evgen Yurchenko
 * Updated Version Author: Rustam Gulov
 * Text Domain: wp-translitera
 * Domain Path: /languages/
 * License: GPL2
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WP_Translitera {

    /**
     * Returns an array of transliteration rules based on locale.
     *
     * @return array
     */
    protected static function createLocale(): array {
        $loc = get_locale();
        $ret = [];
        if ($loc === 'ru_RU') {
            $ret = [
                'А' => 'A', 'а' => 'a', 'Б' => 'B', 'б' => 'b', 'В' => 'V', 'в' => 'v', 'Г' => 'G',
                'г' => 'g', 'Д' => 'D', 'д' => 'd', 'Е' => 'E', 'е' => 'e', 'Ё' => 'Jo', 'ё' => 'jo',
                'Ж' => 'Zh', 'ж' => 'zh', 'З' => 'Z', 'з' => 'z', 'И' => 'I', 'и' => 'i', 'Й' => 'J',
                'й' => 'j', 'К' => 'K', 'к' => 'k', 'Л' => 'L', 'л' => 'l', 'М' => 'M', 'м' => 'm',
                'Н' => 'N', 'н' => 'n', 'О' => 'O', 'о' => 'o', 'П' => 'P', 'п' => 'p', 'Р' => 'R',
                'р' => 'r', 'С' => 'S', 'с' => 's', 'Т' => 'T', 'т' => 't', 'У' => 'U', 'у' => 'u',
                'Ф' => 'F', 'ф' => 'f', 'Х' => 'H', 'х' => 'h', 'Ц' => 'C', 'ц' => 'c', 'Ч' => 'Ch',
                'ч' => 'ch', 'Ш' => 'Sh', 'ш' => 'sh', 'Щ' => 'Shh', 'щ' => 'shh', 'Ъ' => '',
                'ъ' => '', 'Ы' => 'Y', 'ы' => 'y', 'Ь' => '', 'ь' => '', 'Э' => 'Je', 'э' => 'je',
                'Ю' => 'Ju', 'ю' => 'ju', 'Я' => 'Ja', 'я' => 'ja'
            ];
        } elseif ($loc === 'uk') {
            $ret = [
                'А' => 'A', 'а' => 'a', 'Б' => 'B', 'б' => 'b', 'В' => 'V', 'в' => 'v', 'Г' => 'H',
                'г' => 'h', 'Ґ' => 'G', 'ґ' => 'g', 'Д' => 'D', 'д' => 'd', 'Е' => 'E', 'е' => 'e',
                'Є' => 'Ie', 'є' => 'ie', 'Ж' => 'Zh', 'ж' => 'zh', 'З' => 'Z', 'з' => 'z', 'И' => 'Y',
                'и' => 'y', 'І' => 'I', 'і' => 'i', 'Ї' => 'I', 'ї' => 'i', 'Й' => 'I', 'й' => 'i',
                'К' => 'K', 'к' => 'k', 'Л' => 'L', 'л' => 'l', 'М' => 'M', 'м' => 'm', 'Н' => 'N',
                'н' => 'n', 'О' => 'O', 'о' => 'o', 'П' => 'P', 'п' => 'p', 'Р' => 'R', 'р' => 'r',
                'С' => 'S', 'с' => 's', 'Т' => 'T', 'т' => 't', 'У' => 'U', 'у' => 'u', 'Ф' => 'F',
                'ф' => 'f', 'Х' => 'Kh', 'х' => 'kh', 'Ц' => 'Ts', 'ц' => 'ts', 'Ч' => 'Ch', 'ч' => 'ch',
                'Ш' => 'Sh', 'ш' => 'sh', 'Щ' => 'Shch', 'щ' => 'shch', 'Ь' => '', 'ь' => '', 'Ю' => 'Iu',
                'ю' => 'iu', 'Я' => 'Ia', 'я' => 'ia', "'" => ''
            ];
        } elseif ($loc === 'bg' || $loc === 'bg_BG') {
            $ret = [
                'А' => 'A', 'а' => 'a', 'Б' => 'B', 'б' => 'b', 'В' => 'V', 'в' => 'v', 'Г' => 'G',
                'г' => 'g', 'Д' => 'D', 'д' => 'd', 'Е' => 'E', 'е' => 'e', 'Ё' => 'Jo', 'ё' => 'jo',
                'Ж' => 'Zh', 'ж' => 'zh', 'З' => 'Z', 'з' => 'z', 'И' => 'I', 'и' => 'i', 'Й' => 'J',
                'й' => 'j', 'К' => 'K', 'к' => 'k', 'Л' => 'L', 'л' => 'l', 'М' => 'M', 'м' => 'm',
                'Н' => 'N', 'н' => 'n', 'О' => 'O', 'о' => 'o', 'П' => 'P', 'п' => 'p', 'Р' => 'R',
                'р' => 'r', 'С' => 'S', 'с' => 's', 'Т' => 'T', 'т' => 't', 'У' => 'U', 'у' => 'u',
                'Ф' => 'F', 'ф' => 'f', 'Х' => 'H', 'х' => 'h', 'Ц' => 'C', 'ц' => 'c', 'Ч' => 'Ch',
                'ч' => 'ch', 'Ш' => 'Sh', 'ш' => 'sh', 'Щ' => 'Sht', 'щ' => 'sht', 'Ъ' => 'a',
                'ъ' => 'a', 'Ы' => 'Y', 'ы' => 'y', 'Ь' => '', 'ь' => '', 'Э' => 'Je', 'э' => 'je',
                'Ю' => 'Ju', 'ю' => 'ju', 'Я' => 'Ja', 'я' => 'ja'
            ];
        }

        // Глобальные правила транслитерации
        $ret = $ret + [
            'А' => 'A', 'а' => 'a', 'Б' => 'B', 'б' => 'b', 'В' => 'V', 'в' => 'v', 'Г' => 'G',
            'г' => 'g', 'Д' => 'D', 'д' => 'd', 'Е' => 'E', 'е' => 'e', 'Ё' => 'Jo', 'ё' => 'jo',
            'Ж' => 'Zh', 'ж' => 'zh', 'З' => 'Z', 'з' => 'z', 'И' => 'I', 'и' => 'i', 'Й' => 'J',
            'й' => 'j', 'К' => 'K', 'к' => 'k', 'Л' => 'L', 'л' => 'l', 'М' => 'M', 'м' => 'm',
            'Н' => 'N', 'н' => 'n', 'О' => 'O', 'о' => 'o', 'П' => 'P', 'п' => 'p', 'Р' => 'R',
            'р' => 'r', 'С' => 'S', 'с' => 's', 'Т' => 'T', 'т' => 't', 'У' => 'U', 'у' => 'u',
            'Ф' => 'F', 'ф' => 'f', 'Х' => 'H', 'х' => 'h', 'Ц' => 'C', 'ц' => 'c', 'Ч' => 'Ch',
            'ч' => 'ch', 'Ш' => 'Sh', 'ш' => 'sh', 'Щ' => 'Shh', 'щ' => 'shh', 'Ъ' => '',
            'ъ' => '', 'Ы' => 'Y', 'ы' => 'y', 'Ь' => '', 'ь' => '', 'Э' => 'Je', 'э' => 'je',
            'Ю' => 'Ju', 'ю' => 'ju', 'Я' => 'Ja', 'я' => 'ja', 'Ґ' => 'G', 'ґ' => 'g', 'Є' => 'Ie',
            'є' => 'ie', 'І' => 'I', 'і' => 'i', 'Ї' => 'I', 'ї' => 'i', "'" => ''
        ];

        // Пользовательские правила транслитерации.
        $ret = self::get_custom_rules_for_transliterate() + $ret;
        return $ret;
    }

    /**
     * Возвращает пользовательские правила транслитерации с учетом регистра.
     *
     * @return array
     */
    protected static function get_custom_rules_for_transliterate(): array {
        $rulesJson = self::getset('custom_rules', json_encode([]));
        $rules = json_decode($rulesJson, true);
        if (!is_array($rules)) {
            $rules = [];
        }
        $tr_rules = [];
        foreach ($rules as $key => $value) {
            $tr_rules[$key] = $value;
            // Используем квадратные скобки для доступа к символам (PHP 8)
            $upperKey   = mb_strtoupper($key, 'UTF-8');
            $upperValue = mb_strtoupper($value[0], 'UTF-8') . mb_substr($value, 1);
            $tr_rules[$upperKey] = $upperValue;
        }
        return $tr_rules;
    }

    /**
     * Возвращает атрибут для checkbox на основе сохранённой настройки.
     *
     * @param string $name
     * @return string
     */
    protected static function getCheckbox(string $name): string {
        $value = self::getset($name);
        return empty($value) ? '' : ' checked';
    }

    /**
     * Формирует HTML форму настроек плагина.
     *
     * @return string
     */
    protected static function getForm(): string {
        $noparsevar = self::getset('fileext', []);
        $extForForm = is_array($noparsevar) ? implode(',', $noparsevar) : '';
        $customRulesJson = self::getset('custom_rules', json_encode([]));
        $customRulesArray = json_decode($customRulesJson, true);
        if (!is_array($customRulesArray)) {
            $customRulesArray = [];
        }
        $customRulesString = '';
        foreach ($customRulesArray as $key => $value) {
            $customRulesString .= $key . '=' . $value . PHP_EOL;
        }
        // Интеграция с WPForo (если плагин установлен)
        $wpforoConf = '';
        if (file_exists(WP_PLUGIN_DIR . '/wpforo/wpforo.php')) {
            $wpforoConf = '<h4>' . __('WPForo', 'wp-translitera') . ':</h4>' .
                '<input type="checkbox" name="f1" value="1">' . __('Forums', 'wp-translitera') . '<br>' .
                '<input type="checkbox" name="f2" value="1">' . __('Topics', 'wp-translitera') . '<br>';
        }
        $ret = '<h2>' . __('Convert existing', 'wp-translitera') . ':</h2><br>' .
            '<form method="post">' .
            '<input type="checkbox" name="r1" value="1">' . __('Pages and posts', 'wp-translitera') . '<br>' .
            '<input type="checkbox" name="r2" value="1">' . __('Headings, tags etc...', 'wp-translitera') . '<br>' .
            $wpforoConf .
            '<input type="submit" value="' . __('Transliterate', 'wp-translitera') . '" name="transliterate">' .
            '</form>' .
            '<h2>' . __('Settings', 'wp-translitera') . ':</h2><br>' .
            '<form method="post">' .
            '<input type="checkbox" name="use_force_transliterations" value="1"' . self::getCheckbox("use_force_transliterations") . '>' . __('Use forced transliteration for title', 'wp-translitera') . '<br>' .
            '<input type="checkbox" name="tranliterate_uploads_file" value="1"' . self::getCheckbox("tranliterate_uploads_file") . '>' . __('Transliterate names of uploads files', 'wp-translitera') . '<br>' .
            '<input type="checkbox" name="tranliterate_404" value="1"' . self::getCheckbox("tranliterate_404") . '>' . __('Transliterate 404 URL', 'wp-translitera') . '<br>' .
            '<input type="checkbox" name="init_in_front" value="1"' . self::getCheckbox("init_in_front") . '>' . __('Use transliteration in frontend for transliterating title outside admin (enable if using bbPress, BuddyPress, WooCommerce, etc.)', 'wp-translitera') . '<br>' .
            __('File extensions, separated by commas, titles that do not need transliteration', 'wp-translitera') .
            '<input type="text" size="80" name="typefiles" value="' . esc_attr($extForForm) . '"><br>' .
            '<label style="color:red;font-weight:800">' . __('Custom transliteration rules, in format я=ja (each rule on a new line)', 'wp-translitera') . '</label><br>' .
            '<textarea name="customrules" cols="30" rows="10">' . esc_textarea($customRulesString) . '</textarea><br>' .
            '<input type="submit" value="' . __('Apply', 'wp-translitera') . '" name="apply">' .
            '</form>';
        return $ret;
    }

    /**
     * Выполняет транслитерацию для указанной таблицы базы данных.
     *
     * @param string $table
     * @param string $id
     * @param string $name
     * @return void
     */
    protected static function doTransliterate(string $table, string $id, string $name): void {
        global $wpdb;
        $results = $wpdb->get_results("SELECT {$id}, {$name} FROM {$table} WHERE 1", ARRAY_A);
        foreach ($results as $row) {
            $tmp_name = self::transliterate(urldecode((string)$row[$name]));
            if ($tmp_name !== $row[$name]) {
                $wpdb->update($table, [$name => $tmp_name], [$id => $row[$id]]);
            }
        }
    }

    /**
     * Получает настройки плагина.
     *
     * @return array
     */
    protected static function getOptions(): array {
        $set = is_multisite() ? get_site_option('wp_translitera') : get_option('wp_translitera');
        return is_array($set) ? $set : [];
    }

    /**
     * Получает значение конкретной настройки.
     *
     * @param string $name
     * @param mixed $def
     * @return mixed
     */
    protected static function getset(string $name, $def = null) {
        $set = self::getOptions();
        return array_key_exists($name, $set) ? $set[$name] : $def;
    }

    /**
     * Обновляет настройки плагина.
     *
     * @param array $set
     * @return void
     */
    protected static function updateOption(array $set): void {
        if (is_multisite()) {
            update_site_option('wp_translitera', $set);
        } else {
            update_option('wp_translitera', $set);
        }
    }

    /**
     * Обновляет конкретную настройку.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    protected static function updset(string $name, $value): void {
        $set = self::getOptions();
        $set[$name] = $value;
        self::updateOption($set);
    }

    /**
     * Обновляет несколько настроек.
     *
     * @param array $sets
     * @return void
     */
    protected static function updsets(array $sets): void {
        $set = array_merge($sets, self::getOptions());
        self::updateOption($set);
    }

    /**
     * Выводит сообщение об обновлении настроек в админке.
     *
     * @param bool $need_notice
     * @return bool
     */
    protected static function updnotice(bool $need_notice = true): bool {
        if ($need_notice) {
            add_action('admin_notices', [self::class, 'noticeAdminPluginUpdated']);
        }
        return false;
    }

    /**
     * Обновление базы данных плагина.
     *
     * @param mixed $from
     * @param mixed $for
     * @return void
     */
    protected static function update_bd($from, $for): void {
        if (empty($from)) {
            $from = 160819;
        }
        if ($from == 160819) {
            if (self::getset('fileext') === null) {
                self::updset('fileext', []);
            }
            $from = 161011;
        }
        if ($from == 161011) {
            if (is_multisite()) {
                $set = self::getOptions();
                global $wpdb;
                $blog_ids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
                $original_blog_id = get_current_blog_id();
                foreach ($blog_ids as $blog_id) {
                    switch_to_blog($blog_id);
                    update_site_option('wp_translitera', $set);
                }
                switch_to_blog($original_blog_id);
            }
            $from = 170212;
        }
        if ($from == 170212) {
            $uninstallFile = __DIR__ . '/unistall.php';
            if (file_exists($uninstallFile)) {
                unlink($uninstallFile);
            }
            $from = 170510;
        }
        if ($for != $from) {
            self::updnotice();
            $from = $for;
            self::updset('version', $from);
        }
    }

    /**
     * Коллбек для отображения уведомления в админке.
     *
     * @return void
     */
    public static function noticeAdminPluginUpdated(): void {
        echo '<div class="updated" style="padding: 15px 0;">' .
            __('Plugin WP Translitera has been updated,', 'wp-translitera') .
            ' <a href="options-general.php?page=wp-translitera%2Fwp-translitera">' .
            __('update settings', 'wp-translitera') .
            '</a></div>';
    }

    /**
     * Вывод страницы настроек плагина.
     *
     * @return void
     */
    public static function main_settings(): void {
        global $wpdb;
        load_plugin_textdomain('wp-translitera', false, dirname(plugin_basename(__FILE__)) . '/languages');

        $act = filter_input(INPUT_POST, 'transliterate');
        if (!empty($act)) {
            $r1 = filter_input(INPUT_POST, 'r1');
            $r2 = filter_input(INPUT_POST, 'r2');
            if (!empty($r1)) {
                self::doTransliterate($wpdb->posts, 'ID', 'post_name');
            }
            if (!empty($r2)) {
                self::doTransliterate($wpdb->terms, 'term_id', 'slug');
            }
            // Интеграция с WPForo
            $f1 = filter_input(INPUT_POST, 'f1');
            $f2 = filter_input(INPUT_POST, 'f2');
            if (!empty($f1) || !empty($f2)) {
                $blogprefix = $wpdb->get_blog_prefix();
                if (!empty($f1)) {
                    self::doTransliterate($blogprefix . 'wpforo_forums', 'forumid', 'slug');
                }
                if (!empty($f2)) {
                    self::doTransliterate($blogprefix . 'wpforo_topics', 'topicid', 'slug');
                }
                if (function_exists('wpforo_clean_cache')) {
                    wpforo_clean_cache();
                }
            }
        }
        $setupd = filter_input(INPUT_POST, 'apply');
        $sets = [];
        if (!empty($setupd)) {
            $sets['tranliterate_uploads_file'] = filter_input(INPUT_POST, 'tranliterate_uploads_file');
            $sets['tranliterate_404'] = filter_input(INPUT_POST, 'tranliterate_404');
            $typeFiles = filter_input(INPUT_POST, 'typefiles');
            $sets['fileext'] = $typeFiles ? array_map('trim', explode(',', $typeFiles)) : [];
            $sets['use_force_transliterations'] = filter_input(INPUT_POST, 'use_force_transliterations');
            $sets['init_in_front'] = filter_input(INPUT_POST, 'init_in_front');
            $rulesString = filter_input(INPUT_POST, 'customrules');
            $rulesRawArray = explode(PHP_EOL, (string)$rulesString);
            $rulesArray = [];
            foreach ($rulesRawArray as $rule) {
                if (empty($rule) || $rule === '=') {
                    continue;
                }
                $tmp = explode('=', $rule, 2);
                if (count($tmp) === 2) {
                    $rulesArray[$tmp[0]] = $tmp[1];
                }
            }
            $sets['custom_rules'] = json_encode($rulesArray);
            self::updsets($sets);
        }
        echo self::getForm();
    }

    /**
     * Проверяет, активирован ли плагин WPForo.
     *
     * @return bool
     */
    public static function wpforoActive(): bool {
        $activePlugins = is_multisite() ? get_site_option('active_plugins') : get_option('active_plugins');
        return is_array($activePlugins) && in_array("wpforo/wpforo.php", $activePlugins, true);
    }

    /**
     * Выполняет транслитерацию строки.
     *
     * @param string $title
     * @return string
     */
    public static function transliterate(string $title): string {
        // Пропускаем транслитерацию для файлов с определёнными расширениями.
        $type = substr((string)filter_input(INPUT_POST, 'name'), -3);
        if (!empty($type)) {
            $fileExt = self::getset('fileext', []);
            if (in_array($type, $fileExt, true)) {
                return $title;
            }
        }
        return strtr($title, self::createLocale());
    }

    /**
     * Применяет принудительную транслитерацию для заголовков.
     *
     * @param string $title
     * @param string $raw_title
     * @return string
     */
    public static function transliterate_force(string $title, string $raw_title): string {
        return sanitize_title_with_dashes(self::transliterate($raw_title));
    }

    /**
     * Добавляет страницу настроек в меню админки.
     *
     * @return void
     */
    public static function add_menu(): void {
        add_options_page(
            'WP Translitera',
            'Translitera',
            'manage_options',
            'wp-translitera-settings', // Заменяем __FILE__ на удобный slug
            [self::class, 'main_settings']
        );
    }

    /**
     * Перенаправляет страницу 404 после транслитерации, если включена соответствующая настройка.
     *
     * @return void
     */
    public static function init404(): void {
        $is404 = is_404();
        if (self::wpforoActive()) {
            global $wpforo;
            if ($is404 || (isset($wpforo->current_object['is_404']) && $wpforo->current_object['is_404'])) {
                $is404 = true;
            }
        }
        if ($is404 && self::getset('tranliterate_404')) {
            $thisUrl = urldecode((string)filter_input(INPUT_SERVER, 'REQUEST_URI'));
            $trUrl = self::transliterate($thisUrl);
            if ($thisUrl !== $trUrl) {
                wp_redirect($trUrl, 301);
                exit;
            }
        }
    }

    /**
     * Обрабатывает переименование файлов, загружаемых через форму, если транслитерация включена.
     *
     * @param string $value
     * @param string $filename_raw
     * @return string
     */
    public static function rename_uploads_additional(string $value, string $filename_raw): string {
        if (self::getset('tranliterate_uploads_file')) {
            $value = self::transliterate($value);
        }
        return $value;
    }

    /**
     * Проверяет, необходимо ли обновление базы данных плагина.
     *
     * @return void
     */
    public static function needUpdate(): void {
        $from = self::getset('version');
        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $pluginData = get_plugin_data(__FILE__);
        if ($from !== $pluginData['Version']) {
            self::update_bd($from, $pluginData['Version']);
        }
    }

    /**
     * Инициализирует фильтры транслитерации.
     *
     * @return void
     */
    public static function prepare_transliterate(): void {
        if (self::getset('use_force_transliterations')) {
            add_filter('sanitize_title', [self::class, 'transliterate_force'], 25, 2);
        } else {
            add_filter('sanitize_title', [self::class, 'transliterate'], 0);
        }
    }

    /**
     * Добавляет ссылку на страницу настроек плагина в списке плагинов.
     *
     * @param array $links
     * @return array
     */
    public static function add_plugin_settings_link(array $links): array {
        $url = admin_url('options-general.php?page=wp-translitera-settings');
        $settings_link = '<a href="' . esc_url($url) . '">' . __('Settings', 'wp-translitera') . '</a>';
        $addLink = ['settings' => $settings_link];
        return $addLink + $links;
    }

    /**
     * Инициализирует работу плагина.
     *
     * @return void
     */
    public static function init(): void {
        add_action('admin_init', [self::class, 'needUpdate']);
        add_action('admin_menu', [self::class, 'add_menu']);
        $plugin_file = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin_file", [self::class, 'add_plugin_settings_link']);

        if (self::getset('init_in_front')) {
            self::prepare_transliterate();
        } else {
            add_action('admin_init', [self::class, 'prepare_transliterate']);
        }
    }

    /**
     * Рутинная установка плагина.
     *
     * @return void
     */
    public static function install(): void {
        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $pluginData = get_plugin_data(__FILE__);
        self::updset('version', $pluginData['Version']);
    }
}

// Инициализируем плагин.
add_action('init', ['WP_Translitera', 'init']);
add_action('wp', ['WP_Translitera', 'init404'], WP_Translitera::wpforoActive() ? 11 : 10);
add_filter('sanitize_file_name', ['WP_Translitera', 'rename_uploads_additional'], 10, 2);
register_activation_hook(__FILE__, ['WP_Translitera', 'install']);
