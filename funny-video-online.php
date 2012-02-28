<?php
/*
Plugin Name: Funny video online
Plugin URI: http://www.onlinerel.com/wordpress-plugins/
Description: Plugin "Funny video online" displays Funny video on your blog. There are over 10,000 video clips.
Version: 2.6
Author: A.Kilius
Author URI: http://www.onlinerel.com/wordpress-plugins/
*/

define(funny_video_online_URL_RSS_DEFAULT, 'http://www.weekendjoy.com/weekend/funny-video/feed/');
define(funny_video_online_TITLE, 'Funny video online');
define(funny_video_online_MAX_SHOWN_ITEMS, 3);

function funny_video_online_widget_ShowRss($args)
{
	$options = get_option('funny_video_online_widget');
	if( $options == false ) {
		$options[ 'funny_video_online_widget_url_title' ] = funny_video_online_TITLE;
		$options[ 'funny_video_online_widget_RSS_count_items' ] = funny_video_online_MAX_SHOWN_ITEMS;
	}
  $feed = funny_video_online_URL_RSS_DEFAULT;
	$title = $options[ 'funny_video_online_widget_url_title' ];

$rss = fetch_feed( $feed );
		if ( !is_wp_error( $rss ) ) :
			$maxitems = $rss->get_item_quantity($options['funny_video_online_widget_RSS_count_items'] );
			$items = $rss->get_items( 0, $maxitems );
		endif;
	 $output .= '<ul>';	
	if($items) { 
 			foreach ( $items as $item ) :
				// Create post object
  $titlee = trim($item->get_title()); 
  if ($enclosure = $item->get_enclosure())
	{ 
 $output .= '<li> <a href="';
 $output .=  $item->get_permalink();
  $output .= '"  title="'.$titlee.'" target="_blank">';
   $output .= '<img src="'.$enclosure->link.'"  alt="'.$titlee.'"  title="'.$titlee.'" /></a> ';
	 $output .= '</li>'; 
	}
	  		endforeach;		
	}
$output .= '</ul> ';	 			
extract($args);	
 echo $before_widget;  
 echo $before_title . $title . $after_title;  
echo $output;  
echo $after_widget;  
 }

function funny_video_online_widget_Admin()
{
	$options = $newoptions = get_option('funny_video_online_widget');	
	//default settings
	if( $options == false ) {
		$newoptions[ 'funny_video_online_widget_url_title' ] = funny_video_online_TITLE;
		$newoptions['funny_video_online_widget_RSS_count_items'] = funny_video_online_MAX_SHOWN_ITEMS;		
	}
	if ( $_POST["funny_video_online_widget_RSS_count_items"] ) {
		$newoptions['funny_video_online_widget_url_title'] = strip_tags(stripslashes($_POST["funny_video_online_widget_url_title"]));
$newoptions['funny_video_online_widget_RSS_count_items'] = strip_tags(stripslashes($_POST["funny_video_online_widget_RSS_count_items"]));
	}	
		
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('funny_video_online_widget', $options);		
	}
	$funny_video_online_widget_url_title = wp_specialchars($options['funny_video_online_widget_url_title']);
	$funny_video_online_widget_RSS_count_items = $options['funny_video_online_widget_RSS_count_items'];	
	?> 	<p><label for="funny_video_online_widget_url_title"><?php _e('Title:'); ?> <input style="width: 350px;" id="funny_video_online_widget_url_title" name="funny_video_online_widget_url_title" type="text" value="<?php echo $funny_video_online_widget_url_title; ?>" /></label></p> 
	<p><label for="funny_video_online_widget_RSS_count_items"><?php _e('Count Items To Show:'); ?> <input  id="funny_video_online_widget_RSS_count_items" name="funny_video_online_widget_RSS_count_items" size="2" maxlength="2" type="text" value="<?php echo $funny_video_online_widget_RSS_count_items?>" /></label></p>
	<?php
}


add_filter("plugin_action_links", 'funny_video_online_ActionLink', 10, 2);
function funny_video_online_ActionLink( $links, $file ) {
	    static $this_plugin;		
		if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__); 
        if ( $file == $this_plugin ) {
			$settings_link = "<a href='".admin_url( "options-general.php?page=".$this_plugin )."'>". __('Settings') ."</a>";
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

function funny_video_online_options() {	
	?>
	<div class="wrap">
<h2>Funny video online</h2>
<p>                                
<b>Plugin "Funny video online" displays Funny video on your blog. There are over 10,000 video clips.
Add Funny YouTube videos to your sidebar on your blog using  a widget.</b> </p>
<p> <h3>Add the widget "Funny video online"  to your sidebar from <a href="<? echo "./widgets.php";?>"> Appearance->Widgets</a> and configure the widget options.</h3>  
<h3>More <a href="http://www.onlinerel.com/wordpress-plugins/" target="_blank"> WordPress Plugins</a></h3>
</p>
 	</div>     
	
	<?php
}

function funny_video_online_widget_Init()
{
  register_sidebar_widget(__('Funny video online'), 'funny_video_online_widget_ShowRss');
  register_widget_control(__('Funny video online'), 'funny_video_online_widget_Admin', 500, 250);
}
add_action("plugins_loaded", "funny_video_online_widget_Init");

add_action('admin_menu', 'funny_video_online_menu');
function funny_video_online_menu() {
	 add_menu_page('Funny video online', 'Funny video online', 8, __FILE__, 'funny_video_online_options');
}

?>