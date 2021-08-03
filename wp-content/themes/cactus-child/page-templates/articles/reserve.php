<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div id='reserveDialog' class='modal'>
	<div class='vertical-alignment-helper'>
		<div class='modal-dialog vertical-align-center'>
			<div class='modal-content'>
				<form id='reserveForm' method='post' enctype='multipart/form-data'>
					<div class='modal-header'>
						<h4 class='modal-title'><?php echo g_cfl($article->Title);?></h4>
						<h4 class='modal-title'><?php echo $article->Authors?></h4>
					</div>
					<div class='modal-body'>
						<table class='borderless'>
							<tr>
								<td>Выпуск</td>
								<td>
									<select name='ID_Issue' required >
										<?php
											$issues = tables_list_issue_ids_tostr();
							
											echo "<option value=''>---</option>";
											for ($i = sizeof($issues) - 1; $i >= 0; $i--){
												$item = $issues[$i];
												if ($item->ID_Issue == $article->ID_Issue)
												echo "<option value='{$item->ID_Issue}' selected >{$item->Title}</option>";
												else 
												echo "<option value='{$item->ID_Issue}' >{$item->Title}</option>";
											}											
										?>
									</select>						
								</td>
							</tr>
						</table>
					</div>
					<div class='modal-footer'>													
						<input type='submit' value='Резерв' />
						<input type='button' data-dismiss='modal' value='Отмена' />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>							