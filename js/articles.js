function parseArticleString(string){		
	var title = '';
	var authors = '';
	var trueAuthors = '';
	var affiliation = '';
	var pageCount = '';
	
	var array = string.split('\n');
	var i = 0;
	
	//Title
	while (i < array.length) {
		if (i == 0 || array[i] == array[i].toUpperCase()) {
			title += array[i] + ' ';
			i++;
		}
		else break;
	}
	
	//Authors
	if (i < array.length) {
		authors += array[i];
		i++;
	}
	
	//Format authors: Surname F.P., ...
	if (authors != '') {
		var j = 0;
		var trueAuthors = '';
		var fp = '';
		var surname = '';
		
		while (j <= authors.length) {
			if (j + 1 < authors.length && isAlpha(authors[j]) && authors[j+1] == '.') {
				fp += authors[j] + '.';
				j += 1;
			}
			else if (j + 2 < authors.length && isAlpha(authors[j]) && isAlpha(authors[j+1]) && authors[j+2] == '.') {
				fp += authors[j] + authors[j+1] + '.';
				j += 2;
			}
			else if (j < authors.length && isAlpha(authors[j])) {
				surname += authors[j];
			}
			else {
				if (surname != '') {
					if (trueAuthors != '') {
						trueAuthors += ', ';
					}
					trueAuthors += surname + ' ' + fp;
					fp = '';
					surname = '';
				}
			}
			j++;
		}
	}
	
	//Affiliation
	while (i < array.length) {
		if (!isNaN(array[i])) break;
		affiliation += array[i] + ' ';
		i++;
	}
	
	//PageCount
	if (i < array.length) {
		pageCount = array[i];
	}
	
	return [title, trueAuthors, affiliation, pageCount]
}


