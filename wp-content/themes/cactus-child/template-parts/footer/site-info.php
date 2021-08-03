<?php
global $cactus_options;
?>
<div class="footer-info-area text-center">

	<?php
	if (isset($cactus_options['footer_logo']) && $cactus_options['footer_logo'] != '')
		echo '<div class="footer-logo cactus-footer-logo"><img src="' . esc_url($cactus_options['footer_logo']) . '" alt=""></div>';
	?>
	<?php
	if (isset($cactus_options['enable_footer_icons']) && $cactus_options['enable_footer_icons'] == '1') :

	?>
		<ul class="footer-sns cactus-footer-sns">
			<?php
			for ($i = 1; $i <= 5; $i++) {
				if (isset($cactus_options['footer_icon_' . $i]) &&  $cactus_options['footer_icon_' . $i] != '') {
					$link = isset($cactus_options['footer_icon_link_' . $i]) ? $cactus_options['footer_icon_link_' . $i] : '#';
			?>
					<li><a href="<?php echo esc_url($link); ?>" target="_blank"><i class="fa <?php echo esc_attr($cactus_options['footer_icon_' . $i]); ?>"></i></a></li>
			<?php
				}
			}
			?>
		</ul>
	<?php endif;	?>

	<?php if (g_cua('administrator', 'seceditor', 'maineditor', 'tech')) { ?>
		<div class="site-info"><b>Кошелёк для пожертвований (yandex-money):</b> 410011554314005 </div>
	<?php } ?>
	<div class="site-info"><?php _e('Designed by VelaThemes & <b>LIK</b>. All Rights Reserved.', 'cactus'); ?> </div>
</div>