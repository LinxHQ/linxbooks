jQuery.easing['jswing'] = jQuery.easing['swing'];
jQuery.extend(jQuery.easing, {
    def: 'easeOutQuad',
    swing: function (x, t, b, c, d) {
        return jQuery.easing[jQuery.easing.def](x, t, b, c, d)
    },
    easeInQuad: function (x, t, b, c, d) {
        return c * (t /= d) * t + b
    },
    easeOutQuad: function (x, t, b, c, d) {
        return -c * (t /= d) * (t - 2) + b
    },
    easeInOutQuad: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t + b;
        return -c / 2 * ((--t) * (t - 2) - 1) + b
    },
    easeInCubic: function (x, t, b, c, d) {
        return c * (t /= d) * t * t + b
    },
    easeOutCubic: function (x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t + 1) + b
    },
    easeInOutCubic: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b
    },
    easeInQuart: function (x, t, b, c, d) {
        return c * (t /= d) * t * t * t + b
    },
    easeOutQuart: function (x, t, b, c, d) {
        return -c * ((t = t / d - 1) * t * t * t - 1) + b
    },
    easeInOutQuart: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b
    },
    easeInQuint: function (x, t, b, c, d) {
        return c * (t /= d) * t * t * t * t + b
    },
    easeOutQuint: function (x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t * t * t + 1) + b
    },
    easeInOutQuint: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t * t * t + 2) + b
    },
    easeInSine: function (x, t, b, c, d) {
        return -c * Math.cos(t / d * (Math.PI / 2)) + c + b
    },
    easeOutSine: function (x, t, b, c, d) {
        return c * Math.sin(t / d * (Math.PI / 2)) + b
    },
    easeInOutSine: function (x, t, b, c, d) {
        return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b
    },
    easeInExpo: function (x, t, b, c, d) {
        return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b
    },
    easeOutExpo: function (x, t, b, c, d) {
        return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b
    },
    easeInOutExpo: function (x, t, b, c, d) {
        if (t == 0) return b;
        if (t == d) return b + c;
        if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
        return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b
    },
    easeInCirc: function (x, t, b, c, d) {
        return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b
    },
    easeOutCirc: function (x, t, b, c, d) {
        return c * Math.sqrt(1 - (t = t / d - 1) * t) + b
    },
    easeInOutCirc: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
        return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b
    },
    easeInElastic: function (x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) return b;
        if ((t /= d) == 1) return b + c;
        if (!p) p = d * .3;
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4
        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
        return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b
    },
    easeOutElastic: function (x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) return b;
        if ((t /= d) == 1) return b + c;
        if (!p) p = d * .3;
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4
        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
        return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b
    },
    easeInOutElastic: function (x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0) return b;
        if ((t /= d / 2) == 2) return b + c;
        if (!p) p = d * (.3 * 1.5);
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4
        } else var s = p / (2 * Math.PI) * Math.asin(c / a); if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
        return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b
    },
    easeInBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c * (t /= d) * t * ((s + 1) * t - s) + b
    },
    easeOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b
    },
    easeInOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
        return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b
    },
    easeInBounce: function (x, t, b, c, d) {
        return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b
    },
    easeOutBounce: function (x, t, b, c, d) {
        if ((t /= d) < (1 / 2.75)) {
            return c * (7.5625 * t * t) + b
        } else if (t < (2 / 2.75)) {
            return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b
        } else if (t < (2.5 / 2.75)) {
            return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b
        } else {
            return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b
        }
    },
    easeInOutBounce: function (x, t, b, c, d) {
        if (t < d / 2) return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b;
        return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b
    }
});
(function (e) {
    e.fn.superfish = function (t) {
        var n = e.fn.superfish,
            r = n.c,
            i = e(['<span class="', r.arrowClass, '"> <i class="fa-chevron-down"></i> </span>'].join("")),
            s = function () {
                var t = e(this),
                    n = u(t);
                clearTimeout(n.sfTimer);
                t.showSuperfishUl().siblings().hideSuperfishUl()
            }, o = function () {
                var t = e(this),
                    r = u(t),
                    i = n.op;
                clearTimeout(r.sfTimer);
                r.sfTimer = setTimeout(function () {
                    i.retainPath = e.inArray(t[0], i.$path) > -1;
                    t.hideSuperfishUl();
                    if (i.$path.length && t.parents(["li.", i.hoverClass].join("")).length < 1) {
                        s.call(i.$path)
                    }
                }, i.delay)
            }, u = function (e) {
                var t = e.parents(["ul.", r.menuClass, ":first"].join(""))[0];
                n.op = n.o[t.serial];
                return t
            }, a = function (e) {
                e.addClass(r.anchorClass).append(i.clone())
            };
        return this.each(function () {
            var i = this.serial = n.o.length;
            var u = e.extend({}, n.defaults, t);
            u.$path = e("li." + u.pathClass, this).slice(0, u.pathLevels).each(function () {
                e(this).addClass([u.hoverClass, r.bcClass].join(" ")).filter("li:has(ul)").removeClass(u.pathClass)
            });
            n.o[i] = n.op = u;
            e("li:has(ul)", this)[e.fn.hoverIntent && !u.disableHI ? "hoverIntent" : "hover"](s, o).each(function () {
                if (u.autoArrows) a(e(">a:first-child", this))
            }).not("." + r.bcClass).hideSuperfishUl();
            var f = e("a", this);
            f.each(function (e) {
                var t = f.eq(e).parents("li");
                f.eq(e).focus(function () {
                    s.call(t)
                }).blur(function () {
                    o.call(t)
                })
            });
            u.onInit.call(this)
        }).each(function () {
            var t = [r.menuClass];
            if (n.op.dropShadows && !(e.browser.msie && e.browser.version < 7)) t.push(r.shadowClass);
            e(this).addClass(t.join(" "))
        })
    };
    var t = e.fn.superfish;
    t.o = [];
    t.op = {};
    t.IE7fix = function () {
        var n = t.op;
        if (e.browser.msie && e.browser.version > 6 && n.dropShadows && n.animation.opacity != undefined) this.toggleClass(t.c.shadowClass + "-off")
    };
    t.c = {
        bcClass: "sf-breadcrumb",
        menuClass: "sf-js-enabled",
        anchorClass: "sf-with-ul",
        arrowClass: "sf-sub-indicator",
        shadowClass: "sf-shadow"
    };
    t.defaults = {
        hoverClass: "sfHover",
        pathClass: "overideThisToUse",
        pathLevels: 1,
        delay: 800,
        animation: {
            opacity: "show"
        },
        speed: "normal",
        autoArrows: true,
        dropShadows: true,
        disableHI: false,
        onInit: function () {},
        onBeforeShow: function () {},
        onShow: function () {},
        onHide: function () {}
    };
    e.fn.extend({
        hideSuperfishUl: function () {
            var n = t.op,
                r = n.retainPath === true ? n.$path : "";
            n.retainPath = false;
            var i = e(["li.", n.hoverClass].join(""), this).add(this).not(r).removeClass(n.hoverClass).find(">ul").hide().css("visibility", "hidden");
            n.onHide.call(i);
            return this
        },
        showSuperfishUl: function () {
            var e = t.op,
                n = t.c.shadowClass + "-off",
                r = this.addClass(e.hoverClass).find(">ul:hidden").css("visibility", "visible");
            t.IE7fix.call(r);
            e.onBeforeShow.call(r);
            r.animate(e.animation, e.speed, function () {
                t.IE7fix.call(r);
                e.onShow.call(r)
            });
            return this
        }
    })
})(jQuery);
(function (e) {
    e.fn.lavaLamp = function (t) {
        t = e.extend({
            fx: "swing",
            speed: 500,
            click: function () {
                return true
            },
            startItem: "no",
            autoReturn: true,
            returnDelay: 0,
            setOnClick: true,
            homeTop: 0,
            homeLeft: 0,
            homeWidth: 0,
            homeHeight: 0,
            returnHome: false
        }, t || {});
        var n;
        if (t.homeTop || t.homeLeft) {
            n = e('<li class="current"></li>').css({
                left: t.homeLeft,
                top: t.homeTop,
                width: t.homeWidth,
                height: t.homeHeight,
                position: "absolute"
            });
            e(this).prepend(n)
        }
        return this.each(function () {
            function l(n) {
                if (!n) n = a;
                var r = 0,
                    i = 0;
                if (!e.browser.msie) {
                    r = (u.outerWidth() - u.innerWidth()) / 2;
                    i = (u.outerHeight() - u.innerHeight()) / 2
                }
                u.stop().animate({
                    left: n.offsetLeft - r,
                    width: n.offsetWidth,
                    height: n.offsetHeight
                }, t.speed, t.fx)
            }
            var r = location.pathname + location.search + location.hash;
            var i = new Object;
            var s;
            var u;
            var a;
            e.expr[":"].parents = function (t, n, r) {
                return e(t).parents(r[3]).length < 1
            };
            var f = e("li", this).filter(":parents(ul ul, .sub-menu)");
            if (t.startItem == "no") i = e('li a[href$="' + r + '"]', this).parent("li");
            if (i.length == 0 && t.startItem == "no") i = e('li a[href$="' + location.pathname.substring(location.pathname.lastIndexOf("/") + 1) + location.search + location.hash + '"]', this).parent("li");
            if (i.length == 0 || t.startItem != "no") {
                if (t.startItem == "no") t.startItem = 0;
                i = e(f[t.startItem])
            }
            a = e("li.selectedLava", this)[0] || e(i).addClass("selectedLava")[0];
            f.mouseenter(function () {
                if (e(this).hasClass("homeLava")) {
                    a = e(this)[0]
                }
                l(this)
            });
            u = e('<li class="back"><div class="left"></div></li>').appendTo(this);
            e(this).mouseleave(function () {
                if (t.autoReturn) {
                    if (t.returnHome && n) {
                        l(n[0])
                    } else if (t.returnDelay) {
                        if (s) clearTimeout(s);
                        s = setTimeout(function () {
                            l(null)
                        }, t.returnDelay + t.speed)
                    } else {
                        l(null)
                    }
                }
            });
            f.click(function (n) {
                if (t.setOnClick) {
                    e(a).removeClass("selectedLava");
                    e(this).addClass("selectedLava");
                    a = this
                }
                return t.click.apply(this, [n, this])
            });
            if (t.homeTop || t.homeLeft) u.css({
                left: t.homeLeft,
                width: t.homeWidth,
                height: t.homeHeight
            });
            else u.css({
                left: a.offsetLeft,
                width: a.offsetWidth,
                height: a.offsetHeight
            })
        })
    }
})(jQuery);
jQuery.easing["jswing"] = jQuery.easing["swing"];
jQuery.extend(jQuery.easing, {
    def: "easeOutQuad",
    swing: function (e, t, n, r, i) {
        return jQuery.easing[jQuery.easing.def](e, t, n, r, i)
    },
    easeInQuad: function (e, t, n, r, i) {
        return r * (t /= i) * t + n
    },
    easeOutQuad: function (e, t, n, r, i) {
        return -r * (t /= i) * (t - 2) + n
    },
    easeInOutQuad: function (e, t, n, r, i) {
        if ((t /= i / 2) < 1) return r / 2 * t * t + n;
        return -r / 2 * (--t * (t - 2) - 1) + n
    },
    easeInCubic: function (e, t, n, r, i) {
        return r * (t /= i) * t * t + n
    },
    easeOutCubic: function (e, t, n, r, i) {
        return r * ((t = t / i - 1) * t * t + 1) + n
    },
    easeInOutCubic: function (e, t, n, r, i) {
        if ((t /= i / 2) < 1) return r / 2 * t * t * t + n;
        return r / 2 * ((t -= 2) * t * t + 2) + n
    },
    easeInQuart: function (e, t, n, r, i) {
        return r * (t /= i) * t * t * t + n
    },
    easeOutQuart: function (e, t, n, r, i) {
        return -r * ((t = t / i - 1) * t * t * t - 1) + n
    },
    easeInOutQuart: function (e, t, n, r, i) {
        if ((t /= i / 2) < 1) return r / 2 * t * t * t * t + n;
        return -r / 2 * ((t -= 2) * t * t * t - 2) + n
    },
    easeInQuint: function (e, t, n, r, i) {
        return r * (t /= i) * t * t * t * t + n
    },
    easeOutQuint: function (e, t, n, r, i) {
        return r * ((t = t / i - 1) * t * t * t * t + 1) + n
    },
    easeInOutQuint: function (e, t, n, r, i) {
        if ((t /= i / 2) < 1) return r / 2 * t * t * t * t * t + n;
        return r / 2 * ((t -= 2) * t * t * t * t + 2) + n
    },
    easeInSine: function (e, t, n, r, i) {
        return -r * Math.cos(t / i * (Math.PI / 2)) + r + n
    },
    easeOutSine: function (e, t, n, r, i) {
        return r * Math.sin(t / i * (Math.PI / 2)) + n
    },
    easeInOutSine: function (e, t, n, r, i) {
        return -r / 2 * (Math.cos(Math.PI * t / i) - 1) + n
    },
    easeInExpo: function (e, t, n, r, i) {
        return t == 0 ? n : r * Math.pow(2, 10 * (t / i - 1)) + n
    },
    easeOutExpo: function (e, t, n, r, i) {
        return t == i ? n + r : r * (-Math.pow(2, -10 * t / i) + 1) + n
    },
    easeInOutExpo: function (e, t, n, r, i) {
        if (t == 0) return n;
        if (t == i) return n + r;
        if ((t /= i / 2) < 1) return r / 2 * Math.pow(2, 10 * (t - 1)) + n;
        return r / 2 * (-Math.pow(2, -10 * --t) + 2) + n
    },
    easeInCirc: function (e, t, n, r, i) {
        return -r * (Math.sqrt(1 - (t /= i) * t) - 1) + n
    },
    easeOutCirc: function (e, t, n, r, i) {
        return r * Math.sqrt(1 - (t = t / i - 1) * t) + n
    },
    easeInOutCirc: function (e, t, n, r, i) {
        if ((t /= i / 2) < 1) return -r / 2 * (Math.sqrt(1 - t * t) - 1) + n;
        return r / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + n
    },
    easeInElastic: function (e, t, n, r, i) {
        var s = 1.70158;
        var o = 0;
        var u = r;
        if (t == 0) return n;
        if ((t /= i) == 1) return n + r;
        if (!o) o = i * .3;
        if (u < Math.abs(r)) {
            u = r;
            var s = o / 4
        } else var s = o / (2 * Math.PI) * Math.asin(r / u);
        return -(u * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o)) + n
    },
    easeOutElastic: function (e, t, n, r, i) {
        var s = 1.70158;
        var o = 0;
        var u = r;
        if (t == 0) return n;
        if ((t /= i) == 1) return n + r;
        if (!o) o = i * .3;
        if (u < Math.abs(r)) {
            u = r;
            var s = o / 4
        } else var s = o / (2 * Math.PI) * Math.asin(r / u);
        return u * Math.pow(2, -10 * t) * Math.sin((t * i - s) * 2 * Math.PI / o) + r + n
    },
    easeInOutElastic: function (e, t, n, r, i) {
        var s = 1.70158;
        var o = 0;
        var u = r;
        if (t == 0) return n;
        if ((t /= i / 2) == 2) return n + r;
        if (!o) o = i * .3 * 1.5;
        if (u < Math.abs(r)) {
            u = r;
            var s = o / 4
        } else var s = o / (2 * Math.PI) * Math.asin(r / u); if (t < 1) return -.5 * u * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o) + n;
        return u * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o) * .5 + r + n
    },
    easeInBack: function (e, t, n, r, i, s) {
        if (s == undefined) s = 1.70158;
        return r * (t /= i) * t * ((s + 1) * t - s) + n
    },
    easeOutBack: function (e, t, n, r, i, s) {
        if (s == undefined) s = 1.70158;
        return r * ((t = t / i - 1) * t * ((s + 1) * t + s) + 1) + n
    },
    easeInOutBack: function (e, t, n, r, i, s) {
        if (s == undefined) s = 1.70158;
        if ((t /= i / 2) < 1) return r / 2 * t * t * (((s *= 1.525) + 1) * t - s) + n;
        return r / 2 * ((t -= 2) * t * (((s *= 1.525) + 1) * t + s) + 2) + n
    },
    easeInBounce: function (e, t, n, r, i) {
        return r - jQuery.easing.easeOutBounce(e, i - t, 0, r, i) + n
    },
    easeOutBounce: function (e, t, n, r, i) {
        if ((t /= i) < 1 / 2.75) {
            return r * 7.5625 * t * t + n
        } else if (t < 2 / 2.75) {
            return r * (7.5625 * (t -= 1.5 / 2.75) * t + .75) + n
        } else if (t < 2.5 / 2.75) {
            return r * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) + n
        } else {
            return r * (7.5625 * (t -= 2.625 / 2.75) * t + .984375) + n
        }
    },
    easeInOutBounce: function (e, t, n, r, i) {
        if (t < i / 2) return jQuery.easing.easeInBounce(e, t * 2, 0, r, i) * .5 + n;
        return jQuery.easing.easeOutBounce(e, t * 2 - i, 0, r, i) * .5 + r * .5 + n
    }
});
(function (e) {
    e.fn.jflickrfeed = function (t, n) {
        t = e.extend(true, {
            flickrbase: "http://api.flickr.com/services/feeds/",
            feedapi: "photos_public.gne",
            limit: 20,
            qstrings: {
                lang: "en-us",
                format: "json",
                jsoncallback: "?"
            },
            cleanDescription: true,
            useTemplate: true,
            itemTemplate: "",
            itemCallback: function () {}
        }, t);
        var r = t.flickrbase + t.feedapi + "?";
        var i = true;
        for (var s in t.qstrings) {
            if (!i) r += "&";
            r += s + "=" + t.qstrings[s];
            i = false
        }
        return e(this).each(function () {
            var i = e(this);
            var s = this;
            e.getJSON(r, function (r) {
                e.each(r.items, function (e, n) {
                    if (e < t.limit) {
                        if (t.cleanDescription) {
                            var r = /<p>(.*?)<\/p>/g;
                            var o = n.description;
                            if (r.test(o)) {
                                n.description = o.match(r)[2];
                                if (n.description != undefined) n.description = n.description.replace("<p>", "").replace("</p>", "")
                            }
                        }
                        n["image_s"] = n.media.m.replace("_m", "_s");
                        n["image_t"] = n.media.m.replace("_m", "_t");
                        n["image_m"] = n.media.m.replace("_m", "_m");
                        n["image"] = n.media.m.replace("_m", "");
                        n["image_b"] = n.media.m.replace("_m", "_b");
                        delete n.media;
                        if (t.useTemplate) {
                            var u = t.itemTemplate;
                            for (var a in n) {
                                var f = new RegExp("{{" + a + "}}", "g");
                                u = u.replace(f, n[a])
                            }
                            i.append(u)
                        }
                        t.itemCallback.call(s, n)
                    }
                });
                if (e.isFunction(n)) {
                    n.call(s, r)
                }
            })
        })
    }
})(jQuery);
(function (e) {
    function t(t, n) {
        return parseInt(e.css(t[0], n)) || 0
    }

    function n(e) {
        return e[0].offsetWidth + t(e, "marginLeft") + t(e, "marginRight")
    }

    function r(e) {
        return e[0].offsetHeight + t(e, "marginTop") + t(e, "marginBottom")
    }
    e.fn.jCarouselLite = function (t) {
        t = e.extend({
            btnPrev: null,
            btnNext: null,
            btnGo: null,
            mouseWheel: false,
            auto: null,
            hoverPause: false,
            speed: 200,
            easing: null,
            vertical: false,
            circular: true,
            visible: 3,
            start: 0,
            scroll: 1,
            beforeStart: null,
            afterEnd: null
        }, t || {});
        return this.each(function () {
            function w() {
                E();
                b = setInterval(function () {
                    x(v + t.scroll)
                }, t.auto + t.speed)
            }

            function E() {
                clearInterval(b)
            }

            function S() {
                return p.slice(v).slice(0, h)
            }

            function x(n) {
                if (!i) {
                    if (t.beforeStart) t.beforeStart.call(this, S());
                    if (t.circular) {
                        if (n < 0) {
                            f.css(s, -((v + c) * m) + "px");
                            v = n + c
                        } else if (n > d - h) {
                            f.css(s, -((v - c) * m) + "px");
                            v = n - c
                        } else v = n
                    } else {
                        if (n < 0 || n > d - h) return;
                        else v = n
                    }
                    i = true;
                    f.animate(s == "left" ? {
                        left: -(v * m)
                    } : {
                        top: -(v * m)
                    }, t.speed, t.easing, function () {
                        if (t.afterEnd) t.afterEnd.call(this, S());
                        i = false
                    });
                    if (!t.circular) {
                        e(t.btnPrev + "," + t.btnNext).removeClass("disabled");
                        e(v - t.scroll < 0 && t.btnPrev || v + t.scroll > d - h && t.btnNext || []).addClass("disabled")
                    }
                }
                return false
            }
            var i = false,
                s = t.vertical ? "top" : "left",
                u = t.vertical ? "height" : "width";
            var a = e(this),
                f = e("ul", a),
                l = e("li", f),
                c = l.size(),
                h = t.visible;
            if (t.circular) {
                f.prepend(l.slice(c - h + 1).clone()).append(l.slice(0, t.scroll).clone());
                t.start += h - 1
            }
            var p = e("li", f),
                d = p.size(),
                v = t.start;
            a.css("visibility", "visible");
            p.css({
                overflow: "hidden",
                "float": t.vertical ? "none" : "left"
            });
            f.css({
                margin: "0",
                padding: "0",
                position: "relative",
                "list-style-type": "none",
                "z-index": "1"
            });
            a.css({
                overflow: "hidden",
                position: "relative",
                "z-index": "2",
                left: "0px"
            });
            var m = t.vertical ? r(p) : n(p);
            var g = m * d;
            var y = m * h;
            p.css({
                width: p.width(),
                height: p.height()
            });
            f.css(u, g + "px").css(s, -(v * m));
            a.css(u, y + "px");
            if (t.btnPrev) {
                e(t.btnPrev).click(function () {
                    return x(v - t.scroll)
                });
                if (t.hoverPause) {
                    e(t.btnPrev).hover(function () {
                        E()
                    }, function () {
                        w()
                    })
                }
            }
            if (t.btnNext) {
                e(t.btnNext).click(function () {
                    return x(v + t.scroll)
                });
                if (t.hoverPause) {
                    e(t.btnNext).hover(function () {
                        E()
                    }, function () {
                        w()
                    })
                }
            }
            if (t.btnGo) e.each(t.btnGo, function (n, r) {
                e(r).click(function () {
                    return x(t.circular ? t.visible + n : n)
                })
            });
            if (t.mouseWheel && a.mousewheel) a.mousewheel(function (e, n) {
                return n > 0 ? x(v - t.scroll) : x(v + t.scroll)
            });
            var b;
            if (t.auto) {
                if (t.hoverPause) {
                    a.hover(function () {
                        E()
                    }, function () {
                        w()
                    })
                }
                w()
            }
        })
    };
})(jQuery);
(function (e) {
    function t(e) {
        if (e.attr("title") || typeof e.attr("original-title") != "string") {
            e.attr("original-title", e.attr("title") || "").removeAttr("title")
        }
    }

    function n(n, r) {
        this.$element = e(n);
        this.options = r;
        this.enabled = true;
        t(this.$element)
    }
    n.prototype = {
        show: function () {
            var t = this.getTitle();
            if (t && this.enabled) {
                var n = this.tip();
                n.find(".tipsy-inner")[this.options.html ? "html" : "text"](t);
                n[0].className = "tipsy";
                n.remove().css({
                    top: 0,
                    left: 0,
                    visibility: "hidden",
                    display: "block"
                }).appendTo(document.body);
                var r = e.extend({}, this.$element.offset(), {
                    width: this.$element[0].offsetWidth,
                    height: this.$element[0].offsetHeight
                });
                var i = n[0].offsetWidth,
                    s = n[0].offsetHeight;
                var o = typeof this.options.gravity == "function" ? this.options.gravity.call(this.$element[0]) : this.options.gravity;
                var u;
                switch (o.charAt(0)) {
                case "n":
                    u = {
                        top: r.top + r.height + this.options.offset,
                        left: r.left + r.width / 2 - i / 2
                    };
                    break;
                case "s":
                    u = {
                        top: r.top - s - this.options.offset,
                        left: r.left + r.width / 2 - i / 2
                    };
                    break;
                case "e":
                    u = {
                        top: r.top + r.height / 2 - s / 2,
                        left: r.left - i - this.options.offset
                    };
                    break;
                case "w":
                    u = {
                        top: r.top + r.height / 2 - s / 2,
                        left: r.left + r.width + this.options.offset
                    };
                    break
                }
                if (o.length == 2) {
                    if (o.charAt(1) == "w") {
                        u.left = r.left + r.width / 2 - 15
                    } else {
                        u.left = r.left + r.width / 2 - i + 15
                    }
                }
                n.css(u).addClass("tipsy-" + o);
                if (this.options.fade) {
                    n.stop().css({
                        opacity: 0,
                        display: "block",
                        visibility: "visible"
                    }).animate({
                        opacity: this.options.opacity
                    })
                } else {
                    n.css({
                        visibility: "visible",
                        opacity: this.options.opacity
                    })
                }
            }
        },
        hide: function () {
            if (this.options.fade) {
                this.tip().stop().fadeOut(function () {
                    e(this).remove()
                })
            } else {
                this.tip().remove()
            }
        },
        getTitle: function () {
            var e, n = this.$element,
                r = this.options;
            t(n);
            var e, r = this.options;
            if (typeof r.title == "string") {
                e = n.attr(r.title == "title" ? "original-title" : r.title)
            } else if (typeof r.title == "function") {
                e = r.title.call(n[0])
            }
            e = ("" + e).replace(/(^\s*|\s*$)/, "");
            return e || r.fallback
        },
        tip: function () {
            if (!this.$tip) {
                this.$tip = e('<div class="tipsy"></div>').html('<div class="tipsy-arrow"></div><div class="tipsy-inner"/></div>')
            }
            return this.$tip
        },
        validate: function () {
            if (!this.$element[0].parentNode) {
                this.hide();
                this.$element = null;
                this.options = null
            }
        },
        enable: function () {
            this.enabled = true
        },
        disable: function () {
            this.enabled = false
        },
        toggleEnabled: function () {
            this.enabled = !this.enabled
        }
    };
    e.fn.tipsy = function (t) {
        function r(r) {
            var i = e.data(r, "tipsy");
            if (!i) {
                i = new n(r, e.fn.tipsy.elementOptions(r, t));
                e.data(r, "tipsy", i)
            }
            return i
        }

        function i() {
            var e = r(this);
            e.hoverState = "in";
            if (t.delayIn == 0) {
                e.show()
            } else {
                setTimeout(function () {
                    if (e.hoverState == "in") e.show()
                }, t.delayIn)
            }
        }

        function s() {
            var e = r(this);
            e.hoverState = "out";
            if (t.delayOut == 0) {
                e.hide()
            } else {
                setTimeout(function () {
                    if (e.hoverState == "out") e.hide()
                }, t.delayOut)
            }
        }
        if (t === true) {
            return this.data("tipsy")
        } else if (typeof t == "string") {
            return this.data("tipsy")[t]()
        }
        t = e.extend({}, e.fn.tipsy.defaults, t);
        if (!t.live) this.each(function () {
            r(this)
        });
        if (t.trigger != "manual") {
            var o = t.live ? "live" : "bind",
                u = t.trigger == "hover" ? "mouseenter" : "focus",
                a = t.trigger == "hover" ? "mouseleave" : "blur";
            this[o](u, i)[o](a, s)
        }
        return this
    };
    e.fn.tipsy.defaults = {
        delayIn: 0,
        delayOut: 0,
        fade: false,
        fallback: "",
        gravity: "n",
        html: false,
        live: false,
        offset: 0,
        opacity: 1,
        title: "title",
        trigger: "hover"
    };
    e.fn.tipsy.elementOptions = function (t, n) {
        return e.metadata ? e.extend({}, n, e(t).metadata()) : n
    };
    e.fn.tipsy.autoNS = function () {
        return e(this).offset().top > e(document).scrollTop() + e(window).height() / 2 ? "s" : "n"
    };
    e.fn.tipsy.autoWE = function () {
        return e(this).offset().left > e(document).scrollLeft() + e(window).width() / 2 ? "e" : "w"
    }
})(jQuery);
(function (e, t, n, r) {
    function d(t, n) {
        this.element = t;
        this.options = e.extend({}, s, n);
        this._defaults = s;
        this._name = i;
        this.init()
    }
    var i = "stellar",
        s = {
            scrollProperty: "scroll",
            positionProperty: "position",
            horizontalScrolling: true,
            verticalScrolling: true,
            horizontalOffset: 0,
            verticalOffset: 0,
            responsive: true,
            parallaxBackgrounds: true,
            parallaxElements: true,
            hideDistantElements: true,
            hideElement: function (e) {
                e.hide()
            },
            showElement: function (e) {
                e.show()
            }
        }, o = {
            scroll: {
                getLeft: function (e) {
                    return e.scrollLeft()
                },
                setLeft: function (e, t) {
                    e.scrollLeft(t)
                },
                getTop: function (e) {
                    return e.scrollTop()
                },
                setTop: function (e, t) {
                    e.scrollTop(t)
                }
            },
            position: {
                getLeft: function (e) {
                    return parseInt(e.css("left"), 10) * -1
                },
                getTop: function (e) {
                    return parseInt(e.css("top"), 10) * -1
                }
            },
            margin: {
                getLeft: function (e) {
                    return parseInt(e.css("margin-left"), 10) * -1
                },
                getTop: function (e) {
                    return parseInt(e.css("margin-top"), 10) * -1
                }
            },
            transform: {
                getLeft: function (e) {
                    var t = getComputedStyle(e[0])[f];
                    return t !== "none" ? parseInt(t.match(/(-?[0-9]+)/g)[4], 10) * -1 : 0
                },
                getTop: function (e) {
                    var t = getComputedStyle(e[0])[f];
                    return t !== "none" ? parseInt(t.match(/(-?[0-9]+)/g)[5], 10) * -1 : 0
                }
            }
        }, u = {
            position: {
                setLeft: function (e, t) {
                    e.css("left", t)
                },
                setTop: function (e, t) {
                    e.css("top", t)
                }
            },
            transform: {
                setPosition: function (e, t, n, r, i) {
                    e[0].style[f] = "translate3d(" + (t - n) + "px, " + (r - i) + "px, 0)"
                }
            }
        }, a = function () {
            var t = /^(Moz|Webkit|Khtml|O|ms|Icab)(?=[A-Z])/,
                n = e("script")[0].style,
                r = "",
                i;
            for (i in n) {
                if (t.test(i)) {
                    r = i.match(t)[0];
                    break
                }
            }
            if ("WebkitOpacity" in n) {
                r = "Webkit"
            }
            if ("KhtmlOpacity" in n) {
                r = "Khtml"
            }
            return function (e) {
                return r + (r.length > 0 ? e.charAt(0).toUpperCase() + e.slice(1) : e)
            }
        }(),
        f = a("transform"),
        l = e("<div />", {
            style: "background:#fff"
        }).css("background-position-x") !== r,
        c = l ? function (e, t, n) {
            e.css({
                "background-position-x": t,
                "background-position-y": n
            })
        } : function (e, t, n) {
            e.css("background-position", t + " " + n)
        }, h = l ? function (e) {
            return [e.css("background-position-x"), e.css("background-position-y")]
        } : function (e) {
            return e.css("background-position").split(" ")
        }, p = t.requestAnimationFrame || t.webkitRequestAnimationFrame || t.mozRequestAnimationFrame || t.oRequestAnimationFrame || t.msRequestAnimationFrame || function (e) {
            setTimeout(e, 1e3 / 60)
        };
    d.prototype = {
        init: function () {
            this.options.name = i + "_" + Math.floor(Math.random() * 1e9);
            this._defineElements();
            this._defineGetters();
            this._defineSetters();
            this._handleWindowLoadAndResize();
            this._detectViewport();
            this.refresh({
                firstLoad: true
            });
            if (this.options.scrollProperty === "scroll") {
                this._handleScrollEvent()
            } else {
                this._startAnimationLoop()
            }
        },
        _defineElements: function () {
            if (this.element === n.body) this.element = t;
            this.$scrollElement = e(this.element);
            this.$element = this.element === t ? e("body") : this.$scrollElement;
            this.$viewportElement = this.options.viewportElement !== r ? e(this.options.viewportElement) : this.$scrollElement[0] === t || this.options.scrollProperty === "scroll" ? this.$scrollElement : this.$scrollElement.parent()
        },
        _defineGetters: function () {
            var e = this,
                t = o[e.options.scrollProperty];
            this._getScrollLeft = function () {
                return t.getLeft(e.$scrollElement)
            };
            this._getScrollTop = function () {
                return t.getTop(e.$scrollElement)
            }
        },
        _defineSetters: function () {
            var t = this,
                n = o[t.options.scrollProperty],
                r = u[t.options.positionProperty],
                i = n.setLeft,
                s = n.setTop;
            this._setScrollLeft = typeof i === "function" ? function (e) {
                i(t.$scrollElement, e)
            } : e.noop;
            this._setScrollTop = typeof s === "function" ? function (e) {
                s(t.$scrollElement, e)
            } : e.noop;
            this._setPosition = r.setPosition || function (e, n, i, s, o) {
                if (t.options.horizontalScrolling) {
                    r.setLeft(e, n, i)
                }
                if (t.options.verticalScrolling) {
                    r.setTop(e, s, o)
                }
            }
        },
        _handleWindowLoadAndResize: function () {
            var n = this,
                r = e(t);
            if (n.options.responsive) {
                r.bind("load." + this.name, function () {
                    n.refresh()
                })
            }
            r.bind("resize." + this.name, function () {
                n._detectViewport();
                if (n.options.responsive) {
                    n.refresh()
                }
            })
        },
        refresh: function (n) {
            var r = this,
                i = r._getScrollLeft(),
                s = r._getScrollTop();
            if (!n || !n.firstLoad) {
                this._reset()
            }
            this._setScrollLeft(0);
            this._setScrollTop(0);
            this._setOffsets();
            this._findParticles();
            this._findBackgrounds();
            if (n && n.firstLoad && /WebKit/.test(navigator.userAgent)) {
                e(t).load(function () {
                    var e = r._getScrollLeft(),
                        t = r._getScrollTop();
                    r._setScrollLeft(e + 1);
                    r._setScrollTop(t + 1);
                    r._setScrollLeft(e);
                    r._setScrollTop(t)
                })
            }
            this._setScrollLeft(i);
            this._setScrollTop(s)
        },
        _detectViewport: function () {
            var e = this.$viewportElement.offset(),
                t = e !== null && e !== r;
            this.viewportWidth = this.$viewportElement.width();
            this.viewportHeight = this.$viewportElement.height();
            this.viewportOffsetTop = t ? e.top : 0;
            this.viewportOffsetLeft = t ? e.left : 0
        },
        _findParticles: function () {
            var t = this,
                n = this._getScrollLeft(),
                i = this._getScrollTop();
            if (this.particles !== r) {
                for (var s = this.particles.length - 1; s >= 0; s--) {
                    this.particles[s].$element.data("stellar-elementIsActive", r)
                }
            }
            this.particles = [];
            if (!this.options.parallaxElements) return;
            this.$element.find("[data-stellar-ratio]").each(function (n) {
                var i = e(this),
                    s, o, u, a, f, l, c, h, p, d = 0,
                    v = 0,
                    m = 0,
                    g = 0;
                if (!i.data("stellar-elementIsActive")) {
                    i.data("stellar-elementIsActive", this)
                } else if (i.data("stellar-elementIsActive") !== this) {
                    return
                }
                t.options.showElement(i);
                if (!i.data("stellar-startingLeft")) {
                    i.data("stellar-startingLeft", i.css("left"));
                    i.data("stellar-startingTop", i.css("top"))
                } else {
                    i.css("left", i.data("stellar-startingLeft"));
                    i.css("top", i.data("stellar-startingTop"))
                }
                u = i.position().left;
                a = i.position().top;
                f = i.css("margin-left") === "auto" ? 0 : parseInt(i.css("margin-left"), 10);
                l = i.css("margin-top") === "auto" ? 0 : parseInt(i.css("margin-top"), 10);
                h = i.offset().left - f;
                p = i.offset().top - l;
                i.parents().each(function () {
                    var t = e(this);
                    if (t.data("stellar-offset-parent") === true) {
                        d = m;
                        v = g;
                        c = t;
                        return false
                    } else {
                        m += t.position().left;
                        g += t.position().top
                    }
                });
                s = i.data("stellar-horizontal-offset") !== r ? i.data("stellar-horizontal-offset") : c !== r && c.data("stellar-horizontal-offset") !== r ? c.data("stellar-horizontal-offset") : t.horizontalOffset;
                o = i.data("stellar-vertical-offset") !== r ? i.data("stellar-vertical-offset") : c !== r && c.data("stellar-vertical-offset") !== r ? c.data("stellar-vertical-offset") : t.verticalOffset;
                t.particles.push({
                    $element: i,
                    $offsetParent: c,
                    isFixed: i.css("position") === "fixed",
                    horizontalOffset: s,
                    verticalOffset: o,
                    startingPositionLeft: u,
                    startingPositionTop: a,
                    startingOffsetLeft: h,
                    startingOffsetTop: p,
                    parentOffsetLeft: d,
                    parentOffsetTop: v,
                    stellarRatio: i.data("stellar-ratio") !== r ? i.data("stellar-ratio") : 1,
                    width: i.outerWidth(true),
                    height: i.outerHeight(true),
                    isHidden: false
                })
            })
        },
        _findBackgrounds: function () {
            var t = this,
                n = this._getScrollLeft(),
                i = this._getScrollTop(),
                s;
            this.backgrounds = [];
            if (!this.options.parallaxBackgrounds) return;
            s = this.$element.find("[data-stellar-background-ratio]");
            if (this.$element.data("stellar-background-ratio")) {
                s = s.add(this.$element)
            }
            s.each(function () {
                var s = e(this),
                    o = h(s),
                    u, a, f, l, p, d, v, m, g, y = 0,
                    b = 0,
                    w = 0,
                    E = 0;
                if (!s.data("stellar-backgroundIsActive")) {
                    s.data("stellar-backgroundIsActive", this)
                } else if (s.data("stellar-backgroundIsActive") !== this) {
                    return
                }
                if (!s.data("stellar-backgroundStartingLeft")) {
                    s.data("stellar-backgroundStartingLeft", o[0]);
                    s.data("stellar-backgroundStartingTop", o[1])
                } else {
                    c(s, s.data("stellar-backgroundStartingLeft"), s.data("stellar-backgroundStartingTop"))
                }
                p = s.css("margin-left") === "auto" ? 0 : parseInt(s.css("margin-left"), 10);
                d = s.css("margin-top") === "auto" ? 0 : parseInt(s.css("margin-top"), 10);
                v = s.offset().left - p - n;
                m = s.offset().top - d - i;
                s.parents().each(function () {
                    var t = e(this);
                    if (t.data("stellar-offset-parent") === true) {
                        y = w;
                        b = E;
                        g = t;
                        return false
                    } else {
                        w += t.position().left;
                        E += t.position().top
                    }
                });
                u = s.data("stellar-horizontal-offset") !== r ? s.data("stellar-horizontal-offset") : g !== r && g.data("stellar-horizontal-offset") !== r ? g.data("stellar-horizontal-offset") : t.horizontalOffset;
                a = s.data("stellar-vertical-offset") !== r ? s.data("stellar-vertical-offset") : g !== r && g.data("stellar-vertical-offset") !== r ? g.data("stellar-vertical-offset") : t.verticalOffset;
                t.backgrounds.push({
                    $element: s,
                    $offsetParent: g,
                    isFixed: s.css("background-attachment") === "fixed",
                    horizontalOffset: u,
                    verticalOffset: a,
                    startingValueLeft: o[0],
                    startingValueTop: o[1],
                    startingBackgroundPositionLeft: isNaN(parseInt(o[0], 10)) ? 0 : parseInt(o[0], 10),
                    startingBackgroundPositionTop: isNaN(parseInt(o[1], 10)) ? 0 : parseInt(o[1], 10),
                    startingPositionLeft: s.position().left,
                    startingPositionTop: s.position().top,
                    startingOffsetLeft: v,
                    startingOffsetTop: m,
                    parentOffsetLeft: y,
                    parentOffsetTop: b,
                    stellarRatio: s.data("stellar-background-ratio") === r ? 1 : s.data("stellar-background-ratio")
                })
            })
        },
        _reset: function () {
            var e, t, n, r, i;
            for (i = this.particles.length - 1; i >= 0; i--) {
                e = this.particles[i];
                t = e.$element.data("stellar-startingLeft");
                n = e.$element.data("stellar-startingTop");
                this._setPosition(e.$element, t, t, n, n);
                this.options.showElement(e.$element);
                e.$element.data("stellar-startingLeft", null).data("stellar-elementIsActive", null).data("stellar-backgroundIsActive", null)
            }
            for (i = this.backgrounds.length - 1; i >= 0; i--) {
                r = this.backgrounds[i];
                r.$element.data("stellar-backgroundStartingLeft", null).data("stellar-backgroundStartingTop", null);
                c(r.$element, r.startingValueLeft, r.startingValueTop)
            }
        },
        destroy: function () {
            this._reset();
            this.$scrollElement.unbind("resize." + this.name).unbind("scroll." + this.name);
            this._animationLoop = e.noop;
            e(t).unbind("load." + this.name).unbind("resize." + this.name)
        },
        _setOffsets: function () {
            var n = this,
                r = e(t);
            r.unbind("resize.horizontal-" + this.name).unbind("resize.vertical-" + this.name);
            if (typeof this.options.horizontalOffset === "function") {
                this.horizontalOffset = this.options.horizontalOffset();
                r.bind("resize.horizontal-" + this.name, function () {
                    n.horizontalOffset = n.options.horizontalOffset()
                })
            } else {
                this.horizontalOffset = this.options.horizontalOffset
            } if (typeof this.options.verticalOffset === "function") {
                this.verticalOffset = this.options.verticalOffset();
                r.bind("resize.vertical-" + this.name, function () {
                    n.verticalOffset = n.options.verticalOffset()
                })
            } else {
                this.verticalOffset = this.options.verticalOffset
            }
        },
        _repositionElements: function () {
            var e = this._getScrollLeft(),
                t = this._getScrollTop(),
                n, r, i, s, o, u, a, f = true,
                l = true,
                h, p, d, v, m;
            if (this.currentScrollLeft === e && this.currentScrollTop === t && this.currentWidth === this.viewportWidth && this.currentHeight === this.viewportHeight) {
                return
            } else {
                this.currentScrollLeft = e;
                this.currentScrollTop = t;
                this.currentWidth = this.viewportWidth;
                this.currentHeight = this.viewportHeight
            }
            for (m = this.particles.length - 1; m >= 0; m--) {
                i = this.particles[m];
                s = i.isFixed ? 1 : 0;
                if (this.options.horizontalScrolling) {
                    h = (e + i.horizontalOffset + this.viewportOffsetLeft + i.startingPositionLeft - i.startingOffsetLeft + i.parentOffsetLeft) * -(i.stellarRatio + s - 1) + i.startingPositionLeft;
                    d = h - i.startingPositionLeft + i.startingOffsetLeft
                } else {
                    h = i.startingPositionLeft;
                    d = i.startingOffsetLeft
                } if (this.options.verticalScrolling) {
                    p = (t + i.verticalOffset + this.viewportOffsetTop + i.startingPositionTop - i.startingOffsetTop + i.parentOffsetTop) * -(i.stellarRatio + s - 1) + i.startingPositionTop;
                    v = p - i.startingPositionTop + i.startingOffsetTop
                } else {
                    p = i.startingPositionTop;
                    v = i.startingOffsetTop
                } if (this.options.hideDistantElements) {
                    l = !this.options.horizontalScrolling || d + i.width > (i.isFixed ? 0 : e) && d < (i.isFixed ? 0 : e) + this.viewportWidth + this.viewportOffsetLeft;
                    f = !this.options.verticalScrolling || v + i.height > (i.isFixed ? 0 : t) && v < (i.isFixed ? 0 : t) + this.viewportHeight + this.viewportOffsetTop
                }
                if (l && f) {
                    if (i.isHidden) {
                        this.options.showElement(i.$element);
                        i.isHidden = false
                    }
                    this._setPosition(i.$element, h, i.startingPositionLeft, p, i.startingPositionTop)
                } else {
                    if (!i.isHidden) {
                        this.options.hideElement(i.$element);
                        i.isHidden = true
                    }
                }
            }
            for (m = this.backgrounds.length - 1; m >= 0; m--) {
                o = this.backgrounds[m];
                s = o.isFixed ? 0 : 1;
                u = this.options.horizontalScrolling ? (e + o.horizontalOffset - this.viewportOffsetLeft - o.startingOffsetLeft + o.parentOffsetLeft - o.startingBackgroundPositionLeft) * (s - o.stellarRatio) + "px" : o.startingValueLeft;
                a = this.options.verticalScrolling ? (t + o.verticalOffset - this.viewportOffsetTop - o.startingOffsetTop + o.parentOffsetTop - o.startingBackgroundPositionTop) * (s - o.stellarRatio) + "px" : o.startingValueTop;
                c(o.$element, u, a)
            }
        },
        _handleScrollEvent: function () {
            var e = this,
                t = false;
            var n = function () {
                e._repositionElements();
                t = false
            };
            var r = function () {
                if (!t) {
                    p(n);
                    t = true
                }
            };
            this.$scrollElement.bind("scroll." + this.name, r);
            r()
        },
        _startAnimationLoop: function () {
            var e = this;
            this._animationLoop = function () {
                p(e._animationLoop);
                e._repositionElements()
            };
            this._animationLoop()
        }
    };
    e.fn[i] = function (t) {
        var n = arguments;
        if (t === r || typeof t === "object") {
            return this.each(function () {
                if (!e.data(this, "plugin_" + i)) {
                    e.data(this, "plugin_" + i, new d(this, t))
                }
            })
        } else if (typeof t === "string" && t[0] !== "_" && t !== "init") {
            return this.each(function () {
                var r = e.data(this, "plugin_" + i);
                if (r instanceof d && typeof r[t] === "function") {
                    r[t].apply(r, Array.prototype.slice.call(n, 1))
                }
                if (t === "destroy") {
                    e.data(this, "plugin_" + i, null)
                }
            })
        }
    };
    e[i] = function (n) {
        var r = e(t);
        return r.stellar.apply(r, Array.prototype.slice.call(arguments, 0))
    };
    e[i].scrollProperty = o;
    e[i].positionProperty = u;
    t.Stellar = d
})(jQuery, this, document);
(function (c, b) {
    var a = a || function (k) {
            var f = {
                element: null,
                dragger: null,
                disable: "none",
                addBodyClasses: true,
                hyperextensible: true,
                resistance: 0.5,
                flickThreshold: 50,
                transitionSpeed: 0.3,
                easing: "ease",
                maxPosition: 266,
                minPosition: -266,
                tapToClose: true,
                touchToDrag: true,
                slideIntent: 40,
                minDragDistance: 5
            }, e = {
                    simpleStates: {
                        opening: null,
                        towards: null,
                        hyperExtending: null,
                        halfway: null,
                        flick: null,
                        translation: {
                            absolute: 0,
                            relative: 0,
                            sinceDirectionChange: 0,
                            percentage: 0
                        }
                    }
                }, h = {}, d = {
                    hasTouch: (b.ontouchstart === null),
                    eventType: function (m) {
                        var l = {
                            down: (d.hasTouch ? "touchstart" : "mousedown"),
                            move: (d.hasTouch ? "touchmove" : "mousemove"),
                            up: (d.hasTouch ? "touchend" : "mouseup"),
                            out: (d.hasTouch ? "touchcancel" : "mouseout")
                        };
                        return l[m]
                    },
                    page: function (l, m) {
                        return (d.hasTouch && m.touches.length && m.touches[0]) ? m.touches[0]["page" + l] : m["page" + l]
                    },
                    klass: {
                        has: function (m, l) {
                            return (m.className).indexOf(l) !== -1
                        },
                        add: function (m, l) {
                            if (!d.klass.has(m, l) && f.addBodyClasses) {
                                m.className += " " + l
                            }
                        },
                        remove: function (m, l) {
                            if (f.addBodyClasses) {
                                m.className = (m.className).replace(l, "").replace(/^\s+|\s+$/g, "")
                            }
                        }
                    },
                    dispatchEvent: function (l) {
                        if (typeof h[l] === "function") {
                            return h[l].call()
                        }
                    },
                    vendor: function () {
                        var m = b.createElement("div"),
                            n = "webkit Moz O ms".split(" "),
                            l;
                        for (l in n) {
                            if (typeof m.style[n[l] + "Transition"] !== "undefined") {
                                return n[l]
                            }
                        }
                    },
                    transitionCallback: function () {
                        return (e.vendor === "Moz" || e.vendor === "ms") ? "transitionend" : e.vendor + "TransitionEnd"
                    },
                    canTransform: function () {
                        return typeof f.element.style[e.vendor + "Transform"] !== "undefined"
                    },
                    deepExtend: function (l, n) {
                        var m;
                        for (m in n) {
                            if (n[m] && n[m].constructor && n[m].constructor === Object) {
                                l[m] = l[m] || {};
                                d.deepExtend(l[m], n[m])
                            } else {
                                l[m] = n[m]
                            }
                        }
                        return l
                    },
                    angleOfDrag: function (l, o) {
                        var n, m;
                        m = Math.atan2(-(e.startDragY - o), (e.startDragX - l));
                        if (m < 0) {
                            m += 2 * Math.PI
                        }
                        n = Math.floor(m * (180 / Math.PI) - 180);
                        if (n < 0 && n > -180) {
                            n = 360 - Math.abs(n)
                        }
                        return Math.abs(n)
                    },
                    events: {
                        addEvent: function g(m, l, n) {
                            if (m.addEventListener) {
                                return m.addEventListener(l, n, false)
                            } else {
                                if (m.attachEvent) {
                                    return m.attachEvent("on" + l, n)
                                }
                            }
                        },
                        removeEvent: function g(m, l, n) {
                            if (m.addEventListener) {
                                return m.removeEventListener(l, n, false)
                            } else {
                                if (m.attachEvent) {
                                    return m.detachEvent("on" + l, n)
                                }
                            }
                        },
                        prevent: function (l) {
                            if (l.preventDefault) {
                                l.preventDefault()
                            } else {
                                l.returnValue = false
                            }
                        }
                    },
                    parentUntil: function (n, l) {
                        var m = typeof l === "string";
                        while (n.parentNode) {
                            if (m && n.getAttribute && n.getAttribute(l)) {
                                return n
                            } else {
                                if (!m && n === l) {
                                    return n
                                }
                            }
                            n = n.parentNode
                        }
                        return null
                    }
                }, i = {
                    translate: {
                        get: {
                            matrix: function (n) {
                                if (!d.canTransform()) {
                                    return parseInt(f.element.style.left, 10)
                                } else {
                                    var m = c.getComputedStyle(f.element)[e.vendor + "Transform"].match(/\((.*)\)/),
                                        l = 8;
                                    if (m) {
                                        m = m[1].split(",");
                                        if (m.length === 16) {
                                            n += l
                                        }
                                        return parseInt(m[n], 10)
                                    }
                                    return 0
                                }
                            }
                        },
                        easeCallback: function () {
                            f.element.style[e.vendor + "Transition"] = "";
                            e.translation = i.translate.get.matrix(4);
                            e.easing = false;
                            clearInterval(e.animatingInterval);
                            if (e.easingTo === 0) {
                                d.klass.remove(b.body, "snapjs-right");
                                d.klass.remove(b.body, "snapjs-left")
                            }
                            d.dispatchEvent("animated");
                            d.events.removeEvent(f.element, d.transitionCallback(), i.translate.easeCallback)
                        },
                        easeTo: function (l) {
                            if (!d.canTransform()) {
                                e.translation = l;
                                i.translate.x(l)
                            } else {
                                e.easing = true;
                                e.easingTo = l;
                                f.element.style[e.vendor + "Transition"] = "all " + f.transitionSpeed + "s " + f.easing;
                                e.animatingInterval = setInterval(function () {
                                    d.dispatchEvent("animating")
                                }, 1);
                                d.events.addEvent(f.element, d.transitionCallback(), i.translate.easeCallback);
                                i.translate.x(l)
                            } if (l === 0) {
                                f.element.style[e.vendor + "Transform"] = ""
                            }
                        },
                        x: function (m) {
                            if ((f.disable === "left" && m > 0) || (f.disable === "right" && m < 0)) {
                                return
                            }
                            if (!f.hyperextensible) {
                                if (m === f.maxPosition || m > f.maxPosition) {
                                    m = f.maxPosition
                                } else {
                                    if (m === f.minPosition || m < f.minPosition) {
                                        m = f.minPosition
                                    }
                                }
                            }
                            m = parseInt(m, 10);
                            if (isNaN(m)) {
                                m = 0
                            }
                            if (d.canTransform()) {
                                var l = "translate3d(" + m + "px, 0,0)";
                                f.element.style[e.vendor + "Transform"] = l
                            } else {
                                f.element.style.width = (c.innerWidth || b.documentElement.clientWidth) + "px";
                                f.element.style.left = m + "px";
                                f.element.style.right = ""
                            }
                        }
                    },
                    drag: {
                        listen: function () {
                            e.translation = 0;
                            e.easing = false;
                            d.events.addEvent(f.element, d.eventType("down"), i.drag.startDrag);
                            d.events.addEvent(f.element, d.eventType("move"), i.drag.dragging);
                            d.events.addEvent(f.element, d.eventType("up"), i.drag.endDrag)
                        },
                        stopListening: function () {
                            d.events.removeEvent(f.element, d.eventType("down"), i.drag.startDrag);
                            d.events.removeEvent(f.element, d.eventType("move"), i.drag.dragging);
                            d.events.removeEvent(f.element, d.eventType("up"), i.drag.endDrag)
                        },
                        startDrag: function (n) {
                            var m = n.target ? n.target : n.srcElement,
                                l = d.parentUntil(m, "data-snap-ignore");
                            if (l) {
                                d.dispatchEvent("ignore");
                                return
                            }
                            if (f.dragger) {
                                var o = d.parentUntil(m, f.dragger);
                                if (!o && (e.translation !== f.minPosition && e.translation !== f.maxPosition)) {
                                    return
                                }
                            }
                            d.dispatchEvent("start");
                            f.element.style[e.vendor + "Transition"] = "";
                            e.isDragging = true;
                            e.hasIntent = null;
                            e.intentChecked = false;
                            e.startDragX = d.page("X", n);
                            e.startDragY = d.page("Y", n);
                            e.dragWatchers = {
                                current: 0,
                                last: 0,
                                hold: 0,
                                state: ""
                            };
                            e.simpleStates = {
                                opening: null,
                                towards: null,
                                hyperExtending: null,
                                halfway: null,
                                flick: null,
                                translation: {
                                    absolute: 0,
                                    relative: 0,
                                    sinceDirectionChange: 0,
                                    percentage: 0
                                }
                            }
                        },
                        dragging: function (s) {
                            if (e.isDragging && f.touchToDrag) {
                                var v = d.page("X", s),
                                    u = d.page("Y", s),
                                    t = e.translation,
                                    o = i.translate.get.matrix(4),
                                    n = v - e.startDragX,
                                    p = o > 0,
                                    q = n,
                                    w;
                                if ((e.intentChecked && !e.hasIntent)) {
                                    return
                                }
                                if (f.addBodyClasses) {
                                    if ((o) > 0) {
                                        d.klass.add(b.body, "snapjs-left");
                                        d.klass.remove(b.body, "snapjs-right")
                                    } else {
                                        if ((o) < 0) {
                                            d.klass.add(b.body, "snapjs-right");
                                            d.klass.remove(b.body, "snapjs-left")
                                        }
                                    }
                                }
                                if (e.hasIntent === false || e.hasIntent === null) {
                                    var m = d.angleOfDrag(v, u),
                                        l = (m >= 0 && m <= f.slideIntent) || (m <= 360 && m > (360 - f.slideIntent)),
                                        r = (m >= 180 && m <= (180 + f.slideIntent)) || (m <= 180 && m >= (180 - f.slideIntent));
                                    if (!r && !l) {
                                        e.hasIntent = false
                                    } else {
                                        e.hasIntent = true
                                    }
                                    e.intentChecked = true
                                }
                                if ((f.minDragDistance >= Math.abs(v - e.startDragX)) || (e.hasIntent === false)) {
                                    return
                                }
                                d.events.prevent(s);
                                d.dispatchEvent("drag");
                                e.dragWatchers.current = v;
                                if (e.dragWatchers.last > v) {
                                    if (e.dragWatchers.state !== "left") {
                                        e.dragWatchers.state = "left";
                                        e.dragWatchers.hold = v
                                    }
                                    e.dragWatchers.last = v
                                } else {
                                    if (e.dragWatchers.last < v) {
                                        if (e.dragWatchers.state !== "right") {
                                            e.dragWatchers.state = "right";
                                            e.dragWatchers.hold = v
                                        }
                                        e.dragWatchers.last = v
                                    }
                                } if (p) {
                                    if (f.maxPosition < o) {
                                        w = (o - f.maxPosition) * f.resistance;
                                        q = n - w
                                    }
                                    e.simpleStates = {
                                        opening: "left",
                                        towards: e.dragWatchers.state,
                                        hyperExtending: f.maxPosition < o,
                                        halfway: o > (f.maxPosition / 2),
                                        flick: Math.abs(e.dragWatchers.current - e.dragWatchers.hold) > f.flickThreshold,
                                        translation: {
                                            absolute: o,
                                            relative: n,
                                            sinceDirectionChange: (e.dragWatchers.current - e.dragWatchers.hold),
                                            percentage: (o / f.maxPosition) * 100
                                        }
                                    }
                                } else {
                                    if (f.minPosition > o) {
                                        w = (o - f.minPosition) * f.resistance;
                                        q = n - w
                                    }
                                    e.simpleStates = {
                                        opening: "right",
                                        towards: e.dragWatchers.state,
                                        hyperExtending: f.minPosition > o,
                                        halfway: o < (f.minPosition / 2),
                                        flick: Math.abs(e.dragWatchers.current - e.dragWatchers.hold) > f.flickThreshold,
                                        translation: {
                                            absolute: o,
                                            relative: n,
                                            sinceDirectionChange: (e.dragWatchers.current - e.dragWatchers.hold),
                                            percentage: (o / f.minPosition) * 100
                                        }
                                    }
                                }
                                i.translate.x(q + t)
                            }
                        },
                        endDrag: function (m) {
                            if (e.isDragging) {
                                d.dispatchEvent("end");
                                var l = i.translate.get.matrix(4);
                                if (e.dragWatchers.current === 0 && l !== 0 && f.tapToClose) {
                                    d.dispatchEvent("close");
                                    d.events.prevent(m);
                                    i.translate.easeTo(0);
                                    e.isDragging = false;
                                    e.startDragX = 0;
                                    return
                                }
                                if (e.simpleStates.opening === "left") {
                                    if ((e.simpleStates.halfway || e.simpleStates.hyperExtending || e.simpleStates.flick)) {
                                        if (e.simpleStates.flick && e.simpleStates.towards === "left") {
                                            i.translate.easeTo(0)
                                        } else {
                                            if ((e.simpleStates.flick && e.simpleStates.towards === "right") || (e.simpleStates.halfway || e.simpleStates.hyperExtending)) {
                                                i.translate.easeTo(f.maxPosition)
                                            }
                                        }
                                    } else {
                                        i.translate.easeTo(0)
                                    }
                                } else {
                                    if (e.simpleStates.opening === "right") {
                                        if ((e.simpleStates.halfway || e.simpleStates.hyperExtending || e.simpleStates.flick)) {
                                            if (e.simpleStates.flick && e.simpleStates.towards === "right") {
                                                i.translate.easeTo(0)
                                            } else {
                                                if ((e.simpleStates.flick && e.simpleStates.towards === "left") || (e.simpleStates.halfway || e.simpleStates.hyperExtending)) {
                                                    i.translate.easeTo(f.minPosition)
                                                }
                                            }
                                        } else {
                                            i.translate.easeTo(0)
                                        }
                                    }
                                }
                                e.isDragging = false;
                                e.startDragX = d.page("X", m)
                            }
                        }
                    }
                }, j = function (l) {
                    if (l.element) {
                        d.deepExtend(f, l);
                        e.vendor = d.vendor();
                        i.drag.listen()
                    }
                };
            this.open = function (l) {
                d.dispatchEvent("open");
                d.klass.remove(b.body, "snapjs-expand-left");
                d.klass.remove(b.body, "snapjs-expand-right");
                if (l === "left") {
                    e.simpleStates.opening = "left";
                    e.simpleStates.towards = "right";
                    d.klass.add(b.body, "snapjs-left");
                    d.klass.remove(b.body, "snapjs-right");
                    i.translate.easeTo(f.maxPosition)
                } else {
                    if (l === "right") {
                        e.simpleStates.opening = "right";
                        e.simpleStates.towards = "left";
                        d.klass.remove(b.body, "snapjs-left");
                        d.klass.add(b.body, "snapjs-right");
                        i.translate.easeTo(f.minPosition)
                    }
                }
            };
            this.close = function () {
                d.dispatchEvent("close");
                i.translate.easeTo(0)
            };
            this.expand = function (l) {
                var m = c.innerWidth || b.documentElement.clientWidth;
                if (l === "left") {
                    d.dispatchEvent("expandLeft");
                    d.klass.add(b.body, "snapjs-expand-left");
                    d.klass.remove(b.body, "snapjs-expand-right")
                } else {
                    d.dispatchEvent("expandRight");
                    d.klass.add(b.body, "snapjs-expand-right");
                    d.klass.remove(b.body, "snapjs-expand-left");
                    m *= -1
                }
                i.translate.easeTo(m)
            };
            this.on = function (l, m) {
                h[l] = m;
                return this
            };
            this.off = function (l) {
                if (h[l]) {
                    h[l] = false
                }
            };
            this.enable = function () {
                d.dispatchEvent("enable");
                i.drag.listen()
            };
            this.disable = function () {
                d.dispatchEvent("disable");
                i.drag.stopListening()
            };
            this.settings = function (l) {
                d.deepExtend(f, l)
            };
            this.state = function () {
                var l, m = i.translate.get.matrix(4);
                if (m === f.maxPosition) {
                    l = "left"
                } else {
                    if (m === f.minPosition) {
                        l = "right"
                    } else {
                        l = "closed"
                    }
                }
                return {
                    state: l,
                    info: e.simpleStates
                }
            };
            j(k)
        };
    if ((typeof module !== "undefined") && module.exports) {
        module.exports = a
    }
    if (typeof ender === "undefined") {
        this.Snap = a
    }
    if ((typeof define === "function") && define.amd) {
        define("snap", [], function () {
            return a
        })
    }
}).call(this, window, document);
(function (e) {
    e.fn.countdown = function (t, n) {
        function i() {
            eventDate = Date.parse(r["date"]) / 1e3;
            currentDate = Math.floor(e.now() / 1e3);
            if (eventDate <= currentDate) {
                n.call(this);
                clearInterval(interval)
            }
            seconds = eventDate - currentDate;
            days = Math.floor(seconds / (60 * 60 * 24));
            seconds -= days * 60 * 60 * 24;
            hours = Math.floor(seconds / (60 * 60));
            seconds -= hours * 60 * 60;
            minutes = Math.floor(seconds / 60);
            seconds -= minutes * 60;
            if (days == 1) {
                thisEl.find(".timeRefDays").text("day")
            } else {
                thisEl.find(".timeRefDays").text("days")
            } if (hours == 1) {
                thisEl.find(".timeRefHours").text("hour")
            } else {
                thisEl.find(".timeRefHours").text("hours")
            } if (minutes == 1) {
                thisEl.find(".timeRefMinutes").text("minute")
            } else {
                thisEl.find(".timeRefMinutes").text("minutes")
            } if (seconds == 1) {
                thisEl.find(".timeRefSeconds").text("second")
            } else {
                thisEl.find(".timeRefSeconds").text("seconds")
            } if (r["format"] == "on") {
                days = String(days).length >= 2 ? days : "0" + days;
                hours = String(hours).length >= 2 ? hours : "0" + hours;
                minutes = String(minutes).length >= 2 ? minutes : "0" + minutes;
                seconds = String(seconds).length >= 2 ? seconds : "0" + seconds
            }
            if (!isNaN(eventDate)) {
                thisEl.find(".days").text(days);
                thisEl.find(".hours").text(hours);
                thisEl.find(".minutes").text(minutes);
                thisEl.find(".seconds").text(seconds)
            } else {
                alert("Invalid date. Here's an example: 12 Tuesday 2012 17:30:00");
                clearInterval(interval)
            }
        }
        thisEl = e(this);
        var r = {
            date: null,
            format: null
        };
        if (t) {
            e.extend(r, t)
        }
        i();
        interval = setInterval(i, 1e3)
    }
})(jQuery);

