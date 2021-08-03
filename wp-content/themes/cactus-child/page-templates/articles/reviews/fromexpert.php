<script type="text/javascript">
	$(document).ready(function() {

		//From Expert
		$('#id_verdict').change(function() {
			if (this.value == 1 || this.value == 4 || this.value == 5 || this.value == 6) {
				$('#revFiles').prop('required', false);
			} else {
				$('#revFiles').prop('required', true);
			}

			if (this.value == 5 || this.value == 6) {
				$('#isToAuthors').prop('checked', false);
				$('#isToAuthors').trigger('change');
			} else {
				$('#isToAuthors').prop('checked', true);
				$('#isToAuthors').trigger('change');
			}
		});

		$('#isToAuthors').change(function() {
			if ($('#isToAuthors').prop('checked')) $('#feTechDetails').closest('tr').show();
			else $('#feTechDetails').closest('tr').hide();
		});

		$('#feTechDetails').on('propertychange input', function() {
			var res = this.value.split('\n');
			this.value = '';
			for (var i = 0; i < res.length; i++) {
				var str = res[i];

				if (str.length > 0 && isNaN(str[0])) this.value += (i + 1) + '.\t';
				this.value += str;
				if (i != res.length - 1) this.value += '\n'
			}
		});

		$('.dateMinus').click(function() {
			var now = new Date();
			var date = new Date();
			date.setDate(now.getDate() - parseInt(this.id.slice(-1)));

			var day = ("0" + date.getDate()).slice(-2);
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var today = date.getFullYear() + "-" + (month) + "-" + (day);
			$('#fromExpRD').val(today);
		});

		$('.verdict').click(function() {
			$('#id_verdict').val(parseInt(this.id.slice(-1)));
			$('#id_verdict').trigger('change');
		});
	});
</script>

<div id='fromExpertDialog' class='modal'>
	<div class='vertical-alignment-helper'>
		<div class='modal-dialog vertical-align-center'>
			<div class='modal-content'>
				<form id='fromExpertForm' method='post' enctype='multipart/form-data'>
					<div class='modal-header'>
						<h4 class='modal-title'><?php echo g_cfl($article->Title); ?></h4>
						<h4 class='modal-title'><?php echo $article->Authors ?></h4>
					</div>
					<div class='modal-body'>
						<table class='borderless'>
							<tr>
								<td style='width: 150px;'>Дата получения</td>
								<td><input id='fromExpRD' type='date' name='RecvDate' value='<?php echo date('Y-m-d'); ?>' required /></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input id='feminus1' class='dateMinus' style='margin-bottom:5px;' type='button' value='вчера' />
									<input id='feminus2' class='dateMinus' type='button' value='-2 дня' />
									<input id='feminus3' class='dateMinus' type='button' value='-3 дня' />
								</td>
							</tr>
							<tr>
								<td>Вердикт</td>
								<td><select id='id_verdict' name='ID_Verdict' required>
										<?php
										$verdicts = tables_list_verdict_ids_tostr();
										echo "<option value=''>---</option>";
										foreach ($verdicts as $verdict) {
											if ($verdict->ID_Verdict >= 5)
												echo "<option value='{$verdict->ID_Verdict}'>---{$verdict->Title}</option>";
											else
												echo "<option value='{$verdict->ID_Verdict}'>{$verdict->Title}</option>";
										}
										?>
									</select></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input id='verdict1' class='verdict' style='margin-bottom:5px;' type='button' value='добро' />
									<input id='verdict2' class='verdict' type='button' value='подправить' />
									<input id='verdict3' class='verdict' type='button' value='переделать' />
								</td>
							</tr>
							<tr>
								<td>Файлы</td>
								<td><input id='revFiles' name='files' type='file' class='files' multiple required /></td>
							</tr>
							<tr>
								<td>Отправить авторам</td>
								<td><input id='isToAuthors' type='checkbox' name='IsToAuthors' checked /></td>
							</tr>
							<?php if ($article->IsTechApproved == 'N') { ?>
								<tr>
									<td>Претензии</td>
									<td><textarea id='feTechDetails' name='TechDetails' rows='10' style='width:100%; line-height:1;'></textarea></td>
								</tr>
							<?php } ?>
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