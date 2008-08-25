<?php get_header()?>
	<div id="content">
		<div id="main">
			<div class="post">
<?php
	global $wp_query;
	$curauth = $wp_query->get_queried_object();
?>
<h2>About: <?php echo $curauth->nickname; ?></h2>

<strong>Full Name</strong>
<p><?php echo $curauth->first_name. ' ' . $curauth->last_name ;?></p>
<strong>Website</strong>
<p><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
<strong>Details</strong>
<p><?php echo $curauth->description; ?></p>


			<h2>Posts by <?php echo $curauth->nickname; ?>:</h2>
			<ul class="authorposts">
			<!-- The Loop -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a> [<?php the_time('d M Y'); ?>]
			</li>
			<?php endwhile; else: ?>
			<p><?php _e('No posts by this author.'); ?></p>

			<?php endif; ?>
			<!-- End Loop -->			
		</ul>
		<p align="center"><?php posts_nav_link() ?></p>
	</div>
		</div>
	</div>
<?php get_sidebar();?>
<?php get_footer();?>