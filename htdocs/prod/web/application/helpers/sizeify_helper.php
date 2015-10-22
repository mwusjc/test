<?php
function sizeify($url,$resizeto,$endpoint='http://sizeifyb.sjc.io') {
    $error_image = $endpoint.'/error?code=400';
    if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === false) {
        return $error_image;
    }
    if (!preg_match('/[whpgbslc]\d{1,4}|\d{1,4}x\d{1,4}|original|big/', $resizeto)) {
        return $error_image;
    }
    $u = parse_url($url);
    $p = substr($u['path'],1);
    if (!empty($u['query'])) {
        $p .= '?' . $u['query'];
    }
    $r = [
        $endpoint,
        $u['scheme'],
        implode('.',array_reverse(explode('.',$u['host']))),
        $resizeto,
        rawurlencode($p)
    ];
    return implode('/',$r);
}