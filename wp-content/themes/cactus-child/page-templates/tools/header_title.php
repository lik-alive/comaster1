<section class="page-title-bar title-left">
	<div class="container title-box">
		<hgroup class="page-title">
			<h1>
				<?php
				if (isset($customtitle)) echo $customtitle;
				else the_title();
				?>
			</h1>
		</hgroup>

		<div class="breadcrumb-nav">
			<?php cactus_breadcrumbs(); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</section>

<?php
$username = g_gcu();

if ($username == 'doeditor') {
	$idsec = '1';
} else if ($username == 'oieditor' || $username == 'vmyas' || $username == 'vserg') {
	$idsec = '3';
} else if ($username == 'cmeditor') {
	$idsec = '4';
} else {
	$idsec = '777';
}
?>