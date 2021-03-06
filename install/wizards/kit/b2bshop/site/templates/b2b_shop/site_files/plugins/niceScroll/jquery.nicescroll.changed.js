! function(e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function(e) {
    "use strict";
    var o = !1,
        t = !1,
        r = 0,
        i = 2e3,
        s = 0,
        n = e,
        l = document,
        a = window,
        c = n(a),
        d = [],
        u = a.requestAnimationFrame || a.webkitRequestAnimationFrame || a.mozRequestAnimationFrame || !1,
        h = a.cancelAnimationFrame || a.webkitCancelAnimationFrame || a.mozCancelAnimationFrame || !1;
    if (u) a.cancelAnimationFrame || (h = function(e) {});
    else {
        var p = 0;
        u = function(e, o) {
            var t = (new Date).getTime(),
                r = Math.max(0, 16 - (t - p)),
                i = a.setTimeout(function() {
                    e(t + r)
                }, r);
            return p = t + r, i
        }, h = function(e) {
            a.clearTimeout(e)
        }
    }
    var m = a.MutationObserver || a.WebKitMutationObserver || !1,
        f = Date.now || function() {
            return (new Date).getTime()
        },
        g = {
            zindex: "auto",
            cursoropacitymin: 0,
            cursoropacitymax: 1,
            cursorcolor: "#424242",
            cursorwidth: "6px",
            cursorborder: "1px solid #fff",
            cursorborderradius: "5px",
            scrollspeed: 40,
            mousescrollstep: 27,
            touchbehavior: !1,
            emulatetouch: !1,
            hwacceleration: !0,
            usetransition: !0,
            boxzoom: !1,
            dblclickzoom: !0,
            gesturezoom: !0,
            grabcursorenabled: !0,
            autohidemode: !0,
            background: "",
            iframeautoresize: !0,
            cursorminheight: 32,
            preservenativescrolling: !0,
            railoffset: !1,
            railhoffset: !1,
            bouncescroll: !0,
            spacebarenabled: !0,
            railpadding: {
                top: 0,
                right: 0,
                left: 0,
                bottom: 0
            },
            disableoutline: !0,
            horizrailenabled: !0,
            railalign: "right",
            railvalign: "bottom",
            enabletranslate3d: !0,
            enablemousewheel: !0,
            enablekeyboard: !0,
            smoothscroll: !0,
            sensitiverail: !0,
            enablemouselockapi: !0,
            cursorfixedheight: !1,
            directionlockdeadzone: 6,
            hidecursordelay: 400,
            nativeparentscrolling: !0,
            enablescrollonselection: !0,
            overflowx: !0,
            overflowy: !0,
            cursordragspeed: .3,
            rtlmode: "auto",
            cursordragontouch: !1,
            oneaxismousemode: "auto",
            scriptpath: function() {
                var e = l.currentScript || function() {
                        var e = l.getElementsByTagName("script");
                        return !!e.length && e[e.length - 1]
                    }(),
                    o = e ? e.src.split("?")[0] : "";
                return o.split("/").length > 0 ? o.split("/").slice(0, -1).join("/") + "/" : ""
            }(),
            preventmultitouchscrolling: !0,
            disablemutationobserver: !1,
            enableobserver: !0,
            scrollbarid: !1
        },
        v = !1,
        w = function() {
            if (v) return v;
            var e = l.createElement("DIV"),
                o = e.style,
                t = navigator.userAgent,
                r = navigator.platform,
                i = {};
            return i.haspointerlock = "pointerLockElement" in l || "webkitPointerLockElement" in l || "mozPointerLockElement" in l, i.isopera = "opera" in a, i.isopera12 = i.isopera && "getUserMedia" in navigator, i.isoperamini = "[object OperaMini]" === Object.prototype.toString.call(a.operamini), i.isie = "all" in l && "attachEvent" in e && !i.isopera, i.isieold = i.isie && !("msInterpolationMode" in o), i.isie7 = i.isie && !i.isieold && (!("documentMode" in l) || 7 === l.documentMode), i.isie8 = i.isie && "documentMode" in l && 8 === l.documentMode, i.isie9 = i.isie && "performance" in a && 9 === l.documentMode, i.isie10 = i.isie && "performance" in a && 10 === l.documentMode, i.isie11 = "msRequestFullscreen" in e && l.documentMode >= 11, i.ismsedge = "msCredentials" in a, i.ismozilla = "MozAppearance" in o, i.iswebkit = !i.ismsedge && "WebkitAppearance" in o, i.ischrome = i.iswebkit && "chrome" in a, i.ischrome38 = i.ischrome && "touchAction" in o, i.ischrome22 = !i.ischrome38 && i.ischrome && i.haspointerlock, i.ischrome26 = !i.ischrome38 && i.ischrome && "transition" in o, i.cantouch = "ontouchstart" in l.documentElement || "ontouchstart" in a, i.hasw3ctouch = (a.PointerEvent || !1) && (navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0), i.hasmstouch = !i.hasw3ctouch && (a.MSPointerEvent || !1), i.ismac = /^mac$/i.test(r), i.isios = i.cantouch && /iphone|ipad|ipod/i.test(r), i.isios4 = i.isios && !("seal" in Object), i.isios7 = i.isios && "webkitHidden" in l, i.isios8 = i.isios && "hidden" in l, i.isios10 = i.isios && a.Proxy, i.isandroid = /android/i.test(t), i.haseventlistener = "addEventListener" in e, i.trstyle = !1, i.hastransform = !1, i.hastranslate3d = !1, i.transitionstyle = !1, i.hastransition = !1, i.transitionend = !1, i.trstyle = "transform", i.hastransform = "transform" in o || function() {
                for (var e = ["msTransform", "webkitTransform", "MozTransform", "OTransform"], t = 0, r = e.length; t < r; t++)
                    if (void 0 !== o[e[t]]) {
                        i.trstyle = e[t];
                        break
                    }
                i.hastransform = !!i.trstyle
            }(), i.hastransform && (o[i.trstyle] = "translate3d(1px,2px,3px)", i.hastranslate3d = /translate3d/.test(o[i.trstyle])), i.transitionstyle = "transition", i.prefixstyle = "", i.transitionend = "transitionend", i.hastransition = "transition" in o || function() {
                i.transitionend = !1;
                for (var e = ["webkitTransition", "msTransition", "MozTransition", "OTransition", "OTransition", "KhtmlTransition"], t = ["-webkit-", "-ms-", "-moz-", "-o-", "-o", "-khtml-"], r = ["webkitTransitionEnd", "msTransitionEnd", "transitionend", "otransitionend", "oTransitionEnd", "KhtmlTransitionEnd"], s = 0, n = e.length; s < n; s++)
                    if (e[s] in o) {
                        i.transitionstyle = e[s], i.prefixstyle = t[s], i.transitionend = r[s];
                        break
                    }
                i.ischrome26 && (i.prefixstyle = t[1]), i.hastransition = i.transitionstyle
            }(), i.cursorgrabvalue = function() {
                var e = ["grab", "-webkit-grab", "-moz-grab"];
                (i.ischrome && !i.ischrome38 || i.isie) && (e = []);
                for (var t = 0, r = e.length; t < r; t++) {
                    var s = e[t];
                    if (o.cursor = s, o.cursor == s) return s
                }
                return "url(https://cdnjs.cloudflare.com/ajax/libs/slider-pro/1.3.0/css/images/openhand.cur),n-resize"
            }(), i.hasmousecapture = "setCapture" in e, i.hasMutationObserver = !1 !== m, e = null, v = i, i
        },
        b = function(e, p) {
            function v() {
                var e = k.doc.css(P.trstyle);
                return !(!e || "matrix" != e.substr(0, 6)) && e.replace(/^.*\((.*)\)$/g, "$1").replace(/px/g, "").split(/, +/)
            }

            function b() {
                var e = k.win;
                if ("zIndex" in e) return e.zIndex();
                for (; e.length > 0;) {
                    if (9 == e[0].nodeType) return !1;
                    var o = e.css("zIndex");
                    if (!isNaN(o) && 0 !== o) return parseInt(o);
                    e = e.parent()
                }
                return !1
            }

            function x(e, o, t) {
                var r = e.css(o),
                    i = parseFloat(r);
                if (isNaN(i)) {
                    var s = 3 == (i = I[r] || 0) ? t ? k.win.outerHeight() - k.win.innerHeight() : k.win.outerWidth() - k.win.innerWidth() : 1;
                    return k.isie8 && i && (i += 1), s ? i : 0
                }
                return i
            }

            function S(e, o, t, r) {
                k._bind(e, o, function(r) {
                    var i = {
                        original: r = r || a.event,
                        target: r.target || r.srcElement,
                        type: "wheel",
                        deltaMode: "MozMousePixelScroll" == r.type ? 0 : 1,
                        deltaX: 0,
                        deltaZ: 0,
                        preventDefault: function() {
                            return r.preventDefault ? r.preventDefault() : r.returnValue = !1, !1
                        },
                        stopImmediatePropagation: function() {
                            r.stopImmediatePropagation ? r.stopImmediatePropagation() : r.cancelBubble = !0
                        }
                    };
                    return "mousewheel" == o ? (r.wheelDeltaX && (i.deltaX = -.025 * r.wheelDeltaX), r.wheelDeltaY && (i.deltaY = -.025 * r.wheelDeltaY), !i.deltaY && !i.deltaX && (i.deltaY = -.025 * r.wheelDelta)) : i.deltaY = r.detail, t.call(e, i)
                }, r)
            }

            function z(e, o, t, r) {
                k.scrollrunning || (k.newscrolly = k.getScrollTop(), k.newscrollx = k.getScrollLeft(), D = f());
                var i = f() - D;
                if (D = f(), i > 350 ? A = 1 : A += (2 - A) / 10, e = e * A | 0, o = o * A | 0, e) {
                    if (r)
                        if (e < 0) {
                            if (k.getScrollLeft() >= k.page.maxw) return !0
                        } else if (k.getScrollLeft() <= 0) return !0;
                    var s = e > 0 ? 1 : -1;
                    X !== s && (k.scrollmom && k.scrollmom.stop(), k.newscrollx = k.getScrollLeft(), X = s), k.lastdeltax -= e
                }
                if (o) {
                    if (function() {
                            var e = k.getScrollTop();
                            if (o < 0) {
                                if (e >= k.page.maxh) return !0
                            } else if (e <= 0) return !0
                        }()) {
                        if (M.nativeparentscrolling && t && !k.ispage && !k.zoomactive) return !0;
                        var n = k.view.h >> 1;
                        k.newscrolly < -n ? (k.newscrolly = -n, o = -1) : k.newscrolly > k.page.maxh + n ? (k.newscrolly = k.page.maxh + n, o = 1) : o = 0
                    }
                    var l = o > 0 ? 1 : -1;
                    B !== l && (k.scrollmom && k.scrollmom.stop(), k.newscrolly = k.getScrollTop(), B = l), k.lastdeltay -= o
                }(o || e) && k.synched("relativexy", function() {
                    var e = k.lastdeltay + k.newscrolly;
                    k.lastdeltay = 0;
                    var o = k.lastdeltax + k.newscrollx;
                    k.lastdeltax = 0, k.rail.drag || k.doScrollPos(o, e)
                })
            }

            function T(e, o, t) {
                var r, i;
                return !(t || !q) || (0 === e.deltaMode ? (r = -e.deltaX * (M.mousescrollstep / 54) | 0, i = -e.deltaY * (M.mousescrollstep / 54) | 0) : 1 === e.deltaMode && (r = -e.deltaX * M.mousescrollstep * 50 / 80 | 0, i = -e.deltaY * M.mousescrollstep * 50 / 80 | 0), o && M.oneaxismousemode && 0 === r && i && (r = i, i = 0, t && (r < 0 ? k.getScrollLeft() >= k.page.maxw : k.getScrollLeft() <= 0) && (i = r, r = 0)), k.isrtlmode && (r = -r), z(r, i, t, !0) ? void(t && (q = !0)) : (q = !1, e.stopImmediatePropagation(), e.preventDefault()))
            }
            var k = this;
            this.version = "3.7.6", this.name = "nicescroll", this.me = p;
            var E = n("body"),
                M = this.opt = {
                    doc: E,
                    win: !1
                };
            if (n.extend(M, g), M.snapbackspeed = 80, e)
                for (var L in M) void 0 !== e[L] && (M[L] = e[L]);
            if (M.disablemutationobserver && (m = !1), this.doc = M.doc, this.iddoc = this.doc && this.doc[0] ? this.doc[0].id || "" : "", this.ispage = /^BODY|HTML/.test(M.win ? M.win[0].nodeName : this.doc[0].nodeName), this.haswrapper = !1 !== M.win, this.win = M.win || (this.ispage ? c : this.doc), this.docscroll = this.ispage && !this.haswrapper ? c : this.win, this.body = E, this.viewport = !1, this.isfixed = !1, this.iframe = !1, this.isiframe = "IFRAME" == this.doc[0].nodeName && "IFRAME" == this.win[0].nodeName, this.istextarea = "TEXTAREA" == this.win[0].nodeName, this.forcescreen = !1, this.canshowonmouseevent = "scroll" != M.autohidemode, this.onmousedown = !1, this.onmouseup = !1, this.onmousemove = !1, this.onmousewheel = !1, this.onkeypress = !1, this.ongesturezoom = !1, this.onclick = !1, this.onscrollstart = !1, this.onscrollend = !1, this.onscrollcancel = !1, this.onzoomin = !1, this.onzoomout = !1, this.view = !1, this.page = !1, this.scroll = {
                    x: 0,
                    y: 0
                }, this.scrollratio = {
                    x: 0,
                    y: 0
                }, this.cursorheight = 20, this.scrollvaluemax = 0, "auto" == M.rtlmode) {
                var C = this.win[0] == a ? this.body : this.win,
                    N = C.css("writing-mode") || C.css("-webkit-writing-mode") || C.css("-ms-writing-mode") || C.css("-moz-writing-mode");
                "horizontal-tb" == N || "lr-tb" == N || "" === N ? (this.isrtlmode = "rtl" == C.css("direction"), this.isvertical = !1) : (this.isrtlmode = "vertical-rl" == N || "tb" == N || "tb-rl" == N || "rl-tb" == N, this.isvertical = "vertical-rl" == N || "tb" == N || "tb-rl" == N)
            } else this.isrtlmode = !0 === M.rtlmode, this.isvertical = !1;
            if (this.scrollrunning = !1, this.scrollmom = !1, this.observer = !1, this.observerremover = !1, this.observerbody = !1, !1 !== M.scrollbarid) this.id = M.scrollbarid;
            else
                do {
                    this.id = "ascrail" + i++
                } while (l.getElementById(this.id));
            this.rail = !1, this.cursor = !1, this.cursorfreezed = !1, this.selectiondrag = !1, this.zoom = !1, this.zoomactive = !1, this.hasfocus = !1, this.hasmousefocus = !1, this.railslocked = !1, this.locked = !1, this.hidden = !1, this.cursoractive = !0, this.wheelprevented = !1, this.overflowx = M.overflowx, this.overflowy = M.overflowy, this.nativescrollingarea = !1, this.checkarea = 0, this.events = [], this.saved = {}, this.delaylist = {}, this.synclist = {}, this.lastdeltax = 0, this.lastdeltay = 0, this.detected = w();
            var P = n.extend({}, this.detected);
            this.canhwscroll = P.hastransform && M.hwacceleration, this.ishwscroll = this.canhwscroll && k.haswrapper, this.isrtlmode ? this.isvertical ? this.hasreversehr = !(P.iswebkit || P.isie || P.isie11) : this.hasreversehr = !(P.iswebkit || P.isie && !P.isie10 && !P.isie11) : this.hasreversehr = !1, this.istouchcapable = !1, P.cantouch || !P.hasw3ctouch && !P.hasmstouch ? !P.cantouch || P.isios || P.isandroid || !P.iswebkit && !P.ismozilla || (this.istouchcapable = !0) : this.istouchcapable = !0, M.enablemouselockapi || (P.hasmousecapture = !1, P.haspointerlock = !1), this.debounced = function(e, o, t) {
                k && (k.delaylist[e] || !1 || (k.delaylist[e] = {
                    h: u(function() {
                        k.delaylist[e].fn.call(k), k.delaylist[e] = !1
                    }, t)
                }, o.call(k)), k.delaylist[e].fn = o)
            }, this.synched = function(e, o) {
                k.synclist[e] ? k.synclist[e] = o : (k.synclist[e] = o, u(function() {
                    k && (k.synclist[e] && k.synclist[e].call(k), k.synclist[e] = null)
                }))
            }, this.unsynched = function(e) {
                k.synclist[e] && (k.synclist[e] = !1)
            }, this.css = function(e, o) {
                for (var t in o) k.saved.css.push([e, t, e.css(t)]), e.css(t, o[t])
            }, this.scrollTop = function(e) {
                return void 0 === e ? k.getScrollTop() : k.setScrollTop(e)
            }, this.scrollLeft = function(e) {
                return void 0 === e ? k.getScrollLeft() : k.setScrollLeft(e)
            };
            var R = function(e, o, t, r, i, s, n) {
                this.st = e, this.ed = o, this.spd = t, this.p1 = r || 0, this.p2 = i || 1, this.p3 = s || 0, this.p4 = n || 1, this.ts = f(), this.df = o - e
            };
            if (R.prototype = {
                    B2: function(e) {
                        return 3 * (1 - e) * (1 - e) * e
                    },
                    B3: function(e) {
                        return 3 * (1 - e) * e * e
                    },
                    B4: function(e) {
                        return e * e * e
                    },
                    getPos: function() {
                        return (f() - this.ts) / this.spd
                    },
                    getNow: function() {
                        var e = (f() - this.ts) / this.spd,
                            o = this.B2(e) + this.B3(e) + this.B4(e);
                        return e >= 1 ? this.ed : this.st + this.df * o | 0
                    },
                    update: function(e, o) {
                        return this.st = this.getNow(), this.ed = e, this.spd = o, this.ts = f(), this.df = this.ed - this.st, this
                    }
                }, this.ishwscroll) {
                this.doc.translate = {
                    x: 0,
                    y: 0,
                    tx: "0px",
                    ty: "0px"
                }, P.hastranslate3d && P.isios && this.doc.css("-webkit-backface-visibility", "hidden"), this.getScrollTop = function(e) {
                    if (!e) {
                        var o = v();
                        if (o) return 16 == o.length ? -o[13] : -o[5];
                        if (k.timerscroll && k.timerscroll.bz) return k.timerscroll.bz.getNow()
                    }
                    return k.doc.translate.y
                }, this.getScrollLeft = function(e) {
                    if (!e) {
                        var o = v();
                        if (o) return 16 == o.length ? -o[12] : -o[4];
                        if (k.timerscroll && k.timerscroll.bh) return k.timerscroll.bh.getNow()
                    }
                    return k.doc.translate.x
                }, this.notifyScrollEvent = function(e) {
                    var o = l.createEvent("UIEvents");
                    o.initUIEvent("scroll", !1, !1, a, 1), o.niceevent = !0, e.dispatchEvent(o)
                };
                var _ = this.isrtlmode ? 1 : -1;
                P.hastranslate3d && M.enabletranslate3d ? (this.setScrollTop = function(e, o) {
                    k.doc.translate.y = e, k.doc.translate.ty = -1 * e + "px", k.doc.css(P.trstyle, "translate3d(" + k.doc.translate.tx + "," + k.doc.translate.ty + ",0)"), o || k.notifyScrollEvent(k.win[0])
                }, this.setScrollLeft = function(e, o) {
                    k.doc.translate.x = e, k.doc.translate.tx = e * _ + "px", k.doc.css(P.trstyle, "translate3d(" + k.doc.translate.tx + "," + k.doc.translate.ty + ",0)"), o || k.notifyScrollEvent(k.win[0])
                }) : (this.setScrollTop = function(e, o) {
                    k.doc.translate.y = e, k.doc.translate.ty = -1 * e + "px", k.doc.css(P.trstyle, "translate(" + k.doc.translate.tx + "," + k.doc.translate.ty + ")"), o || k.notifyScrollEvent(k.win[0])
                }, this.setScrollLeft = function(e, o) {
                    k.doc.translate.x = e, k.doc.translate.tx = e * _ + "px", k.doc.css(P.trstyle, "translate(" + k.doc.translate.tx + "," + k.doc.translate.ty + ")"), o || k.notifyScrollEvent(k.win[0])
                })
            } else this.getScrollTop = function() {
                return k.docscroll.scrollTop()
            }, this.setScrollTop = function(e) {
                k.docscroll.scrollTop(e)
            }, this.getScrollLeft = function() {
                return k.hasreversehr ? k.detected.ismozilla ? k.page.maxw - Math.abs(k.docscroll.scrollLeft()) : k.page.maxw - k.docscroll.scrollLeft() : k.docscroll.scrollLeft()
            }, this.setScrollLeft = function(e) {
                return setTimeout(function() {
                    if (k) return k.hasreversehr && (e = k.detected.ismozilla ? -(k.page.maxw - e) : k.page.maxw - e), k.docscroll.scrollLeft(e)
                }, 1)
            };
            this.getTarget = function(e) {
                return !!e && (e.target ? e.target : !!e.srcElement && e.srcElement)
            }, this.hasParent = function(e, o) {
                if (!e) return !1;
                for (var t = e.target || e.srcElement || e || !1; t && t.id != o;) t = t.parentNode || !1;
                return !1 !== t
            };
            var I = {
                thin: 1,
                medium: 3,
                thick: 5
            };
            this.getDocumentScrollOffset = function() {
                return {
                    top: a.pageYOffset || l.documentElement.scrollTop,
                    left: a.pageXOffset || l.documentElement.scrollLeft
                }
            }, this.getOffset = function() {
                if (k.isfixed) {
                    var e = k.win.offset(),
                        o = k.getDocumentScrollOffset();
                    return e.top -= o.top, e.left -= o.left, e
                }
                var t = k.win.offset();
                if (!k.viewport) return t;
                var r = k.viewport.offset();
                return {
                    top: t.top - r.top,
                    left: t.left - r.left
                }
            }, this.updateScrollBar = function(e) {
                var o, t;
                if (k.ishwscroll) k.rail.css({
                    height: k.win.innerHeight() - (M.railpadding.top + M.railpadding.bottom)
                }), k.railh && k.railh.css({
                    width: k.win.innerWidth() - (M.railpadding.left + M.railpadding.right)
                });
                else {
                    var r = k.getOffset();
                    if (o = {
                            top: r.top,
                            left: r.left - (M.railpadding.left + M.railpadding.right)
                        }, o.top += x(k.win, "border-top-width", !0), o.left += k.rail.align ? k.win.outerWidth() - x(k.win, "border-right-width") - k.rail.width : x(k.win, "border-left-width"), (t = M.railoffset) && (t.top && (o.top += t.top), t.left && (o.left += t.left)), k.railslocked || k.rail.css({
                            height: (e ? e.h : k.win.innerHeight()) - (M.railpadding.top + M.railpadding.bottom)
                        }), k.zoom && k.zoom.css({
                            top: o.top + 1,
                            left: 1 == k.rail.align ? o.left - 20 : o.left + k.rail.width + 4
                        }), k.railh && !k.railslocked) {
                        o = {
                            top: r.top,
                            left: r.left
                        }, (t = M.railhoffset) && (t.top && (o.top += t.top), t.left && (o.left += t.left));
                        k.railh.align ? (o.top, x(k.win, "border-top-width", !0), k.win.innerHeight(), k.railh.height) : (o.top, x(k.win, "border-top-width", !0)), o.left, x(k.win, "border-left-width");
                        k.railh.css({
                            width: k.railh.width
                        })
                    }
                }
            }, this.doRailClick = function(e, o, t) {
                var r, i, s, n;
                k.railslocked || (k.cancelEvent(e), "pageY" in e || (e.pageX = e.clientX + l.documentElement.scrollLeft, e.pageY = e.clientY + l.documentElement.scrollTop), o ? (r = t ? k.doScrollLeft : k.doScrollTop, s = t ? (e.pageX - k.railh.offset().left - k.cursorwidth / 2) * k.scrollratio.x : (e.pageY - k.rail.offset().top - k.cursorheight / 2) * k.scrollratio.y, k.unsynched("relativexy"), r(0 | s)) : (r = t ? k.doScrollLeftBy : k.doScrollBy, s = t ? k.scroll.x : k.scroll.y, n = t ? e.pageX - k.railh.offset().left : e.pageY - k.rail.offset().top, i = t ? k.view.w : k.view.h, r(s >= n ? i : -i)))
            }, k.newscrolly = k.newscrollx = 0, k.hasanimationframe = "requestAnimationFrame" in a, k.hascancelanimationframe = "cancelAnimationFrame" in a, k.hasborderbox = !1, this.init = function() {
                if (k.saved.css = [], P.isoperamini) return !0;
                if (P.isandroid && !("hidden" in l)) return !0;
                M.emulatetouch = M.emulatetouch || M.touchbehavior, k.hasborderbox = a.getComputedStyle && "border-box" === a.getComputedStyle(l.body)["box-sizing"];
                var e = {
                    "overflow-y": "hidden"
                };
                if ((P.isie11 || P.isie10) && (e["-ms-overflow-style"] = "none"), k.ishwscroll && (this.doc.css(P.transitionstyle, P.prefixstyle + "transform 0ms ease-out"), P.transitionend && k.bind(k.doc, P.transitionend, k.onScrollTransitionEnd, !1)), k.zindex = "auto", k.ispage || "auto" != M.zindex ? k.zindex = M.zindex : k.zindex = b() || "auto", !k.ispage && "auto" != k.zindex && k.zindex > s && (s = k.zindex), k.isie && 0 === k.zindex && "auto" == M.zindex && (k.zindex = "auto"), !k.ispage || !P.isieold) {
                    var i = k.docscroll;
                    k.ispage && (i = k.haswrapper ? k.win : k.doc), k.css(i, e), k.ispage && (P.isie11 || P.isie) && k.css(n("html"), e), !P.isios || k.ispage || k.haswrapper || k.css(E, {
                        "-webkit-overflow-scrolling": "touch"
                    });
                    var d = n(l.createElement("div"));
                    d.css({
                        position: "relative",
                        top: 0,
                        width: M.cursorwidth,
                        height: 0,
                        "background-clip": "padding-box"
                    }), d.addClass("nicescroll-cursors"), k.cursor = d;
                    var u = n(l.createElement("div"));
                    u.attr("id", k.id), u.addClass("nicescroll-rails nicescroll-rails-vr");
                    var h, p, f = ["left", "right", "top", "bottom"];
                    for (var g in f) p = f[g], (h = M.railpadding[p] || 0) && u.css("padding-" + p, h + "px");
                    u.append(d), u.css({
                        zIndex: k.zindex,
                        cursor: "default"
                    }), u.visibility = !0, u.scrollable = !0, u.align = "left" == M.railalign ? 0 : 1, k.rail = u, k.rail.drag = !1;
                    var v = !1;
                    !M.boxzoom || k.ispage || P.isieold || (v = l.createElement("div"), k.bind(v, "click", k.doZoom), k.bind(v, "mouseenter", function() {
                        k.zoom.css("opacity", M.cursoropacitymax)
                    }), k.bind(v, "mouseleave", function() {
                        k.zoom.css("opacity", M.cursoropacitymin)
                    }), k.zoom = n(v), k.zoom.css({
                        cursor: "pointer",
                        zIndex: k.zindex,
                        backgroundImage: "url(" + M.scriptpath + "zoomico.png)",
                        height: 18,
                        width: 18,
                        backgroundPosition: "0 0"
                    }), M.dblclickzoom && k.bind(k.win, "dblclick", k.doZoom), P.cantouch && M.gesturezoom && (k.ongesturezoom = function(e) {
                        return e.scale > 1.5 && k.doZoomIn(e), e.scale < .8 && k.doZoomOut(e), k.cancelEvent(e)
                    }, k.bind(k.win, "gestureend", k.ongesturezoom))), k.railh = !1;
                    var w;
                    if (M.horizrailenabled && (k.css(i, {
                            overflowX: "hidden"
                        }), (d = n(l.createElement("div"))).css({
                            position: "absolute",
                            top: 0,
                            height: M.cursorwidth
                        }), P.isieold && d.css("overflow", "hidden"), d.addClass("nicescroll-cursors"), k.cursorh = d, (w = n(l.createElement("div"))).attr("id", k.id + "-hr"), w.addClass("nicescroll-rails nicescroll-rails-hr"), w.height = Math.max(parseFloat(M.cursorwidth), d.outerHeight()), w.css({
                            height: w.height + "px",
                            zIndex: k.zindex
                        }), w.append(d), w.visibility = !0, w.scrollable = !0, w.align = "top" == M.railvalign ? 0 : 1, k.railh = w, k.railh.drag = !1), k.ispage) u.css({
                        position: "fixed",
                        top: 0,
                        height: "100%"
                    }), u.css(u.align ? {
                        right: 0
                    } : {
                        left: 0
                    }), k.body.append(u), k.railh && (w.css({
                        position: "fixed",
                        left: 0,
                        width: "100%"
                    }), w.css(w.align ? {
                        bottom: 0
                    } : {
                        top: 0
                    }), k.win.parent().append(w));
                    else {
                        if (k.ishwscroll) {
                            "static" == k.win.css("position") && k.css(k.win, {
                                position: "relative"
                            });
                            var x = "HTML" == k.win[0].nodeName ? k.body : k.win;
                            n(x).scrollTop(0).scrollLeft(0), k.zoom && (k.zoom.css({
                                position: "absolute",
                                top: 1,
                                right: 0,
                                "margin-right": u.width + 4
                            }), x.append(k.zoom)), u.css({
                                position: "absolute",
                                top: 0
                            }), u.css(u.align ? {
                                right: 0
                            } : {
                                left: 0
                            }), x.append(u), w && (w.css({
                                position: "absolute",
                                left: 0,
                                bottom: 0
                            }), w.css(w.align ? {
                                bottom: 0
                            } : {
                                top: 0
                            }), x.append(w))
                        } else {
                            k.isfixed = "fixed" == k.win.css("position");
                            var S = k.isfixed ? "fixed" : "absolute";
                            k.isfixed || (k.viewport = k.getViewport(k.win[0])), k.viewport && (k.body = k.viewport, /fixed|absolute/.test(k.viewport.css("position")) || k.css(k.viewport, {
                                position: "relative"
                            })), u.css({
                                position: S
                            }), k.zoom && k.zoom.css({
                                position: S
                            }), k.updateScrollBar(), k.win.parent().append(u), k.zoom && k.body.append(k.zoom), k.railh && (w.css({}), k.win.parent().append(w))
                        }
                        P.isios && k.css(k.win, {
                            "-webkit-tap-highlight-color": "rgba(0,0,0,0)",
                            "-webkit-touch-callout": "none"
                        }), M.disableoutline && (P.isie && k.win.attr("hideFocus", "true"), P.iswebkit && k.win.css("outline", "none"))
                    }
                    if (!1 === M.autohidemode ? (k.autohidedom = !1, k.rail.css({
                            opacity: M.cursoropacitymax
                        }), k.railh && k.railh.css({
                            opacity: M.cursoropacitymax
                        })) : !0 === M.autohidemode || "leave" === M.autohidemode ? (k.autohidedom = n().add(k.rail), P.isie8 && (k.autohidedom = k.autohidedom.add(k.cursor)), k.railh && (k.autohidedom = k.autohidedom.add(k.railh)), k.railh && P.isie8 && (k.autohidedom = k.autohidedom.add(k.cursorh))) : "scroll" == M.autohidemode ? (k.autohidedom = n().add(k.rail), k.railh && (k.autohidedom = k.autohidedom.add(k.railh))) : "cursor" == M.autohidemode ? (k.autohidedom = n().add(k.cursor), k.railh && (k.autohidedom = k.autohidedom.add(k.cursorh))) : "hidden" == M.autohidemode && (k.autohidedom = !1, k.hide(), k.railslocked = !1), P.cantouch || k.istouchcapable || M.emulatetouch || P.hasmstouch) {
                        k.scrollmom = new y(k);
                        k.ontouchstart = function(e) {
                            if (k.locked) return !1;
                            if (e.pointerType && ("mouse" === e.pointerType || e.pointerType === e.MSPOINTER_TYPE_MOUSE)) return !1;
                            if (k.hasmoving = !1, k.scrollmom.timer && (k.triggerScrollEnd(), k.scrollmom.stop()), !k.railslocked) {
                                var o = k.getTarget(e);
                                if (o && /INPUT/i.test(o.nodeName) && /range/i.test(o.type)) return k.stopPropagation(e);
                                var t = "mousedown" === e.type;
                                if (!("clientX" in e) && "changedTouches" in e && (e.clientX = e.changedTouches[0].clientX, e.clientY = e.changedTouches[0].clientY), k.forcescreen) {
                                    var r = e;
                                    (e = {
                                        original: e.original ? e.original : e
                                    }).clientX = r.screenX, e.clientY = r.screenY
                                }
                                if (k.rail.drag = {
                                        x: e.clientX,
                                        y: e.clientY,
                                        sx: k.scroll.x,
                                        sy: k.scroll.y,
                                        st: k.getScrollTop(),
                                        sl: k.getScrollLeft(),
                                        pt: 2,
                                        dl: !1,
                                        tg: o
                                    }, k.ispage || !M.directionlockdeadzone) k.rail.drag.dl = "f";
                                else {
                                    var i = {
                                            w: c.width(),
                                            h: c.height()
                                        },
                                        s = k.getContentSize(),
                                        l = s.h - i.h,
                                        a = s.w - i.w;
                                    k.rail.scrollable && !k.railh.scrollable ? k.rail.drag.ck = l > 0 && "v" : !k.rail.scrollable && k.railh.scrollable ? k.rail.drag.ck = a > 0 && "h" : k.rail.drag.ck = !1
                                }
                                if (M.emulatetouch && k.isiframe && P.isie) {
                                    var d = k.win.position();
                                    k.rail.drag.x += d.left, k.rail.drag.y += d.top
                                }
                                if (k.hasmoving = !1, k.lastmouseup = !1, k.scrollmom.reset(e.clientX, e.clientY), o && t) {
                                    if (!/INPUT|SELECT|BUTTON|TEXTAREA/i.test(o.nodeName)) return P.hasmousecapture && o.setCapture(), M.emulatetouch ? (o.onclick && !o._onclick && (o._onclick = o.onclick, o.onclick = function(e) {
                                        if (k.hasmoving) return !1;
                                        o._onclick.call(this, e)
                                    }), k.cancelEvent(e)) : k.stopPropagation(e);
                                    /SUBMIT|CANCEL|BUTTON/i.test(n(o).attr("type")) && (k.preventclick = {
                                        tg: o,
                                        click: !1
                                    })
                                }
                            }
                        }, k.ontouchend = function(e) {
                            if (!k.rail.drag) return !0;
                            if (2 == k.rail.drag.pt) {
                                if (e.pointerType && ("mouse" === e.pointerType || e.pointerType === e.MSPOINTER_TYPE_MOUSE)) return !1;
                                k.rail.drag = !1;
                                var o = "mouseup" === e.type;
                                if (k.hasmoving && (k.scrollmom.doMomentum(), k.lastmouseup = !0, k.hideCursor(), P.hasmousecapture && l.releaseCapture(), o)) return k.cancelEvent(e)
                            } else if (1 == k.rail.drag.pt) return k.onmouseup(e)
                        };
                        var z = M.emulatetouch && k.isiframe && !P.hasmousecapture,
                            T = .3 * M.directionlockdeadzone | 0;
                        k.ontouchmove = function(e, o) {
                            if (!k.rail.drag) return !0;
                            if (e.targetTouches && M.preventmultitouchscrolling && e.targetTouches.length > 1) return !0;
                            if (e.pointerType && ("mouse" === e.pointerType || e.pointerType === e.MSPOINTER_TYPE_MOUSE)) return !0;
                            if (2 == k.rail.drag.pt) {
                                "changedTouches" in e && (e.clientX = e.changedTouches[0].clientX, e.clientY = e.changedTouches[0].clientY);
                                var t, r;
                                if (r = t = 0, z && !o) {
                                    var i = k.win.position();
                                    r = -i.left, t = -i.top
                                }
                                var s = e.clientY + t,
                                    n = s - k.rail.drag.y,
                                    a = e.clientX + r,
                                    c = a - k.rail.drag.x,
                                    d = k.rail.drag.st - n;
                                if (k.ishwscroll && M.bouncescroll) d < 0 ? d = Math.round(d / 2) : d > k.page.maxh && (d = k.page.maxh + Math.round((d - k.page.maxh) / 2));
                                else if (d < 0 ? (d = 0, s = 0) : d > k.page.maxh && (d = k.page.maxh, s = 0), 0 === s && !k.hasmoving) return k.ispage || (k.rail.drag = !1), !0;
                                var u = k.getScrollLeft();
                                if (k.railh && k.railh.scrollable && (u = k.isrtlmode ? c - k.rail.drag.sl : k.rail.drag.sl - c, k.ishwscroll && M.bouncescroll ? u < 0 ? u = Math.round(u / 2) : u > k.page.maxw && (u = k.page.maxw + Math.round((u - k.page.maxw) / 2)) : (u < 0 && (u = 0, a = 0), u > k.page.maxw && (u = k.page.maxw, a = 0))), !k.hasmoving) {
                                    if (k.rail.drag.y === e.clientY && k.rail.drag.x === e.clientX) return k.cancelEvent(e);
                                    var h = Math.abs(n),
                                        p = Math.abs(c),
                                        m = M.directionlockdeadzone;
                                    if (k.rail.drag.ck ? "v" == k.rail.drag.ck ? p > m && h <= T ? k.rail.drag = !1 : h > m && (k.rail.drag.dl = "v") : "h" == k.rail.drag.ck && (h > m && p <= T ? k.rail.drag = !1 : p > m && (k.rail.drag.dl = "h")) : h > m && p > m ? k.rail.drag.dl = "f" : h > m ? k.rail.drag.dl = p > T ? "f" : "v" : p > m && (k.rail.drag.dl = h > T ? "f" : "h"), !k.rail.drag.dl) return k.cancelEvent(e);
                                    k.triggerScrollStart(e.clientX, e.clientY, 0, 0, 0), k.hasmoving = !0
                                }
                                return k.preventclick && !k.preventclick.click && (k.preventclick.click = k.preventclick.tg.onclick || !1, k.preventclick.tg.onclick = k.onpreventclick), k.rail.drag.dl && ("v" == k.rail.drag.dl ? u = k.rail.drag.sl : "h" == k.rail.drag.dl && (d = k.rail.drag.st)), k.synched("touchmove", function() {
                                    k.rail.drag && 2 == k.rail.drag.pt && (k.prepareTransition && k.resetTransition(), k.rail.scrollable && k.setScrollTop(d), k.scrollmom.update(a, s), k.railh && k.railh.scrollable ? (k.setScrollLeft(u), k.showCursor(d, u)) : k.showCursor(d), P.isie10 && l.selection.clear())
                                }), k.cancelEvent(e)
                            }
                            return 1 == k.rail.drag.pt ? k.onmousemove(e) : void 0
                        }, k.ontouchstartCursor = function(e, o) {
                            if (!k.rail.drag || 3 == k.rail.drag.pt) {
                                if (k.locked) return k.cancelEvent(e);
                                k.cancelScroll(), k.rail.drag = {
                                    x: e.touches[0].clientX,
                                    y: e.touches[0].clientY,
                                    sx: k.scroll.x,
                                    sy: k.scroll.y,
                                    pt: 3,
                                    hr: !!o
                                };
                                var t = k.getTarget(e);
                                return !k.ispage && P.hasmousecapture && t.setCapture(), k.isiframe && !P.hasmousecapture && (k.saved.csspointerevents = k.doc.css("pointer-events"), k.css(k.doc, {
                                    "pointer-events": "none"
                                })), k.cancelEvent(e)
                            }
                        }, k.ontouchendCursor = function(e) {
                            if (k.rail.drag) {
                                if (P.hasmousecapture && l.releaseCapture(), k.isiframe && !P.hasmousecapture && k.doc.css("pointer-events", k.saved.csspointerevents), 3 != k.rail.drag.pt) return;
                                return k.rail.drag = !1, k.cancelEvent(e)
                            }
                        }, k.ontouchmoveCursor = function(e) {
                            if (k.rail.drag) {
                                if (3 != k.rail.drag.pt) return;
                                if (k.cursorfreezed = !0, k.rail.drag.hr) {
                                    k.scroll.x = k.rail.drag.sx + (e.touches[0].clientX - k.rail.drag.x), k.scroll.x < 0 && (k.scroll.x = 0);
                                    var o = k.scrollvaluemaxw;
                                    k.scroll.x > o && (k.scroll.x = o)
                                } else {
                                    k.scroll.y = k.rail.drag.sy + (e.touches[0].clientY - k.rail.drag.y), k.scroll.y < 0 && (k.scroll.y = 0);
                                    var t = k.scrollvaluemax;
                                    k.scroll.y > t && (k.scroll.y = t)
                                }
                                return k.synched("touchmove", function() {
                                    k.rail.drag && 3 == k.rail.drag.pt && (k.showCursor(), k.rail.drag.hr ? k.doScrollLeft(Math.round(k.scroll.x * k.scrollratio.x), M.cursordragspeed) : k.doScrollTop(Math.round(k.scroll.y * k.scrollratio.y), M.cursordragspeed))
                                }), k.cancelEvent(e)
                            }
                        }
                    }
                    if (k.onmousedown = function(e, o) {
                            if (!k.rail.drag || 1 == k.rail.drag.pt) {
                                if (k.railslocked) return k.cancelEvent(e);
                                k.cancelScroll(), k.rail.drag = {
                                    x: e.clientX,
                                    y: e.clientY,
                                    sx: k.scroll.x,
                                    sy: k.scroll.y,
                                    pt: 1,
                                    hr: o || !1
                                };
                                var t = k.getTarget(e);
                                return P.hasmousecapture && t.setCapture(), k.isiframe && !P.hasmousecapture && (k.saved.csspointerevents = k.doc.css("pointer-events"), k.css(k.doc, {
                                    "pointer-events": "none"
                                })), k.hasmoving = !1, k.cancelEvent(e)
                            }
                        }, k.onmouseup = function(e) {
                            if (k.rail.drag) return 1 != k.rail.drag.pt || (P.hasmousecapture && l.releaseCapture(), k.isiframe && !P.hasmousecapture && k.doc.css("pointer-events", k.saved.csspointerevents), k.rail.drag = !1, k.cursorfreezed = !1, k.hasmoving && k.triggerScrollEnd(), k.cancelEvent(e))
                        }, k.onmousemove = function(e) {
                            if (k.rail.drag) {
                                if (1 !== k.rail.drag.pt) return;
                                if (P.ischrome && 0 === e.which) return k.onmouseup(e);
                                if (k.cursorfreezed = !0, k.hasmoving || k.triggerScrollStart(e.clientX, e.clientY, 0, 0, 0), k.hasmoving = !0, k.rail.drag.hr) {
                                    k.scroll.x = k.rail.drag.sx + (e.clientX - k.rail.drag.x), k.scroll.x < 0 && (k.scroll.x = 0);
                                    var o = k.scrollvaluemaxw;
                                    k.scroll.x > o && (k.scroll.x = o)
                                } else {
                                    k.scroll.y = k.rail.drag.sy + (e.clientY - k.rail.drag.y), k.scroll.y < 0 && (k.scroll.y = 0);
                                    var t = k.scrollvaluemax;
                                    k.scroll.y > t && (k.scroll.y = t)
                                }
                                return k.synched("mousemove", function() {
                                    k.cursorfreezed && (k.showCursor(), k.rail.drag.hr ? k.scrollLeft(Math.round(k.scroll.x * k.scrollratio.x)) : k.scrollTop(Math.round(k.scroll.y * k.scrollratio.y)))
                                }), k.cancelEvent(e)
                            }
                            k.checkarea = 0
                        }, P.cantouch || M.emulatetouch) k.onpreventclick = function(e) {
                        if (k.preventclick) return k.preventclick.tg.onclick = k.preventclick.click, k.preventclick = !1, k.cancelEvent(e)
                    }, k.onclick = !P.isios && function(e) {
                        return !k.lastmouseup || (k.lastmouseup = !1, k.cancelEvent(e))
                    }, M.grabcursorenabled && P.cursorgrabvalue && (k.css(k.ispage ? k.doc : k.win, {
                        cursor: P.cursorgrabvalue
                    }), k.css(k.rail, {
                        cursor: P.cursorgrabvalue
                    }));
                    else {
                        var L = function(e) {
                            if (k.selectiondrag) {
                                if (e) {
                                    var o = k.win.outerHeight(),
                                        t = e.pageY - k.selectiondrag.top;
                                    t > 0 && t < o && (t = 0), t >= o && (t -= o), k.selectiondrag.df = t
                                }
                                if (0 !== k.selectiondrag.df) {
                                    var r = -2 * k.selectiondrag.df / 6 | 0;
                                    k.doScrollBy(r), k.debounced("doselectionscroll", function() {
                                        L()
                                    }, 50)
                                }
                            }
                        };
                        k.hasTextSelected = "getSelection" in l ? function() {
                            return l.getSelection().rangeCount > 0
                        } : "selection" in l ? function() {
                            return "None" != l.selection.type
                        } : function() {
                            return !1
                        }, k.onselectionstart = function(e) {
                            k.ispage || (k.selectiondrag = k.win.offset())
                        }, k.onselectionend = function(e) {
                            k.selectiondrag = !1
                        }, k.onselectiondrag = function(e) {
                            k.selectiondrag && k.hasTextSelected() && k.debounced("selectionscroll", function() {
                                L(e)
                            }, 250)
                        }
                    }
                    if (P.hasw3ctouch ? (k.css(k.ispage ? n("html") : k.win, {
                            "touch-action": "none"
                        }), k.css(k.rail, {
                            "touch-action": "none"
                        }), k.css(k.cursor, {
                            "touch-action": "none"
                        }), k.bind(k.win, "pointerdown", k.ontouchstart), k.bind(l, "pointerup", k.ontouchend), k.delegate(l, "pointermove", k.ontouchmove)) : P.hasmstouch ? (k.css(k.ispage ? n("html") : k.win, {
                            "-ms-touch-action": "none"
                        }), k.css(k.rail, {
                            "-ms-touch-action": "none"
                        }), k.css(k.cursor, {
                            "-ms-touch-action": "none"
                        }), k.bind(k.win, "MSPointerDown", k.ontouchstart), k.bind(l, "MSPointerUp", k.ontouchend), k.delegate(l, "MSPointerMove", k.ontouchmove), k.bind(k.cursor, "MSGestureHold", function(e) {
                            e.preventDefault()
                        }), k.bind(k.cursor, "contextmenu", function(e) {
                            e.preventDefault()
                        })) : P.cantouch && (k.bind(k.win, "touchstart", k.ontouchstart, !1, !0), k.bind(l, "touchend", k.ontouchend, !1, !0), k.bind(l, "touchcancel", k.ontouchend, !1, !0), k.delegate(l, "touchmove", k.ontouchmove, !1, !0)), M.emulatetouch && (k.bind(k.win, "mousedown", k.ontouchstart, !1, !0), k.bind(l, "mouseup", k.ontouchend, !1, !0), k.bind(l, "mousemove", k.ontouchmove, !1, !0)), (M.cursordragontouch || !P.cantouch && !M.emulatetouch) && (k.rail.css({
                            cursor: "default"
                        }), k.railh && k.railh.css({
                            cursor: "default"
                        }), k.jqbind(k.rail, "mouseenter", function() {
                            if (!k.ispage && !k.win.is(":visible")) return !1;
                            k.canshowonmouseevent && k.showCursor(), k.rail.active = !0
                        }), k.jqbind(k.rail, "mouseleave", function() {
                            k.rail.active = !1, k.rail.drag || k.hideCursor()
                        }), M.sensitiverail && (k.bind(k.rail, "click", function(e) {
                            k.doRailClick(e, !1, !1)
                        }), k.bind(k.rail, "dblclick", function(e) {
                            k.doRailClick(e, !0, !1)
                        }), k.bind(k.cursor, "click", function(e) {
                            k.cancelEvent(e)
                        }), k.bind(k.cursor, "dblclick", function(e) {
                            k.cancelEvent(e)
                        })), k.railh && (k.jqbind(k.railh, "mouseenter", function() {
                            if (!k.ispage && !k.win.is(":visible")) return !1;
                            k.canshowonmouseevent && k.showCursor(), k.rail.active = !0
                        }), k.jqbind(k.railh, "mouseleave", function() {
                            k.rail.active = !1, k.rail.drag || k.hideCursor()
                        }), M.sensitiverail && (k.bind(k.railh, "click", function(e) {
                            k.doRailClick(e, !1, !0)
                        }), k.bind(k.railh, "dblclick", function(e) {
                            k.doRailClick(e, !0, !0)
                        }), k.bind(k.cursorh, "click", function(e) {
                            k.cancelEvent(e)
                        }), k.bind(k.cursorh, "dblclick", function(e) {
                            k.cancelEvent(e)
                        })))), M.cursordragontouch && (this.istouchcapable || P.cantouch) && (k.bind(k.cursor, "touchstart", k.ontouchstartCursor), k.bind(k.cursor, "touchmove", k.ontouchmoveCursor), k.bind(k.cursor, "touchend", k.ontouchendCursor), k.cursorh && k.bind(k.cursorh, "touchstart", function(e) {
                            k.ontouchstartCursor(e, !0)
                        }), k.cursorh && k.bind(k.cursorh, "touchmove", k.ontouchmoveCursor), k.cursorh && k.bind(k.cursorh, "touchend", k.ontouchendCursor)), M.emulatetouch || P.isandroid || P.isios ? (k.bind(P.hasmousecapture ? k.win : l, "mouseup", k.ontouchend), k.onclick && k.bind(l, "click", k.onclick), M.cursordragontouch ? (k.bind(k.cursor, "mousedown", k.onmousedown), k.bind(k.cursor, "mouseup", k.onmouseup), k.cursorh && k.bind(k.cursorh, "mousedown", function(e) {
                            k.onmousedown(e, !0)
                        }), k.cursorh && k.bind(k.cursorh, "mouseup", k.onmouseup)) : (k.bind(k.rail, "mousedown", function(e) {
                            e.preventDefault()
                        }), k.railh && k.bind(k.railh, "mousedown", function(e) {
                            e.preventDefault()
                        }))) : (k.bind(P.hasmousecapture ? k.win : l, "mouseup", k.onmouseup), k.bind(l, "mousemove", k.onmousemove), k.onclick && k.bind(l, "click", k.onclick), k.bind(k.cursor, "mousedown", k.onmousedown), k.bind(k.cursor, "mouseup", k.onmouseup), k.railh && (k.bind(k.cursorh, "mousedown", function(e) {
                            k.onmousedown(e, !0)
                        }), k.bind(k.cursorh, "mouseup", k.onmouseup)), !k.ispage && M.enablescrollonselection && (k.bind(k.win[0], "mousedown", k.onselectionstart), k.bind(l, "mouseup", k.onselectionend), k.bind(k.cursor, "mouseup", k.onselectionend), k.cursorh && k.bind(k.cursorh, "mouseup", k.onselectionend), k.bind(l, "mousemove", k.onselectiondrag)), k.zoom && (k.jqbind(k.zoom, "mouseenter", function() {
                            k.canshowonmouseevent && k.showCursor(), k.rail.active = !0
                        }), k.jqbind(k.zoom, "mouseleave", function() {
                            k.rail.active = !1, k.rail.drag || k.hideCursor()
                        }))), M.enablemousewheel && (k.isiframe || k.mousewheel(P.isie && k.ispage ? l : k.win, k.onmousewheel), k.mousewheel(k.rail, k.onmousewheel), k.railh && k.mousewheel(k.railh, k.onmousewheelhr)), k.ispage || P.cantouch || /HTML|^BODY/.test(k.win[0].nodeName) || (k.win.attr("tabindex") || k.win.attr({
                            tabindex: ++r
                        }), k.bind(k.win, "focus", function(e) {
                            o = k.getTarget(e).id || k.getTarget(e) || !1, k.hasfocus = !0, k.canshowonmouseevent && k.noticeCursor()
                        }), k.bind(k.win, "blur", function(e) {
                            o = !1, k.hasfocus = !1
                        }), k.bind(k.win, "mouseenter", function(e) {
                            t = k.getTarget(e).id || k.getTarget(e) || !1, k.hasmousefocus = !0, k.canshowonmouseevent && k.noticeCursor()
                        }), k.bind(k.win, "mouseleave", function(e) {
                            t = !1, k.hasmousefocus = !1, k.rail.drag || k.hideCursor()
                        })), k.onkeypress = function(e) {
                            if (k.railslocked && 0 === k.page.maxh) return !0;
                            e = e || a.event;
                            var r = k.getTarget(e);
                            if (r && /INPUT|TEXTAREA|SELECT|OPTION/.test(r.nodeName) && (!(r.getAttribute("type") || r.type || !1) || !/submit|button|cancel/i.tp)) return !0;
                            if (n(r).attr("contenteditable")) return !0;
                            if (k.hasfocus || k.hasmousefocus && !o || k.ispage && !o && !t) {
                                var i = e.keyCode;
                                if (k.railslocked && 27 != i) return k.cancelEvent(e);
                                var s = e.ctrlKey || !1,
                                    l = e.shiftKey || !1,
                                    c = !1;
                                switch (i) {
                                    case 38:
                                    case 63233:
                                        k.doScrollBy(72), c = !0;
                                        break;
                                    case 40:
                                    case 63235:
                                        k.doScrollBy(-72), c = !0;
                                        break;
                                    case 37:
                                    case 63232:
                                        k.railh && (s ? k.doScrollLeft(0) : k.doScrollLeftBy(72), c = !0);
                                        break;
                                    case 39:
                                    case 63234:
                                        k.railh && (s ? k.doScrollLeft(k.page.maxw) : k.doScrollLeftBy(-72), c = !0);
                                        break;
                                    case 33:
                                    case 63276:
                                        k.doScrollBy(k.view.h), c = !0;
                                        break;
                                    case 34:
                                    case 63277:
                                        k.doScrollBy(-k.view.h), c = !0;
                                        break;
                                    case 36:
                                    case 63273:
                                        k.railh && s ? k.doScrollPos(0, 0) : k.doScrollTo(0), c = !0;
                                        break;
                                    case 35:
                                    case 63275:
                                        k.railh && s ? k.doScrollPos(k.page.maxw, k.page.maxh) : k.doScrollTo(k.page.maxh), c = !0;
                                        break;
                                    case 32:
                                        M.spacebarenabled && (l ? k.doScrollBy(k.view.h) : k.doScrollBy(-k.view.h), c = !0);
                                        break;
                                    case 27:
                                        k.zoomactive && (k.doZoom(), c = !0)
                                }
                                if (c) return k.cancelEvent(e)
                            }
                        }, M.enablekeyboard && k.bind(l, P.isopera && !P.isopera12 ? "keypress" : "keydown", k.onkeypress), k.bind(l, "keydown", function(e) {
                            (e.ctrlKey || !1) && (k.wheelprevented = !0)
                        }), k.bind(l, "keyup", function(e) {
                            e.ctrlKey || !1 || (k.wheelprevented = !1)
                        }), k.bind(a, "blur", function(e) {
                            k.wheelprevented = !1
                        }), k.bind(a, "resize", k.onscreenresize), k.bind(a, "orientationchange", k.onscreenresize), k.bind(a, "load", k.lazyResize), P.ischrome && !k.ispage && !k.haswrapper) {
                        var C = k.win.attr("style"),
                            N = parseFloat(k.win.css("width")) + 1;
                        k.win.css("width", N), k.synched("chromefix", function() {
                            k.win.attr("style", C)
                        })
                    }
                    if (k.onAttributeChange = function(e) {
                            k.lazyResize(k.isieold ? 250 : 30)
                        }, M.enableobserver && (k.isie11 || !1 === m || (k.observerbody = new m(function(e) {
                            if (e.forEach(function(e) {
                                    if ("attributes" == e.type) return E.hasClass("modal-open") && E.hasClass("modal-dialog") && !n.contains(n(".modal-dialog")[0], k.doc[0]) ? k.hide() : k.show()
                                }), k.me.clientWidth != k.page.width || k.me.clientHeight != k.page.height) return k.lazyResize(30)
                        }), k.observerbody.observe(l.body, {
                            childList: !0,
                            subtree: !0,
                            characterData: !1,
                            attributes: !0,
                            attributeFilter: ["class"]
                        })), !k.ispage && !k.haswrapper)) {
                        var R = k.win[0];
                        !1 !== m ? (k.observer = new m(function(e) {
                            e.forEach(k.onAttributeChange)
                        }), k.observer.observe(R, {
                            childList: !0,
                            characterData: !1,
                            attributes: !0,
                            subtree: !1
                        }), k.observerremover = new m(function(e) {
                            e.forEach(function(e) {
                                if (e.removedNodes.length > 0)
                                    for (var o in e.removedNodes)
                                        if (k && e.removedNodes[o] === R) return k.remove()
                            })
                        }), k.observerremover.observe(R.parentNode, {
                            childList: !0,
                            characterData: !1,
                            attributes: !1,
                            subtree: !1
                        })) : (k.bind(R, P.isie && !P.isie9 ? "propertychange" : "DOMAttrModified", k.onAttributeChange), P.isie9 && R.attachEvent("onpropertychange", k.onAttributeChange), k.bind(R, "DOMNodeRemoved", function(e) {
                            e.target === R && k.remove()
                        }))
                    }!k.ispage && M.boxzoom && k.bind(a, "resize", k.resizeZoom), k.istextarea && (k.bind(k.win, "keydown", k.lazyResize), k.bind(k.win, "mouseup", k.lazyResize)), k.lazyResize(30)
                }
                if ("IFRAME" == this.doc[0].nodeName) {
                    var _ = function() {
                        k.iframexd = !1;
                        var o;
                        try {
                            (o = "contentDocument" in this ? this.contentDocument : this.contentWindow._doc).domain
                        } catch (e) {
                            k.iframexd = !0, o = !1
                        }
                        if (k.iframexd) return "console" in a && console.log("NiceScroll error: policy restriced iframe"), !0;
                        if (k.forcescreen = !0, k.isiframe && (k.iframe = {
                                doc: n(o),
                                html: k.doc.contents().find("html")[0],
                                body: k.doc.contents().find("body")[0]
                            }, k.getContentSize = function() {
                                return {
                                    w: Math.max(k.iframe.html.scrollWidth, k.iframe.body.scrollWidth),
                                    h: Math.max(k.iframe.html.scrollHeight, k.iframe.body.scrollHeight)
                                }
                            }, k.docscroll = n(k.iframe.body)), !P.isios && M.iframeautoresize && !k.isiframe) {
                            k.win.scrollTop(0), k.doc.height("");
                            var t = Math.max(o.getElementsByTagName("html")[0].scrollHeight, o.body.scrollHeight);
                            k.doc.height(t)
                        }
                        k.lazyResize(30), k.css(n(k.iframe.body), e), P.isios && k.haswrapper && k.css(n(o.body), {
                            "-webkit-transform": "translate3d(0,0,0)"
                        }), "contentWindow" in this ? k.bind(this.contentWindow, "scroll", k.onscroll) : k.bind(o, "scroll", k.onscroll), M.enablemousewheel && k.mousewheel(o, k.onmousewheel), M.enablekeyboard && k.bind(o, P.isopera ? "keypress" : "keydown", k.onkeypress), P.cantouch ? (k.bind(o, "touchstart", k.ontouchstart), k.bind(o, "touchmove", k.ontouchmove)) : M.emulatetouch && (k.bind(o, "mousedown", k.ontouchstart), k.bind(o, "mousemove", function(e) {
                            return k.ontouchmove(e, !0)
                        }), M.grabcursorenabled && P.cursorgrabvalue && k.css(n(o.body), {
                            cursor: P.cursorgrabvalue
                        })), k.bind(o, "mouseup", k.ontouchend), k.zoom && (M.dblclickzoom && k.bind(o, "dblclick", k.doZoom), k.ongesturezoom && k.bind(o, "gestureend", k.ongesturezoom))
                    };
                    this.doc[0].readyState && "complete" === this.doc[0].readyState && setTimeout(function() {
                        _.call(k.doc[0], !1)
                    }, 500), k.bind(this.doc, "load", _)
                }
            }, this.showCursor = function(e, o) {
                if (k.cursortimeout && (clearTimeout(k.cursortimeout), k.cursortimeout = 0), k.rail) {
                    if (k.autohidedom && (k.autohidedom.stop().css({
                            opacity: M.cursoropacitymax
                        }), k.cursoractive = !0), k.rail.drag && 1 == k.rail.drag.pt || (void 0 !== e && !1 !== e && (k.scroll.y = e / k.scrollratio.y | 0), void 0 !== o && (k.scroll.x = o / k.scrollratio.x | 0)), k.cursor.css({
                            height: k.cursorheight,
                            top: k.scroll.y
                        }), k.cursorh) {
                        var t = k.hasreversehr ? k.scrollvaluemaxw - k.scroll.x : k.scroll.x;
                        k.cursorh.css({
                            width: k.cursorwidth,
                            left: !k.rail.align && k.rail.visibility ? t + k.rail.width : t
                        }), k.cursoractive = !0
                    }
                    k.zoom && k.zoom.stop().css({
                        opacity: M.cursoropacitymax
                    })
                }
            }, this.hideCursor = function(e) {
                k.cursortimeout || k.rail && k.autohidedom && (k.hasmousefocus && "leave" === M.autohidemode || (k.cursortimeout = setTimeout(function() {
                    k.rail.active && k.showonmouseevent || (k.autohidedom.stop().animate({
                        opacity: M.cursoropacitymin
                    }), k.zoom && k.zoom.stop().animate({
                        opacity: M.cursoropacitymin
                    }), k.cursoractive = !1), k.cursortimeout = 0
                }, e || M.hidecursordelay)))
            }, this.noticeCursor = function(e, o, t) {
                k.showCursor(o, t), k.rail.active || k.hideCursor(e)
            }, this.getContentSize = k.ispage ? function() {
                return {
                    w: Math.max(l.body.scrollWidth, l.documentElement.scrollWidth),
                    h: Math.max(l.body.scrollHeight, l.documentElement.scrollHeight)
                }
            } : k.haswrapper ? function() {
                return {
                    w: k.doc[0].offsetWidth,
                    h: k.doc[0].offsetHeight
                }
            } : function() {
                return {
                    w: k.docscroll[0].scrollWidth,
                    h: k.docscroll[0].scrollHeight
                }
            }, this.onResize = function(e, o) {
                if (!k || !k.win) return !1;
                var t = k.page.maxh,
                    r = k.page.maxw,
                    i = k.view.h,
                    s = k.view.w;
                if (k.view = {
                        w: k.ispage ? k.win.width() : k.win[0].clientWidth,
                        h: k.ispage ? k.win.height() : k.win[0].clientHeight
                    }, k.page = o || k.getContentSize(), k.page.maxh = Math.max(0, k.page.h - k.view.h), k.page.maxw = Math.max(0, k.page.w - k.view.w), k.page.maxh == t && k.page.maxw == r && k.view.w == s && k.view.h == i) {
                    if (k.ispage) return k;
                    var n = k.win.offset();
                    if (k.lastposition) {
                        var l = k.lastposition;
                        if (l.top == n.top && l.left == n.left) return k
                    }
                    k.lastposition = n
                }
                return 0 === k.page.maxh ? (k.hideRail(), k.scrollvaluemax = 0, k.scroll.y = 0, k.scrollratio.y = 0, k.cursorheight = 0, k.setScrollTop(0), k.rail && (k.rail.scrollable = !1)) : (k.page.maxh -= M.railpadding.top + M.railpadding.bottom, k.rail.scrollable = !0), 0 === k.page.maxw ? (k.hideRailHr(), k.scrollvaluemaxw = 0, k.scroll.x = 0, k.scrollratio.x = 0, k.cursorwidth = 0, k.setScrollLeft(0), k.railh && (k.railh.scrollable = !1)) : (k.page.maxw -= M.railpadding.left + M.railpadding.right, k.railh && (k.railh.scrollable = M.horizrailenabled)), k.railslocked = k.locked || 0 === k.page.maxh && 0 === k.page.maxw, k.railslocked ? (k.ispage || k.updateScrollBar(k.view), !1) : (k.hidden || (k.rail.visibility || k.showRail(), k.railh && !k.railh.visibility && k.showRailHr()), k.istextarea && k.win.css("resize") && "none" != k.win.css("resize") && (k.view.h -= 20), k.cursorheight = Math.min(k.view.h, Math.round(k.view.h * (k.view.h / k.page.h))), k.cursorheight = M.cursorfixedheight ? M.cursorfixedheight : Math.max(M.cursorminheight, k.cursorheight), k.cursorwidth = Math.min(k.view.w, Math.round(k.view.w * (k.view.w / k.page.w))), k.cursorwidth = M.cursorfixedheight ? M.cursorfixedheight : Math.max(M.cursorminheight, k.cursorwidth), k.scrollvaluemax = k.view.h - k.cursorheight - (M.railpadding.top + M.railpadding.bottom), k.hasborderbox || (k.scrollvaluemax -= k.cursor[0].offsetHeight - k.cursor[0].clientHeight), k.railh && (k.railh.width = k.page.maxh > 0 ? k.view.w - k.rail.width : k.view.w, k.scrollvaluemaxw = k.railh.width - k.cursorwidth - (M.railpadding.left + M.railpadding.right)), k.ispage || k.updateScrollBar(k.view), k.scrollratio = {
                    x: k.page.maxw / k.scrollvaluemaxw,
                    y: k.page.maxh / k.scrollvaluemax
                }, k.getScrollTop() > k.page.maxh ? k.doScrollTop(k.page.maxh) : (k.scroll.y = k.getScrollTop() / k.scrollratio.y | 0, k.scroll.x = k.getScrollLeft() / k.scrollratio.x | 0, k.cursoractive && k.noticeCursor()), k.scroll.y && 0 === k.getScrollTop() && k.doScrollTo(k.scroll.y * k.scrollratio.y | 0), k)
            }, this.resize = k.onResize;
            var O = 0;
            this.onscreenresize = function(e) {
                clearTimeout(O);
                var o = !k.ispage && !k.haswrapper;
                o && k.hideRails(), O = setTimeout(function() {
                    k && (o && k.showRails(), k.resize()), O = 0
                }, 120)
            }, this.lazyResize = function(e) {
                return clearTimeout(O), e = isNaN(e) ? 240 : e, O = setTimeout(function() {
                    k && k.resize(), O = 0
                }, e), k
            }, this.jqbind = function(e, o, t) {
                k.events.push({
                    e: e,
                    n: o,
                    f: t,
                    q: !0
                }), n(e).on(o, t)
            }, this.mousewheel = function(e, o, t) {
                var r = "jquery" in e ? e[0] : e;
                if ("onwheel" in l.createElement("div")) k._bind(r, "wheel", o, t || !1);
                else {
                    var i = void 0 !== l.onmousewheel ? "mousewheel" : "DOMMouseScroll";
                    S(r, i, o, t || !1), "DOMMouseScroll" == i && S(r, "MozMousePixelScroll", o, t || !1)
                }
            };
            var Y = !1;
            if (P.haseventlistener) {
                try {
                    var H = Object.defineProperty({}, "passive", {
                        get: function() {
                            Y = !0
                        }
                    });
                    a.addEventListener("test", null, H)
                } catch (e) {}
                this.stopPropagation = function(e) {
                    return !!e && ((e = e.original ? e.original : e).stopPropagation(), !1)
                }, this.cancelEvent = function(e) {
                    return e.cancelable && e.preventDefault(), e.stopImmediatePropagation(), e.preventManipulation && e.preventManipulation(), !1
                }
            } else Event.prototype.preventDefault = function() {
                this.returnValue = !1
            }, Event.prototype.stopPropagation = function() {
                this.cancelBubble = !0
            }, a.constructor.prototype.addEventListener = l.constructor.prototype.addEventListener = Element.prototype.addEventListener = function(e, o, t) {
                this.attachEvent("on" + e, o)
            }, a.constructor.prototype.removeEventListener = l.constructor.prototype.removeEventListener = Element.prototype.removeEventListener = function(e, o, t) {
                this.detachEvent("on" + e, o)
            }, this.cancelEvent = function(e) {
                return (e = e || a.event) && (e.cancelBubble = !0, e.cancel = !0, e.returnValue = !1), !1
            }, this.stopPropagation = function(e) {
                return (e = e || a.event) && (e.cancelBubble = !0), !1
            };
            this.delegate = function(e, o, t, r, i) {
                var s = d[o] || !1;
                s || (s = {
                    a: [],
                    l: [],
                    f: function(e) {
                        for (var o = s.l, t = !1, r = o.length - 1; r >= 0; r--)
                            if (!1 === (t = o[r].call(e.target, e))) return !1;
                        return t
                    }
                }, k.bind(e, o, s.f, r, i), d[o] = s), k.ispage ? (s.a = [k.id].concat(s.a), s.l = [t].concat(s.l)) : (s.a.push(k.id), s.l.push(t))
            }, this.undelegate = function(e, o, t, r, i) {
                var s = d[o] || !1;
                if (s && s.l)
                    for (var n = 0, l = s.l.length; n < l; n++) s.a[n] === k.id && (s.a.splice(n), s.l.splice(n), 0 === s.a.length && (k._unbind(e, o, s.l.f), d[o] = null))
            }, this.bind = function(e, o, t, r, i) {
                var s = "jquery" in e ? e[0] : e;
                k._bind(s, o, t, r || !1, i || !1)
            }, this._bind = function(e, o, t, r, i) {
                k.events.push({
                    e: e,
                    n: o,
                    f: t,
                    b: r,
                    q: !1
                }), Y && i ? e.addEventListener(o, t, {
                    passive: !1,
                    capture: r
                }) : e.addEventListener(o, t, r || !1)
            }, this._unbind = function(e, o, t, r) {
                d[o] ? k.undelegate(e, o, t, r) : e.removeEventListener(o, t, r)
            }, this.unbindAll = function() {
                for (var e = 0; e < k.events.length; e++) {
                    var o = k.events[e];
                    o.q ? o.e.unbind(o.n, o.f) : k._unbind(o.e, o.n, o.f, o.b)
                }
            }, this.showRails = function() {
                return k.showRail().showRailHr()
            }, this.showRail = function() {
                return 0 === k.page.maxh || !k.ispage && "none" == k.win.css("display") || (k.rail.visibility = !0, k.rail.css("display", "block")), k
            }, this.showRailHr = function() {
                return k.railh && (0 === k.page.maxw || !k.ispage && "none" == k.win.css("display") || (k.railh.visibility = !0, k.railh.css("display", "block"))), k
            }, this.hideRails = function() {
                return k.hideRail().hideRailHr()
            }, this.hideRail = function() {
                return k.rail.visibility = !1, k.rail.css("display", "none"), k
            }, this.hideRailHr = function() {
                return k.railh && (k.railh.visibility = !1, k.railh.css("display", "none")), k
            }, this.show = function() {
                return k.hidden = !1, k.railslocked = !1, k.showRails()
            }, this.hide = function() {
                return k.hidden = !0, k.railslocked = !0, k.hideRails()
            }, this.toggle = function() {
                return k.hidden ? k.show() : k.hide()
            }, this.remove = function() {
                k.stop(), k.cursortimeout && clearTimeout(k.cursortimeout);
                for (var e in k.delaylist) k.delaylist[e] && h(k.delaylist[e].h);
                k.doZoomOut(), k.unbindAll(), P.isie9 && k.win[0].detachEvent("onpropertychange", k.onAttributeChange), !1 !== k.observer && k.observer.disconnect(), !1 !== k.observerremover && k.observerremover.disconnect(), !1 !== k.observerbody && k.observerbody.disconnect(), k.events = null, k.cursor && k.cursor.remove(), k.cursorh && k.cursorh.remove(), k.rail && k.rail.remove(), k.railh && k.railh.remove(), k.zoom && k.zoom.remove();
                for (var o = 0; o < k.saved.css.length; o++) {
                    var t = k.saved.css[o];
                    t[0].css(t[1], void 0 === t[2] ? "" : t[2])
                }
                k.saved = !1, k.me.data("__nicescroll", "");
                var r = n.nicescroll;
                r.each(function(e) {
                    if (this && this.id === k.id) {
                        delete r[e];
                        for (var o = ++e; o < r.length; o++, e++) r[e] = r[o];
                        --r.length && delete r[r.length]
                    }
                });
                for (var i in k) k[i] = null, delete k[i];
                k = null
            }, this.scrollstart = function(e) {
                return this.onscrollstart = e, k
            }, this.scrollend = function(e) {
                return this.onscrollend = e, k
            }, this.scrollcancel = function(e) {
                return this.onscrollcancel = e, k
            }, this.zoomin = function(e) {
                return this.onzoomin = e, k
            }, this.zoomout = function(e) {
                return this.onzoomout = e, k
            }, this.isScrollable = function(e) {
                var o = e.target ? e.target : e;
                if ("OPTION" == o.nodeName) return !0;
                for (; o && 1 == o.nodeType && o !== this.me[0] && !/^BODY|HTML/.test(o.nodeName);) {
                    var t = n(o),
                        r = t.css("overflowY") || t.css("overflowX") || t.css("overflow") || "";
                    if (/scroll|auto/.test(r)) return o.clientHeight != o.scrollHeight;
                    o = !!o.parentNode && o.parentNode
                }
                return !1
            }, this.getViewport = function(e) {
                for (var o = !(!e || !e.parentNode) && e.parentNode; o && 1 == o.nodeType && !/^BODY|HTML/.test(o.nodeName);) {
                    var t = n(o);
                    if (/fixed|absolute/.test(t.css("position"))) return t;
                    var r = t.css("overflowY") || t.css("overflowX") || t.css("overflow") || "";
                    if (/scroll|auto/.test(r) && o.clientHeight != o.scrollHeight) return t;
                    if (t.getNiceScroll().length > 0) return t;
                    o = !!o.parentNode && o.parentNode
                }
                return !1
            }, this.triggerScrollStart = function(e, o, t, r, i) {
                if (k.onscrollstart) {
                    var s = {
                        type: "scrollstart",
                        current: {
                            x: e,
                            y: o
                        },
                        request: {
                            x: t,
                            y: r
                        },
                        end: {
                            x: k.newscrollx,
                            y: k.newscrolly
                        },
                        speed: i
                    };
                    k.onscrollstart.call(k, s)
                }
            }, this.triggerScrollEnd = function() {
                if (k.onscrollend) {
                    var e = k.getScrollLeft(),
                        o = k.getScrollTop(),
                        t = {
                            type: "scrollend",
                            current: {
                                x: e,
                                y: o
                            },
                            end: {
                                x: e,
                                y: o
                            }
                        };
                    k.onscrollend.call(k, t)
                }
            };
            var B = 0,
                X = 0,
                D = 0,
                A = 1,
                q = !1;
            if (this.onmousewheel = function(e) {
                    if (k.wheelprevented || k.locked) return !1;
                    if (k.railslocked) return k.debounced("checkunlock", k.resize, 250), !1;
                    if (k.rail.drag) return k.cancelEvent(e);
                    if ("auto" === M.oneaxismousemode && 0 !== e.deltaX && (M.oneaxismousemode = !1), M.oneaxismousemode && 0 === e.deltaX && !k.rail.scrollable) return !k.railh || !k.railh.scrollable || k.onmousewheelhr(e);
                    var o = f(),
                        t = !1;
                    if (M.preservenativescrolling && k.checkarea + 600 < o && (k.nativescrollingarea = k.isScrollable(e), t = !0), k.checkarea = o, k.nativescrollingarea) return !0;
                    var r = T(e, !1, t);
                    return r && (k.checkarea = 0), r
                }, this.onmousewheelhr = function(e) {
                    if (!k.wheelprevented) {
                        if (k.railslocked || !k.railh.scrollable) return !0;
                        if (k.rail.drag) return k.cancelEvent(e);
                        var o = f(),
                            t = !1;
                        return M.preservenativescrolling && k.checkarea + 600 < o && (k.nativescrollingarea = k.isScrollable(e), t = !0), k.checkarea = o, !!k.nativescrollingarea || (k.railslocked ? k.cancelEvent(e) : T(e, !0, t))
                    }
                }, this.stop = function() {
                    return k.cancelScroll(), k.scrollmon && k.scrollmon.stop(), k.cursorfreezed = !1, k.scroll.y = Math.round(k.getScrollTop() * (1 / k.scrollratio.y)), k.noticeCursor(), k
                }, this.getTransitionSpeed = function(e) {
                    return 80 + e / 72 * M.scrollspeed | 0
                }, M.smoothscroll)
                if (k.ishwscroll && P.hastransition && M.usetransition && M.smoothscroll) {
                    var j = "";
                    this.resetTransition = function() {
                        j = "", k.doc.css(P.prefixstyle + "transition-duration", "0ms")
                    }, this.prepareTransition = function(e, o) {
                        var t = o ? e : k.getTransitionSpeed(e),
                            r = t + "ms";
                        return j !== r && (j = r, k.doc.css(P.prefixstyle + "transition-duration", r)), t
                    }, this.doScrollLeft = function(e, o) {
                        var t = k.scrollrunning ? k.newscrolly : k.getScrollTop();
                        k.doScrollPos(e, t, o)
                    }, this.doScrollTop = function(e, o) {
                        var t = k.scrollrunning ? k.newscrollx : k.getScrollLeft();
                        k.doScrollPos(t, e, o)
                    }, this.cursorupdate = {
                        running: !1,
                        start: function() {
                            var e = this;
                            if (!e.running) {
                                e.running = !0;
                                var o = function() {
                                    e.running && u(o), k.showCursor(k.getScrollTop(), k.getScrollLeft()), k.notifyScrollEvent(k.win[0])
                                };
                                u(o)
                            }
                        },
                        stop: function() {
                            this.running = !1
                        }
                    }, this.doScrollPos = function(e, o, t) {
                        var r = k.getScrollTop(),
                            i = k.getScrollLeft();
                        if (((k.newscrolly - r) * (o - r) < 0 || (k.newscrollx - i) * (e - i) < 0) && k.cancelScroll(), M.bouncescroll ? (o < 0 ? o = o / 2 | 0 : o > k.page.maxh && (o = k.page.maxh + (o - k.page.maxh) / 2 | 0), e < 0 ? e = e / 2 | 0 : e > k.page.maxw && (e = k.page.maxw + (e - k.page.maxw) / 2 | 0)) : (o < 0 ? o = 0 : o > k.page.maxh && (o = k.page.maxh), e < 0 ? e = 0 : e > k.page.maxw && (e = k.page.maxw)), k.scrollrunning && e == k.newscrollx && o == k.newscrolly) return !1;
                        k.newscrolly = o, k.newscrollx = e;
                        var s = k.getScrollTop(),
                            n = k.getScrollLeft(),
                            l = {};
                        l.x = e - n, l.y = o - s;
                        var a = 0 | Math.sqrt(l.x * l.x + l.y * l.y),
                            c = k.prepareTransition(a);
                        k.scrollrunning || (k.scrollrunning = !0, k.triggerScrollStart(n, s, e, o, c), k.cursorupdate.start()), k.scrollendtrapped = !0, P.transitionend || (k.scrollendtrapped && clearTimeout(k.scrollendtrapped), k.scrollendtrapped = setTimeout(k.onScrollTransitionEnd, c)), k.setScrollTop(k.newscrolly), k.setScrollLeft(k.newscrollx)
                    }, this.cancelScroll = function() {
                        if (!k.scrollendtrapped) return !0;
                        var e = k.getScrollTop(),
                            o = k.getScrollLeft();
                        return k.scrollrunning = !1, P.transitionend || clearTimeout(P.transitionend), k.scrollendtrapped = !1, k.resetTransition(), k.setScrollTop(e), k.railh && k.setScrollLeft(o), k.timerscroll && k.timerscroll.tm && clearInterval(k.timerscroll.tm), k.timerscroll = !1, k.cursorfreezed = !1, k.cursorupdate.stop(), k.showCursor(e, o), k
                    }, this.onScrollTransitionEnd = function() {
                        if (k.scrollendtrapped) {
                            var e = k.getScrollTop(),
                                o = k.getScrollLeft();
                            if (e < 0 ? e = 0 : e > k.page.maxh && (e = k.page.maxh), o < 0 ? o = 0 : o > k.page.maxw && (o = k.page.maxw), e != k.newscrolly || o != k.newscrollx) return k.doScrollPos(o, e, M.snapbackspeed);
                            k.scrollrunning && k.triggerScrollEnd(), k.scrollrunning = !1, k.scrollendtrapped = !1, k.resetTransition(), k.timerscroll = !1, k.setScrollTop(e), k.railh && k.setScrollLeft(o), k.cursorupdate.stop(), k.noticeCursor(!1, e, o), k.cursorfreezed = !1
                        }
                    }
                } else this.doScrollLeft = function(e, o) {
                    var t = k.scrollrunning ? k.newscrolly : k.getScrollTop();
                    k.doScrollPos(e, t, o)
                }, this.doScrollTop = function(e, o) {
                    var t = k.scrollrunning ? k.newscrollx : k.getScrollLeft();
                    k.doScrollPos(t, e, o)
                }, this.doScrollPos = function(e, o, t) {
                    var r = k.getScrollTop(),
                        i = k.getScrollLeft();
                    ((k.newscrolly - r) * (o - r) < 0 || (k.newscrollx - i) * (e - i) < 0) && k.cancelScroll();
                    var s = !1;
                    if (k.bouncescroll && k.rail.visibility || (o < 0 ? (o = 0, s = !0) : o > k.page.maxh && (o = k.page.maxh, s = !0)), k.bouncescroll && k.railh.visibility || (e < 0 ? (e = 0, s = !0) : e > k.page.maxw && (e = k.page.maxw, s = !0)), k.scrollrunning && k.newscrolly === o && k.newscrollx === e) return !0;
                    k.newscrolly = o, k.newscrollx = e, k.dst = {}, k.dst.x = e - i, k.dst.y = o - r, k.dst.px = i, k.dst.py = r;
                    var n = 0 | Math.sqrt(k.dst.x * k.dst.x + k.dst.y * k.dst.y),
                        l = k.getTransitionSpeed(n);
                    k.bzscroll = {};
                    var a = s ? 1 : .58;
                    k.bzscroll.x = new R(i, k.newscrollx, l, 0, 0, a, 1), k.bzscroll.y = new R(r, k.newscrolly, l, 0, 0, a, 1);
                    f();
                    var c = function() {
                        if (k.scrollrunning) {
                            var e = k.bzscroll.y.getPos();
                            k.setScrollLeft(k.bzscroll.x.getNow()), k.setScrollTop(k.bzscroll.y.getNow()), e <= 1 ? k.timer = u(c) : (k.scrollrunning = !1, k.timer = 0, k.triggerScrollEnd())
                        }
                    };
                    k.scrollrunning || (k.triggerScrollStart(i, r, e, o, l), k.scrollrunning = !0, k.timer = u(c))
                }, this.cancelScroll = function() {
                    return k.timer && h(k.timer), k.timer = 0, k.bzscroll = !1, k.scrollrunning = !1, k
                };
            else this.doScrollLeft = function(e, o) {
                var t = k.getScrollTop();
                k.doScrollPos(e, t, o)
            }, this.doScrollTop = function(e, o) {
                var t = k.getScrollLeft();
                k.doScrollPos(t, e, o)
            }, this.doScrollPos = function(e, o, t) {
                var r = e > k.page.maxw ? k.page.maxw : e;
                r < 0 && (r = 0);
                var i = o > k.page.maxh ? k.page.maxh : o;
                i < 0 && (i = 0), k.synched("scroll", function() {
                    k.setScrollTop(i), k.setScrollLeft(r)
                })
            }, this.cancelScroll = function() {};
            this.doScrollBy = function(e, o) {
                z(0, e)
            }, this.doScrollLeftBy = function(e, o) {
                z(e, 0)
            }, this.doScrollTo = function(e, o) {
                var t = o ? Math.round(e * k.scrollratio.y) : e;
                t < 0 ? t = 0 : t > k.page.maxh && (t = k.page.maxh), k.cursorfreezed = !1, k.doScrollTop(e)
            }, this.checkContentSize = function() {
                var e = k.getContentSize();
                e.h == k.page.h && e.w == k.page.w || k.resize(!1, e)
            }, k.onscroll = function(e) {
                k.rail.drag || k.cursorfreezed || k.synched("scroll", function() {
                    k.scroll.y = Math.round(k.getScrollTop() / k.scrollratio.y), k.railh && (k.scroll.x = Math.round(k.getScrollLeft() / k.scrollratio.x)), k.noticeCursor()
                })
            }, k.bind(k.docscroll, "scroll", k.onscroll), this.doZoomIn = function(e) {
                if (!k.zoomactive) {
                    k.zoomactive = !0, k.zoomrestore = {
                        style: {}
                    };
                    var o = ["position", "top", "left", "zIndex", "backgroundColor", "marginTop", "marginBottom", "marginLeft", "marginRight"],
                        t = k.win[0].style;
                    for (var r in o) {
                        var i = o[r];
                        k.zoomrestore.style[i] = void 0 !== t[i] ? t[i] : ""
                    }
                    k.zoomrestore.style.width = k.win.css("width"), k.zoomrestore.style.height = k.win.css("height"), k.zoomrestore.padding = {
                        w: k.win.outerWidth() - k.win.width(),
                        h: k.win.outerHeight() - k.win.height()
                    }, P.isios4 && (k.zoomrestore.scrollTop = c.scrollTop(), c.scrollTop(0)), k.win.css({
                        position: P.isios4 ? "absolute" : "fixed",
                        top: 0,
                        left: 0,
                        zIndex: s + 100,
                        margin: 0
                    });
                    var n = k.win.css("backgroundColor");
                    return ("" === n || /transparent|rgba\(0, 0, 0, 0\)|rgba\(0,0,0,0\)/.test(n)) && k.win.css("backgroundColor", "#fff"), k.rail.css({
                        zIndex: s + 101
                    }), k.zoom.css({
                        zIndex: s + 102
                    }), k.zoom.css("backgroundPosition", "0 -18px"), k.resizeZoom(), k.onzoomin && k.onzoomin.call(k), k.cancelEvent(e)
                }
            }, this.doZoomOut = function(e) {
                if (k.zoomactive) return k.zoomactive = !1, k.win.css("margin", ""), k.win.css(k.zoomrestore.style), P.isios4 && c.scrollTop(k.zoomrestore.scrollTop), k.rail.css({
                    "z-index": k.zindex
                }), k.zoom.css({
                    "z-index": k.zindex
                }), k.zoomrestore = !1, k.zoom.css("backgroundPosition", "0 0"), k.onResize(), k.onzoomout && k.onzoomout.call(k), k.cancelEvent(e)
            }, this.doZoom = function(e) {
                return k.zoomactive ? k.doZoomOut(e) : k.doZoomIn(e)
            }, this.resizeZoom = function() {
                if (k.zoomactive) {
                    var e = k.getScrollTop();
                    k.win.css({
                        width: c.width() - k.zoomrestore.padding.w + "px",
                        height: c.height() - k.zoomrestore.padding.h + "px"
                    }), k.onResize(), k.setScrollTop(Math.min(k.page.maxh, e))
                }
            }, this.init(), n.nicescroll.push(this)
        },
        y = function(e) {
            var o = this;
            this.nc = e, this.lastx = 0, this.lasty = 0, this.speedx = 0, this.speedy = 0, this.lasttime = 0, this.steptime = 0, this.snapx = !1, this.snapy = !1, this.demulx = 0, this.demuly = 0, this.lastscrollx = -1, this.lastscrolly = -1, this.chkx = 0, this.chky = 0, this.timer = 0, this.reset = function(e, t) {
                o.stop(), o.steptime = 0, o.lasttime = f(), o.speedx = 0, o.speedy = 0, o.lastx = e, o.lasty = t, o.lastscrollx = -1, o.lastscrolly = -1
            }, this.update = function(e, t) {
                var r = f();
                o.steptime = r - o.lasttime, o.lasttime = r;
                var i = t - o.lasty,
                    s = e - o.lastx,
                    n = o.nc.getScrollTop() + i,
                    l = o.nc.getScrollLeft() + s;
                o.snapx = l < 0 || l > o.nc.page.maxw, o.snapy = n < 0 || n > o.nc.page.maxh, o.speedx = s, o.speedy = i, o.lastx = e, o.lasty = t
            }, this.stop = function() {
                o.nc.unsynched("domomentum2d"), o.timer && clearTimeout(o.timer), o.timer = 0, o.lastscrollx = -1, o.lastscrolly = -1
            }, this.doSnapy = function(e, t) {
                var r = !1;
                t < 0 ? (t = 0, r = !0) : t > o.nc.page.maxh && (t = o.nc.page.maxh, r = !0), e < 0 ? (e = 0, r = !0) : e > o.nc.page.maxw && (e = o.nc.page.maxw, r = !0), r ? o.nc.doScrollPos(e, t, o.nc.opt.snapbackspeed) : o.nc.triggerScrollEnd()
            }, this.doMomentum = function(e) {
                var t = f(),
                    r = e ? t + e : o.lasttime,
                    i = o.nc.getScrollLeft(),
                    s = o.nc.getScrollTop(),
                    n = o.nc.page.maxh,
                    l = o.nc.page.maxw;
                o.speedx = l > 0 ? Math.min(60, o.speedx) : 0, o.speedy = n > 0 ? Math.min(60, o.speedy) : 0;
                var a = r && t - r <= 60;
                (s < 0 || s > n || i < 0 || i > l) && (a = !1);
                var c = !(!o.speedy || !a) && o.speedy,
                    d = !(!o.speedx || !a) && o.speedx;
                if (c || d) {
                    var u = Math.max(16, o.steptime);
                    if (u > 50) {
                        var h = u / 50;
                        o.speedx *= h, o.speedy *= h, u = 50
                    }
                    o.demulxy = 0, o.lastscrollx = o.nc.getScrollLeft(), o.chkx = o.lastscrollx, o.lastscrolly = o.nc.getScrollTop(), o.chky = o.lastscrolly;
                    var p = o.lastscrollx,
                        m = o.lastscrolly,
                        g = function() {
                            var e = f() - t > 600 ? .04 : .02;
                            o.speedx && (p = Math.floor(o.lastscrollx - o.speedx * (1 - o.demulxy)), o.lastscrollx = p, (p < 0 || p > l) && (e = .1)), o.speedy && (m = Math.floor(o.lastscrolly - o.speedy * (1 - o.demulxy)), o.lastscrolly = m, (m < 0 || m > n) && (e = .1)), o.demulxy = Math.min(1, o.demulxy + e), o.nc.synched("domomentum2d", function() {
                                if (o.speedx) {
                                    o.nc.getScrollLeft();
                                    o.chkx = p, o.nc.setScrollLeft(p)
                                }
                                if (o.speedy) {
                                    o.nc.getScrollTop();
                                    o.chky = m, o.nc.setScrollTop(m)
                                }
                                o.timer || (o.nc.hideCursor(), o.doSnapy(p, m))
                            }), o.demulxy < 1 ? o.timer = setTimeout(g, u) : (o.stop(), o.nc.hideCursor(), o.doSnapy(p, m))
                        };
                    g()
                } else o.doSnapy(o.nc.getScrollLeft(), o.nc.getScrollTop())
            }
        },
        x = e.fn.scrollTop;
    e.cssHooks.pageYOffset = {
        get: function(e, o, t) {
            var r = n.data(e, "__nicescroll") || !1;
            return r && r.ishwscroll ? r.getScrollTop() : x.call(e)
        },
        set: function(e, o) {
            var t = n.data(e, "__nicescroll") || !1;
            return t && t.ishwscroll ? t.setScrollTop(parseInt(o)) : x.call(e, o), this
        }
    }, e.fn.scrollTop = function(e) {
        if (void 0 === e) {
            var o = !!this[0] && (n.data(this[0], "__nicescroll") || !1);
            return o && o.ishwscroll ? o.getScrollTop() : x.call(this)
        }
        return this.each(function() {
            var o = n.data(this, "__nicescroll") || !1;
            o && o.ishwscroll ? o.setScrollTop(parseInt(e)) : x.call(n(this), e)
        })
    };
    var S = e.fn.scrollLeft;
    n.cssHooks.pageXOffset = {
        get: function(e, o, t) {
            var r = n.data(e, "__nicescroll") || !1;
            return r && r.ishwscroll ? r.getScrollLeft() : S.call(e)
        },
        set: function(e, o) {
            var t = n.data(e, "__nicescroll") || !1;
            return t && t.ishwscroll ? t.setScrollLeft(parseInt(o)) : S.call(e, o), this
        }
    }, e.fn.scrollLeft = function(e) {
        if (void 0 === e) {
            var o = !!this[0] && (n.data(this[0], "__nicescroll") || !1);
            return o && o.ishwscroll ? o.getScrollLeft() : S.call(this)
        }
        return this.each(function() {
            var o = n.data(this, "__nicescroll") || !1;
            o && o.ishwscroll ? o.setScrollLeft(parseInt(e)) : S.call(n(this), e)
        })
    };
    var z = function(e) {
        var o = this;
        if (this.length = 0, this.name = "nicescrollarray", this.each = function(e) {
                return n.each(o, e), o
            }, this.push = function(e) {
                o[o.length] = e, o.length++
            }, this.eq = function(e) {
                return o[e]
            }, e)
            for (var t = 0; t < e.length; t++) {
                var r = n.data(e[t], "__nicescroll") || !1;
                r && (this[this.length] = r, this.length++)
            }
        return this
    };
    ! function(e, o, t) {
        for (var r = 0, i = o.length; r < i; r++) t(e, o[r])
    }(z.prototype, ["show", "hide", "toggle", "onResize", "resize", "remove", "stop", "doScrollPos"], function(e, o) {
        e[o] = function() {
            var e = arguments;
            return this.each(function() {
                this[o].apply(this, e)
            })
        }
    }), e.fn.getNiceScroll = function(e) {
        return void 0 === e ? new z(this) : this[e] && n.data(this[e], "__nicescroll") || !1
    }, (e.expr.pseudos || e.expr[":"]).nicescroll = function(e) {
        return void 0 !== n.data(e, "__nicescroll")
    }, n.fn.niceScroll = function(e, o) {
        void 0 !== o || "object" != typeof e || "jquery" in e || (o = e, e = !1);
        var t = new z;
        return this.each(function() {
            var r = n(this),
                i = n.extend({}, o);
            if (e) {
                var s = n(e);
                i.doc = s.length > 1 ? n(e, r) : s, i.win = r
            }!("doc" in i) || "win" in i || (i.win = r);
            var l = r.data("__nicescroll") || !1;
            l || (i.doc = i.doc || r, l = new b(i, r), r.data("__nicescroll", l)), t.push(l)
        }), 1 === t.length ? t[0] : t
    }, a.NiceScroll = {
        getjQuery: function() {
            return e
        }
    }, n.nicescroll || (n.nicescroll = new z, n.nicescroll.options = g)
});