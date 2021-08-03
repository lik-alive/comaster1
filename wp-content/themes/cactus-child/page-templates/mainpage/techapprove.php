<script type="text/javascript">
	$(document).ready(function() {
		var techapptable = $('#techapptable').DataTable({
			"bAutoWidth": false,
			"ordering": false,
			"bInfo": false,
			"paging": false,
			"serverSide": false,
			"processing": false,
			"language": {
				'emptyTable': "<div style='text-align: center; font-size:12pt;'>Статей нет</div>"
			},
			"ajax": {
				url: "<?php echo admin_url('admin-ajax.php'); ?>?action=main_list_nst_require_techapprove_articles&id=" + <?php echo $idsec ?>,
				type: "post",
				dataType: "json",
				contentType: "application/json; charset=utf-8",
			},

			"columns": [{
					"orderable": false,
					"data": null,
					"defaultContent": '',
					"class": 'centered'
				},
				{
					"data": "h_ida"
				},
				{
					"data": "h_sec",
					"orderable": false,
					"class": 'centered'
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
					"data": "h_mxd",
					"orderable": false,
					"class": 'centered'
				},
				{
					"data": null,
					"defaultContent": '',
					"class": 'centered'
				},
				{
					"data": null,
					"defaultContent": '',
					"class": 'centered'
				}
			],

			"columnDefs": [{
				"targets": 1,
				"visible": false,
				"searchable": false
			}],

			"drawCallback": function(settings) {
				var api = this.api();
				var rows = api.rows().nodes();

				if (rows.length > 0)
					$(this).closest('.infblock')[0].style.display = 'block';

				//mouse hovering
				<?php if (g_cua('administrator')) { ?>
					rows.to$().addClass('hovered');
				<?php } ?>

				api.column(0).nodes().each(function(cell, i) {
					cell.innerHTML = i + 1;
				});

				api.rows().every(function(rowIdx, tableLoop, rowLoop) {
					api.cell(rowIdx, 6).node().innerHTML =
						"<button class='btn btn-send' style='width:130px' ><table class='borderless'><tr>" +
						"<td width='40px'><img class='btn-icon' src='resources/letter.png'/></td>" +
						"<td class='btn-title'>Послать</td>" +
						"</tr></table></button>";
				});

				api.rows().every(function(rowIdx, tableLoop, rowLoop) {
					api.cell(rowIdx, 7).node().innerHTML =
						"<button class='btn btn-accept' style='width:130px' ><table class='borderless'><tr>" +
						"<td width='40px'><img class='btn-icon' src='resources/check.png'/></td>" +
						"<td class='btn-title'>Одобрить</td>" +
						"</tr></table></button>";
				});
			}
		});

		<?php if (g_cua('administrator')) { ?>
			InitMouseClick(techapptable, 1, 'articles/view/?id=');
		<?php } ?>

		var ID_Article = '';
		techapptable.on('click', 'button.btn-send', function() {
			var rowNo = techapptable.row($(this).closest('tr')).index();
			ID_Article = techapptable.cell(rowNo, 1).data();
			authors = techapptable.cell(rowNo, 3).data();
			title = techapptable.cell(rowNo, 4).data();

			$('#techDetailsDialog').find('.modal-title').html(title + '<br>' + authors);
			$('#techDetailsDialog').modal('toggle');
		});

		$('#techDetailsForm').submit(function(e) {
			e.preventDefault();
			$(this).closest('.modal').modal('toggle');

			var fd = new FormData(this);
			fd.append('ID_Article', ID_Article);
			fd.append('action', 'articles_senddetails');

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

		techapptable.on('click', 'button.btn-accept', function() {
			var rowNo = techapptable.row($(this).closest('tr')).index();
			ID_Article = techapptable.cell(rowNo, 1).data();

			$('#confirmMsg').html('Одобрить оформление?');
			$('#confirmDialog').modal('toggle');
		});

		$('#confirmForm').submit(function(e) {
			e.preventDefault();
			$(this).closest('.modal').modal('toggle');

			var fd = new FormData();
			fd.append('ID_Article', ID_Article);
			fd.append('action', 'articles_techapprove');

			$.ajax({
				type: 'POST',
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				data: fd,
				contentType: false,
				processData: false,
				success: function(response) {
					showStatus(response);
					techapptable.ajax.reload();
				}
			});
		});
	});
</script>

<div class='infblock' style='display:none'>
	<div class='infwarn'>
		<div class='inftitle'>Статьи ждут Вашего одобрения оформления</div>
		<div class='inftitledelim'></div>
		<div>
			<div style='overflow-x:auto;'>
				<table id='techapptable'>
					<thead>
						<tr>
							<th width='20px'>№</th>
							<th>ID</th>
							<th width='60px'>Секция</th>
							<th width='15%'>Авторы</th>
							<th>Название</th>
							<th width='70px'>Получено</th>
							<th width='70px'>Претензии</th>
							<th width='70px'>Одобрить</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class='infblockdelim'></div>
</div>

<?php include 'techdetails.php'; ?>