<script type = "text/javascript">
	$(document).ready(function() {
		/*$('#techDetails').on('propertychange input', function() {
			var res = this.value.split('\n');
			this.value = '';
			for (var i = 0; i < res.length; i++) {
				var str = res[i];
				
				if (str.length > 0  && isNaN(str[0])) this.value += (i+1) + '.\t';
				this.value += str;
				if (i != res.length - 1) this.value += '\n'
			}
		});*/
	}); 
</script>

<div id='techDetailsDialog' class='modal'>
	<div class='vertical-alignment-helper'>
		<div class='modal-dialog vertical-align-center'>
			<div class='modal-content'>
				<form id='techDetailsForm' method='post' enctype='multipart/form-data'>
					<div class='modal-header'>
						<h4 class='modal-title'></h4>
					</div>
					<div class='modal-body'>
						<table class='borderless'>
							<tr>
								<td>Претензии</td>
								<td><textarea id='techDetails' name='TechDetails' rows='10' style='width:100%; line-height:1;' ></textarea></td>
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