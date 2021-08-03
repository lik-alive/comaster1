<?php
/*
		Template Name: Tables Expert List
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

			var imgok = "<img src='" + SITE_URL + "/resources/check.png' width='32' height='32' style='margin:auto;' />";
			var imgno = "<img src='" + SITE_URL + "/resources/cycle.png' width='32' height='32' style='margin:auto;' />";

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
				"data": <?php echo tables_list_expert(); ?>,

				"columns": [{
						"defaultContent": '',
						"orderable": false
					},
					{
						"data": "h_ide"
					},
					{
						"data": "h_nam",
						"orderable": false
					},
					{
						"data": "h_mai",
						"orderable": false
					},
					{
						"data": "h_isa",
						"orderable": false,
						'class': 'centered',
						"render": function(data, type, JsonResultRow, meta) {
							if (data == 'Y') return imgok;
							else return imgno;
						}
					},
					{
						"data": "h_pos",
						"orderable": false
					},
					{
						"data": "h_int",
						"orderable": false
					},
					{
						"data": "h_phn",
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

			$('#datatable tbody tr').click(function() {
				var rowNo = table.row(this).index();
				if (rowNo != null) {
					var curId = table.cell(rowNo, 1).data();
					window.location = SITE_URL + '/tables/experts/edit?id=' + curId;
				}
			}).hover(function() {
				$(this).toggleClass('hovered');
			});

			$('#searchInput').keyup(function() {
				table.search($(this).val()).draw();

				if (table.rows({
						filter: 'applied'
					}).nodes().length == 1) {
					var curId = table.cell({
						filter: 'applied'
					}, 1).data();
					window.location = SITE_URL + '/tables/experts/edit?id=' + curId;
				}
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
						if (g_cua('administrator')) {
						?>
							<div class='actions-panel'>
								<button class='btn btn-add' onclick="window.location.href=SITE_URL + '/tables/experts/create'">
									<table class='borderless'>
										<tr>
											<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/plus.png' /></td>
											<td class='btn-title'>Добавить рецензента</td>
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
												<th>ФИО</th>
												<th>Почта</th>
												<th>Доступен</th>
												<th>Должность и место работы</th>
												<th>Научные интересы</th>
												<th>Телефон</th>
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