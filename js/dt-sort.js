$.fn.dataTableExt.oSort["nanumeric-desc"] = function (x, y) {
	if (x == 'n/a' && y == 'n/a') return 0;
	
	if (x == 'n/a') return 1;
	if (y == 'n/a') return -1;
	
	return y - x;
};

$.fn.dataTableExt.oSort["nanumeric-asc"] = function (x, y) {
	if (x == 'n/a' && y == 'n/a') return 0;
	
	if (x == 'n/a') return 1;
	if (y == 'n/a') return -1;
	
	return x - y;
}
