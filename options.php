<?php
function jrodix_render_settings_page() {
    ?>
<div class="jrodix-navbar">
    <img src="<?php echo plugin_dir_url(__FILE__) . 'img/logo.png'; ?>" alt="logo" style="vertical-align: middle; margin-right: 10px; width: 50px; height: 50px;">
    <h1 style="color: #fff; display: inline-block;">WP Speeder Ayarları</h1>
</div>


    <div class="wrap settings-form">
        <form method="post" action="options.php">
            <?php
            settings_fields('jrodix_wp_speeder_settings_group');
            do_settings_sections('jrodix_wp_speeder');
            submit_button();
            ?>
        </form>
    </div>
    <div class="copyright">
        <p>JRodix.Com Internet Hizmetleri Tarafından Ücretsiz WordPress Hosting Paketlerine Tanımlanmıştır</p>
    </div>
    <?php
}

function jrodix_register_settings() {
    register_setting('jrodix_wp_speeder_settings_group', 'jrodix_wp_speeder_settings');

    add_settings_section(
        'jrodix_wp_speeder_main_section',
        'Ana Ayarlar',
        'jrodix_wp_speeder_main_section_callback',
        'jrodix_wp_speeder'
    );

    add_settings_field(
        'remove_query_strings',
        'Sorgu Dizesi\'ni Kaldır',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'remove_query_strings']
    );

    add_settings_field(
        'remove_emojis',
        'Emojiyi Kaldır',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'remove_emojis']
    );

    add_settings_field(
        'defer_js',
        'JavaScript Ayrıştırmasını Ertele',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'defer_js']
    );

    add_settings_field(
        'lazy_load_iframes',
        'Iframe Tembel Yükleme',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'lazy_load_iframes']
    );

    add_settings_field(
        'remove_jquery_migrate',
        'JS\'yi Sıradan Çıkar',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'remove_jquery_migrate']
    );

    add_settings_field(
        'remove_css',
        'CSS\'yi Sıradan Çıkar',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'remove_css']
    );


    add_settings_field(
        'convert_to_webp',
        'Resimleri WebP\'ye Dönüştür (Yalnızca Yeni Yüklenenler)',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'convert_to_webp']
    );
	 add_settings_field(
        'lazy_load_images',
        'Resimler için Lazy Load',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'lazy_load_images']
    );
	add_settings_field(
    'html_compression',
    'HTML Sıkıştır',
    'jrodix_render_switch_field',
    'jrodix_wp_speeder',
    'jrodix_wp_speeder_main_section',
    ['name' => 'html_compression']
);
       add_settings_field(
        'page_cache',
        'Sayfa Önbelleği',
        'jrodix_render_switch_field',
        'jrodix_wp_speeder',
        'jrodix_wp_speeder_main_section',
        ['name' => 'page_cache']
    );
add_settings_field(
    'cache_method',
    'Önbellek Yöntemi Seçimi',
    'jrodix_render_cache_method_field', 
    'jrodix_wp_speeder',
    'jrodix_wp_speeder_main_section',
    ['name' => 'cache_method']
);

}

function jrodix_wp_speeder_main_section_callback() {
    echo 'Bu ayarları kullanarak site performansını artırabilirsiniz.';
}

function jrodix_render_switch_field($args) {
    $options = get_option('jrodix_wp_speeder_settings');
    $checked = isset($options[$args['name']]) ? 'checked' : '';
    echo '<div class="form-field">
            <label class="switch">
                <input type="checkbox" name="jrodix_wp_speeder_settings[' . $args['name'] . ']" value="1" ' . $checked . '>
                <span class="slider round"></span>
            </label>
          </div>';
}

function jrodix_render_cache_method_field($args) {
    $options = get_option('jrodix_wp_speeder_settings');
    $selected = isset($options[$args['name']]) ? $options[$args['name']] : '';
  $connection_status = jrodix_cache_method_switcher($options); 

    echo '<div class="form-field">
            <select name="jrodix_wp_speeder_settings[' . $args['name'] . ']">
                <option value="memcached" ' . selected('memcached', $selected, false) . '>Memcached</option>
                <option value="redis" ' . selected('redis', $selected, false) . '>Redis</option>
            </select>
            <span>' . $connection_status . '</span>
          </div>';
}
add_action('admin_menu', 'jrodix_add_admin_menu');
function jrodix_add_admin_menu() {
    add_menu_page(
        'WP Speeder',
        'WP Speeder',
        'manage_options',
        'jrodix-wp-speeder',
        'jrodix_render_settings_page',
        'dashicons-admin-generic'
    );
}

