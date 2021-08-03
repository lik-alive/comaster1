<?php
/*
		Template Name: Tables Review Create
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
				$review = tables_view_review($id);
			}
			?>

			onReadyScript('<?php echo $id; ?>', 'review', '<?php echo admin_url('admin-ajax.php'); ?>');
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
							$articles = tables_list_article_ids_tostr();
							$experts = tables_list_expert_ids_tostr();
							$verdicts = tables_list_verdict_ids_tostr();
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

										<?php if (!is_null($review)) { ?>
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
											<td>Статья</td>
											<td>
												<select name='ID_Article' required>
													<?php
													echo "<option value=''>---</option>";
													foreach ($articles as $item) {
														if ($item->ID_Article == $review->ID_Article)
															echo "<option value='{$item->ID_Article}' selected >{$item->Title}</option>";
														else
															echo "<option value='{$item->ID_Article}' >{$item->Title}</option>";
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td>Эксперт</td>
											<td>
												<select name='ID_Expert' required>
													<?php
													echo "<option value=''>---</option>";
													foreach ($experts as $item) {
														if ($item->ID_Expert == $review->ID_Expert)
															echo "<option value='{$item->ID_Expert}' selected >{$item->Name}</option>";
														else
															echo "<option value='{$item->ID_Expert}' >{$item->Name}</option>";
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td>Номер рецензии</td>
											<td><input type='text' name='RevNo' value='<?php echo $review->RevNo ?>' /></td>
										</tr>
										<tr>
											<td>Направлено</td>
											<td><input type='date' name='ToExpDate' value='<?php echo $review->ToExpDate ?>' /></td>
										</tr>
										<tr>
											<td>Ответ</td>
											<td><input type='date' name='FromExpDate' value='<?php echo $review->FromExpDate ?>' /></td>
										</tr>
										<tr>
											<td>Вердикт</td>
											<td>
												<select name='ID_Verdict'>
													<?php
													echo "<option value=''>---</option>";
													foreach ($verdicts as $item) {
														if ($item->ID_Verdict == $review->ID_Verdict)
															echo "<option value='{$item->ID_Verdict}' selected >{$item->Title}</option>";
														else
															echo "<option value='{$item->ID_Verdict}' >{$item->Title}</option>";
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td>Авторам</td>
											<td><input type='date' name='ToAuthDate' value='<?php echo $review->ToAuthDate ?>' /></td>
										</tr>
										<tr>
											<td>Ответ</td>
											<td><input type='date' name='FromAuthDate' value='<?php echo $review->FromAuthDate ?>' /></td>
										</tr>
										<tr>
											<td>Напоминание</td>
											<td><input type='date' name='RemDate' value='<?php echo $review->RemDate ?>' /></td>
										</tr>
										<tr>
											<td>Комментарии</td>
											<td><input type='text' name='Comments' style='width:100%' value='<?php echo $review->Comments ?>' /></td>
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