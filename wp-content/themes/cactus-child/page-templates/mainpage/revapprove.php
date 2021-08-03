<script type="text/javascript">
	$(document).ready(function() {
		var revapptable = $('#revapptable').DataTable({
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
				url: "<?php echo admin_url('admin-ajax.php'); ?>?action=main_list_nst_require_revapprove_articles&id=" + <?php echo $idsec ?>,
				type: "post",
				dataType: "json",
				contentType: "application/json; charset=utf-8",
			},

			"columns": [{
					"orderable": false,
					"data": null,
					"defaultContent": '',
					"className": 'centered'
				},
				{
					"data": "h_ida"
				},
				{
					"data": "h_sec",
					"orderable": false,
					"className": 'centered'
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
					"data": "h_ver",
					"orderable": false,
					"className": 'centered'
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
					this.DataTable().table().container().parentElement.parentElement.parentElement.parentElement.style.display = 'block';

				//mouse hovering
				rows.to$().addClass('hovered');


				api.column(0).nodes().each(function(cell, i) {
					cell.innerHTML = i + 1;
				});
			}
		});

		InitMouseClick(revapptable, 1, 'articles/view/?id=');
	});
</script>

<div style='display:none'>
	<div class='infwarn'>
		<div class='inftitle'>Статьи ждут Вашего одобрения / отклонения</div>
		<div class='inftitledelim'></div>
		<div>
			<div style='overflow-x:auto;'>
				<table id='revapptable'>
					<thead>
						<tr>
							<th width='20px'>№</th>
							<th>ID</th>
							<th width='60px'>Секция</th>
							<th width='25%'>Авторы</th>
							<th>Название</th>
							<th width='70px'>Статус</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class='infblockdelim'></div>
</div>