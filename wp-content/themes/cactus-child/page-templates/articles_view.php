<?php
/*
		Template Name: Articles View
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->
<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>

<?php if (g_cua('administrator', 'seceditor')) { ?>

	<script type="text/javascript">
		$(document).ready(function() {
			var ID_Article = <?php echo g_si($_GET['id']); ?>;
			var confirmType = '';

			//Request Experts
			$('#reqexperts').on('click', function() {
				confirmType = 'reqexp';
				$('#confirmMsg').html('Отправить запрос?');
				$('#confirmDialog').modal('toggle');
			});

			//Add Expert
			$('#addexpert').click(function() {
				$('#addExpertForm')[0].reset();
				$('#addExpertDialog').modal('toggle');
			});

			$('#addExpertForm').submit(function(e) {
				e.preventDefault();
				$(this).closest('.modal').modal('toggle');

				var fd = new FormData(this);
				fd.append('ID_Article', ID_Article);
				fd.append('action', 'articles_add_expert');

				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						showStatus(response);
						$('#reviewstable').DataTable().ajax.reload();
					}
				});
			});

			//Rev Approve
			$('#revapprove').on('click', function() {
				confirmType = 'revapp';
				$('#confirmMsg').html('Принять статью?');
				$('#confirmDialog').modal('toggle');
			});

			//Rev Reject
			$('#revreject').on('click', function() {
				confirmType = 'revrej';
				$('#confirmMsg').html('Отклонить статью?');
				$('#confirmDialog').modal('toggle');
			});

			//Tech Approve
			$('#techapprove').on('click', function() {
				confirmType = 'techapp';
				$('#confirmMsg').html('Одобрить оформление?');
				$('#confirmDialog').modal('toggle');
			});

			//Confirm Action
			$('#confirmForm').submit(function(e) {
				e.preventDefault();
				$(this).closest('.modal').modal('toggle');

				var fd = new FormData();
				fd.append('ID_Article', ID_Article);
				if (confirmType == 'reqexp')
					fd.append('action', 'articles_request_experts');
				else if (confirmType == 'revapp')
					fd.append('action', 'articles_revapprove');
				else if (confirmType == 'revrej')
					fd.append('action', 'articles_revreject');
				else if (confirmType == 'techapp')
					fd.append('action', 'articles_techapprove');

				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						showStatus(response);
						if (confirmType != 'reqexp') location.reload();
					}
				});
			});

			//Edit
			$('#edit').on('click', function() {
				window.location.href = SITE_URL + '/tables/articles/edit/?id=' + ID_Article;
			});

			//Reserve
			$('#reserve').on('click', function() {
				$('#reserveForm')[0].reset();
				$('#reserveDialog').modal('toggle');
			});

			$('#reserveForm').submit(function(e) {
				e.preventDefault();
				$(this).closest('.modal').modal('toggle');

				var fd = new FormData(this);
				fd.append('ID_Article', ID_Article);
				fd.append('action', 'articles_reserve');

				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						showStatus(response);
						$('#reviewstable').DataTable().ajax.reload();
					}
				});
			});

			//Download Files
			$('#dfile').on('click', function() {
				window.open(SITE_URL + '/download/?ida=' + ID_Article, '_blank');
			});

			//Update Files			
			$('#updateafile').on('click', function() {
				updatetype = 'article';
				$('#updateAFileDialog').modal('toggle');
			});

			$('#updateAFileForm').submit(function(e) {
				e.preventDefault();
				$(this).closest('.modal').modal('toggle');

				var fd = new FormData();
				var file_data = $(this).find('.files').prop('files');
				for (var x = 0; x < file_data.length; x++) {
					fd.append('files[]', file_data[x]);
				}
				fd.append('ID_Article', ID_Article);
				fd.append('action', 'articles_update_file');

				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						showStatus(response);
					}
				});
			});
		});
	</script>

<?php } ?>

<div class="page-wrap">
	<div class="container">
		<div class="page-inner row right-aside">
			<div class="col-main">
				<section class="post-main" role="main" id="content">
					<article class="post-entry text-left">
						<?php
						if (g_cua('administrator', 'seceditor')) {
							$id = g_si($_GET["id"]);
							$article = tables_view_article($id);

							if ($article == "") {
								echo "Статья не найдена";
							} else {
						?>

								<div class='actions-panel'>
									<table class='borderless'>
										<tr>
											<td>
												<?php if ((g_cua('seceditor') && $article->ID_Section == $idsec) || g_cua('administrator')) { ?>
													<button id='addexpert' class='btn btn-add'>
														<table class='borderless'>
															<tr>
																<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/plus.png' /></td>
																<td class='btn-title'>Назначить рецензента</td>
															</tr>
														</table>
													</button>

													<?php if ($article->IsRevApproved == "N" && $article->ID_Issue != "1") { ?>
														<button id='revapprove' class='btn btn-accept'>
															<table class='borderless'>
																<tr>
																	<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/check.png' /></td>
																	<td class='btn-title'>Принять статью</td>
																</tr>
															</table>
														</button>

														<button id='revreject' class='btn btn-reject'>
															<table class='borderless'>
																<tr>
																	<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/cross.png' /></td>
																	<td class='btn-title'>Отклонить статью</td>
																</tr>
															</table>
														</button>
													<?php } ?>

													<?php if (g_cua('administrator')) { ?>
														<?php if ($article->IsTechApproved == "N") { ?>
															<button id='techapprove' class='btn btn-accept'>
																<table class='borderless'>
																	<tr>
																		<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/check.png' /></td>
																		<td class='btn-title'>Одобрить оформление</td>
																	</tr>
																</table>
															</button>
														<?php } ?>

														<button id='reserve' class='btn btn-accept'>
															<table class='borderless'>
																<tr>
																	<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/check.png' /></td>
																	<td class='btn-title'>Зарезервировать</td>
																</tr>
															</table>
														</button>
											</td>
											<td class='righted' style='vertical-align:top;'>
												<button id='edit' class='btn btn-edit'>
													<table class='borderless'>
														<tr>
															<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/edit.png' /></td>
															<td class='btn-title'>Редактировать</td>
														</tr>
													</table>
												</button>
											<td>
											<?php } ?>
										<?php } ?>
											</td>
										</tr>
									</table>
								</div>
								<div style='height:5px;background-color:#F5F5F5;'></div>


								<table class='borderless'>
									<tr>
										<td width='200px'>Название</td>
										<td style='font-weight:bold;'><?php echo g_cfl($article->Title); ?></td>
									</tr>
									<tr>
										<td>Авторы</td>
										<td><?php echo $article->Authors ?></td>
									</tr>
									<tr>
										<td>Содержание / Оформление</td>
										<td>╰(
											<?php
											$imgok = "<img src='" . site_url() . "/resources/check.png' width='25' height='25' style='margin:auto;' />";
											$imgrj = "<img src='" . site_url() . "/resources/cross.png' width='25' height='25' style='margin:auto;' />";
											$imgno = "<img src='" . site_url() . "/resources/cycle.png' width='25' height='25' style='margin:auto;' />";

											if ($article->IsRevApproved == "Y") echo $imgok;
											else if ($article->IsRevApproved == "R") echo $imgrj;
											else echo $imgno;

											echo '_';

											if ($article->IsTechApproved == "Y") echo $imgok;
											else echo $imgno;
											?>
											)╯
										</td>
									</tr>
									<tr>
										<td>Файл статьи</td>
										<td>
											<?php if (articles_get_fileinfo($id) != null) { ?>
												<input type='button' id='dfile' class='file' style='width:40px; height:40px' />
											<?php } ?>
											<?php if (g_cua('administrator')) { ?>
												<input id='updateafile' type='button' class='edit' style='width:30px; height:40px' />
											<?php } ?>
										</td>
									</tr>
									<?php if (g_cua('administrator')) { ?>
										<tr>
											<td>Комментарии</td>
											<td><?php echo $article->Comments ?></td>
										</tr>
									<?php } ?>
								</table>

								<div style='margin:5px; margin-bottom:20px; border: 1px solid #CCCCCC;'>
									<div class='collpanel'>
										<a class='collpanel' data-toggle='collapse' href='#collapse1'>Дополнительная информация</a>
									</div>
									<div id='collapse1' class='panel-collapse collapse'>
										<table class='borderless' style='margin:0px;'>
											<tr>
												<td>Язык</td>
												<td><?php if ($article->Language == 'R') echo 'русский';
														else echo 'english'; ?></td>
											</tr>
											<tr>
												<td>Аффилиация</td>
												<td><?php echo $article->Affiliation ?></td>
											</tr>
											<tr>
												<td>Выпуск</td>
												<td><?php echo $article->ITitle ?></td>
											</tr>
											<tr>
												<td>Раздел</td>
												<td><?php echo $article->STitle ?></td>
											</tr>
											<tr>
												<td>Число страниц</td>
												<td><?php echo $article->PageCount ?></td>
											</tr>
											<tr>
												<td>Дата получения</td>
												<td><?php echo date('d-m-Y', strtotime($article->RecvDate)) ?></td>
											</tr>
											<tr>
												<td>ФИО автора для связи</td>
												<td><?php echo $article->CorName ?></td>
											</tr>
											<tr>
												<td>Почта автора для связи</td>
												<td><?php echo $article->CorMail ?></td>
											</tr>
											<tr>
												<td>Напоминание</td>
												<td><?php echo $article->RemDate ?></td>
											</tr>
											<?php if (g_cua('administrator')) { ?>
												<tr>
													<td>ID</td>
													<td><?php echo $article->ID_Article ?></td>
												</tr>
											<?php } ?>
											<tr>
												<td>Порядковый номер</td>
												<td><?php echo $article->SeqNumber ?></td>
											</tr>
										</table>
									</div>
								</div>

								<?php include 'articles/addexpert.php'; ?>
								<?php include 'articles/updateafile.php'; ?>
								<?php include 'articles/reserve.php'; ?>
								<?php include 'articles/reviews.php'; ?>
								<?php include 'tools/confirm_dialog.php'; ?>

						<?php
							}
						} else {
							echo "Авторизуйтесь, чтобы получить доступ к странице";
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