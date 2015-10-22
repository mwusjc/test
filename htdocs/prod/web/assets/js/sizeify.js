/**
 * @description - creates a global function called sizeify that accepts either 2 or 3 arguments: [endpoint,url,resizeto] or [url,resizeto]
 * @argument - string - endpoint - The sizeify service (optional)
 * @argument - string - url - the URL of the source image
 * @argument - string - resizeto - the special code that indicates desired image dimensions
 * @returns - string - a url pointing to the resized image, or an error if one of the arguments was malformed
 **/
;(function(undefined){
    "use strict";
    //    duck-type for node / browser
    var publish;
    if (typeof window === 'undefined') {
        require('@sean9999/isomorph/window/document/createElement');
        publish = function(name,func){
            module.exports = func;
        };
    } else if ("angular" in window) {
        publish = angular.module('sizeify', []).filter('sizeify', function() {
            return function(item,resizeto) {
                return sizeify(item,resizeto);
            };
        });
    } else {
        publish = function(name,func){
            window[name] = func;
        };
    }
    var DEFAULT_ENDPOINT = 'http://sizeifyb.sjc.io';
    var endpointIsSane = function(url) {
        var reg = /^http[s]?:\/\/[\w\-_\.]/;
        var r = reg.test(url);
        return r;        
    };
    var urlIsSane = function(url){
        var reg = /^http[s]?:\/\/[\w\-_\.]+\/.*/;
        var r = reg.test(url);
        return r;
    };
    var resizetoIsSane = function(resizeto){
        var reg = /^[whlspbgc]\d{1,4}|\d{1,4}x\d{1,4}$/;
        var r = reg.test(resizeto);
        return r;
    };
    var sizeify = function(arg1,arg2,arg3){
        var url,
            resizeto,
            endpoint = DEFAULT_ENDPOINT,
            parser,
            r;
        switch (arguments.length) {
            case 2:
            if (urlIsSane(arg1) && resizetoIsSane(arg2)) {
                url = arg1;
                resizeto = arg2;
            } else {
                throw new Error('bad parameter values');
            }
            break;
            case 3:
            if (endpointIsSane(arg1) && urlIsSane(arg2) && resizetoIsSane(arg3)) {
                endpoint = arg1;
                url = arg2;
                resizeto = arg3;
            } else {
                throw new Error('bad parameter values');
            }
            break;
            default:
            throw new Error('Wrong number of arguments');        
        }
        if (urlIsSane(url) && resizetoIsSane(resizeto)) {
            parser = document.createElement('a');
            parser.setAttribute('href',url);
            r = endpoint +
                '/' +
                parser.protocol.replace(':','') + '/' +
                parser.hostname.split('.').reverse().join('.') +
                '/' +
                resizeto +
                '/' +
                encodeURIComponent( parser.pathname.replace(/^\//,'') + parser.search );
            return r;
        } else {
            throw new Error('Insane arguments');
        }
    };
    sizeify.errorUrl = DEFAULT_ENDPOINT + '/error?code=400';
    sizeify.endpoint = DEFAULT_ENDPOINT;
    publish('sizeify',sizeify);
})();