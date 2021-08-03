<script type="text/javascript">
	$(document).ready(function() {
		var ID_Article = <?php echo g_si($_GET['id']); ?>;
		var ID_Review = '';

		var table = $('#reviewstable').DataTable({
			"bAutoWidth": false,
			"ordering": false,
			"bInfo": false,
			"paging": false,
			"serverSide": false,
			"processing": false,
			"language": {
				'emptyTable': "<div style='text-align: center; font-size:12pt;'>Рецензенты ещё не назначены</div>"
			},
			"ajax": {
				url: "<?php echo admin_url('admin-ajax.php'); ?>?action=reviews_list_for_article&ida=" + ID_Article,
				type: "post",
				dataType: "json",
				contentType: "application/json; charset=utf-8",
			},

			"columns": [{
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{
					"data": "h_rno",
					"orderable": false,
					'class': 'centered'
				},
				{
					"data": "h_idr"
				},
				{
					"data": "h_esn",
					"orderable": false
				},
				{
					"data": "h_ted",
					"orderable": false,
					'class': 'centered'
				},
				{
					"data": "h_fed",
					"orderable": false,
					'class': 'centered'
				},
				{
					"data": "h_vt",
					"orderable": false,
					'class': 'centered'
				},
				{
					"data": null,
					"defaultContent": '',
					'class': 'centered'
				},
				{
					"data": "h_tad",
					"orderable": false,
					'class': 'centered'
				},
				{
					"data": "h_fad",
					"orderable": false,
					'class': 'centered'
				},
				{
					"data": "h_red",
					"orderable": false,
					'class': 'centered'
				}
				<?php if (g_cua('administrator')) { ?>, {
						"data": "h_cm",
						"orderable": false
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
				var rows = api.rows().nodes();

				//mouse hovering
				<?php if (g_cua('administrator')) { ?>
					rows.to$().addClass('hovered');
				<?php } ?>

				var lastspec;
				api.rows().every(function(rowIdx, tableLoop, rowLoop) {
					var data = this.data();
					//colorize rows
					if (data.h_vt == 'добро') $(this.node()).addClass('bggreen');
					else if (data.h_vt == 'отклонить') $(this.node()).addClass('bgred');
					if (data.h_vt == 'снят' || data.h_vt == 'отказался') $(this.node()).addClass('bggray');

					//hide rows
					if (lastspec != data.h_ide) {
						lastspec = data.h_ide;
						var str = 'asd';
						var tmp = str.endsWith('d');
						if (data.h_rno != null && data.h_rno.endsWith('.1')) $(api.cell(rowIdx, 0).node()).addClass('nodetails-control');
						else $(api.cell(rowIdx, 0).node()).addClass('details-control');
					} else {
						this.node().style.display = 'none';
						$(api.cell(rowIdx, 0).node()).addClass('nodetails-control');
					}

					//download reviews/edit
					if (data.h_vt != null && data.h_rfs > 0) {
						api.cell(rowIdx, 7).node().innerHTML += "<input type='button' class='file' style='width:32px; height:40px' />";
					}
					<?php if (g_cua('administrator')) { ?>
						api.cell(rowIdx, 7).node().innerHTML += "<input type='button' class='updaterfile edit' style='width:30px; height:40px' />";
					<?php } ?>

					//buttons in cells
					<?php if (g_cua('administrator')) { ?>
						if (data.h_fed == null)
							api.cell(rowIdx, 5).node().innerHTML = "<input type='button' value='Получено' class='cellbutton setrev' />";
						else if (data.h_tad == null) {
							if (data.h_vt != 'снят' && data.h_vt != 'отказался') api.cell(rowIdx, 8).node().innerHTML = "<input type='button' value='Направить' class='cellbutton setans' />";
						} else if (data.h_fad == null)
							api.cell(rowIdx, 9).node().innerHTML = "<input type='button' value='Получено' class='cellbutton setrep' />";

						if (data.h_red == null && data.h_fed == null)
							api.cell(rowIdx, 10).node().innerHTML = "<input type='button' value='Направить' class='cellbutton remexp remind' />";
					<?php } ?>
				});
			}
		});

		table.on('click', 'td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table.row(tr);

			if (tr.hasClass('shown')) {
				table.rows().every(function(rowIdx, tableLoop, rowLoop) {
					if (row.data().h_ide == this.data().h_ide && row.data() != this.data())
						this.node().style.display = 'none';
				});
				tr.removeClass('shown');
			} else {
				table.rows().every(function(rowIdx, tableLoop, rowLoop) {
					if (row.data().h_ide == this.data().h_ide && row.data() != this.data())
						this.node().style.display = '';
				});
				tr.addClass('shown');
			}
		});

		<?php if (g_cua('administrator')) { ?>
			table.on('click', 'td', function() {
				if ($(table.cell(this).node()).find("input:button").length == 0 && table.column(this).index() != 0) {
					window.location = SITE_URL + '/tables/reviews/edit/?id=' + table.row(this).data().h_idr;
				}
			});
		<?php } ?>

		//From Expert
		table.on('click', 'input.setrev', function() {
			ID_Review = table.row($(this).closest('tr')).data().h_idr;
			$('#fromExpertForm')[0].reset();
			$('#isToAuthors').trigger('change');
			$('#fromExpertDialog').modal('toggle');
		});

		$('#fromExpertForm').submit(function(e) {
			e.preventDefault();
			$(this).closest('.modal').modal('toggle');

			var fd = new FormData(this);
			fd.append('ID_Review', ID_Review);
			var file_data = $(this).find('.files').prop('files');
			for (var x = 0; x < file_data.length; x++) {
				fd.append('files[]', file_data[x]);
			}
			fd.append('action', 'reviews_fromexpert');

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

		//To Author
		table.on('click', 'input.setans', function() {
			ID_Review = table.row($(this).closest('tr')).data().h_idr;

			var fd = new FormData();
			fd.append('ID_Review', ID_Review);
			fd.append('action', 'reviews_get_fileinfo');
			$.ajax({
				type: 'POST',
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				data: fd,
				contentType: false,
				processData: false,
				success: function(response) {
					$('#toAuthorForm').find('#fileinfo').html(response);
				}
			});

			$('#toAuthorDialog').modal('toggle');
		});

		$('#toAuthorForm').submit(function(e) {
			e.preventDefault();
			$(this).closest('.modal').modal('toggle');

			var fd = new FormData(this);
			fd.append('ID_Review', ID_Review);
			fd.append('action', 'reviews_toauthor');

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

		//From Author
		table.on('click', 'input.setrep', function() {
			ID_Review = table.row($(this).closest('tr')).data().h_idr;
			$('#fromAuthorDialog').modal('toggle');
		});

		$('#fromAuthorForm').submit(function(e) {
			e.preventDefault();
			$(this).closest('.modal').modal('toggle');

			var fd = new FormData(this);
			var file_data = $(this).find('.files').prop('files');
			for (var x = 0; x < file_data.length; x++) {
				fd.append('files[]', file_data[x]);
			}
			fd.append('ID_Review', ID_Review);
			fd.append('action', 'reviews_fromauthor');

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

		//Remind Expert
		table.on('click', 'input.remexp', function() {
			ID_Review = table.row($(this).closest('tr')).data().h_idr;

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
					table.ajax.reload();
				}
			});
		});

		//Download Files			
		table.on('click', 'input.file', function() {
			window.open(SITE_URL + '/download/?ida=' + ID_Article + '&idr=' + table.row($(this).closest('tr')).data().h_idr, '_blank');
		});


		//Update Files
		table.on('click', 'input.updaterfile', function() {
			ID_Review = table.row($(this).closest('tr')).data().h_idr;

			var data = table.row($(this).closest('tr')).data();
			$('#updateRFileDialog .modal-title').html(data.h_rno + ' ' + data.h_esn);
			$('#updateRFileDialog').modal('toggle');
		});

		$('#updateRFileForm').submit(function(e) {
			e.preventDefault();
			$(this).closest('.modal').modal('toggle');

			var fd = new FormData();
			var file_data = $(this).find('.files').prop('files');
			for (var x = 0; x < file_data.length; x++) {
				fd.append('files[]', file_data[x]);
			}
			fd.append('ID_Review', ID_Review);
			fd.append('action', 'reviews_update_file');

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
	});
</script>

<div style='overflow-x:auto; margin:5px'>
	<table id='reviewstable' class='details smartcompact'>
		<thead>
			<tr>
				<th style='min-width: 30px; width: 30px'></th>
				<th style='min-width: 30px; width: 30px'>№</th>
				<th>IDR</th>
				<th>Рецензент</th>
				<th style='min-width: 80px; width: 10%;'>Послано</th>
				<th style='min-width: 80px; width: 10%;'>Ответ</th>
				<th style='min-width: 70px; width: 10%;'>Вердикт</th>
				<th style='min-width: 90px; width: 90px;'>Файл</th>
				<th style='min-width: 80px; width: 10%;'>Авторам</th>
				<th style='min-width: 80px; width: 10%;'>Ответ</th>
				<th style='min-width: 80px; width: 10%;'>Напом.</th>
				<?php if (g_cua('administrator')) { ?>
					<th style='width: 20%;'>Комментарии</th>
				<?php } ?>
			</tr>
		</thead>
	</table>
</div>


<?php include 'reviews/fromexpert.php'; ?>
<?php include 'reviews/toauthor.php'; ?>
<?php include 'reviews/fromauthor.php'; ?>
<?php include 'reviews/updaterfile.php'; ?>