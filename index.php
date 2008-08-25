<?php get_header()?>
	<div id="content">
		<div id="main">
					
	<?php if ($posts) {
		$AsideId = get_settings('justsimple_asideid');
		function stupid_hack($str)
		{
			return preg_replace('|</ul>\s*<ul class="asides">|', '', $str);
		}
		ob_start('stupid_hack');
		foreach($posts as $post)
		{
			start_wp();
	?>
	<?php if ( in_category($AsideId) && !is_single() ) : ?>
		<ul class="asides">
			<li id="p<?php the_ID(); ?>">
				<?php echo wptexturize($post->post_content); ?>							
				<br/>
				<?php comments_popup_link('(0)', '(1)','(%)')?>  | <a href="<?php the_permalink(); ?>" title="Permalink: <?php echo wptexturize(strip_tags(stripslashes($post->post_title), '')); ?>" rel="bookmark">#</a> <?php edit_post_link('(edit)'); ?>
			</li>						
		</ul>
	<?php else: // If it's a regular post or a permalink page ?>
		<div class="post">
			<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="post-content">
				<?php the_content('Continue Reading &#187;'); ?>
				<?php wp_link_pages(); ?>		
				<p class="post-info">
					<?php the_author_posts_link() ?> :: <?php the_time('M.d.Y'); ?> :: 
					<?php the_category(', ') ?> <?php edit_post_link(); ?> :: 
					<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
				</p>
				<!--
				<?php trackback_rdf(); ?>
				-->
			</div>
			<?php comments_template(); ?>
		</div>
	<?php endif; // end if in category ?>
	<?php
		}
	} // end if (posts)
	else
		{
			echo '<p>Sorry, No Posts matched your criteria.</p>';
		}
	?>
		<p align="center"><?php posts_nav_link() ?></p>
		</div>
	</div>
<?php get_sidebar();?>
<?php get_footer();?>