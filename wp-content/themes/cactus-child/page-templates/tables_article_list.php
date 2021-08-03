<?php
/*
		Template Name: Tables Article List
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="<?php echo site_url() ?>/js/table-list.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			var imgok = "<img class='statusok' width='20' height='32' style='display:block; margin:auto;'  />";
			var imgno = "<img class='statusundef' width='20' height='32' style='display:block; margin:auto;'  />";

			var table = $('#datatable').DataTable({
				"bAutoWidth": false,
				"ordering": false,
				"bInfo": false,
				"paging": false,
				"serverSide": false,
				"processing": false,
				"language": {
					'emptyTable': "<div style='text-align: center; font-size:12pt;'>Статей в портфеле не обнаружено</div>"
				},
				"data": <?php echo tables_list_article(); ?>,

				"columns": [{
						"defaultContent": '',
						"orderable": false
					},
					{
						"data": "h_ida"
					},
					{
						"data": "h_iss",
						"orderable": false
					},
					{
						"data": "h_sec",
						"orderable": false
					},
					{
						"data": "h_sqn",
						"orderable": false
					},
					{
						"data": "h_aut",
						"orderable": false
					},
					{
						"data": "h_tit",
						"orderable": false
					},
					{
						"data": "h_aff",
						"orderable": false
					},
					{
						"data": "h_pgc",
						"orderable": false
					},
					{
						"data": "h_rec",
						"orderable": false
					},
					{
						"data": "h_can",
						"orderable": false
					},
					{
						"data": "h_cam",
						"orderable": false
					},
					{
						"data": "h_rad",
						"orderable": false
					},
					{
						"data": "h_ira",
						"orderable": false,
						"render": function(data, type, JsonResultRow, meta) {
							if (data == 'Y') return imgok;
							else return imgno;
						}
					},
					{
						"data": "h_ita",
						"orderable": false,
						"render": function(data, type, JsonResultRow, meta) {
							if (data == 'Y') return imgok;
							else return imgno;
						}
					},
					{
						"data": "h_lan",
						"orderable": false
					},
					{
						"data": "h_com",
						"orderable": false
					}
				],

				"drawCallback": function(settings) {
					this.api().column(0).nodes().each(function(cell, i) {
						cell.innerHTML = i + 1;
					});
				}
			});

			onReadyScript('articles');
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
						if (g_cua('administrator')) {
						?>
							<div class='actions-panel'>
								<button class='btn btn-add' onclick="window.location.href=SITE_URL + '/tables/articles/create'">
									<table class='borderless'>
										<tr>
											<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/plus.png' /></td>
											<td class='btn-title'>Добавить статью</td>
										</tr>
									</table>
								</button>
							</div>
							<div style='height:5px;background-color:#F5F5F5;'></div>

							<div style='margin:5px'>
								<div style='font-size:12pt;padding:10px;'>
									<label style='font-weight:bold;'>Быстрый поиск:</label>
									<input id='searchInput' type='text' autocomplete='off' autofocus />
								</div>
								<div style='overflow-x:auto;'>
									<table id='datatable' class='supercompact'>
										<thead>
											<tr>
												<th>№</th>
												<th>ID</th>
												<th>Выпуск</th>
												<th>Секция</th>
												<th>Порядок</th>
												<th>Авторы</th>
												<th>Название</th>
												<th>Аффилиация</th>
												<th>Число страниц</th>
												<th>Получена</th>
												<th>Кор.ФИО</th>
												<th>Кор.Почта</th>
												<th>Напом.</th>
												<th>Науч.</th>
												<th>Тех.</th>
												<th>Язык</th>
												<th>Комментарии</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
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