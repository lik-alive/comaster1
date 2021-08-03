<?php
/*
		Template Name: Articles Create
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/articles.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>

	<script>
		function recognize() {
			var str = $('#text').val();

			var res = parseArticleString(str);

			$('[name=title]')[0].value = res[0];
			$('[name=authors]')[0].value = res[1];
			$('[name=affiliation]')[0].value = res[2];
			$('[name=pageCount]')[0].value = res[3];
		}

		$(document).ready(function() {
			$('#createForm').submit(function(e) {
				e.preventDefault();

				var file_data = $(this).find('.files').prop('files');

				var fd = new FormData($('#createForm')[0]);
				var ins = file_data.length;
				for (var x = 0; x < ins; x++) {
					fd.append('files[]', file_data[x]);
				}
				fd.append('action', 'articles_create');

				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						var res = response.split('>');
						var id = res[res.length - 1];

						if (isNaN(id)) showStatus(response);
						else window.location.href = SITE_URL + '/articles/view?id=' + id;
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
					<article class="post-entry text-left" style='padding:0px'>

						<?php
						if (g_cua('administrator')) {
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
									</tr>
								</table>
							</div>
							<div style='height:5px;background-color:#F5F5F5;'></div>


							<div style='margin-left:6px; margin-bottom:20px; margin-right:6px;'>
								Автораспознавание
								<textarea id='text' rows='7' style='width:100%; line-height:1;' onkeyup='recognize();'></textarea>
							</div>
							<form id='createForm' method='post'>
								<div style='overflow-x:auto'>
									<table class='borderless'>
										<tr>
											<td width='200px'>Название</td>
											<td><input type='text' name='title' style='width:100%' value='' required /></td>
										</tr>
										<tr>
											<td>Авторы</td>
											<td><input type='text' name='authors' style='width:100%' value='' required /></td>
										</tr>
										<tr>
											<td>Аффилиация</td>
											<td><input type='text' name='affiliation' style='width:100%' value='' required /></td>
										</tr>
										<tr>
											<td>Число страниц</td>
											<td><input type='number' name='pageCount' value='' required /></td>
										</tr>
										<tr>
											<td>Язык</td>
											<td><select name='language'>
													<option value='R'>Русский</option>
													<option value='E'>Английский</option>
												</select></td>
										</tr>
										<tr>
											<td>ФИО автора для связи</td>
											<td><input type='text' name='corName' style='width:100%' value='' required /></td>
										</tr>
										<tr>
											<td>Почта автора для связи</td>
											<td><input type='text' name='corMail' style='width:100%' value='' required /></td>
										</tr>
										<tr>
											<td>Раздел</td>
											<td>
												<select name='id_section' required>
													<?php
													echo "<option value=''>---</option>";
													foreach ($sections as $section) {
														echo "<option value='{$section->ID_Section}'>{$section->Title}</option>";
													}
													?>
												</select>
											</td>
										</tr>
										<tr>
											<td>Дата получения</td>
											<td><input type='date' name='recvDate' value='<?php echo date('Y-m-d'); ?>' required /></td>
										</tr>
										<tr>
											<td>Комментарии</td>
											<td><input type='text' name='comments' style='width:100%' value='' /></td>
										</tr>
										<tr>
											<td>Файлы статьи</td>
											<td><input type='file' name='files' class='files' multiple required /></td>
										</tr>
										<tr>
											<td>Подтверждение авторам</td>
											<td><input id='isToAuthor' type='checkbox' name='isToAuthor' checked /></td>
										</tr>
										<tr>
											<td>Запрос редактору</td>
											<td><input id='isToEditor' type='checkbox' name='isToEditor' checked /></td>
										</tr>
									</table>
								</div>
							</form>
							<br />

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