add_action('admin_init', 'jrodix_register_settings');

function jrodix_convert_to_webp_switcher($attachment_id) {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['convert_to_webp'])) {
        $upload_dir = wp_upload_dir();
        $file_path = get_attached_file($attachment_id);
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $webp_file_path = preg_replace('/\.[^.\s]{3,4}$/', '', $file_path) . '.webp';
            if (function_exists('imagewebp')) {
                $image = wp_get_image_editor($file_path);
                if (!is_wp_error($image)) {
                    $image->set_quality(80); 
                    $image->save($webp_file_path, 'image/webp');
                }
            }
        }
    }
}
add_action('add_attachment', 'jrodix_convert_to_webp_switcher');
function jrodix_webp_support($url) {
    $extension = pathinfo($url, PATHINFO_EXTENSION);
    if (in_array($extension, array('jpg', 'jpeg', 'png'))) {
        $webp_url = preg_replace('/\.[^.\s]{3,4}$/', '', $url) . '.webp';
        if (file_exists(str_replace(site_url(), ABSPATH, $webp_url))) {
            $url = $webp_url;
        }
    }
    return $url;
}
add_filter('wp_get_attachment_url', 'jrodix_webp_support');
function jrodix_cache_method_switcher($options) {
    if (isset($options['cache_method'])) {
        $cache_method = $options['cache_method'];
        if ($cache_method === 'memcached' && class_exists('Memcached')) {
            $memcached = new Memcached();
            $memcached->addServer('127.0.0.1', 11211);
            $connected = $memcached->getVersion();
            if (!$connected) {
                return 'Bağlantı Başarısız. Sunucunuz Desteklemiyor.';
            } else {
                return 'Bağlantı Başarılı.';
            }
        } elseif ($cache_method === 'redis' && class_exists('Redis')) {
            $redis = new Redis();
            $connected = $redis->connect('127.0.0.1', 6379);
            if (!$connected) {
                return 'Bağlantı Başarısız. Sunucunuz Desteklemiyor.';
            } else {
                return 'Bağlantı Başarılı.';
            }
        }
    }
    return 'Bağlantı Başarısız. Sunucunuz Desteklemiyor.';
}
function jrodix_enable_lazy_load() {
    $options = get_option('jrodix_wp_speeder_settings');
    if (isset($options['lazy_load_images']) && $options['lazy_load_images'] == 1) {
        add_filter('the_content', 'jrodix_lazy_load_images');
    }
}
add_action('wp', 'jrodix_enable_lazy_load');
function jrodix_lazy_load_images($content) {
    $content = preg_replace_callback(
        '/(<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]+>)/',
        function($match) {
            $new_image = str_replace('<img', '<img loading="lazy"', $match[1]);
            return $new_image;
        },
        $content
    );

    return $content;
}
add_action('init', 'jrodix_cache_method_switcher');
function jrodix_cache_headers() {
    header("Cache-Control: public");
    header("Expires: " . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT'); 
    header("Age: 3600"); 
    header("Last-Modified: " . gmdate('D, d M Y H:i:s', time()) . ' GMT');
    header("ETag: " . md5(get_permalink())); 
    header("X-Cache-Enabled: true");
    header("X-Srcache-Store-Status: MISS");
    header("X-Srcache-Fetch-Status: MISS");
	header("X-Srcache-Fetch-Status: MISS");
	
}
add_action('init', 'jrodix_cache_headers');
add_action('wp_loaded', 'jrodix_compress_html_output');

function jrodix_compress_html_output() {
    ob_start('jrodix_compress_html');
}
function jrodix_compress_html($buffer) {
    $search = array(
        '/\>[^\S ]+/s', 
        '/[^\S ]+\</s',     
        '/(\s)+/s',       
    );
    $replace = array(
        '>',
        '<',
        '\\1',
    );

    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}
?>

