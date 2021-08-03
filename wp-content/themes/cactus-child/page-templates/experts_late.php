<?php
/*
		Template Name: Experts Late
	*/
get_header(); ?>

<?php $customtitle = 'Опаздывающие рецензии';
include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator', 'seceditor', 'maineditor')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-click.js"></script>

	<script type="text/javascript">
		function extraInfo(d) {
			return '<table>' +
				'<tr>' +
				'<td>Название:</td>' +
				'<td>' + d.h_tit + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Авторы:</td>' +
				'<td>' + d.h_aut + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Дата напоминания:</td>' +
				'<td>' + ((d.h_red == null) ? '' : d.h_red) + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Комментарии:</td>' +
				'<td>' + ((d.h_rcm == null) ? '' : d.h_rcm) + '</td>' +
				'</tr>' +
				'</table>';
		}

		$(document).ready(function() {

			var table = $('#datatable').DataTable({
				"bAutoWidth": false,
				"ordering": false,
				"bInfo": false,
				"paging": false,
				"serverSide": false,
				"processing": false,
				"language": {
					'emptyTable': "<div style='text-align: center; font-size:12pt;'>Опаздывающих рецензий не обнаружено</div>"
				},
				"data": <?php echo experts_list_late($idsec); ?>,

				"columns": [{
						"class": "details-control",
						"data": null,
						"defaultContent": ''
					},
					{
						"defaultContent": '',
						"orderable": false,
						'class': 'centered'
					},
					{
						"data": "h_ida"
					},
					{
						"data": "h_idr"
					},
					{
						"data": "h_sec",
						"orderable": false,
						'class': 'centered'
					},
					{
						"data": "h_rsn",
						"orderable": false
					},
					{
						"data": "h_ted",
						"orderable": false,
						'class': 'centered'
					},
					{
						"data": "h_lrd",
						"orderable": false,
						'class': 'centered'
					}
					<?php if (g_cua('administrator')) { ?>, {
							"defaultContent": "<input type='button' value='Направить' class='cellbutton remind' />",
							'class': 'centered'
						}
					<?php } ?>
				],

				"columnDefs": [{
					"targets": [2, 3],
					"visible": false,
					"searchable": false
				}],

				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows({
						page: 'current'
					}).nodes();

					//mouse hovering
					rows.to$().addClass('hovered');

					var i = 0;

					for (; i < api.rows().count(); i++) {
						if (api.row(i).node().style.display == 'none') continue;
						if (revertDate(api.cells(i, 7).data()[0]) >= <?php echo "'" . date('Y-m-d') . "'"; ?>) {
							$(api.rows().nodes()).eq(0).before('<tr><td colspan="7" class="group">Срок заканчивается</td></tr>');
							break;
						}
						if (revertDate(api.cells(i, 7).data()[0]) < <?php echo "'" . date('Y-m-d') . "'"; ?>) break;
					}

					for (; i < api.rows().count(); i++) {
						if (api.row(i).node().style.display == 'none') continue;
						if (revertDate(api.cells(i, 7).data()[0]) < <?php echo "'" . date('Y-m-d') . "'"; ?>) {
							$(api.rows().nodes()).eq(i).before('<tr><td colspan="7" class="group">Срок вышел</td></tr>');
							break;
						}
					}

					//All rows are hidden
					if (i == api.rows().count()) {
						$(api.rows().nodes()).eq(0).before('<tr><td colspan="7"><div style="text-align: center; font-size:12pt;">Опаздывающих рецензий не обнаружено</div></td></tr>');
					}

					var n = 1;
					api.column(1).nodes().each(function(cell, i) {
						if (api.row(i).node().style.display != 'none') cell.innerHTML = n++;
					});
				}
			});

			table.on('click', 'td.details-control', function() {
				var tr = $(this).closest('tr');
				var row = table.row(tr);

				if (row.child.isShown()) {
					row.child.hide();
					tr.removeClass('shown');
				} else {
					row.child(extraInfo(row.data())).show();
					tr.addClass('shown');
				}
			});

			table.on('click', 'input.remind', function() {
				var tr = $(this).closest('tr');
				var ID_Review = table.row(tr).data().h_idr;

				var fd = new FormData();
				fd.append('ID_Review', ID_Review);
				fd.append('action', 'reviews_remind_expert');

				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						showStatus(response);
						$(table.row(tr).node()).hide();
						table.draw();
					}
				});
			});

			InitMouseClick(table, 2, SITE_URL + '/articles/view/?id=');
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
							if (g_cua('administrator')) {
						?>
								<div class='actions-panel'>
								</div>
								<div style='height:5px;background-color:#F5F5F5;'></div>
							<?php
							}
							?>
							<div style='margin:5px'>
								<div style='overflow-x:auto;'>
									<table id='datatable' class='smartcompact'>
										<thead>
											<tr>
												<th style='width: 30px'></th>
												<th style='width: 40px'>№</th>
												<th>IDA</th>
												<th>IDR</th>
												<th style='width: 80px'>Раздел</th>
												<th>Рецензент</th>
												<th style='width: 80px'>Направлено</th>
												<th style='width: 80px'>Срок</th>
												<?php if (g_cua('administrator')) { ?>
													<th style='width: 80px'>Напомнить</th>
												<?php } ?>
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