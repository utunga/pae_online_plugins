<?php
if (!defined('ABSPATH')) {
    die('-1');
}

function wpb_load_widget() {
    register_widget('quadmenu_widget');
}

add_action('widgets_init', 'wpb_load_widget');

class QuadMenu_Widget extends WP_Widget {

    function __construct() {
        self::QuadMenu_Widget();
    }

    function QuadMenu_Widget() {

        $widget_ops = array('classname' => 'widget_quadmenu_widget', 'description' => esc_html__('A widget that displays the menu in the sidebar.', 'quadmenu'));

        $control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'quadmenu_widget');

        parent::__construct('quadmenu_widget', esc_html__('QuadMenu Widget', 'quadmenu'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {

        extract($args);

        extract(shortcode_atts(array('menu' => '', 'theme' => '', 'layout' => 'inherit'), $instance));

        echo $before_widget;

        $args = array(
            'echo' => false,
            'menu' => $menu,
            'theme' => $theme,
            'layout' => $layout,
                //'layout_classes' => 'js'
        );

        echo quadmenu($args);

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['theme'] = strip_tags($new_instance['theme']);
        $instance['menu'] = strip_tags($new_instance['menu']);
        $instance['layout'] = strip_tags($new_instance['layout']);
        return $instance;
    }

    function themes($current = false) {

        global $quadmenu_themes;

        foreach ($quadmenu_themes as $key => $theme) {
            ?>
            <option value="<?php echo esc_attr($key); ?>" <?php echo selected($key, $current); ?>><?php echo esc_html($theme); ?></option>
            <?php
        }
    }

    function menus($current = false) {

        $menus = wp_get_nav_menus();

        foreach ($menus as $key => $menu) {
            ?>
            <option value="<?php echo esc_attr($menu->term_id); ?>" <?php echo selected($menu->term_id, $current); ?>><?php echo esc_html($menu->name); ?></option>
            <?php
        }
    }

    function layouts($current = false) {

        $layouts = array(
            'embed' => esc_html__('Embed', 'quadmenu'),
            'collapse' => esc_html__('Collapse', 'quadmenu'),
            'offcanvas' => esc_html__('Offcanvas', 'quadmenu'),
            'vertical' => esc_html__('Vertical', 'quadmenu'),
            'inherit' => esc_html__('Inherit', 'quadmenu'),
        );

        foreach ($layouts as $key => $layout) {
            ?>
            <option value="<?php echo esc_attr($key); ?>" <?php echo selected($key, $current); ?>><?php echo esc_html($layout); ?></option>
            <?php
        }
    }

    function form($instance) {

        $defaults = array(
            'location' => '',
            'menu' => '',
            'layout' => '',
            'theme' => '',
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('menu'); ?>"><?php esc_html_e('Menu', 'quadmenu'); ?></label>
            <select id="<?php echo $this->get_field_id('menu'); ?>" name="<?php echo $this->get_field_name('menu'); ?>" class="widefat">
                <?php echo $this->menus($instance['menu']); ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('layout'); ?>"><?php esc_html_e('layout', 'quadlayout'); ?></label>
            <select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" class="widefat">
                <?php echo $this->layouts($instance['layout']); ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('theme'); ?>"><?php esc_html_e('Theme', 'quadmenu'); ?></label>
            <select id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>" class="widefat">
                <?php echo $this->themes($instance['theme']); ?>
            </select>
        </p>
        <?php
    }

}
