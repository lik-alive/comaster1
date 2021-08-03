<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type = "text/javascript">							
	$(document).ready(function() {
		var activeExperts = [];
		
		$('#expertName').autocomplete({
			minLength: 3,
			source: function (request, resolve) {
				$.ajax({
					type: 'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ); ?>?action=experts_list&kw='+encodeURIComponent(request.term),
					contentType: false,
					processData: false,
					success: function(response){
						activeExperts.length = 0;
						var res = JSON.parse(response).data;
						for (var i = 0; i < res.length; i++) {
							var expert = res[i];
							activeExperts.push({value: expert.h_nam + ' (рейтинг: ' + expert.h_rat + ')', id: expert.h_ide});
						}
						resolve(activeExperts);
					}
				});
			},
			select: function (event, ui) {
				$('#expertName').val(ui.item.value);
				$('#id_expert').val(ui.item.id);
			}
		});
	});
</script>

<div id='addExpertDialog' class='modal'>
	<div class='vertical-alignment-helper'>
		<div class='modal-dialog vertical-align-center'>
			<div class='modal-content'>
				<form id='addExpertForm' method='post' enctype='multipart/form-data'>
					<div class='modal-header'>
						<h4 class='modal-title'><?php echo g_cfl($article->Title);?></h4>
						<h4 class='modal-title'><?php echo $article->Authors?></h4>
					</div>
					<div class='modal-body'>
						<table class='borderless'>
							<tr>
								<td>Рецензент</td>
								<td>
									<input id='expertName' type='text' style='width:300px' placeholder='Введите имя или ключевое слово' required autofocus />
									<input id='id_expert' name='ID_Expert' type='hidden' required />
								</td>
							</tr>
							<?php $afileinfo = articles_get_fileinfo($article->ID_Article); ?>
							<tr>
								<td>Загруженный файл</td>
								<td><div><?php echo $afileinfo ?></div></td>
							</tr>
						</table>
					</div>
					<div class='modal-footer'>													
						<input type='submit' value='Назначить' />
						<input type='button' data-dismiss='modal' value='Отмена' />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>							