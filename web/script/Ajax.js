// Classes Ajax Static =========================================================================

function Ajax() {}

Ajax.get = function(url) {
    return new Promise(function(resolve, reject) {
        var req = new XMLHttpRequest();
        req.open("GET", url);
        
        req.addEventListener("load", function() {
            if (req.status >= 200 && req.status < 400) {
                resolve(req.response);
            } else {
                reject(req.status + " " + req.statusText + " " + url);
            }
        });
        
        req.addEventListener("error", function () {
            reject("Erreur réseau avec l'URL " + url);
        });
        
        req.send(null);
    });
};

Ajax.post = function(url, data) {
    return new Promise(function(resolve, reject) {
        var req = new XMLHttpRequest();
        req.open("POST", url);
        
        req.addEventListener("load", function () {
            if (req.status >= 200 && req.status < 400) {
                resolve(req.response);
            } else {
                reject(req.status + " " + req.statusText + " " + url);
            }
        });
        
        req.addEventListener("error", function () {
            reject("Erreur réseau avec l'URL " + url);
        });
        
        req.send(data);
    });
};