function ssc_init() {
    if (!document.body) return;
    var e = document.body;
    var t = document.documentElement;
    var n = window.innerHeight;
    var r = e.scrollHeight;
    ssc_root = document.compatMode.indexOf("CSS") >= 0 ? t : e;
    ssc_activeElement = e;
    ssc_initdone = true;
    if (top != self) {
        ssc_frame = true
    } else if (r > n && (e.offsetHeight <= n || t.offsetHeight <= n)) {
        ssc_root.style.height = "auto";
        if (ssc_root.offsetHeight <= n) {
            var i = document.createElement("div");
            i.style.clear = "both";
            e.appendChild(i)
        }
    }
    if (!ssc_fixedback) {
        e.style.backgroundAttachment = "scroll";
        t.style.backgroundAttachment = "scroll"
    }
    if (ssc_keyboardsupport) {
        ssc_addEvent("keydown", ssc_keydown)
    }
}

function ssc_scrollArray(e, t, n, r) {
    r || (r = 1e3);
    ssc_directionCheck(t, n);
    ssc_que.push({
        x: t,
        y: n,
        lastX: t < 0 ? .99 : -.99,
        lastY: n < 0 ? .99 : -.99,
        start: +(new Date)
    });
    if (ssc_pending) {
        return
    }
    var i = function () {
        var s = +(new Date);
        var o = 0;
        var u = 0;
        for (var a = 0; a < ssc_que.length; a++) {
            var f = ssc_que[a];
            var l = s - f.start;
            var c = l >= ssc_animtime;
            var h = c ? 1 : l / ssc_animtime;
            if (ssc_pulseAlgorithm) {
                h = ssc_pulse(h)
            }
            var p = f.x * h - f.lastX >> 0;
            var d = f.y * h - f.lastY >> 0;
            o += p;
            u += d;
            f.lastX += p;
            f.lastY += d;
            if (c) {
                ssc_que.splice(a, 1);
                a--
            }
        }
        if (t) {
            var v = e.scrollLeft;
            e.scrollLeft += o;
            if (o && e.scrollLeft === v) {
                t = 0
            }
        }
        if (n) {
            var m = e.scrollTop;
            e.scrollTop += u;
            if (u && e.scrollTop === m) {
                n = 0
            }
        }
        if (!t && !n) {
            ssc_que = []
        }
        if (ssc_que.length) {
            setTimeout(i, r / ssc_framerate + 1)
        } else {
            ssc_pending = false
        }
    };
    setTimeout(i, 0);
    ssc_pending = true
}

