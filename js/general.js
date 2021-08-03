function toColor(red, green, blue) {
	return "#"
	+ (red.toString(16).length < 2 ? '0' + red.toString(16) : red.toString(16))
	+ (green.toString(16).length < 2 ? '0' + green.toString(16) : green.toString(16)) 
	+ (blue.toString(16).length < 2 ? '0' + blue.toString(16) : blue.toString(16));
}

function revertDate(d) {
	return d.substr(6, 4)+'-'+d.substr(3, 2)+'-'+d.substr(0, 2);
}

String.prototype.endsWith = function(suffix) {
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
};

function showStatus(msg) {
	$('#status-msg').fadeIn();
	$('#status-msg').html(msg);
	setTimeout(function() {
		$('#status-msg').hide();
	}, 5000);
}

function isAlpha(chr) {
	if (('a' <= chr && chr <= 'z') ||
		('A' <= chr && chr <= 'Z') ||
		('а' <= chr && chr <= 'я') ||
		('А' <= chr && chr <= 'Я') ||
		chr == 'ё' || chr == 'Ё') return true;
		
	return false;
}

function isAlphaEng(chr) {
	if (('a' <= chr && chr <= 'z') ||
		('A' <= chr && chr <= 'Z')) return true;
		
	return false;
}