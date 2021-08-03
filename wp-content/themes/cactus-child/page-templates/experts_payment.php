<?php
/*
		Template Name: Experts Payment
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
					'emptyTable': "<div style='text-align: center; font-size:12pt;'>Рецензий не обнаружено</div>"
				},
				"ajax": {
					url: "<?php echo admin_url('admin-ajax.php'); ?>?action=experts_list_payment",
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
						"data": "h_fct",
						'className': 'centered'
					},
					{
						"data": "h_sct",
						'className': 'centered'
					},
					{
						"data": "h_pay",
						'className': 'centered'
					}
				],

				"order": [
					[5, "desc"]
				],

				"columnDefs": [{
						"targets": 1,
						"visible": false,
						"searchable": true
					},
					{
						"targets": [3, 4, 5],
						"orderSequence": ["desc", "asc"]
					}
				],

				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows().nodes();

					//mouse hovering
					rows.to$().addClass('hovered');

					var maxcountP = 0,
						val;
					for (var i = 0; i < api.rows().count(); i++) {
						val = parseInt(api.row(i).data().h_pay);
						if (maxcountP < val) maxcountP = val;
					}

					var red, green, blue;
					for (var i = 0; i < api.rows().count(); i++) {
						green = 255;
						red = 255 - parseInt(255 * api.row(i).data().h_pay / maxcountP * 1);
						blue = 255;
						api.cell(i, 5).node().style.background = toColor(red, green, blue);
					}

					api.column(0).nodes().each(function(cell, i) {
						cell.innerHTML = i + 1;
					});
				}
			});

			//Hide pagination list
			$('#datatable_wrapper .dataTables_length')[0].style.display = 'none';

			$('#broadcast').on('click', function() {
				var fd = new FormData();
				fd.append('action', 'experts_payment_broadcast');

				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: fd,
					contentType: false,
					processData: false,
					success: function(response) {
						showStatus(response);
					}
				});
			});

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
							if (g_cua('administrator')) {
						?>
								<div class='actions-panel'>
									<!--<button id='broadcast' class='btn btn-send'>
										<table class='borderless'><tr>
											<td width='40px'><img class='btn-icon' src='echo site_url()/resources/letter.png'/></td>
											<td class='btn-title'>Разослать письма</td>
										</tr></table>
									</button>-->
								</div>
								<div style='height:5px;background-color:#F5F5F5;'></div>
							<?php
							}
							?>

							<div>
								<div class='infstat'>
									<div class='inftitle'>Информация по оплате</div>
									<div class='inftitledelim'></div>
									<div>
										<div>Оплата за первичную рецензию: <b><?php echo experts_payment_freview(); ?> руб.</b> </div>
										<div>Оплата за повторную рецензию: <b><?php echo experts_payment_sreview(); ?> руб.</b> </div>
										<div>Общая сумма на <?php echo date('d-m-Y') ?>: <b><?php echo experts_payment_total(); ?> руб.</b> </div>
										<div>Прогноз на 2017 год: <b><?php echo experts_payment_prediction(); ?> руб.</b> </div>
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
												<th style='vertical-align:middle'>№</th>
												<th>ID</th>
												<th style='vertical-align:middle'>Рецензент</th>
												<th style='min-width:70px; width:20%;'>Первичных рецензий</th>
												<th style='min-width:70px; width:20%;'>Повторных рецензий</th>
												<th style='min-width:70px; width:15%;'>Оплата, руб.</th>
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