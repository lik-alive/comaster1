<?php
/*
		Template Name: Tables Section Create
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
				$section = tables_view_section($id);
			}
			?>

			onReadyScript('<?php echo $id; ?>', 'section', '<?php echo admin_url('admin-ajax.php'); ?>');
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
							$experts = tables_list_expert_ids_tostr();
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

										<?php if (!is_null($section)) { ?>
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
											<td><input type='text' name='Title' style='width:100%' value='<?php echo $section->Title ?>' required /></td>
										</tr>

										<tr>
											<td>Краткое название</td>
											<td><input type='text' name='ShortTitle' value='<?php echo $section->ShortTitle ?>' required /></td>
										</tr>
										<tr>
											<td>Редактор</td>
											<td>
												<select name='ID_Expert' required>
													<?php
													echo "<option value=''>---</option>";
													foreach ($experts as $item) {
														if ($item->ID_Expert == $section->ID_Expert)
															echo "<option value='{$item->ID_Expert}' selected >{$item->Name}</option>";
														else
															echo "<option value='{$item->ID_Expert}' >{$item->Name}</option>";
													}
													?>
												</select>
											</td>
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