function init() {}

function ssc_wheel(e) {
    if (!ssc_initdone) {
        init()
    }
    var t = e.target;
    var n = ssc_overflowingAncestor(t);
    if (!n || e.defaultPrevented || ssc_isNodeName(t, "embed") && /\.pdf/i.test(t.src)) {
        return true
    }
    var r = e.wheelDeltaX || 0;
    var i = e.wheelDeltaY || 0;
    if (!r && !i) {
        i = e.wheelDelta || 0
    }
    if (Math.abs(r) > 1.2) {
        r *= ssc_stepsize / 120
    }
    if (Math.abs(i) > 1.2) {
        i *= ssc_stepsize / 120
    }
    ssc_scrollArray(n, -r, -i);
    e.preventDefault()
}

function ssc_keydown(e) {
    var t = e.target;
    var n = e.ctrlKey || e.altKey || e.metaKey;
    if (/input|textarea|embed/i.test(t.nodeName) || t.isContentEditable || e.defaultPrevented || n) {
        return true
    }
    if (ssc_isNodeName(t, "button") && e.keyCode === ssc_key.spacebar) {
        return true
    }
    var r, i = 0,
        s = 0;
    var o = ssc_overflowingAncestor(ssc_activeElement);
    var u = o.clientHeight;
    if (o == document.body) {
        u = window.innerHeight
    }
    switch (e.keyCode) {
    case ssc_key.up:
        s = -ssc_arrowscroll;
        break;
    case ssc_key.down:
        s = ssc_arrowscroll;
        break;
    case ssc_key.spacebar:
        r = e.shiftKey ? 1 : -1;
        s = -r * u * .9;
        break;
    case ssc_key.pageup:
        s = -u * .9;
        break;
    case ssc_key.pagedown:
        s = u * .9;
        break;
    case ssc_key.home:
        s = -o.scrollTop;
        break;
    case ssc_key.end:
        var a = o.scrollHeight - o.scrollTop - u;
        s = a > 0 ? a + 10 : 0;
        break;
    case ssc_key.left:
        i = -ssc_arrowscroll;
        break;
    case ssc_key.right:
        i = ssc_arrowscroll;
        break;
    default:
        return true
    }
    ssc_scrollArray(o, i, s);
    e.preventDefault()
}

