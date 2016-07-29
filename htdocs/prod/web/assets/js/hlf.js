 function replaceAll(find, replace, str) {
     if (typeof str !== 'undefined')
        return str.replace(new RegExp(find, 'g'), replace);
     return '';
 }

hlf.drawTemplate = function(tpl, replace) {
    $template = $(tpl).html();
    $.each(replace, function(key,item) {
        $template = replaceAll(key,item,$template);
    });
    return $template;
}