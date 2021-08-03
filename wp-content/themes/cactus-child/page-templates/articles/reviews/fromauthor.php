<script type="text/javascript">
	$(document).ready(function() {
		$('.dateMinus').click(function() {
			var now = new Date();
			var date = new Date();
			date.setDate(now.getDate() - parseInt(this.id.slice(-1)));

			var day = ("0" + date.getDate()).slice(-2);
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var today = date.getFullYear() + "-" + (month) + "-" + (day);
			$('#fromAuthRD').val(today);
		});
	});
</script>

<div id='fromAuthorDialog' class='modal'>
	<div class='vertical-alignment-helper'>
		<div class='modal-dialog vertical-align-center'>
			<div class='modal-content'>
				<form id='fromAuthorForm' method='post' enctype='multipart/form-data'>
					<div class='modal-header'>
						<h4 class='modal-title'><?php echo g_cfl($article->Title); ?></h4>
						<h4 class='modal-title'><?php echo $article->Authors ?></h4>
					</div>
					<div class='modal-body'>
						<table class='borderless'>
							<tr>
								<td>Дата получения</td>
								<td><input id='fromAuthRD' type='date' name='RecvDate' value='<?php echo date('Y-m-d'); ?>' required /></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input id='faminus1' class='dateMinus' style='margin-bottom:5px;' type='button' value='вчера' />
									<input id='faminus2' class='dateMinus' type='button' value='-2 дня' />
									<input id='faminus3' class='dateMinus' type='button' value='-3 дня' />
								</td>
							</tr>
							<tr>
								<td>Файлы</td>
								<td><input name='files' type='file' class='files' multiple required /></td>
							</tr>
						</table>
					</div>
					<div class='modal-footer'>
						<input type='submit' value='Сохранить' />
						<input type='button' data-dismiss='modal' value='Отмена' />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>