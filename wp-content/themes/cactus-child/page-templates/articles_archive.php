<?php
/*
		Template Name: Articles Archive
	*/
get_header(); ?>

<?php include 'tools/header_title.php'; ?>

<?php if (g_cua('administrator', 'maineditor', 'seceditor', 'tech')) { ?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="<?php echo site_url() ?>/js/dt-click.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			var imgok = "<img class='statusok' width='32' height='32' style='margin:auto;'  />";
			var imgno = "<img class='statusundef' width='32' height='32' style='margin:auto;'  />";

			var table = $('#datatable').DataTable({
				"bAutoWidth": false,
				"bInfo": false,
				"pagingType": 'numbers',
				"serverSide": false,
				"processing": false,
				"pageLength": 50,
				"language": {
					'emptyTable': "<div style='text-align: center; font-size:12pt;'>Статей в архиве не обнаружено</div>"
				},
				"ajax": {
					url: "<?php echo admin_url('admin-ajax.php'); ?>?action=articles_list&ids=777&idi=" + $('#id_issue').find(":selected").val(),
					type: "post",
					dataType: "json",
					contentType: "application/json; charset=utf-8",
				},

				"columns": [{
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
						"data": "h_aut"
					},
					{
						"data": "h_tit",
						"orderable": false
					},
					{
						"data": "h_tmd",
						'class': 'centered'
					}
				],

				"columnDefs": [{
						"targets": 1,
						"visible": false,
						"searchable": true
					},
					{
						"targets": 5,
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
				}
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

			$('#id_issue').change(function() {
				table.ajax.url("<?php echo admin_url('admin-ajax.php'); ?>?action=articles_list&ids=777&idi=" + this.value).load();
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
							$issues = tables_list_issue_ids_tostr();
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
													<select id='id_issue'>
														<?php
														echo "<option value='777'>весь архив</option>";
														$issue = $issues[2];
														echo "<option value='{$issue->ID_Issue}'>{$issue->Title}</option>";
														for ($i = sizeof($issues) - 1; $i >= 0; $i--) {
															if ($i == 2) continue;
															$issue = $issues[$i];
															echo "<option value='{$issue->ID_Issue}'>{$issue->Title}</option>";
														}
														?>
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
												<th>Раздел</th>
												<th width='20%'>Авторы</th>
												<th>Название</th>
												<th style='width:90px;'>Срок (дней)</th>
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