<?php
/*
		Template Name: Main Page
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">-->
<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-click.js"></script>
<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>

<div class="page-wrap">
	<div class="container">
		<div class="page-inner row right-aside">
			<div class="col-main">
				<section class="post-main" role="main" id="content">
					<article class="post-entry text-left">
						<?php
						if (g_cua('administrator', 'maineditor', 'seceditor', 'tech')) {
						?>
							<div class='actions-panel'>
							</div>
							<div style='height:5px;background-color:#F5F5F5;'></div>

							<?php include 'tools/confirm_dialog.php'; ?>

							<?php include 'mainpage/updates.php'; ?>

							<div>
								<div class='infstat'>
									<div class='inftitle'>Статистика <?php if ($idsec === '777') echo 'портфеля';
																										else echo 'раздела'; ?></div>
									<div class='inftitledelim'></div>
									<div>
										<div style='overflow-x:auto;'>
											<table class='dataTable'>
												<thead>
													<tr>
														<th>Всего статей</th>
														<th>Принято (полностью)</th>
														<th>Принято (только науч.)</th>
														<th>Принято (только техн.)</th>
														<th>С положительными рецензиями</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class='centered'><b><?php echo main_list_nst_articles_count($idsec); ?></b></td>
														<td class='centered'><b><?php echo main_list_nst_articles_approved_count($idsec); ?></b></td>
														<td class='centered'><b><?php echo main_list_nst_articles_revapproved_count($idsec); ?></b></td>
														<td class='centered'><b><?php echo main_list_nst_articles_techapproved_count($idsec); ?></b></td>
														<td class='centered'><b><?php echo main_list_nst_articles_one_positive_count($idsec); ?></b></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class='infblockdelim'></div>
							</div>

							<?php
							if (g_cua('administrator', 'seceditor')) {
								include 'mainpage/newarticles.php';
								include 'mainpage/revapprove.php';
							}
							?>

							<?php
							if (g_cua('administrator', 'tech')) {
								include 'mainpage/techapprove.php';
							}
							?>

						<?php
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
