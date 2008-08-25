<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<title><?php bloginfo('name'); ?><?php wp_title();?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php
		global $page_sort;	
		if(get_settings('justsimple_sortpages')!='')
		{ 
			$page_sort = 'sort_column='. get_settings('justsimple_sortpages');
		}	
		global $pages_to_exclude;
	
		if(get_settings('justsimple_excludepages')!='')
		{ 
			$pages_to_exclude = 'exclude='. get_settings('justsimple_excludepages');
		}	
	?>
	<?php wp_head(); ?>
</head>
<body>
<div id="menu">
		<ul>
			<li <?php if(is_home()) { echo 'class="current_page_item"';} ?>><a href="<?php bloginfo('siteurl'); ?>">Home</a></li>
			<?php wp_list_pages('title_li=&depth=1&'.$page_sort.'&'.$pages_to_exclude)?>
		</ul>
	</div>
<div id="outer">
	<div id="header">
		<form id="searchform" method="get" action="<?php bloginfo('siteurl')?>/">
			<input type="text" name="s" id="s" class="textbox" value="<?php echo wp_specialchars($s, 1); ?>" />
			<input id="btnSearch" type="submit" name="submit" value="<?php _e('Search'); ?>" />
		</form>						
		<h1><a href="<?php bloginfo('siteurl'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2><?php bloginfo("description")?></h2>			
	</div>
	<div id="feedinfo">
		<em><span class="feed"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Posts RSS'); ?></a></span> <span class="feed"><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments RSS'); ?></a></span></em>
		<?php global $numposts; echo $numposts;?> <?php _e('Posts'); ?> <?php _e('and');?> <?php global $numcmnts; echo $numcmnts;?> <?php _e('Comments'); ?> <?php _e('till now'); ?>
	</div>