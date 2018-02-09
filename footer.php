	
			<footer>
				<?php if (is_active_sidebar('footer1')) : ?>
					<div class="widget-location">
						<?php dynamic_sidebar('footer1'); ?>
					</div>
				<?php endif; ?>
				<p><?php // echo date('Y'); ?></p>
			</footer>
		</div> <!-- Site -->
		
		<?php if (is_active_sidebar('footer2')) : ?>
		<aside id="footer-beneath">
			<div class="container">
				<button id="btn-footer-beneath-close">I'm done here</button>
				<div class="widget-location">
					<?php dynamic_sidebar('footer2'); ?>
				</div>
			</div>
		</aside>
		<?php endif; ?>

		<?php wp_footer(); ?>
	</body>
</html>