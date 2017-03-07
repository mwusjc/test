/**
 *  @description: render templates or '<span />' if sanity tests don't pass
 **/

var isArray = jQuery.isArray;
function isObject(thing) {
    var r = false;
    if (Object.prototype.toString.call(thing) === '[object Object]') {
        r = true;
    }
    return r;
}
function replaceAll(find, replace, str) {
    var r = str;
    if (typeof str === 'string') {
        return str.replace(new RegExp(find, 'g'), replace);    
    }
    return r;
}
hlf.drawTemplate = function(tpl, replace) {
    $template = $(tpl).html() || '<span />';
    if (isObject(replace) || isArray(replace)) {
        $.each(replace, function(key,item) {
            $template = replaceAll(key,item,$template);
        });
    }
    return $template;
}
