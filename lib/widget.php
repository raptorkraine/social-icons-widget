<?php
global $social_accounts;

$data = array();
foreach ($social_accounts as $site => $id) {
	$data[$id] = $instance[$id];
}

extract($args);

$title = empty($instance['title']) ? 'Follow Us' : apply_filters('widget_title', $instance['title']);
$icons = $instance['icons'];
$labels = $instance['labels'];
$target = $instant['target'];
$show_title = $instance['show_title'];

echo $before_widget;

if($show_title == '') {
	echo $before_title;
	echo $title;
	echo $after_title;
}

if($labels == 'show') { $ul_class = 'show-labels '; }
else { $ul_class = ''; }
$ul_class .= 'icons-'.$icons;
?>

<ul class="<?php echo $ul_class; ?>">
<?php foreach($social_accounts as $title => $id) : ?>
	<?php if($instance[$id] != '' && $instance[$id] != 'http://') :
		
		$custom_sizes = array('custom_small','custom_medium','custom_large');
		
		if (in_array($icons, $custom_sizes)) {
			$size = str_replace("custom_","",$icons);
			$icon_path = STYLESHEETPATH .'/social_icons/'.$size.'/'.$id.'.{gif,jpg,jpeg,png}';
		}
		else {
			$siw_abs_path = str_replace('lib/', '', plugin_dir_path( __FILE__ ));
			$icon_path =  $siw_abs_path . 'icons/'.$icons.'/'.$id.'.{gif,jpg,jpeg,png}';			
		}
		
		$result = glob( $icon_path, GLOB_BRACE );

		if($result) {
			if (in_array($icons, $custom_sizes)) {
				$path = explode('themes', $result[0]);
				$icon = get_bloginfo('url').'/wp-content/themes'.$path[1];
			}
			else {
				$path = explode('plugins', $result[0]);
				$icon = plugins_url().''.$path[1];
			}
		}
		elseif( $labels != 'show' && $icons != 'small' ) {
			$icon = plugins_url().'/social-media-icons-widget/icons/'.$icons.'/_unknown.jpg';
		}
		else {
			$icon = '';
		}

		if ( $icon ) { $image = '<img class="site-icon" src="'.$icon.'" alt="'.$title.'" title="'.$title.'" />'; }
		else { $image = ''; }
		
		if($labels != 'show') { $title = ''; }
		else { $title = '<span class="site-label">'.$title.'</span>'; }
		
	?>
		<li><a href="<?php echo $instance[$id]; ?>" <?php if($target != 'show' ) { ?> target="_blank" <?php } ?>><?php echo $image; ?><?php echo $title; ?></a></li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>

<?php 
echo $after_widget;
?>
