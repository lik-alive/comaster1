<?php
/*
		Template Name: Tables Article Create
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
				$article = tables_view_article($id);
			}
			?>

			onReadyScript('<?php echo $id; ?>', 'article', '<?php echo admin_url('admin-ajax.php'); ?>');
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
							$issues = tables_list_issue_ids_tostr();
							$sections = tables_list_section_ids_tostr();
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

										<?php if (!is_null($article)) { ?>
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
											<td>Выпуск</td>
											<td>
												<select name='ID_Issue' required>
													<?php
													echo "<option value=''>---</option>";
													foreach ($issues as $item) {
														if ($item->ID_Issue == $article->ID_Issue)
															echo "<option value='{$item->ID_Issue}' selected >{$item->Title}</option>";
														else
															echo "<option value='{$item->ID_Issue}' >{$item->Title}</option>";
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td>Раздел</td>
											<td>
												<select name='ID_Section' required>
													<?php
													echo "<option value=''>---</option>";
													foreach ($sections as $item) {
														if ($item->ID_Section == $article->ID_Section)
															echo "<option value='{$item->ID_Section}' selected >{$item->Title}</option>";
														else
															echo "<option value='{$item->ID_Section}' >{$item->Title}</option>";
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td>Порядковый номер</td>
											<td><input type='number' name='SeqNumber' value='<?php echo $article->SeqNumber ?>' /></td>
										</tr>
										<tr>
											<td>Название</td>
											<td><input type='text' name='Title' style='width:100%' value='<?php echo $article->Title ?>' required /></td>
										</tr>
										<tr>
											<td>Авторы</td>
											<td><input type='text' name='Authors' style='width:100%' value='<?php echo $article->Authors ?>' required /></td>
										</tr>
										<tr>
											<td>Аффилиация</td>
											<td><input type='text' name='Affiliation' style='width:100%' value='<?php echo $article->Affiliation ?>' required /></td>
										</tr>
										<tr>
											<td>Число страниц</td>
											<td><input type='number' name='PageCount' value='<?php echo $article->PageCount ?>' required /></td>
										</tr>
										<tr>
											<td>Дата получения</td>
											<td><input type='date' name='RecvDate' value='<?php echo $article->RecvDate ?>' required /></td>
										</tr>
										<tr>
											<td>ФИО автора для связи</td>
											<td><input type='text' name='CorName' style='width:100%' value='<?php echo $article->CorName ?>' required /></td>
										</tr>
										<tr>
											<td>Почта автора для связи</td>
											<td><input type='text' name='CorMail' style='width:100%' value='<?php echo $article->CorMail ?>' required /></td>
										</tr>
										<tr>
											<td>Напоминание</td>
											<td><input type='date' name='RemDate' value='<?php echo $article->RemDate ?>' /></td>
										</tr>
										<tr>
											<td>Научное одобрение</td>
											<td><input type='checkbox' name='IsRevApproved' <?php if ($article->IsRevApproved == 'Y') echo 'checked' ?> /></td>
										</tr>
										<tr>
											<td>Техническое одобрение</td>
											<td><input type='checkbox' name='IsTechApproved' <?php if ($article->IsTechApproved == 'Y') echo 'checked' ?> /></td>
										</tr>
										<tr>
											<td>Язык</td>
											<td>
												<select name='Language' value='<?php echo $article->Language ?>' required>
													<option value='R'>Русский</option>
													<option value='E' <?php if ($article->Language == 'E') echo 'selected' ?>>Английский</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Комментарии</td>
											<td><input type='text' name='Comments' style='width:100%' value='<?php echo $article->Comments ?>' /></td>
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