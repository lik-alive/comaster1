<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<?php g_lu(); ?>
</head>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	var SITE_URL = "<?php echo site_url() ?>";
	$(document).ready(function() {
		$('#id_user').change(function() {
			$.ajax({
				type: 'POST',
				url: '<?php echo admin_url('admin-ajax.php'); ?>?action=g_chu&idu=' + this.value,
				contentType: false,
				processData: false,
				success: function(response) {
					location.reload();
				}
			});
		});
	});
</script>

<body <?php body_class('page blog'); ?>>
	<div class="wrapper">
		<!--Header-->
		<?php
		$header_image = get_header_image();
		if ($header_image)
			echo '<img class="header-image" src="' . esc_url($header_image) . '" alt="" />';

		?>
		<?php get_template_part('template-parts/header/header', 'classic'); ?>

		<?php if (g_scua('administrator') && g_gtm()) { ?>
			<div>
				<select id='id_user'>
					<option value='777' <?php if (g_gcu() == 'administrator') echo 'selected' ?>>Администратор</option>
					<option value='1' <?php if (g_gcu() == 'doeditor') echo 'selected' ?>>Редактор "ДО"</option>
					<option value='2' <?php if (g_gcu() == 'oieditor') echo 'selected' ?>>Редактор "ОИ"</option>
					<option value='3' <?php if (g_gcu() == 'cmeditor') echo 'selected' ?>>Редактор "ЧМ"</option>
					<option value='4' <?php if (g_gcu() == 'tech') echo 'selected' ?>>Тех. редактор</option>
					<option value='5' <?php if (g_gcu() == 'maineditor') echo 'selected' ?>>Главный редактор</option>
				</select>
			</div>
		<?php } ?>