function ssc_mousedown(e) {
    ssc_activeElement = e.target
}

function ssc_setCache(e, t) {
    for (var n = e.length; n--;) ssc_cache[ssc_uniqueID(e[n])] = t;
    return t
}

function ssc_overflowingAncestor(e) {
    var t = [];
    var n = ssc_root.scrollHeight;
    do {
        var r = ssc_cache[ssc_uniqueID(e)];
        if (r) {
            return ssc_setCache(t, r)
        }
        t.push(e);
        if (n === e.scrollHeight) {
            if (!ssc_frame || ssc_root.clientHeight + 10 < n) {
                return ssc_setCache(t, document.body)
            }
        } else if (e.clientHeight + 10 < e.scrollHeight) {
            overflow = getComputedStyle(e, "").getPropertyValue("overflow");
            if (overflow === "scroll" || overflow === "auto") {
                return ssc_setCache(t, e)
            }
        }
    } while (e = e.parentNode)
}

function ssc_addEvent(e, t, n) {
    window.addEventListener(e, t, n || false)
}

function ssc_removeEvent(e, t, n) {
    window.removeEventListener(e, t, n || false)
}

function ssc_isNodeName(e, t) {
    return e.nodeName.toLowerCase() === t.toLowerCase()
}

function ssc_directionCheck(e, t) {
    e = e > 0 ? 1 : -1;
    t = t > 0 ? 1 : -1;
    if (ssc_direction.x !== e || ssc_direction.y !== t) {
        ssc_direction.x = e;
        ssc_direction.y = t;
        ssc_que = []
    }
}

