function replaceAll(find, replace, str) {
  return str.replace(new RegExp(find, 'g'), replace);
}

hlf.drawTemplate = function(tpl, replace) {
  $template = $(tpl).html();
  $.each(replace, function(key,item) {
    $template = replaceAll(key,item,$template);
  });
  return $template;
}