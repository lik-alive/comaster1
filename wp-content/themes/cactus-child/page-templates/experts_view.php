<?php
/*
		Template Name: Experts View
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->

<?php if (g_cua('administrator', 'maineditor', 'seceditor')) { ?>

	<script type="text/javascript">
		$(document).ready(function() {
			var ID_Expert = <?php echo g_si($_GET['id']); ?>;

			//Edit
			$('#edit').on('click', function() {
				window.location.href = SITE_URL + '/tables/experts/edit/?id=' + ID_Expert;
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
						if (g_cua('administrator', 'maineditor', 'seceditor')) {
							$id = g_si($_GET["id"]);
							$expert = tables_view_expert($id);

							if ($expert == "") {
								echo "Эксперт не найден";
							} else {
						?>

								<div class='actions-panel'>
									<?php if (g_cua('administrator')) { ?>
										<input id='edit' type='button' style='width:190px;' value='Редактировать' />
									<?php } ?>
								</div>
								<div style='height:5px;background-color:#F5F5F5;'></div>

								<table class='borderless'>
									<tr>
										<td width='200px'>ФИО</td>
										<td style='font-weight:bold;'><?php echo $expert->Name; ?></td>
									</tr>
									<tr>
										<td>Почта</td>
										<td><?php echo $expert->Mail ?></td>
									</tr>
									<tr>
										<td>Активный</td>
										<td>
											<?php
											$imgok = "<img src='" . site_url() . "/resources/check.png' width='25' height='25' style='margin:auto;' />";
											$imgno = "<img src='" . site_url() . "/resources/cross.png' width='25' height='25' style='margin:auto;' />";

											if ($expert->IsActive == "Y") echo $imgok;
											else echo $imgno;
											?>
										</td>
									</tr>
									<tr>
										<td>Должность и место работы</td>
										<td><?php echo $expert->Position ?></td>
									</tr>
									<tr>
										<td>Интересы</td>
										<td><?php echo $expert->Interests ?></td>
									</tr>
									<?php if (g_cua('administrator')) { ?>
										<tr>
											<td>Комментарии</td>
											<td><?php echo $expert->Comments ?></td>
										</tr>
									<?php } ?>
								</table>

								<?php include 'experts/reviews.php'; ?>

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