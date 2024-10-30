<?php
/*
Plugin Name: Leaflet Map Widget
Plugin URI: https://emojized.com
Description: An extra widget for Leaflet Map and it depends on it.
Author: emojized
Version: 0.2
Author URI: https://emojized.com
License: GPL2
Text Domain: leafletmapwidget
Domain Path: /languages

Copyright (c) 2016 WP-Plugin-Dev.com

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

/**
* Class and Function List:
* Function list:
* - register_LeafletMap_widget()
* - leafletmapwidget_init()
* - __construct()
* - widget()
* - form()
* - update()
* Classes list:
* - LeafletMapWidget extends WP_Widget
*/

function register_LeafletMap_widget()
{
    register_widget('LeafletMapwidget');
}
add_action('widgets_init', 'register_LeafletMap_widget');

add_action('init', 'leafletmapwidget_init');
function leafletmapwidget_init()
{

    $path   = dirname(plugin_basename(__FILE__)) . '/languages/';
    $loaded = load_plugin_textdomain('leafletmapwidget', false, $path);
}

/**
 * Adds LeafletMapWidget widget.
 */
class LeafletMapWidget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct('LeafletMapwidget', // Base ID
        __('LeafletMap Widget', 'leafletmap') , // Name
        array(
            'description' => __('A LeafletMap Widget - use this as the solution, that Google needs an API Key for showing their maps.', 'leafletmap') ,
        ) // Args
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title']))
        {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo do_shortcode('[leaflet-map address="' . $instance['address'] . ',' . $instance['postcode_town'] . '" zoom=' . $instance['zoomlevel'] . ' scrollwheel=1][leaflet-marker]');

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title         = !empty($instance['title']) ? $instance['title'] : __('New title', 'leafletmapwidget');
        $adresse       = !empty($instance['address']) ? $instance['address'] : __('address', 'leafletmapwidget');
        $postcode_town = !empty($instance['postcode_town']) ? $instance['postcode_town'] : __('postcode_town', 'leafletmapwidget');
        $zoomlevel     = !empty($instance['zoomlevel']) ? $instance['zoomlevel'] : __('17', 'leafletmapwidget');

?>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e(esc_attr('Title:')); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>

		<p>
			<label for="adresse" ><?php _e('Address', 'leafletmapwidget'); ?>:</label><br>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($adresse); ?>">
		</p>
		<p>
			<label for="postcode_town" ><?php _e('Postcode Town, Country', 'leafletmapwidget'); ?>:</label><br>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('postcode_town')); ?>" name="<?php echo esc_attr($this->get_field_name('postcode_town')); ?>" type="text" value="<?php echo esc_attr($postcode_town); ?>">
		</p>

		<p>
			<label for="zoomlevel" ><?php _e('Zoomlevel (1 = World , 18 very detailed)', 'leafletmapwidget'); ?>:</label><br>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('zoomlevel')); ?>" name="<?php echo esc_attr($this->get_field_name('zoomlevel')); ?>" type="number" min=1 max=18 value="<?php echo esc_attr($zoomlevel); ?>">
		</p>



		<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title']          = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['postcode_town']          = (!empty($new_instance['postcode_town'])) ? strip_tags($new_instance['postcode_town']) : '';
        $instance['address']          = (!empty($new_instance['address'])) ? strip_tags($new_instance['address']) : '';
        $instance['zoomlevel']          = (!empty($new_instance['zoomlevel'])) ? strip_tags($new_instance['zoomlevel']) : '';

        return $instance;
    }

} // class LeafletMapWidget



?>