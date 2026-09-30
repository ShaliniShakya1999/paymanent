/**
 * Recharge (Mobile / DTH) – frontend service
 */
var RechargeService = (function() {
    function getOperators(url, csrfToken, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                try {
                    var res = JSON.parse(xhr.responseText || '{}');
                    if (callback) callback(res);
                } catch (e) {
                    if (callback) callback({ success: false, message: 'Invalid response' });
                }
            }
        };
        xhr.send(JSON.stringify({}));
    }

    function doRecharge(url, csrfToken, payload, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                try {
                    var res = JSON.parse(xhr.responseText || '{}');
                    if (callback) callback(res);
                } catch (e) {
                    if (callback) callback({ success: false, message: 'Invalid response' });
                }
            }
        };
        xhr.send(JSON.stringify(payload || {}));
    }

    return {
        getOperators: getOperators,
        doRecharge: doRecharge
    };
})();
