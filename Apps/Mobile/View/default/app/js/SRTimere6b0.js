/// @MIT-LICENSE | v1.0
/// @AUTHOR: Samlv9
/// @DATE: 2015-08-31
(function main( domain, undefined ) { "use strict";


var SRTimer = function SRTimer( options ) {
    /// <summary>
    /// SRTimer 定义一个高精度的且与动画时间轴同步的计时器类。</summary>


    /// <field type='Object'>
    /// 计时器配置参数；</field>
    this._options = (options || {});


    /// <field type='Number'>
    /// 上次计时器更新的时间戳。</field>
    this._lastUpdated = 0;


    /// <field type='Number'>
    /// 当前计时器更新的时间戳。</field>
    this._currUpdated = 0;


    /// <field type='Number'>
    /// 当前计时器从上次更新后至本次更新所经过的时间。</field>
    this._timeElapsed = 0;


    /// <field type='Number'>
    /// 指示当前计时器总过经过的时间。</field>
    this._timeTotalElapsed = 0;


    /// <field type='Number'>
    /// 指示当前计时器总共的计时器周期。</field>
    this._timeTotalCount = 0;


    /// <field type='Number'>
    /// 以毫秒作为单位，指示计时器更新频率。默认值： 100ms。该值仅 `setTimeout` 使用。
    /// 如果使用了参数 `useRequestAPI` 并且浏览器支持 H5 的 `requestAnimationFrame/cancelAnimationFrame` 
    /// 或者该 API 的供应商版本，则无视 `updateFPS` 值。</field>
    this._updateFPS = Math.min(1000, Math.max(this._options.updateFPS || 100, 16));


    /// <field type='Boolean'>
    /// 指示计时器是否应该启用 H5 的 `requestAnimationFrame/cancelAnimationFrame` API 来更新。</field>
    this._useRequestAPI = (this._options.useRequestAPI === false ? false : true);


    /// <field type='Boolean'>
    /// 指示计时器是否应该在执行 `start` 方法时，调用 `update` 更新一次。</field>
    this._updateOnStart = (this._options.updateOnStart === false ? false : true);

    /// <field type='ObjectRef'>
    /// 对 Date 或者 window.performance 的引用。</field>
    this._timerRef = domain.performance && domain.performance.now ? domain.performance : Date.now ? Date : null;


    /// <field type='Number'>
    /// 引用 `requestAnimationFrame` 或者是 `setTimeout` 的计时句柄。</field>
    this._timerHandler = 0;


    /// <field type='Boolean'>
    /// 指示当前的计时器句柄是否是由 `requestAnimationFrame` API 生成的。</field>
    this._isRequestTimerHandler = false;


    /// <field type='Number'>
    /// 指示当前计时器是否正在运行。</field>
    this._isRunning = false;


    /// <field type='Boolean'>
    /// 指示浏览器是否支持 `requestAnimationFrame/cancelRequestAnimationFrame` API。</field>
    this._isRCAPIAvailable = !!this.getRequestAPI() && !!this.getCancelAPI();


    /// <field type='Function'>
    /// 当计时器启动时，将调用该函数通知其他脚本。</field>
    this._onStartCallBack = this._options.onStartCallBack || null;


    /// <field type='Function'>
    /// 当计时器暂停时，将调用该函数通知其他脚本。</field>
    this._onStopCallBack = this._options.onStopCallBack || null;


    /// <field type='Function'>
    /// 当计时器更新时，将调用该函数通知其他脚本。</field>
    this._onUpdateCallBack = this._options.onUpdateCallBack || null;
}



SRTimer.prototype._onTimerUpdate = function _onTimerUpdate() {
    /// <summary>
    /// 计时器更新事件通知；</summary>
    this._currUpdated = this.getTimeNow();
    this._timeElapsed = this._currUpdated - this._lastUpdated;
    this._lastUpdated = this._currUpdated;
    this._timeTotalElapsed += this._timeElapsed;
    this._timeTotalCount += 1;
    this.update(this._timeElapsed);


    /// TODU: 如果计时器没有停止，则继续下一次更新。
    if ( this._isRunning ) {
        this._startTimer();
    }
}


SRTimer.prototype.start = function start() {
    /// <summary>
    /// 启动计时器。</summary>
    if ( this._isRunning ) {
        /// TODU: 当前计时器处于正在计时状态，为防止多次引用 `setTimeout` 或者 `requestAnimationFrame` 句柄，
        /// 这里做直接返回处理。
        return this;
    }

    this._isRunning = true;
    

    /// TODU: 调整当前时间；
    this._currUpdated = this.getTimeNow();
    this._lastUpdated = this._currUpdated;

    /// TODU: 启动计时器；
    this._startTimer();


    /// TODU: 执行计时器开始回调函数；
    if ( typeof this._onStartCallBack == "function" ) {
        this._onStartCallBack.apply(this, [this]);
    }

    /// TODU: 在计时器触发 `start` 事件时，更新一个 DOM 对象。否则 DOM 对象需要等待本次计数完成时，
    /// 才会被更新。
    if ( this._updateOnStart ) {
        this.update(0);
    }

    return this;
}


SRTimer.prototype._startTimer = function _startTimer() {
    /// <summary>
    /// 启动计时器。</summary>
    var that = this;

    if ( this._useRequestAPI && this._isRCAPIAvailable ) {
        /// TODU: 使用 `requestAnimationFrame` API 来更新计时器。
        this._isRequestTimerHandler = true;
        this._timerHandler = this.getRequestAPI().call(domain, function() { that._onTimerUpdate(); });
    }

    else {
        this._isRequestTimerHandler = false;
        /// TODU: 更新的 FPS 需要保证在 [16-1000] 的范围内；
        this._timerHandler = domain.setTimeout(function() { that._onTimerUpdate(); }, Math.min(1000, Math.max(16, this._updateFPS)));
    }
}



SRTimer.prototype._stopTimer = function _stopTimer() {
    /// <summary>
    /// 停止计时器。</summary>
    if ( this._isRequestTimerHandler ) {
        /// TODU: 计时器句柄是由 `requestAnimationFrame` 所生成的。
        this.getCancelAPI().call(domain, this._timerHandler);
    }
    else {
        domain.clearTimeout(this._timerHandler);
    }
}


SRTimer.prototype.stop = function stop() {
    /// <summary>
    /// 暂停计时器。</summary>
    if ( !this._isRunning ) {
        /// TODU: 防止多次调用 `stop` 方法；
        return this;
    }

    this._isRunning = false;
    this._stopTimer();

    /// TODU: 执行暂停回调函数；
    if ( typeof this._onStopCallBack == "function" ) {
        this._onStopCallBack.apply(this, [this]);
    }

    return this;
}


SRTimer.prototype.reset = function reset() {
    /// <summary>
    /// 停止计时器并重置计时次数和计时总时间。</summary>
    this._timeTotalCount = 0;
    this._timeTotalElapsed = 0;
    this.stop();

    return this;
}


SRTimer.prototype.update = function update( time ) {
    /// <summary>
    /// 更新并将当前值渲染至 DOM 对象中。</summary>
    /// <param name='time' type='Number'>
    /// 必须，提供从上次计时开始后所经过的时间。</param>

    if ( time >= 0 && typeof this._onUpdateCallBack == "function" ) {
        this._onUpdateCallBack.apply(this, [this, time]);
    }

    return this;
}


SRTimer.prototype.getTimeElapsed = function getTimeElapsed() {
    /// <summary>
    /// 获取上次更新所花费的时间。</summary>
    return this._timeElapsed;
}


SRTimer.prototype.getLastUpdated = function getLastUpdated() {
    /// <summary>
    /// 获取上次更新时的时间戳。</summary>
    return this._lastUpdated;
}


SRTimer.prototype.getTotalElapsed = function getTotalElapsed() {
    /// <summary>
    /// 获取从计时器初始化以来所经过的计时时间。</summary>
    return this._timeTotalElapsed;
}


SRTimer.prototype.getTotalCount = function getTotalCount() {
    /// <summary>
    /// 获取从计时器初始化以来所计数的次数。</summary>
    return this._timeTotalCount;
}


SRTimer.prototype.getTimeNow = function getTimeNow() {
    /// <summary>
    /// 以毫秒作为单位，获取系统当前时间戳。</summary>
    /// <returns type='Number'>
    /// 如果浏览器支持 `performance` API, 返回值为双精度的浮点数。否则返回值为 `Date.now()` 的整数值。</returns>
    return this._timerRef ? this._timerRef.now() : +(new Date);
}


SRTimer.prototype.getRequestAPI = function getRequestAPI() {
    /// <summary>
    /// 获取 H5 的 `requestAnimationFrame` API 或者是该 API 的供应商前缀版本。</summary>
    return domain['requestAnimationFrame']
        || domain['webkitRequestAnimationFrame']
        || domain['mozRequestAnimationFrame']
        || domain['msRequestAnimationFrame']
        || domain['oRequestAnimationFrame'];
}


SRTimer.prototype.getCancelAPI = function getCancelAPI() {
    /// <summary>
    /// 获取 H5 的 `cancelAnimationFrame` API 或者是该 API 的供应商前缀版本。</summary>
    return domain['cancelAnimationFrame']
        || domain['webkitCancelAnimationFrame']
        || domain['mozCancelAnimationFrame']
        || domain['msCancelAnimationFrame']
        || domain['oCancelAnimationFrame']

        || domain['webkitCancelRequestAnimationFrame']
        || domain['mozCancelRequestAnimationFrame']
        || domain['msCancelRequestAnimationFrame']
        || domain['oCancelRequestAnimationFrame'];
}


SRTimer.prototype.isRCAPIAvailable = function isRCAPIAvailable() {
    /// <summary>
    /// 判断浏览器是否支持 `requestAnimationFrame/cancelAnimationFrame` API。</summary>
    return this._isRCAPIAvailable;
}


SRTimer.prototype.isRunning = function isRunning() {
    /// <summary>
    /// 判断当前计时器是否正在运行。</summary>
    return this._isRunning;
}


return domain.SRTimer = SRTimer;
}(this));