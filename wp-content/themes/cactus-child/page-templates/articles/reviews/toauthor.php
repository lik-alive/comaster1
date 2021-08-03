<script type = "text/javascript">
	$(document).ready(function() {
		$('#taTechDetails').on('propertychange input', function() {
			var res = this.value.split('\n');
			this.value = '';
			for (var i = 0; i < res.length; i++) {
				var str = res[i];
				
				if (str.length > 0  && isNaN(str[0])) this.value += (i+1) + '.\t';
				this.value += str;
				if (i != res.length - 1) this.value += '\n'
			}
		});
	}); 
</script>

<div id='toAuthorDialog' class='modal'>
	<div class='vertical-alignment-helper'>
		<div class='modal-dialog vertical-align-center'>
			<div class='modal-content'>
				<form id='toAuthorForm' method='post' enctype='multipart/form-data'>
					<div class='modal-header'>
						<h4 class='modal-title'><?php echo g_cfl($article->Title);?></h4>
						<h4 class='modal-title'><?php echo $article->Authors?></h4>
					</div>
					<div class='modal-body'>
						<table class='borderless'>
							<?php if ($article->IsTechApproved == 'N') { ?>
								<tr>
									<td>Претензии</td>
									<td><textarea id='taTechDetails' name='TechDetails' rows='10' style='width:100%; line-height:1;' ></textarea></td>
								</tr>
							<?php } ?>
							<tr>
								<td>Загруженный файл</td>
								<td><label id='fileinfo' ></label></td>
							</tr>
						</table>
					</div>
					<div class='modal-footer'>													
						<input type='submit' value='Отправить' />
						<input type='button' data-dismiss='modal' value='Отмена' />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>