/**
 * Created by liujinsheng on 17/5/3.
 */
'use strict';


function createHttpRequest() {
    if (window.ActiveXObject) {
        return new window.ActiveXObject('Microsoft.XMLHTTP');
    } else if (window.XMLHttpRequest) {
        return new window.XMLHttpRequest();
    }
}


function AliLogTracker(host, project, logstore) {
    this.uri_ = 'http://' + project + '.' + host + '/logstores/' + logstore + '/track?APIVersion=0.6.0';
    this.params_ = new Array();
    this.httpRequest_ = createHttpRequest();
}


AliLogTracker.prototype = {
    push: function(key, value) {
        if (!key || !value) {
            return;
        }
        this.params_.push(key);
        this.params_.push(value);
    },
    logger: function() {
        var url = this.uri_;
        var k = 0;
        while (this.params_.length > 0) {
            if (k % 2 == 0) {
                url += '&' + encodeURIComponent(this.params_.shift());
            } else {
                url += '=' + encodeURIComponent(this.params_.shift());
            }
            ++k;
        }
        try {
            this.httpRequest_.open('GET', url, true);
            this.httpRequest_.send(null);
        } catch (ex) {
            // if (window && window.console && typeof window.console.log === 'function') {
            //     console.log('Failed to log to ali log service because of this exception:\n' + ex);
            //     console.log('Failed log data:', url);
            // }
        }
    },
    init: function() {
        if (typeof window === 'undefined' || window._m_tracker) {
            return;
        }
        window._m_tracker = true;
        var that = this;
        window.onerror = function(errorMessage, scriptURI, lineNumber, columnNumber, errorObj) {
            if (typeof errorMessage == 'object') {
                errorObj = errorMessage;
                errorMessage = errorObj.toString();
            }
            if (errorObj && errorObj.stack) {
                that.push('s', encodeURIComponent(errorObj.stack));
            }
            if (scriptURI) {
                that.push('su', encodeURIComponent(scriptURI));
            } else {
                that.push('su', encodeURIComponent(document.URL));
            }
            that.push('m', encodeURIComponent(errorMessage));
            that.push('ua', navigator.userAgent);
            that.push('os', navigator.platform);
            that.push('ln', lineNumber);
            that.push('cn', columnNumber);
            that.push('w', document.documentElement.clientWidth);
            that.push('h', document.documentElement.clientHeight);
            that.push('c', (navigator.cookieEnabled) ? '1' : '0');
            that.push('l', navigator.langauge);
            that.logger();
        };
    }
};