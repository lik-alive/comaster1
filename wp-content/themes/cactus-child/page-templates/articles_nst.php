<?php
/*
		Template Name: Articles Nst
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator', 'maineditor', 'seceditor', 'tech')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-click.js"></script>
	<script type="text/javascript" src="<?php echo site_url() ?>/js/general.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			$('#id_section').val(<?php echo $idsec; ?>);

			var imgok = "<img src='" + SITE_URL + "/resources/check.png' width='32' height='32' style='margin:auto;' />";
			var imgno = "<img src='" + SITE_URL + "/resources/cycle.png' width='32' height='32' style='margin:auto;' />";

			var table = $('#datatable').DataTable({
				"bAutoWidth": false,
				"bInfo": false,
				"pagingType": 'numbers',
				"serverSide": false,
				"processing": false,
				"pageLength": 50,
				"language": {
					'emptyTable': "<div style='text-align: center; font-size:12pt;'>Статей в портфеле не обнаружено</div>"
				},
				"ajax": {
					url: "<?php echo admin_url('admin-ajax.php'); ?>?action=articles_list&idi=888&ids=" + <?php echo $idsec ?>,
					type: "post",
					dataType: "json",
					contentType: "application/json; charset=utf-8",
				},

				"order": [
					[3, "asc"]
				],

				"columns": [{
						"defaultContent": '',
						"orderable": false,
						'class': 'centered'
					},
					{
						"data": "h_ida"
					},
					{
						"data": "h_idi"
					},
					{
						"data": "h_iti",
						'class': 'centered'
					},
					{
						"data": "h_ids"
					},
					{
						"data": "h_sec",
						"orderable": false,
						'class': 'centered'
					},
					{
						"data": "h_sno",
						"orderable": false,
						'class': 'righted',
						"render": function(data, type, JsonResultRow, meta) {
							if (type === 'sort' || type === 'type') {
								if (JsonResultRow['h_iti'] === 'портфель') return null;
								else return data;
							} else {
								if (JsonResultRow['h_iti'] === 'портфель') return '';

								if (JsonResultRow['h_ids'] == <?php echo $idsec; ?> || <?php echo g_cua('administrator') ? 1 : 0; ?>)
									data += "&nbsp;&nbsp;&nbsp;<button class='reorder btn-up' >↑</button><button class='reorder btn-down' >↓</button>";

								return data;
							}
						}
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
						"data": "h_tmd",
						'class': 'centered'
					},
					{
						"data": "h_ast",
						'class': 'centered',
						"render": function(data, type, JsonResultRow, meta) {
							if (type === 'sort' || type === 'type') {
								return data;
							} else {
								var show = '';
								if (data[0] == 'Y') show += imgok;
								else show += imgno;

								show += ' ';

								if (data[1] == 'Y') show += imgok;
								else show += imgno;

								return show;
							}
						}
					}
				],

				"columnDefs": [{
						"targets": [1, 2, 4],
						"visible": false,
						"searchable": true
					},
					{
						"targets": [9, 10],
						"orderSequence": ["desc", "asc"]
					}
				],

				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows({
						page: 'current'
					}).nodes();

					//mouse hovering
					<?php if (g_cua('administrator', 'seceditor')) { ?>
						rows.to$().addClass('hovered');
					<?php } ?>


					api.column(0).nodes().each(function(cell, i) {
						cell.innerHTML = i + 1;
					});

					//Partitioning
					if (api.settings().order()[0][0] == '3' && api.settings().order()[0][1] == 'asc') {
						api.order([2, 'desc'], [4, 'asc'], [6, 'asc'], [10, 'desc'], [3, 'asc']).draw();
						return;
					}

					if (api.settings().order()[0][0] == '2' && api.settings().order()[0][1] == 'desc') {
						var lastIssue;
						var lastNo = 1;
						for (var i = 0; i < api.rows({
								filter: 'applied'
							}).count(); i++) {
							var searchID = api.rows({
								filter: 'applied'
							})[0][i];
							var rowID = api.rows({
								order: 'applied'
							})[0].indexOf(searchID);
							if (i == 0 || api.cells(rowID, 3).data()[0] != lastIssue) {
								lastIssue = api.cells(rowID, 3).data()[0];
								lastNo = 1;
								$(api.rows().nodes()).eq(rowID).before('<tr><td colspan="8" class="group">Статьи в выпуск \'' + lastIssue + '\'</td></tr>');
							}
							api.column(0).nodes()[rowID].innerHTML = lastNo;
							lastNo++;
						}
					}
				}
			});

			//Reorder articles
			table.on('click', 'button.reorder', function() {
				var fd = new FormData();
				fd.append('ID_Article', table.row($(this).closest('tr')).data().h_ida);
				fd.append('IsUp', $(this).hasClass('btn-up') ? 'Y' : 'N');
				fd.append('action', 'articles_reorder');
				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						showStatus(response);
						table.ajax.reload();
					}
				});
			});

			//Hide pagination list
			$('#datatable_wrapper .dataTables_length')[0].style.display = 'none';

			//Mouse-button click
			<?php if (g_cua('administrator', 'seceditor')) { ?>
				InitMouseClick(table, 1, SITE_URL + '/articles/view/?id=');
			<?php } ?>

			$('#searchInput').keyup(function() {
				table.search($(this).val()).draw();

				if (table.rows({
						filter: 'applied'
					}).nodes().length == 1) {
					var artId = table.rows({
						filter: 'applied'
					}).data()[0].h_ida;
					<?php if (g_cua('administrator', 'seceditor')) { ?>
						window.location.href = SITE_URL + '/articles/view?id=' + artId;
					<?php } ?>
				}
			});

			$('#id_section').change(function() {
				table.ajax.url("<?php echo admin_url('admin-ajax.php'); ?>?action=articles_list&idi=888&ids=" + this.value).load();
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
						if (g_cua('administrator', 'maineditor', 'seceditor', 'tech')) {
							if (g_cua('administrator')) {
						?>
								<div class='actions-panel'>
									<button class='btn btn-add' onclick="window.location.href=SITE_URL + '/articles/create'">
										<table class='borderless'>
											<tr>
												<td width='40px'><img class='btn-icon' src='<?php echo site_url() ?>/resources/plus.png' /></td>
												<td class='btn-title'>Добавить статью</td>
											</tr>
										</table>
									</button>
								</div>
								<div style='height:5px;background-color:#F5F5F5;'></div>
							<?php
							}
							?>
							<div style='margin:5px'>
								<div style='overflow-x:auto;'>
									<table class='borderless'>
										<tr>
											<td>
												<div style='font-size:12pt;padding:10px;'>
													<label style='font-weight:bold;'>Быстрый поиск:</label>
													<input id='searchInput' type='text' autocomplete='off' autofocus />
												</div>
											</td>
											<td class='righted'>
												<div style='font-size:12pt;padding:10px;'>
													<label style='font-weight:bold;'>Раздел:</label>
													<select id='id_section'>
														<option value='777'>Весь портфель</option>
														<option value='1'>Раздел "ДО"</option>
														<option value='3'>Раздел "ОИ"</option>
														<option value='4'>Раздел "ЧМ"</option>
													</select>
												</div>
											</td>
										</tr>
									</table>
									<table id='datatable'>
										<thead>
											<tr>
												<th>№</th>
												<th>ID</th>
												<th>IDI</th>
												<th>Выпуск</th>
												<th>IDS</th>
												<th>Раздел</th>
												<th style='width:70px;'>Порядок</th>
												<th width='20%'>Авторы</th>
												<th>Название</th>
												<th style='width:90px;'>Срок (дней)</th>
												<th style='width:80px;'>Науч./Тех.</th>
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