function ssc_pulse_(e) {
    var t, n, r;
    e = e * ssc_pulseScale;
    if (e < 1) {
        t = e - (1 - Math.exp(-e))
    } else {
        n = Math.exp(-1);
        e -= 1;
        r = 1 - Math.exp(-e);
        t = n + r * (1 - n)
    }
    return t * ssc_pulseNormalize
}

function ssc_pulse(e) {
    if (e >= 1) return 1;
    if (e <= 0) return 0;
    if (ssc_pulseNormalize == 1) {
        ssc_pulseNormalize /= ssc_pulse_(1)
    }
    return ssc_pulse_(e)
}
var ssc_framerate = 150;
var ssc_animtime = 500;
var ssc_stepsize = 150;
var ssc_pulseAlgorithm = true;
var ssc_pulseScale = 6;
var ssc_pulseNormalize = 1;
var ssc_keyboardsupport = true;
var ssc_arrowscroll = 50;
var ssc_frame = false;
var ssc_direction = {
    x: 0,
    y: 0
};
var ssc_initdone = false;
var ssc_fixedback = true;
var ssc_root = document.documentElement;
var ssc_activeElement;
var ssc_key = {
    left: 37,
    up: 38,
    right: 39,
    down: 40,
    spacebar: 32,
    pageup: 33,
    pagedown: 34,
    end: 35,
    home: 36
};
var ssc_que = [];
var ssc_pending = false;
var ssc_cache = {};
setInterval(function () {
    ssc_cache = {}
}, 10 * 1e3);
var ssc_uniqueID = function () {
    var e = 0;
    return function (t) {
        return t.ssc_uniqueID || (t.ssc_uniqueID = e++)
    }
}();
if (/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())) {
    ssc_addEvent("mousedown", ssc_mousedown);
    ssc_addEvent("mousewheel", ssc_wheel);
    ssc_addEvent("load", ssc_init)
}