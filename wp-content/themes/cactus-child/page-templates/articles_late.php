<?php
/*
		Template Name: Articles Late
	*/
get_header(); ?>

<?php $customtitle = 'Опаздывающие статьи';
include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator', 'seceditor', 'maineditor')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">-->
	<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-click.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>

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
				'<td>' + ((d.h_rad == null) ? '' : d.h_rad) + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Комментарии:</td>' +
				'<td>' + ((d.h_com == null) ? '' : d.h_com) + '</td>' +
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
					'emptyTable': "<div style='text-align: center; font-size:12pt;'>Опаздывающих статей не обнаружено</div>"
				},
				"data": <?php echo articles_list_late($idsec); ?>,

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
						"data": "h_sec",
						"orderable": false,
						'class': 'centered'
					},
					{
						"data": "h_cor",
						"orderable": false
					},
					{
						"data": "h_tad",
						"orderable": false,
						'class': 'centered'
					},
					{
						"data": "h_lad",
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
					"targets": 2,
					"visible": false,
					"searchable": false
				}],

				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows({
						page: 'current'
					}).nodes();

					//mouse hovering
					<?php if (g_cua('administrator', 'seceditor')) { ?>
						rows.to$().addClass('hovered');
						//mouse hovering
					<?php } ?>

					var i = 0;

					for (; i < api.rows().count(); i++) {
						if (api.row(i).node().style.display == 'none') continue;
						if (revertDate(api.cells(i, 6).data()[0]) >= <?php echo "'" . date('Y-m-d') . "'"; ?>) {
							$(api.rows().nodes()).eq(0).before('<tr><td colspan="7" class="group">Срок заканчивается</td></tr>');
							break;
						}
						if (revertDate(api.cells(i, 6).data()[0]) < <?php echo "'" . date('Y-m-d') . "'"; ?>) break;
					}

					for (; i < api.rows().count(); i++) {
						if (api.row(i).node().style.display == 'none') continue;
						if (revertDate(api.cells(i, 6).data()[0]) < <?php echo "'" . date('Y-m-d') . "'"; ?>) {
							$(api.rows().nodes()).eq(i).before('<tr><td colspan="7" class="group">Срок вышел</td></tr>');
							break;
						}
					}

					//All rows are hidden
					if (i == api.rows().count()) {
						$(api.rows().nodes()).eq(0).before('<tr><td colspan="7"><div style="text-align: center; font-size:12pt;">Опаздывающих статей не обнаружено</div></td></tr>');
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

			var ID_Article = '',
				ToAuthDate = '',
				tr;
			table.on('click', 'input.remind', function() {
				tr = $(this).closest('tr');
				var rowNo = table.row(tr).index();
				ID_Article = table.cell(rowNo, 2).data();
				ToAuthDate = table.cell(rowNo, 5).data();

				$('#confirmMsg').html('Отправить напоминание?');
				$('#confirmDialog').modal('toggle');
			});

			$('#confirmForm').submit(function(e) {
				e.preventDefault();
				$(this).closest('.modal').modal('toggle');

				var fd = new FormData();
				fd.append('ID_Article', ID_Article);
				fd.append('ToAuthDate', ToAuthDate);
				fd.append('action', 'articles_remind_author');

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

			<?php if (g_cua('administrator', 'seceditor')) { ?>
				InitMouseClick(table, 2, SITE_URL + '/articles/view/?id=');
			<?php } ?>
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

							<?php include 'tools/confirm_dialog.php'; ?>

							<div style='overflow-x:auto; margin:5px'>
								<table id='datatable' class='smartcompact'>
									<thead>
										<tr>
											<th style='width: 40px'></th>
											<th style='width: 40px'>№</th>
											<th>ID</th>
											<th style='width: 80px'>Раздел</th>
											<th>Автор</th>
											<th style='width: 90px'>Направлено</th>
											<th style='width: 90px'>Срок</th>
											<?php if (g_cua('administrator')) { ?>
												<th style='width: 80px'>Напомнить</th>
											<?php } ?>
										</tr>
									</thead>
								</table>
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