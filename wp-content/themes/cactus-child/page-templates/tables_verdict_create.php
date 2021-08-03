<?php
/*
		Template Name: Tables Verdict Create
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/table-create.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>

	<script>
		$(document).ready(function() {
			<?php
			$id = g_si($_GET['id']);
			if ($id != '') {
				$verdict = tables_view_verdict($id);
			}
			?>

			onReadyScript('<?php echo $id; ?>', 'verdict', '<?php echo admin_url('admin-ajax.php'); ?>');
		});
	</script>

<?php } ?>

<div class="page-wrap">
	<div class="container">
		<div class="page-inner row right-aside">
			<div class="col-main">
				<section class="post-main" role="main" id="content">
					<article class="post-entry text-left" style='padding:0px'>

						<?php
						if (g_cua('administrator')) {

						?>
							<div class='actions-panel'>
								<table class='borderless'>
									<tr>
										<td>
											<button class='btn btn-accept' form='createForm'>
												<table class='borderless'>
													<tr>
														<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/check.png' /></td>
														<td class='btn-title'>Принять</td>
													</tr>
												</table>
											</button>
										</td>

										<?php if (!is_null($verdict)) { ?>
											<td class='righted'>
												<button id='delete' class='btn btn-reject'>
													<table class='borderless'>
														<tr>
															<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/cross.png' /></td>
															<td class='btn-title'>Удалить</td>
														</tr>
													</table>
												</button>
											</td>
										<?php } ?>
									</tr>
								</table>
							</div>
							<div style='height:5px;background-color:#F5F5F5;'></div>

							<form id='createForm' method='post'>
								<div style='overflow-x:auto'>
									<table class='borderless'>
										<tr>
											<td>Название</td>
											<td><input type='text' name='Title' style='width:auto' value='<?php echo $verdict->Title ?>' required /></td>
										</tr>
									</table>
								</div>
							</form>
							<br />

							<?php include 'tools/confirm_dialog.php'; ?>

						<?php
						} else {
							echo 'Авторизуйтесь, чтобы получить доступ к странице';
						};
						?>
						<div style='height:20px;background-color:#F5F5F5;'></div>
					</article>
				</section>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>