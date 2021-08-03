<?php
/*
		Template Name: Experts Rate
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator', 'seceditor', 'maineditor')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-click.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-sort.js"></script>

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
					url: "<?php echo admin_url('admin-ajax.php'); ?>?action=experts_list_rate",
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
						"data": "h_cct",
						'className': 'centered'
					},
					{
						"data": "h_tct",
						'className': 'centered'
					},
					{
						"data": "h_avg",
						'className': 'centered',
						"sType": "nanumeric"
					},
					{
						"data": "h_rat",
						'className': 'centered'
					}
				],

				"order": [
					[3, "desc"]
				],

				"columnDefs": [{
						"targets": 1,
						"visible": false,
						"searchable": true
					},
					{
						"targets": [3, 4, 5, 6],
						"orderSequence": ["desc", "asc"]
					}
				],

				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows().nodes();

					//mouse hovering
					rows.to$().addClass('hovered');

					var maxcountA = 0,
						maxcountB = 0,
						maxcountC = 0,
						val;
					for (var i = 0; i < api.rows().count(); i++) {
						val = parseInt(api.row(i).data().h_cct);
						if (maxcountA < val) maxcountA = val;

						val = parseInt(api.row(i).data().h_tct);
						if (maxcountB < val) maxcountB = val;

						val = parseInt(api.row(i).data().h_avg);
						if (maxcountC < val) maxcountC = val;
					}

					var red, green, blue;
					for (var i = 0; i < api.rows().count(); i++) {
						green = 255;
						red = 255 - parseInt(255 * api.row(i).data().h_cct / maxcountA * 0.5);
						blue = 255 - parseInt(255 * api.row(i).data().h_cct / maxcountA * 0.5);
						api.cell(i, 3).node().style.background = toColor(red, green, blue);


						blue = 255;
						green = 255;
						red = 255 - parseInt(255 * api.row(i).data().h_tct / maxcountB * 0.6);
						api.cell(i, 4).node().style.background = toColor(red, green, blue);

						red = 255;
						green = 255 - parseInt(255 * api.row(i).data().h_avg / maxcountC * 0.5);
						blue = 255 - parseInt(255 * api.row(i).data().h_avg / maxcountC * 0.5);
						api.cell(i, 5).node().style.background = toColor(red, green, blue);


						red = 255;
						green = parseInt(150 + (50 - 50 * api.row(i).data().h_rat / 100));
						blue = parseInt((255 - 255 * api.row(i).data().h_rat / 100 * 0.8) * 0.5);
						api.cell(i, 6).node().style.background = toColor(red, green, blue);
					}

					api.column(0).nodes().each(function(cell, i) {
						cell.innerHTML = i + 1;
					});
				}
			});

			//Hide pagination list
			$('#datatable_wrapper .dataTables_length')[0].style.display = 'none';

			InitMouseClick(table, 1, SITE_URL + '/experts/view/?id=');

			$('#searchInput').keyup(function() {
				table.search($(this).val()).draw();
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

							<div>
								<div class='infstat'>
									<div class='inftitle'>Вычисление рейтинга</div>
									<div class='inftitledelim'></div>
									<div>
										<div>Формула: <b>(k * pos + neg) / total * 100%</b> </div>
										<div>---</div>
										<div><b>k</b> (штраф за задержку ответа): <b>14 / (14 + средний_срок_задержки_рецензии)</b> </div>
										<div><b>pos</b> (карма +): <b>1.0 * число_рецензий_с_замечаниями + 0.8 * число_рецензий_с_одобрением</b> </div>
										<div><b>neg</b> (карма -): <b>0.5 * число_отказов_от_рецензирования + 0.1 * число_снятий_с_рецензирования</b> </div>
										<div><b>total</b> (нормировка): <b>общее_число_рецензий</b> </div>
									</div>
								</div>
								<div class='infblockdelim'></div>
							</div>

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
												<th style='min-width:70px; width:15%;'>Статей в работе</th>
												<th style='min-width:70px; width:15%;'>Написано рецензий</th>
												<th style='min-width:70px; width:15%;'>Средний срок</th>
												<th style='min-width:70px; width:15%;'>Рейтинг</th>
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