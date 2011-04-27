<?php
/*
Plugin Name: Funny video online
Plugin URI: http://www.onlinerel.com/wordpress-plugins/
Description: Plugin "Funny video online" displays Funny video on your blog. There are over 10,000 video clips. Add Funny YouTube videos to your sidebar on your blog using  a widget.
Version: 2.3
Author: A.Kilius
Author URI: http://www.onlinerel.com/wordpress-plugins/
*/
define(funny_video_online_URL_RSS_DEFAULT, 'http://fun.onlinerel.com/category/funny-video/feed/');
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
	if ( $_POST["funny_video_online_widget-submit"] ) {
		$newoptions['funny_video_online_widget_url_title'] = strip_tags(stripslashes($_POST["funny_video_online_widget_url_title"]));
				$newoptions['funny_video_online_widget_RSS_count_items'] = strip_tags(stripslashes($_POST["funny_video_online_widget_RSS_count_items"]));
	}	
		
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('funny_video_online_widget', $options);		
	}
	$funny_video_online_widget_url_title = wp_specialchars($options['funny_video_online_widget_url_title']);
	$funny_video_online_widget_RSS_count_items = $options['funny_video_online_widget_RSS_count_items'];
	
	?><form method="post" action="">	

	<p><label for="funny_video_online_widget_url_title"><?php _e('Title:'); ?> <input style="width: 350px;" id="funny_video_online_widget_url_title" name="funny_video_online_widget_url_title" type="text" value="<?php echo $funny_video_online_widget_url_title; ?>" /></label></p>
 
	<p><label for="funny_video_online_widget_RSS_count_items"><?php _e('Count Items To Show:'); ?> <input  id="funny_video_online_widget_RSS_count_items" name="funny_video_online_widget_RSS_count_items" size="2" maxlength="2" type="text" value="<?php echo $funny_video_online_widget_RSS_count_items?>" /></label></p>
	
	<br clear='all'></p>
	<input type="hidden" id="funny_video_online_widget-submit" name="funny_video_online_widget-submit" value="1" />	
	</form>
	<?php
}

add_action('admin_menu', 'funny_video_online_menu');
function funny_video_online_menu() {
	add_options_page('Funny video online', 'Funny video online', 8, __FILE__, 'funny_video_online_options');
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
</p>
 <hr /> <hr />

  <h2>Funny photos</h2>
<p><b>Plugin "Funny Photos" displays Best photos of the day and Funny photos on your blog. There are over 5,000 photos.
Add Funny Photos to your sidebar on your blog using  a widget.</b> </p>
 <h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/funny-photos/">Funny photos</h3></a> 
 <hr />
  <h2>Blog Promotion</h2>  
<p>                                                    
<b>If you produce original news or entertainment content, you can tap into one of the most technologically advanced traffic exchanges among blogs! Start using our Blog Promotion plugin on your site and receive 150%-300% extra traffic free! 
Idea is simple - the more traffic you send to us, the more we can send you back.</b>
</p>                       

 <h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/blog-promotion/">Blog Promotion</h3></a> 
 
 <hr />
   		<h2>Joke of the Day</h2>
<p><b>Plugin "Joke of the Day" displays categorized jokes on your blog. There are over 40,000 jokes in 40 categories. Jokes are saved on our database, so you don't need to have space for all that information. </b> </p>
 <h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/joke-of-the-day/">Joke of the Day</h3></a>
   <hr />
 <h2>Real Estate Finder</h2>
<p><b>Plugin "Real Estate Finder" gives visitors the opportunity to use a large database of real estate.
Real estate search for U.S., Canada, UK, Australia</b> </p>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/real-estate-finder/">Real Estate Finder</h3></a>
 <hr />

 <h2>Jobs Finder</h2>
<p><b>Plugin "Jobs Finder" gives visitors the opportunity to more than 1 million offer of employment.
Jobs search for U.S., Canada, UK, Australia</b> </p>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/jobs-finder/">Jobs Finder</h3></a>
 <hr />
		<h2>Recipe of the Day</h2>
<p><b>Plugin "Recipe of the Day" displays categorized recipes on your blog. There are over 20,000 recipes in 40 categories. Recipes are saved on our database, so you don't need to have space for all that information.</b> </p>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/recipe-of-the-day/">Recipe of the Day</h3></a>
 <hr />
<h2>WP Social Bookmarking</h2>
<p><b>WP-Social-Bookmarking plugin will add a image below your posts, allowing your visitors to share your posts with their friends, on FaceBook, Twitter, Myspace, Friendfeed, Technorati, del.icio.us, Digg, Google, Yahoo Buzz, StumbleUpon.</b></p>
<p><b>Plugin suport sharing your posts feed on <a target="_blank" href="http://www.homeshopworld.com/">Home Shop World</a>. This helps to Promotion your blog and get more traffic.</b></p>
<p>Advertise your real estate, cars, items... Buy, Sell, Rent. Promote your site:
<ul>
	<li><a target="_blank" href="http://www.onlinerel.com/">OnlineRel</a></li>
	<li><a target="_blank" href="http://www.homeshopworld.com/">Home Shop World</a></li>
	<li><a target="_blank" href="http://www.ecobun.com/">Ecology and Health</a></li>
	 <li><a target="_blank" href="http://www.activehotelguide.com/">Travel</a></li>
</ul>
<h3>Get plugin <a target="_blank" href="http://wordpress.org/extend/plugins/wp-social-bookmarking/">WP Social Bookmarking</h3></a>
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
?>