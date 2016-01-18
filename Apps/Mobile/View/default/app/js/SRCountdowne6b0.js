/// @MIT-LICENSE | v1.0
/// @AUTHOR: Samlv9
/// @DATE: 2015-08-31
///
/// <reference path='./SRTimer' />
(function main( domain, SRTimer, $, undefined ) { "use strict";


var SECOND = 1000;        // 秒
var MINUTE = SECOND * 60; // 分
var HOUR   = MINUTE * 60; // 时
var DAY    = HOUR   * 24; // 天


var SRCountDown = function SRCountDown( selector, options ) {
    if ( !(typeof SRTimer == "function") ) {
        throw new Error("需要提前加载 SRTimer 类型。");
    }

    if ( !(typeof $ == "function") ) {
        throw new Error("需要 $ 函数支持。");
    }

    this.selector = $(selector);
    this.distances = [];
    this.totalDurations = [];
    this.times = [];
    this.preps = [];
    this.ignores = [];
    this.ispreps = [];
    this._options = (options || {});
    this._setStatus  = (this._options.setStatusFn  || $.proxy(this._setAndUpdateStatus , this));
    this._setContent = (this._options.setContentFn || $.proxy(this._setAndUpdateContent, this));
    this._formatToDay = !!(this._options.formatToDay);
    this._formatString = ("" + (this._options.formatString || '{{H:2}}:{{M:2}}:{{S:2}}'));
    this._formatString = this._formatString.toLowerCase();
    this._formatPattern = (this._options.formatPattern || /\{\{\s*([^\}\s]+)\s*\}\}/g);
    this._onUpdateCallBack = (this._options.onUpdateCallBack || null);
    this._dataCountdown = (this._options.dataCountdown || "countdown");
    this._timeOffset = Math.max(0, (this._options.timeOffset || 0));
    this._timer = new SRTimer(this._options);
    this._timer._onUpdateCallBack = $.proxy(this._onTimerUpdateCallBack, this);
    this.init();
}


SRCountDown.prototype.init = function init() {
    for ( var i = 0; i < this.selector.length; ++i ) {
        var item = this.selector.eq(i);
        var data = item.data(this._dataCountdown);

        /// TODU: 更新 `element` 状态；
        this._setStatus(item, !!data.disabled ? "disabled" : !!data.prepering ? "prepering" : "running" );
        this._setContent(item, !!data.prepering ? this.formatToString(+(data.elapsed || 0)) : this.formatToString(+(data.duration || 0)), 0);
        this.times[i]   = this.totalDurations[i] = +(data.duration || 0);
        this.preps[i]   = +(data.elapsed  || 0);
        this.ignores[i] = !!data.disabled;
        this.ispreps[i] = !!data.prepering;
        this.distances[i] = +(data.distance || 0);
    }

    if ( !this._options.paused ) { 
        /// TODU: 自动启动计时器；
        this._timer.start(); 
    }
}



SRCountDown.prototype.calcPercent = function calcPercent( o, t, d ) {
    return 1 - t / (o + d);
}


SRCountDown.prototype.formatToString = function formatToString( time ) {
    if ( time < 0 ) {
        time = 0;
    }

    var tParam = { f: time - parseInt(time) };
        time = parseInt(time);

    if ( this._formatToDay ) {
        tParam.d = time / DAY | 0; time = time % DAY;
    }

    tParam.h  = time / HOUR   | 0; time = time % HOUR;
    tParam.m  = time / MINUTE | 0; time = time % MINUTE;
    tParam.s  = time / SECOND | 0; time = time % SECOND;
    tParam.ms = time;

    return this.formatTimerParam(tParam);
}


SRCountDown.prototype.formatTimerParam = function formatTimerParam( obj ) {
    return this._formatString.replace(this._formatPattern, function( match, origin ) {
        var components = origin.split(":");
        var keyname = "" + components[0];
        var keepsize = +(components[1] || 0);

        if ( isNaN(keepsize) || keepsize <= 0 ) {
            keepsize = 0;
        }

        if ( !(keyname in obj) ) {
            return match;
        }

        var content = ("" + obj[keyname]);

        for ( var i = 0; content.length < keepsize; ++i ) {
            content = "0" + content;
        }

        return content;
    });
}


SRCountDown.prototype._setAndUpdateContent = function _setAndUpdateContent( item, content, percent ) {
    $(item).trigger({ "type": "contentUpdate.SRCountdown", "content": content, "percent": percent });
}


SRCountDown.prototype._setAndUpdateStatus = function _setAndUpdateStatus( item, status ) {
    $(item).trigger({ "type": "statusUpdate.SRCountdown", "status": status });
}


SRCountDown.prototype._onTimerUpdateCallBack = function _onTimerUpdateCallBack( timer, value ) {
    var count = 0;

    for ( var i = 0; i < this.selector.length; ++i ) {
        var item = this.selector.eq(i);
        var data = item.data(this._dataCountdown);

        if ( !!this.ignores[i] ) {
            /// TODU: 跳过禁用的对象；
            ++count;
            continue;
        }

        /// TODU: 准备中...
        if ( !!data.prepering && !!this.ispreps[i] ) {
            this.preps[i] -= value;
            this._setContent(item, this.formatToString(this.preps[i] + this._timeOffset), 0);

            if ( this.preps[i] <= 0 ) {
                this.ispreps[i] = false;
                this._setStatus (item, "running");
                this._setContent(item, this.formatToString(0), 0);
            }

            continue;
        }

        /// TODU: 计时中...
        this.times[i] -= value;
        this._setContent(item, this.formatToString(this.times[i] + this._timeOffset), this.calcPercent(this.distances[i], this.times[i], this.totalDurations[i]));

        if ( this.times[i] <= 0 ) {
            ++count;
            this.ignores[i] = true;
            this._setStatus (item, "complete");
            this._setContent(item, this.formatToString(0), 1);
        }
    }

    if ( typeof this._onUpdateCallBack == "function" ) {
        this._onUpdateCallBack.apply(this, [this, value]);
    }

    if ( count >= this.selector.length ) {
        this._timer.stop();
    }
}


$.fn.SRCountDown = function _SRCountDown( options ) {
    this.data("InstanceOfSRCountDown", new SRCountDown(this, options));
    return this;
}


return domain.SRCountDown = SRCountDown;
}(this, this.SRTimer, this.$));