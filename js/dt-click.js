function InitMouseClick(table, idColNo, tolink) {
	table.on( 'click', 'td', function () {
		var rowNo = table.row(this).index();
		if (typeof(rowNo) != "undefined" 
		&& $(this).find("input:button").length == 0 
		 && $(this).find("button").length == 0
		&& !$(this).hasClass('details-control')) {
			var id = table.cell(rowNo, idColNo).data();
			window.location.href = tolink + id;
		}
	} );
	
	table.on( 'mousedown', 'tr', function (e) {			
		var rowNo = table.row(this).index();
		if (typeof(rowNo) != "undefined") {			
			var id = table.cell(rowNo, idColNo).data();
			if (e.which == 2) {
				window.open(tolink + id);
			}
		}
	} );
}