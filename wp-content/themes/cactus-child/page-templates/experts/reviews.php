<script type="text/javascript">
	$(document).ready(function() {
		var ID_Expert = <?php echo g_si($_GET['id']); ?>;
		var ID_Review = '';

		var table = $('#articlestable').DataTable({
			"bAutoWidth": false,
			"ordering": false,
			"bInfo": false,
			"paging": false,
			"serverSide": false,
			"processing": false,
			"language": {
				'emptyTable': "<div style='text-align: center; font-size:12pt;'>Статей не рецензировал</div>"
			},
			"ajax": {
				url: "<?php echo admin_url('admin-ajax.php'); ?>?action=articles_list_for_expert&ide=" + ID_Expert,
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
					"data": "h_ida"
				},
				{
					"data": "h_ira"
				},
				{
					"data": "h_tit",
					"orderable": false
				},
			],

			"columnDefs": [{
				"targets": [1, 2],
				"visible": false,
				"searchable": false
			}],

			"drawCallback": function(settings) {
				var api = this.api();
				var rows = api.rows().nodes();

				//mouse hovering
				rows.to$().addClass('hovered');

				//accepted/not_accepted parts
				if (api.cells(0, 2).data()[0] === 'N')
					$(api.rows().nodes()).eq(0).before('<tr><td colspan="4" class="group">Статьи в работе</td></tr>');

				for (var i = 0; i < api.rows().count(); i++) {
					if (api.cells(i, 2).data()[0] !== 'N') {
						$(api.rows().nodes()).eq(i).before('<tr><td colspan="4" class="group">Статьи отработанные</td></tr>');
						break;
					}
				}

				api.column(0).nodes().each(function(cell, i) {
					cell.innerHTML = i + 1;
				});
			}
		});

		table.on('click', 'td', function() {
			window.location = SITE_URL + '/articles/view/?id=' + table.row(this).data().h_ida;
		});

	});
</script>

<div style='overflow-x:auto; margin:5px'>
	<table id='articlestable' class='smartcompact'>
		<thead>
			<tr>
				<th style='min-width: 30px; width: 30px'>№</th>
				<th>IDA</th>
				<th>IDI</th>
				<th>Название</th>
			</tr>
		</thead>
	</table>
</div>