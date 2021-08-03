<?php
/*
		Template Name: Experts List
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator', 'seceditor', 'maineditor')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-click.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			var table = $('#datatable').DataTable({
				"bAutoWidth": false,
				"bInfo": false,
				"pagingType": 'numbers',
				"serverSide": false,
				"processing": false,
				"pageLength": 50,
				"language": {
					'emptyTable': "<div style='text-align: center; font-size:12pt;'>Рецензентов не обнаружено</div>"
				},

				"ajax": {
					url: "<?php echo admin_url('admin-ajax.php'); ?>?action=experts_list",
					type: "post",
					dataType: "json",
					contentType: "application/json; charset=utf-8",
				},

				"columns": [{
						"defaultContent": '',
						"orderable": false
					},
					{
						"data": "h_ide"
					},
					{
						"data": "h_nam"
					},
					{
						"data": "h_eml",
						'className': 'centered'
					},
					{
						"data": "h_pos"
					},
					{
						"data": "h_int",
						'className': 'centered'
					}
					<?php if (g_cua('administrator')) { ?>, {
							"data": "h_com",
							'className': 'centered'
						}
					<?php } ?>
				],

				"columnDefs": [{
					"targets": 1,
					"visible": false,
					"searchable": true
				}],

				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows().nodes();

					//mouse hovering
					rows.to$().addClass('hovered');

					api.column(0).nodes().each(function(cell, i) {
						cell.innerHTML = i + 1;
					});
				}
			});

			//Hide pagination list
			$('#datatable_wrapper .dataTables_length')[0].style.display = 'none';

			$('#search').click(function() {
				table.ajax.url("<?php echo admin_url('admin-ajax.php'); ?>?action=experts_list&kw=" + encodeURIComponent($('#keyWordInput')[0].value)).load();
			});

			$('#keyWordInput').keydown(function(k) {
				if (k.key == 'Enter') $('#search').trigger('click');
			});

			InitMouseClick(table, 1, SITE_URL + '/experts/view/?id=');

			$('#searchInput').keyup(function() {
				table.search($(this).val()).draw();

				if (table.rows({
						filter: 'applied'
					}).nodes().length == 1) {
					var expId = table.rows({
						filter: 'applied'
					}).data()[0].h_ide;
					window.location.href = SITE_URL + '/experts/view?id=' + expId;
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
						if (g_cua('administrator', 'seceditor', 'maineditor')) {
						?>
							<div class='actions-panel'>
							</div>
							<div style='height:5px;background-color:#F5F5F5;'></div>

							<div style='font-size:12pt;overflow-x:auto;' class='infstat'>
								<table class='borderless'>
									<tr>
										<td>
											<label style='font-weight:bold; padding-left:5px;'>Умный поиск:</label>
											<input id='keyWordInput' type='text' style='width:300px' autocomplete='off' placeholder='Введите имя или ключевое слово' />
										</td>
										<td class='righted'>
											<input id='search' type='button' style='margin-left:30px;' value='Найти' />
										</td>
									</tr>
								</table>
							</div>

							<div style='height:5px;background-color:#F5F5F5;'></div>

							<div style='margin:5px;'>
								<div style='font-size:12pt;padding:10px;'>
									<label style='font-weight:bold;'>Быстрый поиск:</label>
									<input id='searchInput' type='text' autocomplete='off' autofocus />
								</div>
								<div style='overflow-x:auto;'>
									<table id='datatable'>
										<thead>
											<tr>
												<th>№</th>
												<th>ID</th>
												<th>Рецензент</th>
												<th>Почта</th>
												<th>Должность и место работы</th>
												<th>Интересы</th>
												<?php if (g_cua('administrator')) { ?>
													<th>Комментарии</th>
												<?php } ?>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						<?php
						} else {
							echo "Авторизуйтесь, чтобы получить доступ к странице";
						}
						?>
						<div style='height:20px;background-color:#F5F5F5;'></div>
					</article>
				</section>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>