function newClipboard(element) {
	element.attr("data-clipboard-text",element.text())
	copied = new Clipboard("label");
}

/*jQuery( document ).ready(function($) {
    if($('#modalcovid').length) {
        setTimeout(function() { 
            $('#modalcovid').modal('show')
        }, 2000);
    }
});*/