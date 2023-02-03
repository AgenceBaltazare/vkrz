/*! For license information please see shepherd.js.LICENSE.txt */
!(function () {
  var t = {
      4992: function (t, e, n) {
        var o, r, i;
        function s(t, e) {
          if ("function" != typeof e && null !== e)
            throw new TypeError(
              "Super expression must either be null or a function"
            );
          (t.prototype = Object.create(e && e.prototype, {
            constructor: { value: t, writable: !0, configurable: !0 },
          })),
            Object.defineProperty(t, "prototype", { writable: !1 }),
            e && a(t, e);
        }
        function a(t, e) {
          return (
            (a = Object.setPrototypeOf
              ? Object.setPrototypeOf.bind()
              : function (t, e) {
                  return (t.__proto__ = e), t;
                }),
            a(t, e)
          );
        }
        function c(t) {
          var e = (function () {
            if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
            if (Reflect.construct.sham) return !1;
            if ("function" == typeof Proxy) return !0;
            try {
              return (
                Boolean.prototype.valueOf.call(
                  Reflect.construct(Boolean, [], function () {})
                ),
                !0
              );
            } catch (t) {
              return !1;
            }
          })();
          return function () {
            var n,
              o = f(t);
            if (e) {
              var r = f(this).constructor;
              n = Reflect.construct(o, arguments, r);
            } else n = o.apply(this, arguments);
            return l(this, n);
          };
        }
        function l(t, e) {
          if (e && ("object" === w(e) || "function" == typeof e)) return e;
          if (void 0 !== e)
            throw new TypeError(
              "Derived constructors may only return object or undefined"
            );
          return u(t);
        }
        function u(t) {
          if (void 0 === t)
            throw new ReferenceError(
              "this hasn't been initialised - super() hasn't been called"
            );
          return t;
        }
        function f(t) {
          return (
            (f = Object.setPrototypeOf
              ? Object.getPrototypeOf.bind()
              : function (t) {
                  return t.__proto__ || Object.getPrototypeOf(t);
                }),
            f(t)
          );
        }
        function p(t, e) {
          return (
            (function (t) {
              if (Array.isArray(t)) return t;
            })(t) ||
            (function (t, e) {
              var n =
                null == t
                  ? null
                  : ("undefined" != typeof Symbol && t[Symbol.iterator]) ||
                    t["@@iterator"];
              if (null != n) {
                var o,
                  r,
                  i,
                  s,
                  a = [],
                  c = !0,
                  l = !1;
                try {
                  if (((i = (n = n.call(t)).next), 0 === e)) {
                    if (Object(n) !== n) return;
                    c = !1;
                  } else
                    for (
                      ;
                      !(c = (o = i.call(n)).done) &&
                      (a.push(o.value), a.length !== e);
                      c = !0
                    );
                } catch (t) {
                  (l = !0), (r = t);
                } finally {
                  try {
                    if (
                      !c &&
                      null != n.return &&
                      ((s = n.return()), Object(s) !== s)
                    )
                      return;
                  } finally {
                    if (l) throw r;
                  }
                }
                return a;
              }
            })(t, e) ||
            h(t, e) ||
            (function () {
              throw new TypeError(
                "Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."
              );
            })()
          );
        }
        function d(t) {
          return (
            (function (t) {
              if (Array.isArray(t)) return v(t);
            })(t) ||
            (function (t) {
              if (
                ("undefined" != typeof Symbol && null != t[Symbol.iterator]) ||
                null != t["@@iterator"]
              )
                return Array.from(t);
            })(t) ||
            h(t) ||
            (function () {
              throw new TypeError(
                "Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."
              );
            })()
          );
        }
        function h(t, e) {
          if (t) {
            if ("string" == typeof t) return v(t, e);
            var n = Object.prototype.toString.call(t).slice(8, -1);
            return (
              "Object" === n && t.constructor && (n = t.constructor.name),
              "Map" === n || "Set" === n
                ? Array.from(t)
                : "Arguments" === n ||
                  /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
                ? v(t, e)
                : void 0
            );
          }
        }
        function v(t, e) {
          (null == e || e > t.length) && (e = t.length);
          for (var n = 0, o = new Array(e); n < e; n++) o[n] = t[n];
          return o;
        }
        function m(t, e) {
          if (!(t instanceof e))
            throw new TypeError("Cannot call a class as a function");
        }
        function y(t, e) {
          for (var n = 0; n < e.length; n++) {
            var o = e[n];
            (o.enumerable = o.enumerable || !1),
              (o.configurable = !0),
              "value" in o && (o.writable = !0),
              Object.defineProperty(t, b(o.key), o);
          }
        }
        function g(t, e, n) {
          return (
            e && y(t.prototype, e),
            n && y(t, n),
            Object.defineProperty(t, "prototype", { writable: !1 }),
            t
          );
        }
        function b(t) {
          var e = (function (t, e) {
            if ("object" !== w(t) || null === t) return t;
            var n = t[Symbol.toPrimitive];
            if (void 0 !== n) {
              var o = n.call(t, "string");
              if ("object" !== w(o)) return o;
              throw new TypeError(
                "@@toPrimitive must return a primitive value."
              );
            }
            return String(t);
          })(t);
          return "symbol" === w(e) ? e : String(e);
        }
        function w(t) {
          return (
            (w =
              "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                ? function (t) {
                    return typeof t;
                  }
                : function (t) {
                    return t &&
                      "function" == typeof Symbol &&
                      t.constructor === Symbol &&
                      t !== Symbol.prototype
                      ? "symbol"
                      : typeof t;
                  }),
            w(t)
          );
        }
        (i = function () {
          "use strict";
          var t = function (t) {
              return (
                (function (t) {
                  return !!t && "object" === w(t);
                })(t) &&
                !(function (t) {
                  var n = Object.prototype.toString.call(t);
                  return (
                    "[object RegExp]" === n ||
                    "[object Date]" === n ||
                    (function (t) {
                      return t.$$typeof === e;
                    })(t)
                  );
                })(t)
              );
            },
            e =
              "function" == typeof Symbol && Symbol.for
                ? Symbol.for("react.element")
                : 60103;
          function n(t, e) {
            return !1 !== e.clone && e.isMergeableObject(t)
              ? a(((n = t), Array.isArray(n) ? [] : {}), t, e)
              : t;
            var n;
          }
          function o(t, e, o) {
            return t.concat(e).map(function (t) {
              return n(t, o);
            });
          }
          function r(t) {
            return Object.keys(t).concat(
              (function (t) {
                return Object.getOwnPropertySymbols
                  ? Object.getOwnPropertySymbols(t).filter(function (e) {
                      return t.propertyIsEnumerable(e);
                    })
                  : [];
              })(t)
            );
          }
          function i(t, e) {
            try {
              return e in t;
            } catch (t) {
              return !1;
            }
          }
          function a(e, s, c) {
            ((c = c || {}).arrayMerge = c.arrayMerge || o),
              (c.isMergeableObject = c.isMergeableObject || t),
              (c.cloneUnlessOtherwiseSpecified = n);
            var l = Array.isArray(s);
            return l === Array.isArray(e)
              ? l
                ? c.arrayMerge(e, s, c)
                : (function (t, e, o) {
                    var s = {};
                    return (
                      o.isMergeableObject(t) &&
                        r(t).forEach(function (e) {
                          s[e] = n(t[e], o);
                        }),
                      r(e).forEach(function (r) {
                        (function (t, e) {
                          return (
                            i(t, e) &&
                            !(
                              Object.hasOwnProperty.call(t, e) &&
                              Object.propertyIsEnumerable.call(t, e)
                            )
                          );
                        })(t, r) ||
                          (i(t, r) && o.isMergeableObject(e[r])
                            ? (s[r] = (function (t, e) {
                                if (!e.customMerge) return a;
                                var n = e.customMerge(t);
                                return "function" == typeof n ? n : a;
                              })(r, o)(t[r], e[r], o))
                            : (s[r] = n(e[r], o)));
                      }),
                      s
                    );
                  })(e, s, c)
              : n(s, c);
          }
          a.all = function (t, e) {
            if (!Array.isArray(t))
              throw new Error("first argument should be an array");
            return t.reduce(function (t, n) {
              return a(t, n, e);
            }, {});
          };
          var f = a;
          function h(t) {
            return t instanceof HTMLElement;
          }
          function v(t) {
            return "function" == typeof t;
          }
          function y(t) {
            return "string" == typeof t;
          }
          function x(t) {
            return void 0 === t;
          }
          var O = (function () {
            function t() {
              m(this, t);
            }
            return (
              g(t, [
                {
                  key: "on",
                  value: function (t, e, n, o) {
                    return (
                      void 0 === o && (o = !1),
                      x(this.bindings) && (this.bindings = {}),
                      x(this.bindings[t]) && (this.bindings[t] = []),
                      this.bindings[t].push({ handler: e, ctx: n, once: o }),
                      this
                    );
                  },
                },
                {
                  key: "once",
                  value: function (t, e, n) {
                    return this.on(t, e, n, !0);
                  },
                },
                {
                  key: "off",
                  value: function (t, e) {
                    var n = this;
                    return (
                      x(this.bindings) ||
                        x(this.bindings[t]) ||
                        (x(e)
                          ? delete this.bindings[t]
                          : this.bindings[t].forEach(function (o, r) {
                              o.handler === e && n.bindings[t].splice(r, 1);
                            })),
                      this
                    );
                  },
                },
                {
                  key: "trigger",
                  value: function (t) {
                    for (
                      var e = this,
                        n = arguments.length,
                        o = new Array(n > 1 ? n - 1 : 0),
                        r = 1;
                      r < n;
                      r++
                    )
                      o[r - 1] = arguments[r];
                    return (
                      !x(this.bindings) &&
                        this.bindings[t] &&
                        this.bindings[t].forEach(function (n, r) {
                          var i = n.ctx,
                            s = n.handler,
                            a = n.once,
                            c = i || e;
                          s.apply(c, o), a && e.bindings[t].splice(r, 1);
                        }),
                      this
                    );
                  },
                },
              ]),
              t
            );
          })();
          function $(t) {
            for (
              var e = Object.getOwnPropertyNames(t.constructor.prototype),
                n = 0;
              n < e.length;
              n++
            ) {
              var o = e[n],
                r = t[o];
              "constructor" !== o &&
                "function" == typeof r &&
                (t[o] = r.bind(t));
            }
            return t;
          }
          var E = "top",
            S = "bottom",
            k = "right",
            j = "left",
            T = "auto",
            _ = [E, S, k, j],
            A = "start",
            I = "end",
            P = "viewport",
            M = "popper",
            L = _.reduce(function (t, e) {
              return t.concat([e + "-" + A, e + "-" + I]);
            }, []),
            C = [].concat(_, [T]).reduce(function (t, e) {
              return t.concat([e, e + "-" + A, e + "-" + I]);
            }, []),
            B = [
              "beforeRead",
              "read",
              "afterRead",
              "beforeMain",
              "main",
              "afterMain",
              "beforeWrite",
              "write",
              "afterWrite",
            ];
          function D(t) {
            return t ? (t.nodeName || "").toLowerCase() : null;
          }
          function H(t) {
            if (null == t) return window;
            if ("[object Window]" !== t.toString()) {
              var e = t.ownerDocument;
              return (e && e.defaultView) || window;
            }
            return t;
          }
          function R(t) {
            return t instanceof H(t).Element || t instanceof Element;
          }
          function W(t) {
            return t instanceof H(t).HTMLElement || t instanceof HTMLElement;
          }
          function F(t) {
            return (
              "undefined" != typeof ShadowRoot &&
              (t instanceof H(t).ShadowRoot || t instanceof ShadowRoot)
            );
          }
          var N = {
            name: "applyStyles",
            enabled: !0,
            phase: "write",
            fn: function (t) {
              var e = t.state;
              Object.keys(e.elements).forEach(function (t) {
                var n = e.styles[t] || {},
                  o = e.attributes[t] || {},
                  r = e.elements[t];
                W(r) &&
                  D(r) &&
                  (Object.assign(r.style, n),
                  Object.keys(o).forEach(function (t) {
                    var e = o[t];
                    !1 === e
                      ? r.removeAttribute(t)
                      : r.setAttribute(t, !0 === e ? "" : e);
                  }));
              });
            },
            effect: function (t) {
              var e = t.state,
                n = {
                  popper: {
                    position: e.options.strategy,
                    left: "0",
                    top: "0",
                    margin: "0",
                  },
                  arrow: { position: "absolute" },
                  reference: {},
                };
              return (
                Object.assign(e.elements.popper.style, n.popper),
                (e.styles = n),
                e.elements.arrow &&
                  Object.assign(e.elements.arrow.style, n.arrow),
                function () {
                  Object.keys(e.elements).forEach(function (t) {
                    var o = e.elements[t],
                      r = e.attributes[t] || {},
                      i = Object.keys(
                        e.styles.hasOwnProperty(t) ? e.styles[t] : n[t]
                      ).reduce(function (t, e) {
                        return (t[e] = ""), t;
                      }, {});
                    W(o) &&
                      D(o) &&
                      (Object.assign(o.style, i),
                      Object.keys(r).forEach(function (t) {
                        o.removeAttribute(t);
                      }));
                  });
                }
              );
            },
            requires: ["computeStyles"],
          };
          function V(t) {
            return t.split("-")[0];
          }
          var q = Math.max,
            Y = Math.min,
            X = Math.round;
          function U(t, e) {
            void 0 === e && (e = !1);
            var n = t.getBoundingClientRect(),
              o = 1,
              r = 1;
            if (W(t) && e) {
              var i = t.offsetHeight,
                s = t.offsetWidth;
              s > 0 && (o = X(n.width) / s || 1),
                i > 0 && (r = X(n.height) / i || 1);
            }
            return {
              width: n.width / o,
              height: n.height / r,
              top: n.top / r,
              right: n.right / o,
              bottom: n.bottom / r,
              left: n.left / o,
              x: n.left / o,
              y: n.top / r,
            };
          }
          function z(t) {
            var e = U(t),
              n = t.offsetWidth,
              o = t.offsetHeight;
            return (
              Math.abs(e.width - n) <= 1 && (n = e.width),
              Math.abs(e.height - o) <= 1 && (o = e.height),
              { x: t.offsetLeft, y: t.offsetTop, width: n, height: o }
            );
          }
          function Z(t, e) {
            var n = e.getRootNode && e.getRootNode();
            if (t.contains(e)) return !0;
            if (n && F(n)) {
              var o = e;
              do {
                if (o && t.isSameNode(o)) return !0;
                o = o.parentNode || o.host;
              } while (o);
            }
            return !1;
          }
          function K(t) {
            return H(t).getComputedStyle(t);
          }
          function G(t) {
            return ["table", "td", "th"].indexOf(D(t)) >= 0;
          }
          function J(t) {
            return ((R(t) ? t.ownerDocument : t.document) || window.document)
              .documentElement;
          }
          function Q(t) {
            return "html" === D(t)
              ? t
              : t.assignedSlot ||
                  t.parentNode ||
                  (F(t) ? t.host : null) ||
                  J(t);
          }
          function tt(t) {
            return W(t) && "fixed" !== K(t).position ? t.offsetParent : null;
          }
          function et(t) {
            for (
              var e = H(t), n = tt(t);
              n && G(n) && "static" === K(n).position;

            )
              n = tt(n);
            return n &&
              ("html" === D(n) ||
                ("body" === D(n) && "static" === K(n).position))
              ? e
              : n ||
                  (function (t) {
                    var e =
                      -1 !==
                      navigator.userAgent.toLowerCase().indexOf("firefox");
                    if (
                      -1 !== navigator.userAgent.indexOf("Trident") &&
                      W(t) &&
                      "fixed" === K(t).position
                    )
                      return null;
                    var n = Q(t);
                    for (
                      F(n) && (n = n.host);
                      W(n) && ["html", "body"].indexOf(D(n)) < 0;

                    ) {
                      var o = K(n);
                      if (
                        "none" !== o.transform ||
                        "none" !== o.perspective ||
                        "paint" === o.contain ||
                        -1 !==
                          ["transform", "perspective"].indexOf(o.willChange) ||
                        (e && "filter" === o.willChange) ||
                        (e && o.filter && "none" !== o.filter)
                      )
                        return n;
                      n = n.parentNode;
                    }
                    return null;
                  })(t) ||
                  e;
          }
          function nt(t) {
            return ["top", "bottom"].indexOf(t) >= 0 ? "x" : "y";
          }
          function ot(t, e, n) {
            return q(t, Y(e, n));
          }
          function rt(t) {
            return Object.assign(
              {},
              { top: 0, right: 0, bottom: 0, left: 0 },
              t
            );
          }
          function it(t, e) {
            return e.reduce(function (e, n) {
              return (e[n] = t), e;
            }, {});
          }
          var st = {
            name: "arrow",
            enabled: !0,
            phase: "main",
            fn: function (t) {
              var e,
                n = t.state,
                o = t.name,
                r = t.options,
                i = n.elements.arrow,
                s = n.modifiersData.popperOffsets,
                a = V(n.placement),
                c = nt(a),
                l = [j, k].indexOf(a) >= 0 ? "height" : "width";
              if (i && s) {
                var u = (function (t, e) {
                    return rt(
                      "number" !=
                        typeof (t =
                          "function" == typeof t
                            ? t(
                                Object.assign({}, e.rects, {
                                  placement: e.placement,
                                })
                              )
                            : t)
                        ? t
                        : it(t, _)
                    );
                  })(r.padding, n),
                  f = z(i),
                  p = "y" === c ? E : j,
                  d = "y" === c ? S : k,
                  h =
                    n.rects.reference[l] +
                    n.rects.reference[c] -
                    s[c] -
                    n.rects.popper[l],
                  v = s[c] - n.rects.reference[c],
                  m = et(i),
                  y = m
                    ? "y" === c
                      ? m.clientHeight || 0
                      : m.clientWidth || 0
                    : 0,
                  g = h / 2 - v / 2,
                  b = u[p],
                  w = y - f[l] - u[d],
                  x = y / 2 - f[l] / 2 + g,
                  O = ot(b, x, w),
                  $ = c;
                n.modifiersData[o] =
                  (((e = {})[$] = O), (e.centerOffset = O - x), e);
              }
            },
            effect: function (t) {
              var e = t.state,
                n = t.options.element,
                o = void 0 === n ? "[data-popper-arrow]" : n;
              null != o &&
                ("string" != typeof o ||
                  (o = e.elements.popper.querySelector(o))) &&
                Z(e.elements.popper, o) &&
                (e.elements.arrow = o);
            },
            requires: ["popperOffsets"],
            requiresIfExists: ["preventOverflow"],
          };
          function at(t) {
            return t.split("-")[1];
          }
          var ct = { top: "auto", right: "auto", bottom: "auto", left: "auto" };
          function lt(t) {
            var e,
              n = t.popper,
              o = t.popperRect,
              r = t.placement,
              i = t.variation,
              s = t.offsets,
              a = t.position,
              c = t.gpuAcceleration,
              l = t.adaptive,
              u = t.roundOffsets,
              f = t.isFixed,
              p = s.x,
              d = void 0 === p ? 0 : p,
              h = s.y,
              v = void 0 === h ? 0 : h,
              m = "function" == typeof u ? u({ x: d, y: v }) : { x: d, y: v };
            (d = m.x), (v = m.y);
            var y = s.hasOwnProperty("x"),
              g = s.hasOwnProperty("y"),
              b = j,
              w = E,
              x = window;
            if (l) {
              var O = et(n),
                $ = "clientHeight",
                T = "clientWidth";
              O === H(n) &&
                "static" !== K((O = J(n))).position &&
                "absolute" === a &&
                (($ = "scrollHeight"), (T = "scrollWidth")),
                (r === E || ((r === j || r === k) && i === I)) &&
                  ((w = S),
                  (v -=
                    (f && O === x && x.visualViewport
                      ? x.visualViewport.height
                      : O[$]) - o.height),
                  (v *= c ? 1 : -1)),
                (r !== j && ((r !== E && r !== S) || i !== I)) ||
                  ((b = k),
                  (d -=
                    (f && O === x && x.visualViewport
                      ? x.visualViewport.width
                      : O[T]) - o.width),
                  (d *= c ? 1 : -1));
            }
            var _,
              A = Object.assign({ position: a }, l && ct),
              P =
                !0 === u
                  ? (function (t) {
                      var e = t.x,
                        n = t.y,
                        o = window.devicePixelRatio || 1;
                      return { x: X(e * o) / o || 0, y: X(n * o) / o || 0 };
                    })({ x: d, y: v })
                  : { x: d, y: v };
            return (
              (d = P.x),
              (v = P.y),
              c
                ? Object.assign(
                    {},
                    A,
                    (((_ = {})[w] = g ? "0" : ""),
                    (_[b] = y ? "0" : ""),
                    (_.transform =
                      (x.devicePixelRatio || 1) <= 1
                        ? "translate(" + d + "px, " + v + "px)"
                        : "translate3d(" + d + "px, " + v + "px, 0)"),
                    _)
                  )
                : Object.assign(
                    {},
                    A,
                    (((e = {})[w] = g ? v + "px" : ""),
                    (e[b] = y ? d + "px" : ""),
                    (e.transform = ""),
                    e)
                  )
            );
          }
          var ut = { passive: !0 },
            ft = {
              name: "eventListeners",
              enabled: !0,
              phase: "write",
              fn: function () {},
              effect: function (t) {
                var e = t.state,
                  n = t.instance,
                  o = t.options,
                  r = o.scroll,
                  i = void 0 === r || r,
                  s = o.resize,
                  a = void 0 === s || s,
                  c = H(e.elements.popper),
                  l = [].concat(
                    e.scrollParents.reference,
                    e.scrollParents.popper
                  );
                return (
                  i &&
                    l.forEach(function (t) {
                      t.addEventListener("scroll", n.update, ut);
                    }),
                  a && c.addEventListener("resize", n.update, ut),
                  function () {
                    i &&
                      l.forEach(function (t) {
                        t.removeEventListener("scroll", n.update, ut);
                      }),
                      a && c.removeEventListener("resize", n.update, ut);
                  }
                );
              },
              data: {},
            },
            pt = { left: "right", right: "left", bottom: "top", top: "bottom" };
          function dt(t) {
            return t.replace(/left|right|bottom|top/g, function (t) {
              return pt[t];
            });
          }
          var ht = { start: "end", end: "start" };
          function vt(t) {
            return t.replace(/start|end/g, function (t) {
              return ht[t];
            });
          }
          function mt(t) {
            var e = H(t);
            return { scrollLeft: e.pageXOffset, scrollTop: e.pageYOffset };
          }
          function yt(t) {
            return U(J(t)).left + mt(t).scrollLeft;
          }
          function gt(t) {
            var e = K(t),
              n = e.overflow,
              o = e.overflowX,
              r = e.overflowY;
            return /auto|scroll|overlay|hidden/.test(n + r + o);
          }
          function bt(t) {
            return ["html", "body", "#document"].indexOf(D(t)) >= 0
              ? t.ownerDocument.body
              : W(t) && gt(t)
              ? t
              : bt(Q(t));
          }
          function wt(t, e) {
            var n;
            void 0 === e && (e = []);
            var o = bt(t),
              r = o === (null == (n = t.ownerDocument) ? void 0 : n.body),
              i = H(o),
              s = r ? [i].concat(i.visualViewport || [], gt(o) ? o : []) : o,
              a = e.concat(s);
            return r ? a : a.concat(wt(Q(s)));
          }
          function xt(t) {
            return Object.assign({}, t, {
              left: t.x,
              top: t.y,
              right: t.x + t.width,
              bottom: t.y + t.height,
            });
          }
          function Ot(t, e) {
            return e === P
              ? xt(
                  (function (t) {
                    var e = H(t),
                      n = J(t),
                      o = e.visualViewport,
                      r = n.clientWidth,
                      i = n.clientHeight,
                      s = 0,
                      a = 0;
                    return (
                      o &&
                        ((r = o.width),
                        (i = o.height),
                        /^((?!chrome|android).)*safari/i.test(
                          navigator.userAgent
                        ) || ((s = o.offsetLeft), (a = o.offsetTop))),
                      { width: r, height: i, x: s + yt(t), y: a }
                    );
                  })(t)
                )
              : R(e)
              ? (function (t) {
                  var e = U(t);
                  return (
                    (e.top = e.top + t.clientTop),
                    (e.left = e.left + t.clientLeft),
                    (e.bottom = e.top + t.clientHeight),
                    (e.right = e.left + t.clientWidth),
                    (e.width = t.clientWidth),
                    (e.height = t.clientHeight),
                    (e.x = e.left),
                    (e.y = e.top),
                    e
                  );
                })(e)
              : xt(
                  (function (t) {
                    var e,
                      n = J(t),
                      o = mt(t),
                      r = null == (e = t.ownerDocument) ? void 0 : e.body,
                      i = q(
                        n.scrollWidth,
                        n.clientWidth,
                        r ? r.scrollWidth : 0,
                        r ? r.clientWidth : 0
                      ),
                      s = q(
                        n.scrollHeight,
                        n.clientHeight,
                        r ? r.scrollHeight : 0,
                        r ? r.clientHeight : 0
                      ),
                      a = -o.scrollLeft + yt(t),
                      c = -o.scrollTop;
                    return (
                      "rtl" === K(r || n).direction &&
                        (a += q(n.clientWidth, r ? r.clientWidth : 0) - i),
                      { width: i, height: s, x: a, y: c }
                    );
                  })(J(t))
                );
          }
          function $t(t) {
            var e,
              n = t.reference,
              o = t.element,
              r = t.placement,
              i = r ? V(r) : null,
              s = r ? at(r) : null,
              a = n.x + n.width / 2 - o.width / 2,
              c = n.y + n.height / 2 - o.height / 2;
            switch (i) {
              case E:
                e = { x: a, y: n.y - o.height };
                break;
              case S:
                e = { x: a, y: n.y + n.height };
                break;
              case k:
                e = { x: n.x + n.width, y: c };
                break;
              case j:
                e = { x: n.x - o.width, y: c };
                break;
              default:
                e = { x: n.x, y: n.y };
            }
            var l = i ? nt(i) : null;
            if (null != l) {
              var u = "y" === l ? "height" : "width";
              switch (s) {
                case A:
                  e[l] = e[l] - (n[u] / 2 - o[u] / 2);
                  break;
                case I:
                  e[l] = e[l] + (n[u] / 2 - o[u] / 2);
              }
            }
            return e;
          }
          function Et(t, e) {
            void 0 === e && (e = {});
            var n = e,
              o = n.placement,
              r = void 0 === o ? t.placement : o,
              i = n.boundary,
              s = void 0 === i ? "clippingParents" : i,
              a = n.rootBoundary,
              c = void 0 === a ? P : a,
              l = n.elementContext,
              u = void 0 === l ? M : l,
              f = n.altBoundary,
              p = void 0 !== f && f,
              d = n.padding,
              h = void 0 === d ? 0 : d,
              v = rt("number" != typeof h ? h : it(h, _)),
              m = u === M ? "reference" : M,
              y = t.rects.popper,
              g = t.elements[p ? m : u],
              b = (function (t, e, n) {
                var o =
                    "clippingParents" === e
                      ? (function (t) {
                          var e = wt(Q(t)),
                            n =
                              ["absolute", "fixed"].indexOf(K(t).position) >=
                                0 && W(t)
                                ? et(t)
                                : t;
                          return R(n)
                            ? e.filter(function (t) {
                                return R(t) && Z(t, n) && "body" !== D(t);
                              })
                            : [];
                        })(t)
                      : [].concat(e),
                  r = [].concat(o, [n]),
                  i = r[0],
                  s = r.reduce(function (e, n) {
                    var o = Ot(t, n);
                    return (
                      (e.top = q(o.top, e.top)),
                      (e.right = Y(o.right, e.right)),
                      (e.bottom = Y(o.bottom, e.bottom)),
                      (e.left = q(o.left, e.left)),
                      e
                    );
                  }, Ot(t, i));
                return (
                  (s.width = s.right - s.left),
                  (s.height = s.bottom - s.top),
                  (s.x = s.left),
                  (s.y = s.top),
                  s
                );
              })(R(g) ? g : g.contextElement || J(t.elements.popper), s, c),
              w = U(t.elements.reference),
              x = $t({
                reference: w,
                element: y,
                strategy: "absolute",
                placement: r,
              }),
              O = xt(Object.assign({}, y, x)),
              $ = u === M ? O : w,
              j = {
                top: b.top - $.top + v.top,
                bottom: $.bottom - b.bottom + v.bottom,
                left: b.left - $.left + v.left,
                right: $.right - b.right + v.right,
              },
              T = t.modifiersData.offset;
            if (u === M && T) {
              var A = T[r];
              Object.keys(j).forEach(function (t) {
                var e = [k, S].indexOf(t) >= 0 ? 1 : -1,
                  n = [E, S].indexOf(t) >= 0 ? "y" : "x";
                j[t] += A[n] * e;
              });
            }
            return j;
          }
          function St(t, e) {
            void 0 === e && (e = {});
            var n = e,
              o = n.placement,
              r = n.boundary,
              i = n.rootBoundary,
              s = n.padding,
              a = n.flipVariations,
              c = n.allowedAutoPlacements,
              l = void 0 === c ? C : c,
              u = at(o),
              f = u
                ? a
                  ? L
                  : L.filter(function (t) {
                      return at(t) === u;
                    })
                : _,
              p = f.filter(function (t) {
                return l.indexOf(t) >= 0;
              });
            0 === p.length && (p = f);
            var d = p.reduce(function (e, n) {
              return (
                (e[n] = Et(t, {
                  placement: n,
                  boundary: r,
                  rootBoundary: i,
                  padding: s,
                })[V(n)]),
                e
              );
            }, {});
            return Object.keys(d).sort(function (t, e) {
              return d[t] - d[e];
            });
          }
          var kt = {
            name: "flip",
            enabled: !0,
            phase: "main",
            fn: function (t) {
              var e = t.state,
                n = t.options,
                o = t.name;
              if (!e.modifiersData[o]._skip) {
                for (
                  var r = n.mainAxis,
                    i = void 0 === r || r,
                    s = n.altAxis,
                    a = void 0 === s || s,
                    c = n.fallbackPlacements,
                    l = n.padding,
                    u = n.boundary,
                    f = n.rootBoundary,
                    p = n.altBoundary,
                    d = n.flipVariations,
                    h = void 0 === d || d,
                    v = n.allowedAutoPlacements,
                    m = e.options.placement,
                    y = V(m),
                    g =
                      c ||
                      (y !== m && h
                        ? (function (t) {
                            if (V(t) === T) return [];
                            var e = dt(t);
                            return [vt(t), e, vt(e)];
                          })(m)
                        : [dt(m)]),
                    b = [m].concat(g).reduce(function (t, n) {
                      return t.concat(
                        V(n) === T
                          ? St(e, {
                              placement: n,
                              boundary: u,
                              rootBoundary: f,
                              padding: l,
                              flipVariations: h,
                              allowedAutoPlacements: v,
                            })
                          : n
                      );
                    }, []),
                    w = e.rects.reference,
                    x = e.rects.popper,
                    O = new Map(),
                    $ = !0,
                    _ = b[0],
                    I = 0;
                  I < b.length;
                  I++
                ) {
                  var P = b[I],
                    M = V(P),
                    L = at(P) === A,
                    C = [E, S].indexOf(M) >= 0,
                    B = C ? "width" : "height",
                    D = Et(e, {
                      placement: P,
                      boundary: u,
                      rootBoundary: f,
                      altBoundary: p,
                      padding: l,
                    }),
                    H = C ? (L ? k : j) : L ? S : E;
                  w[B] > x[B] && (H = dt(H));
                  var R = dt(H),
                    W = [];
                  if (
                    (i && W.push(D[M] <= 0),
                    a && W.push(D[H] <= 0, D[R] <= 0),
                    W.every(function (t) {
                      return t;
                    }))
                  ) {
                    (_ = P), ($ = !1);
                    break;
                  }
                  O.set(P, W);
                }
                if ($)
                  for (
                    var F = function (t) {
                        var e = b.find(function (e) {
                          var n = O.get(e);
                          if (n)
                            return n.slice(0, t).every(function (t) {
                              return t;
                            });
                        });
                        if (e) return (_ = e), "break";
                      },
                      N = h ? 3 : 1;
                    N > 0 && "break" !== F(N);
                    N--
                  );
                e.placement !== _ &&
                  ((e.modifiersData[o]._skip = !0),
                  (e.placement = _),
                  (e.reset = !0));
              }
            },
            requiresIfExists: ["offset"],
            data: { _skip: !1 },
          };
          function jt(t, e, n) {
            return (
              void 0 === n && (n = { x: 0, y: 0 }),
              {
                top: t.top - e.height - n.y,
                right: t.right - e.width + n.x,
                bottom: t.bottom - e.height + n.y,
                left: t.left - e.width - n.x,
              }
            );
          }
          function Tt(t) {
            return [E, k, S, j].some(function (e) {
              return t[e] >= 0;
            });
          }
          function _t(t, e, n) {
            void 0 === n && (n = !1);
            var o,
              r = W(e),
              i =
                W(e) &&
                (function (t) {
                  var e = t.getBoundingClientRect(),
                    n = X(e.width) / t.offsetWidth || 1,
                    o = X(e.height) / t.offsetHeight || 1;
                  return 1 !== n || 1 !== o;
                })(e),
              s = J(e),
              a = U(t, i),
              c = { scrollLeft: 0, scrollTop: 0 },
              l = { x: 0, y: 0 };
            return (
              (r || (!r && !n)) &&
                (("body" !== D(e) || gt(s)) &&
                  (c =
                    (o = e) !== H(o) && W(o)
                      ? (function (t) {
                          return {
                            scrollLeft: t.scrollLeft,
                            scrollTop: t.scrollTop,
                          };
                        })(o)
                      : mt(o)),
                W(e)
                  ? (((l = U(e, !0)).x += e.clientLeft), (l.y += e.clientTop))
                  : s && (l.x = yt(s))),
              {
                x: a.left + c.scrollLeft - l.x,
                y: a.top + c.scrollTop - l.y,
                width: a.width,
                height: a.height,
              }
            );
          }
          function At(t) {
            var e = new Map(),
              n = new Set(),
              o = [];
            function r(t) {
              n.add(t.name),
                []
                  .concat(t.requires || [], t.requiresIfExists || [])
                  .forEach(function (t) {
                    if (!n.has(t)) {
                      var o = e.get(t);
                      o && r(o);
                    }
                  }),
                o.push(t);
            }
            return (
              t.forEach(function (t) {
                e.set(t.name, t);
              }),
              t.forEach(function (t) {
                n.has(t.name) || r(t);
              }),
              o
            );
          }
          var It = { placement: "bottom", modifiers: [], strategy: "absolute" };
          function Pt() {
            for (var t = arguments.length, e = new Array(t), n = 0; n < t; n++)
              e[n] = arguments[n];
            return !e.some(function (t) {
              return !(t && "function" == typeof t.getBoundingClientRect);
            });
          }
          function Mt(t) {
            void 0 === t && (t = {});
            var e = t,
              n = e.defaultModifiers,
              o = void 0 === n ? [] : n,
              r = e.defaultOptions,
              i = void 0 === r ? It : r;
            return function (t, e, n) {
              void 0 === n && (n = i);
              var r,
                s,
                a = {
                  placement: "bottom",
                  orderedModifiers: [],
                  options: Object.assign({}, It, i),
                  modifiersData: {},
                  elements: { reference: t, popper: e },
                  attributes: {},
                  styles: {},
                },
                c = [],
                l = !1,
                u = {
                  state: a,
                  setOptions: function (n) {
                    var r = "function" == typeof n ? n(a.options) : n;
                    f(),
                      (a.options = Object.assign({}, i, a.options, r)),
                      (a.scrollParents = {
                        reference: R(t)
                          ? wt(t)
                          : t.contextElement
                          ? wt(t.contextElement)
                          : [],
                        popper: wt(e),
                      });
                    var s,
                      l,
                      p = (function (t) {
                        var e = At(t);
                        return B.reduce(function (t, n) {
                          return t.concat(
                            e.filter(function (t) {
                              return t.phase === n;
                            })
                          );
                        }, []);
                      })(
                        ((s = [].concat(o, a.options.modifiers)),
                        (l = s.reduce(function (t, e) {
                          var n = t[e.name];
                          return (
                            (t[e.name] = n
                              ? Object.assign({}, n, e, {
                                  options: Object.assign(
                                    {},
                                    n.options,
                                    e.options
                                  ),
                                  data: Object.assign({}, n.data, e.data),
                                })
                              : e),
                            t
                          );
                        }, {})),
                        Object.keys(l).map(function (t) {
                          return l[t];
                        }))
                      );
                    return (
                      (a.orderedModifiers = p.filter(function (t) {
                        return t.enabled;
                      })),
                      a.orderedModifiers.forEach(function (t) {
                        var e = t.name,
                          n = t.options,
                          o = void 0 === n ? {} : n,
                          r = t.effect;
                        if ("function" == typeof r) {
                          var i = r({
                            state: a,
                            name: e,
                            instance: u,
                            options: o,
                          });
                          c.push(i || function () {});
                        }
                      }),
                      u.update()
                    );
                  },
                  forceUpdate: function () {
                    if (!l) {
                      var t = a.elements,
                        e = t.reference,
                        n = t.popper;
                      if (Pt(e, n)) {
                        (a.rects = {
                          reference: _t(
                            e,
                            et(n),
                            "fixed" === a.options.strategy
                          ),
                          popper: z(n),
                        }),
                          (a.reset = !1),
                          (a.placement = a.options.placement),
                          a.orderedModifiers.forEach(function (t) {
                            return (a.modifiersData[t.name] = Object.assign(
                              {},
                              t.data
                            ));
                          });
                        for (var o = 0; o < a.orderedModifiers.length; o++)
                          if (!0 !== a.reset) {
                            var r = a.orderedModifiers[o],
                              i = r.fn,
                              s = r.options,
                              c = void 0 === s ? {} : s,
                              f = r.name;
                            "function" == typeof i &&
                              (a =
                                i({
                                  state: a,
                                  options: c,
                                  name: f,
                                  instance: u,
                                }) || a);
                          } else (a.reset = !1), (o = -1);
                      }
                    }
                  },
                  update:
                    ((r = function () {
                      return new Promise(function (t) {
                        u.forceUpdate(), t(a);
                      });
                    }),
                    function () {
                      return (
                        s ||
                          (s = new Promise(function (t) {
                            Promise.resolve().then(function () {
                              (s = void 0), t(r());
                            });
                          })),
                        s
                      );
                    }),
                  destroy: function () {
                    f(), (l = !0);
                  },
                };
              if (!Pt(t, e)) return u;
              function f() {
                c.forEach(function (t) {
                  return t();
                }),
                  (c = []);
              }
              return (
                u.setOptions(n).then(function (t) {
                  !l && n.onFirstUpdate && n.onFirstUpdate(t);
                }),
                u
              );
            };
          }
          var Lt,
            Ct = Mt({
              defaultModifiers: [
                ft,
                {
                  name: "popperOffsets",
                  enabled: !0,
                  phase: "read",
                  fn: function (t) {
                    var e = t.state,
                      n = t.name;
                    e.modifiersData[n] = $t({
                      reference: e.rects.reference,
                      element: e.rects.popper,
                      strategy: "absolute",
                      placement: e.placement,
                    });
                  },
                  data: {},
                },
                {
                  name: "computeStyles",
                  enabled: !0,
                  phase: "beforeWrite",
                  fn: function (t) {
                    var e = t.state,
                      n = t.options,
                      o = n.gpuAcceleration,
                      r = void 0 === o || o,
                      i = n.adaptive,
                      s = void 0 === i || i,
                      a = n.roundOffsets,
                      c = void 0 === a || a,
                      l = {
                        placement: V(e.placement),
                        variation: at(e.placement),
                        popper: e.elements.popper,
                        popperRect: e.rects.popper,
                        gpuAcceleration: r,
                        isFixed: "fixed" === e.options.strategy,
                      };
                    null != e.modifiersData.popperOffsets &&
                      (e.styles.popper = Object.assign(
                        {},
                        e.styles.popper,
                        lt(
                          Object.assign({}, l, {
                            offsets: e.modifiersData.popperOffsets,
                            position: e.options.strategy,
                            adaptive: s,
                            roundOffsets: c,
                          })
                        )
                      )),
                      null != e.modifiersData.arrow &&
                        (e.styles.arrow = Object.assign(
                          {},
                          e.styles.arrow,
                          lt(
                            Object.assign({}, l, {
                              offsets: e.modifiersData.arrow,
                              position: "absolute",
                              adaptive: !1,
                              roundOffsets: c,
                            })
                          )
                        )),
                      (e.attributes.popper = Object.assign(
                        {},
                        e.attributes.popper,
                        { "data-popper-placement": e.placement }
                      ));
                  },
                  data: {},
                },
                N,
                {
                  name: "offset",
                  enabled: !0,
                  phase: "main",
                  requires: ["popperOffsets"],
                  fn: function (t) {
                    var e = t.state,
                      n = t.options,
                      o = t.name,
                      r = n.offset,
                      i = void 0 === r ? [0, 0] : r,
                      s = C.reduce(function (t, n) {
                        return (
                          (t[n] = (function (t, e, n) {
                            var o = V(t),
                              r = [j, E].indexOf(o) >= 0 ? -1 : 1,
                              i =
                                "function" == typeof n
                                  ? n(Object.assign({}, e, { placement: t }))
                                  : n,
                              s = i[0],
                              a = i[1];
                            return (
                              (s = s || 0),
                              (a = (a || 0) * r),
                              [j, k].indexOf(o) >= 0
                                ? { x: a, y: s }
                                : { x: s, y: a }
                            );
                          })(n, e.rects, i)),
                          t
                        );
                      }, {}),
                      a = s[e.placement],
                      c = a.x,
                      l = a.y;
                    null != e.modifiersData.popperOffsets &&
                      ((e.modifiersData.popperOffsets.x += c),
                      (e.modifiersData.popperOffsets.y += l)),
                      (e.modifiersData[o] = s);
                  },
                },
                kt,
                {
                  name: "preventOverflow",
                  enabled: !0,
                  phase: "main",
                  fn: function (t) {
                    var e = t.state,
                      n = t.options,
                      o = t.name,
                      r = n.mainAxis,
                      i = void 0 === r || r,
                      s = n.altAxis,
                      a = void 0 !== s && s,
                      c = n.boundary,
                      l = n.rootBoundary,
                      u = n.altBoundary,
                      f = n.padding,
                      p = n.tether,
                      d = void 0 === p || p,
                      h = n.tetherOffset,
                      v = void 0 === h ? 0 : h,
                      m = Et(e, {
                        boundary: c,
                        rootBoundary: l,
                        padding: f,
                        altBoundary: u,
                      }),
                      y = V(e.placement),
                      g = at(e.placement),
                      b = !g,
                      w = nt(y),
                      x = "x" === w ? "y" : "x",
                      O = e.modifiersData.popperOffsets,
                      $ = e.rects.reference,
                      T = e.rects.popper,
                      _ =
                        "function" == typeof v
                          ? v(
                              Object.assign({}, e.rects, {
                                placement: e.placement,
                              })
                            )
                          : v,
                      I =
                        "number" == typeof _
                          ? { mainAxis: _, altAxis: _ }
                          : Object.assign({ mainAxis: 0, altAxis: 0 }, _),
                      P = e.modifiersData.offset
                        ? e.modifiersData.offset[e.placement]
                        : null,
                      M = { x: 0, y: 0 };
                    if (O) {
                      if (i) {
                        var L,
                          C = "y" === w ? E : j,
                          B = "y" === w ? S : k,
                          D = "y" === w ? "height" : "width",
                          H = O[w],
                          R = H + m[C],
                          W = H - m[B],
                          F = d ? -T[D] / 2 : 0,
                          N = g === A ? $[D] : T[D],
                          X = g === A ? -T[D] : -$[D],
                          U = e.elements.arrow,
                          Z = d && U ? z(U) : { width: 0, height: 0 },
                          K = e.modifiersData["arrow#persistent"]
                            ? e.modifiersData["arrow#persistent"].padding
                            : { top: 0, right: 0, bottom: 0, left: 0 },
                          G = K[C],
                          J = K[B],
                          Q = ot(0, $[D], Z[D]),
                          tt = b
                            ? $[D] / 2 - F - Q - G - I.mainAxis
                            : N - Q - G - I.mainAxis,
                          rt = b
                            ? -$[D] / 2 + F + Q + J + I.mainAxis
                            : X + Q + J + I.mainAxis,
                          it = e.elements.arrow && et(e.elements.arrow),
                          st = it
                            ? "y" === w
                              ? it.clientTop || 0
                              : it.clientLeft || 0
                            : 0,
                          ct = null != (L = null == P ? void 0 : P[w]) ? L : 0,
                          lt = H + rt - ct,
                          ut = ot(
                            d ? Y(R, H + tt - ct - st) : R,
                            H,
                            d ? q(W, lt) : W
                          );
                        (O[w] = ut), (M[w] = ut - H);
                      }
                      if (a) {
                        var ft,
                          pt = "x" === w ? E : j,
                          dt = "x" === w ? S : k,
                          ht = O[x],
                          vt = "y" === x ? "height" : "width",
                          mt = ht + m[pt],
                          yt = ht - m[dt],
                          gt = -1 !== [E, j].indexOf(y),
                          bt =
                            null != (ft = null == P ? void 0 : P[x]) ? ft : 0,
                          wt = gt ? mt : ht - $[vt] - T[vt] - bt + I.altAxis,
                          xt = gt ? ht + $[vt] + T[vt] - bt - I.altAxis : yt,
                          Ot =
                            d && gt
                              ? (function (t, e, n) {
                                  var o = ot(t, e, n);
                                  return o > n ? n : o;
                                })(wt, ht, xt)
                              : ot(d ? wt : mt, ht, d ? xt : yt);
                        (O[x] = Ot), (M[x] = Ot - ht);
                      }
                      e.modifiersData[o] = M;
                    }
                  },
                  requiresIfExists: ["offset"],
                },
                st,
                {
                  name: "hide",
                  enabled: !0,
                  phase: "main",
                  requiresIfExists: ["preventOverflow"],
                  fn: function (t) {
                    var e = t.state,
                      n = t.name,
                      o = e.rects.reference,
                      r = e.rects.popper,
                      i = e.modifiersData.preventOverflow,
                      s = Et(e, { elementContext: "reference" }),
                      a = Et(e, { altBoundary: !0 }),
                      c = jt(s, o),
                      l = jt(a, r, i),
                      u = Tt(c),
                      f = Tt(l);
                    (e.modifiersData[n] = {
                      referenceClippingOffsets: c,
                      popperEscapeOffsets: l,
                      isReferenceHidden: u,
                      hasPopperEscaped: f,
                    }),
                      (e.attributes.popper = Object.assign(
                        {},
                        e.attributes.popper,
                        {
                          "data-popper-reference-hidden": u,
                          "data-popper-escaped": f,
                        }
                      ));
                  },
                },
              ],
            });
          function Bt() {
            return (
              (Bt = Object.assign
                ? Object.assign.bind()
                : function (t) {
                    for (var e = 1; e < arguments.length; e++) {
                      var n = arguments[e];
                      for (var o in n)
                        Object.prototype.hasOwnProperty.call(n, o) &&
                          (t[o] = n[o]);
                    }
                    return t;
                  }),
              Bt.apply(this, arguments)
            );
          }
          function Dt(t) {
            return {
              name: "focusAfterRender",
              enabled: !0,
              phase: "afterWrite",
              fn: function () {
                setTimeout(function () {
                  t.el && t.el.focus({ preventScroll: !0 });
                }, 300);
              },
            };
          }
          function Ht(t) {
            return y(t) && "" !== t
              ? "-" !== t.charAt(t.length - 1)
                ? "".concat(t, "-")
                : t
              : "";
          }
          function Rt(t) {
            return null == t || !t.element || !t.on;
          }
          function Wt(t) {
            t.tooltip && t.tooltip.destroy();
            var e = t._getResolvedAttachToOptions(),
              n = e.element,
              o = (function (t, e) {
                var n = {
                  modifiers: [
                    {
                      name: "preventOverflow",
                      options: { altAxis: !0, tether: !1 },
                    },
                    Dt(e),
                  ],
                  strategy: "absolute",
                };
                Rt(t)
                  ? (n = (function (t) {
                      var e = [
                          {
                            name: "applyStyles",
                            fn: function (t) {
                              var e = t.state;
                              Object.keys(e.elements).forEach(function (t) {
                                if ("popper" === t) {
                                  var n = e.attributes[t] || {},
                                    o = e.elements[t];
                                  Object.assign(o.style, {
                                    position: "fixed",
                                    left: "50%",
                                    top: "50%",
                                    transform: "translate(-50%, -50%)",
                                  }),
                                    Object.keys(n).forEach(function (t) {
                                      var e = n[t];
                                      !1 === e
                                        ? o.removeAttribute(t)
                                        : o.setAttribute(t, !0 === e ? "" : e);
                                    });
                                }
                              });
                            },
                          },
                          { name: "computeStyles", options: { adaptive: !1 } },
                        ],
                        n = {
                          placement: "top",
                          strategy: "fixed",
                          modifiers: [Dt(t)],
                        };
                      return Bt({}, n, {
                        modifiers: Array.from(
                          new Set([].concat(d(n.modifiers), d(e)))
                        ),
                      });
                    })(e))
                  : (n.placement = t.on);
                var o =
                  e.tour && e.tour.options && e.tour.options.defaultStepOptions;
                return o && (n = Nt(o, n)), Nt(e.options, n);
              })(e, t);
            return (
              Rt(e) &&
                ((n = document.body),
                t.shepherdElementComponent
                  .getElement()
                  .classList.add("shepherd-centered")),
              (t.tooltip = Ct(n, t.el, o)),
              (t.target = e.element),
              o
            );
          }
          function Ft() {
            var t = Date.now();
            return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
              /[xy]/g,
              function (e) {
                var n = (t + 16 * Math.random()) % 16 | 0;
                return (
                  (t = Math.floor(t / 16)),
                  ("x" == e ? n : (3 & n) | 8).toString(16)
                );
              }
            );
          }
          function Nt(t, e) {
            if (t.popperOptions) {
              var n = Object.assign({}, e, t.popperOptions);
              if (
                t.popperOptions.modifiers &&
                t.popperOptions.modifiers.length > 0
              ) {
                var o = t.popperOptions.modifiers.map(function (t) {
                    return t.name;
                  }),
                  r = e.modifiers.filter(function (t) {
                    return !o.includes(t.name);
                  });
                n.modifiers = Array.from(
                  new Set([].concat(d(r), d(t.popperOptions.modifiers)))
                );
              }
              return n;
            }
            return e;
          }
          function Vt() {}
          function qt(t, e) {
            for (var n in e) t[n] = e[n];
            return t;
          }
          function Yt(t) {
            return t();
          }
          function Xt() {
            return Object.create(null);
          }
          function Ut(t) {
            t.forEach(Yt);
          }
          function zt(t) {
            return "function" == typeof t;
          }
          function Zt(t, e) {
            return t != t
              ? e == e
              : t !== e || (t && "object" === w(t)) || "function" == typeof t;
          }
          function Kt(t, e) {
            t.appendChild(e);
          }
          function Gt(t, e, n) {
            t.insertBefore(e, n || null);
          }
          function Jt(t) {
            t.parentNode.removeChild(t);
          }
          function Qt(t) {
            return document.createElement(t);
          }
          function te(t) {
            return document.createElementNS("http://www.w3.org/2000/svg", t);
          }
          function ee(t) {
            return document.createTextNode(t);
          }
          function ne() {
            return ee(" ");
          }
          function oe(t, e, n, o) {
            return (
              t.addEventListener(e, n, o),
              function () {
                return t.removeEventListener(e, n, o);
              }
            );
          }
          function re(t, e, n) {
            null == n
              ? t.removeAttribute(e)
              : t.getAttribute(e) !== n && t.setAttribute(e, n);
          }
          function ie(t, e) {
            var n = Object.getOwnPropertyDescriptors(t.__proto__);
            for (var o in e)
              null == e[o]
                ? t.removeAttribute(o)
                : "style" === o
                ? (t.style.cssText = e[o])
                : "__value" === o
                ? (t.value = t[o] = e[o])
                : n[o] && n[o].set
                ? (t[o] = e[o])
                : re(t, o, e[o]);
          }
          function se(t, e, n) {
            t.classList[n ? "add" : "remove"](e);
          }
          function ae(t) {
            Lt = t;
          }
          function ce() {
            if (!Lt)
              throw new Error(
                "Function called outside component initialization"
              );
            return Lt;
          }
          function le(t) {
            ce().$$.after_update.push(t);
          }
          var ue = [],
            fe = [],
            pe = [],
            de = [],
            he = Promise.resolve(),
            ve = !1;
          function me(t) {
            pe.push(t);
          }
          var ye = new Set(),
            ge = 0;
          function be() {
            var t = Lt;
            do {
              for (; ge < ue.length; ) {
                var e = ue[ge];
                ge++, ae(e), we(e.$$);
              }
              for (ae(null), ue.length = 0, ge = 0; fe.length; ) fe.pop()();
              for (var n = 0; n < pe.length; n += 1) {
                var o = pe[n];
                ye.has(o) || (ye.add(o), o());
              }
              pe.length = 0;
            } while (ue.length);
            for (; de.length; ) de.pop()();
            (ve = !1), ye.clear(), ae(t);
          }
          function we(t) {
            if (null !== t.fragment) {
              t.update(), Ut(t.before_update);
              var e = t.dirty;
              (t.dirty = [-1]),
                t.fragment && t.fragment.p(t.ctx, e),
                t.after_update.forEach(me);
            }
          }
          var xe,
            Oe = new Set();
          function $e() {
            xe = { r: 0, c: [], p: xe };
          }
          function Ee() {
            xe.r || Ut(xe.c), (xe = xe.p);
          }
          function Se(t, e) {
            t && t.i && (Oe.delete(t), t.i(e));
          }
          function ke(t, e, n, o) {
            if (t && t.o) {
              if (Oe.has(t)) return;
              Oe.add(t),
                xe.c.push(function () {
                  Oe.delete(t), o && (n && t.d(1), o());
                }),
                t.o(e);
            } else o && o();
          }
          function je(t) {
            t && t.c();
          }
          function Te(t, e, n, o) {
            var r = t.$$,
              i = r.fragment,
              s = r.on_mount,
              a = r.on_destroy,
              c = r.after_update;
            i && i.m(e, n),
              o ||
                me(function () {
                  var e = s.map(Yt).filter(zt);
                  a ? a.push.apply(a, d(e)) : Ut(e), (t.$$.on_mount = []);
                }),
              c.forEach(me);
          }
          function _e(t, e) {
            var n = t.$$;
            null !== n.fragment &&
              (Ut(n.on_destroy),
              n.fragment && n.fragment.d(e),
              (n.on_destroy = n.fragment = null),
              (n.ctx = []));
          }
          function Ae(t, e) {
            -1 === t.$$.dirty[0] &&
              (ue.push(t), ve || ((ve = !0), he.then(be)), t.$$.dirty.fill(0)),
              (t.$$.dirty[(e / 31) | 0] |= 1 << e % 31);
          }
          function Ie(t, e, n, o, r, i, s, a) {
            void 0 === a && (a = [-1]);
            var c = Lt;
            ae(t);
            var l = (t.$$ = {
              fragment: null,
              ctx: null,
              props: i,
              update: Vt,
              not_equal: r,
              bound: Xt(),
              on_mount: [],
              on_destroy: [],
              on_disconnect: [],
              before_update: [],
              after_update: [],
              context: new Map(e.context || (c ? c.$$.context : [])),
              callbacks: Xt(),
              dirty: a,
              skip_bound: !1,
              root: e.target || c.$$.root,
            });
            s && s(l.root);
            var u = !1;
            if (
              ((l.ctx = n
                ? n(t, e.props || {}, function (e, n) {
                    var o =
                      !(arguments.length <= 2) && arguments.length - 2
                        ? arguments.length <= 2
                          ? void 0
                          : arguments[2]
                        : n;
                    return (
                      l.ctx &&
                        r(l.ctx[e], (l.ctx[e] = o)) &&
                        (!l.skip_bound && l.bound[e] && l.bound[e](o),
                        u && Ae(t, e)),
                      n
                    );
                  })
                : []),
              l.update(),
              (u = !0),
              Ut(l.before_update),
              (l.fragment = !!o && o(l.ctx)),
              e.target)
            ) {
              if (e.hydrate) {
                var f = (function (t) {
                  return Array.from(t.childNodes);
                })(e.target);
                l.fragment && l.fragment.l(f), f.forEach(Jt);
              } else l.fragment && l.fragment.c();
              e.intro && Se(t.$$.fragment),
                Te(t, e.target, e.anchor, e.customElement),
                be();
            }
            ae(c);
          }
          var Pe = (function () {
            function t() {
              m(this, t);
            }
            return (
              g(t, [
                {
                  key: "$destroy",
                  value: function () {
                    _e(this, 1), (this.$destroy = Vt);
                  },
                },
                {
                  key: "$on",
                  value: function (t, e) {
                    var n = this.$$.callbacks[t] || (this.$$.callbacks[t] = []);
                    return (
                      n.push(e),
                      function () {
                        var t = n.indexOf(e);
                        -1 !== t && n.splice(t, 1);
                      }
                    );
                  },
                },
                {
                  key: "$set",
                  value: function (t) {
                    var e;
                    this.$$set &&
                      ((e = t), 0 !== Object.keys(e).length) &&
                      ((this.$$.skip_bound = !0),
                      this.$$set(t),
                      (this.$$.skip_bound = !1));
                  },
                },
              ]),
              t
            );
          })();
          function Me(t) {
            var e, n, o, r, i;
            return {
              c: function () {
                re((e = Qt("button")), "aria-label", (n = t[3] ? t[3] : null)),
                  re(
                    e,
                    "class",
                    (o = ""
                      .concat(t[1] || "", " shepherd-button ")
                      .concat(t[4] ? "shepherd-button-secondary" : ""))
                  ),
                  (e.disabled = t[2]),
                  re(e, "tabindex", "0");
              },
              m: function (n, o) {
                Gt(n, e, o),
                  (e.innerHTML = t[5]),
                  r ||
                    ((i = oe(e, "click", function () {
                      zt(t[0]) && t[0].apply(this, arguments);
                    })),
                    (r = !0));
              },
              p: function (r, i) {
                var s = p(i, 1)[0];
                (t = r),
                  32 & s && (e.innerHTML = t[5]),
                  8 & s &&
                    n !== (n = t[3] ? t[3] : null) &&
                    re(e, "aria-label", n),
                  18 & s &&
                    o !==
                      (o = ""
                        .concat(t[1] || "", " shepherd-button ")
                        .concat(t[4] ? "shepherd-button-secondary" : "")) &&
                    re(e, "class", o),
                  4 & s && (e.disabled = t[2]);
              },
              i: Vt,
              o: Vt,
              d: function (t) {
                t && Jt(e), (r = !1), i();
              },
            };
          }
          function Le(t, e, n) {
            var o,
              r,
              i,
              s,
              a,
              c,
              l = e.config,
              u = e.step;
            function f(t) {
              return v(t) ? t.call(u) : t;
            }
            return (
              (t.$$set = function (t) {
                "config" in t && n(6, (l = t.config)),
                  "step" in t && n(7, (u = t.step));
              }),
              (t.$$.update = function () {
                192 & t.$$.dirty &&
                  (n(0, (o = l.action ? l.action.bind(u.tour) : null)),
                  n(1, (r = l.classes)),
                  n(2, (i = !!l.disabled && f(l.disabled))),
                  n(3, (s = l.label ? f(l.label) : null)),
                  n(4, (a = l.secondary)),
                  n(5, (c = l.text ? f(l.text) : null)));
              }),
              [o, r, i, s, a, c, l, u]
            );
          }
          var Ce = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t) {
              var o;
              return (
                m(this, n),
                Ie(u((o = e.call(this))), t, Le, Me, Zt, {
                  config: 6,
                  step: 7,
                }),
                o
              );
            }
            return g(n);
          })(Pe);
          function Be(t, e, n) {
            var o = t.slice();
            return (o[2] = e[n]), o;
          }
          function De(t) {
            for (var e, n, o = t[1], r = [], i = 0; i < o.length; i += 1)
              r[i] = He(Be(t, o, i));
            var s = function (t) {
              return ke(r[t], 1, 1, function () {
                r[t] = null;
              });
            };
            return {
              c: function () {
                for (var t = 0; t < r.length; t += 1) r[t].c();
                e = ee("");
              },
              m: function (t, o) {
                for (var i = 0; i < r.length; i += 1) r[i].m(t, o);
                Gt(t, e, o), (n = !0);
              },
              p: function (t, n) {
                if (3 & n) {
                  var i;
                  for (o = t[1], i = 0; i < o.length; i += 1) {
                    var a = Be(t, o, i);
                    r[i]
                      ? (r[i].p(a, n), Se(r[i], 1))
                      : ((r[i] = He(a)),
                        r[i].c(),
                        Se(r[i], 1),
                        r[i].m(e.parentNode, e));
                  }
                  for ($e(), i = o.length; i < r.length; i += 1) s(i);
                  Ee();
                }
              },
              i: function (t) {
                if (!n) {
                  for (var e = 0; e < o.length; e += 1) Se(r[e]);
                  n = !0;
                }
              },
              o: function (t) {
                r = r.filter(Boolean);
                for (var e = 0; e < r.length; e += 1) ke(r[e]);
                n = !1;
              },
              d: function (t) {
                !(function (t, e) {
                  for (var n = 0; n < t.length; n += 1) t[n] && t[n].d(e);
                })(r, t),
                  t && Jt(e);
              },
            };
          }
          function He(t) {
            var e, n;
            return (
              (e = new Ce({ props: { config: t[2], step: t[0] } })),
              {
                c: function () {
                  je(e.$$.fragment);
                },
                m: function (t, o) {
                  Te(e, t, o), (n = !0);
                },
                p: function (t, n) {
                  var o = {};
                  2 & n && (o.config = t[2]),
                    1 & n && (o.step = t[0]),
                    e.$set(o);
                },
                i: function (t) {
                  n || (Se(e.$$.fragment, t), (n = !0));
                },
                o: function (t) {
                  ke(e.$$.fragment, t), (n = !1);
                },
                d: function (t) {
                  _e(e, t);
                },
              }
            );
          }
          function Re(t) {
            var e,
              n,
              o = t[1] && De(t);
            return {
              c: function () {
                (e = Qt("footer")),
                  o && o.c(),
                  re(e, "class", "shepherd-footer");
              },
              m: function (t, r) {
                Gt(t, e, r), o && o.m(e, null), (n = !0);
              },
              p: function (t, n) {
                var r = p(n, 1)[0];
                t[1]
                  ? o
                    ? (o.p(t, r), 2 & r && Se(o, 1))
                    : ((o = De(t)).c(), Se(o, 1), o.m(e, null))
                  : o &&
                    ($e(),
                    ke(o, 1, 1, function () {
                      o = null;
                    }),
                    Ee());
              },
              i: function (t) {
                n || (Se(o), (n = !0));
              },
              o: function (t) {
                ke(o), (n = !1);
              },
              d: function (t) {
                t && Jt(e), o && o.d();
              },
            };
          }
          function We(t, e, n) {
            var o,
              r = e.step;
            return (
              (t.$$set = function (t) {
                "step" in t && n(0, (r = t.step));
              }),
              (t.$$.update = function () {
                1 & t.$$.dirty && n(1, (o = r.options.buttons));
              }),
              [r, o]
            );
          }
          var Fe = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t) {
              var o;
              return (
                m(this, n),
                Ie(u((o = e.call(this))), t, We, Re, Zt, { step: 0 }),
                o
              );
            }
            return g(n);
          })(Pe);
          function Ne(t) {
            var e, n, o, r, i;
            return {
              c: function () {
                (e = Qt("button")),
                  ((n = Qt("span")).textContent = "×"),
                  re(n, "aria-hidden", "true"),
                  re(
                    e,
                    "aria-label",
                    (o = t[0].label ? t[0].label : "Close Tour")
                  ),
                  re(e, "class", "shepherd-cancel-icon"),
                  re(e, "type", "button");
              },
              m: function (o, s) {
                Gt(o, e, s),
                  Kt(e, n),
                  r || ((i = oe(e, "click", t[1])), (r = !0));
              },
              p: function (t, n) {
                1 & p(n, 1)[0] &&
                  o !== (o = t[0].label ? t[0].label : "Close Tour") &&
                  re(e, "aria-label", o);
              },
              i: Vt,
              o: Vt,
              d: function (t) {
                t && Jt(e), (r = !1), i();
              },
            };
          }
          function Ve(t, e, n) {
            var o = e.cancelIcon,
              r = e.step;
            return (
              (t.$$set = function (t) {
                "cancelIcon" in t && n(0, (o = t.cancelIcon)),
                  "step" in t && n(2, (r = t.step));
              }),
              [
                o,
                function (t) {
                  t.preventDefault(), r.cancel();
                },
                r,
              ]
            );
          }
          var qe = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t) {
              var o;
              return (
                m(this, n),
                Ie(u((o = e.call(this))), t, Ve, Ne, Zt, {
                  cancelIcon: 0,
                  step: 2,
                }),
                o
              );
            }
            return g(n);
          })(Pe);
          function Ye(t) {
            var e;
            return {
              c: function () {
                re((e = Qt("h3")), "id", t[1]),
                  re(e, "class", "shepherd-title");
              },
              m: function (n, o) {
                Gt(n, e, o), t[3](e);
              },
              p: function (t, n) {
                2 & p(n, 1)[0] && re(e, "id", t[1]);
              },
              i: Vt,
              o: Vt,
              d: function (n) {
                n && Jt(e), t[3](null);
              },
            };
          }
          function Xe(t, e, n) {
            var o = e.labelId,
              r = e.element,
              i = e.title;
            return (
              le(function () {
                v(i) && n(2, (i = i())), n(0, (r.innerHTML = i), r);
              }),
              (t.$$set = function (t) {
                "labelId" in t && n(1, (o = t.labelId)),
                  "element" in t && n(0, (r = t.element)),
                  "title" in t && n(2, (i = t.title));
              }),
              [
                r,
                o,
                i,
                function (t) {
                  fe[t ? "unshift" : "push"](function () {
                    n(0, (r = t));
                  });
                },
              ]
            );
          }
          var Ue = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t) {
              var o;
              return (
                m(this, n),
                Ie(u((o = e.call(this))), t, Xe, Ye, Zt, {
                  labelId: 1,
                  element: 0,
                  title: 2,
                }),
                o
              );
            }
            return g(n);
          })(Pe);
          function ze(t) {
            var e, n;
            return (
              (e = new Ue({ props: { labelId: t[0], title: t[2] } })),
              {
                c: function () {
                  je(e.$$.fragment);
                },
                m: function (t, o) {
                  Te(e, t, o), (n = !0);
                },
                p: function (t, n) {
                  var o = {};
                  1 & n && (o.labelId = t[0]),
                    4 & n && (o.title = t[2]),
                    e.$set(o);
                },
                i: function (t) {
                  n || (Se(e.$$.fragment, t), (n = !0));
                },
                o: function (t) {
                  ke(e.$$.fragment, t), (n = !1);
                },
                d: function (t) {
                  _e(e, t);
                },
              }
            );
          }
          function Ze(t) {
            var e, n;
            return (
              (e = new qe({ props: { cancelIcon: t[3], step: t[1] } })),
              {
                c: function () {
                  je(e.$$.fragment);
                },
                m: function (t, o) {
                  Te(e, t, o), (n = !0);
                },
                p: function (t, n) {
                  var o = {};
                  8 & n && (o.cancelIcon = t[3]),
                    2 & n && (o.step = t[1]),
                    e.$set(o);
                },
                i: function (t) {
                  n || (Se(e.$$.fragment, t), (n = !0));
                },
                o: function (t) {
                  ke(e.$$.fragment, t), (n = !1);
                },
                d: function (t) {
                  _e(e, t);
                },
              }
            );
          }
          function Ke(t) {
            var e,
              n,
              o,
              r = t[2] && ze(t),
              i = t[3] && t[3].enabled && Ze(t);
            return {
              c: function () {
                (e = Qt("header")),
                  r && r.c(),
                  (n = ne()),
                  i && i.c(),
                  re(e, "class", "shepherd-header");
              },
              m: function (t, s) {
                Gt(t, e, s),
                  r && r.m(e, null),
                  Kt(e, n),
                  i && i.m(e, null),
                  (o = !0);
              },
              p: function (t, o) {
                var s = p(o, 1)[0];
                t[2]
                  ? r
                    ? (r.p(t, s), 4 & s && Se(r, 1))
                    : ((r = ze(t)).c(), Se(r, 1), r.m(e, n))
                  : r &&
                    ($e(),
                    ke(r, 1, 1, function () {
                      r = null;
                    }),
                    Ee()),
                  t[3] && t[3].enabled
                    ? i
                      ? (i.p(t, s), 8 & s && Se(i, 1))
                      : ((i = Ze(t)).c(), Se(i, 1), i.m(e, null))
                    : i &&
                      ($e(),
                      ke(i, 1, 1, function () {
                        i = null;
                      }),
                      Ee());
              },
              i: function (t) {
                o || (Se(r), Se(i), (o = !0));
              },
              o: function (t) {
                ke(r), ke(i), (o = !1);
              },
              d: function (t) {
                t && Jt(e), r && r.d(), i && i.d();
              },
            };
          }
          function Ge(t, e, n) {
            var o,
              r,
              i = e.labelId,
              s = e.step;
            return (
              (t.$$set = function (t) {
                "labelId" in t && n(0, (i = t.labelId)),
                  "step" in t && n(1, (s = t.step));
              }),
              (t.$$.update = function () {
                2 & t.$$.dirty &&
                  (n(2, (o = s.options.title)),
                  n(3, (r = s.options.cancelIcon)));
              }),
              [i, s, o, r]
            );
          }
          var Je = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t) {
              var o;
              return (
                m(this, n),
                Ie(u((o = e.call(this))), t, Ge, Ke, Zt, {
                  labelId: 0,
                  step: 1,
                }),
                o
              );
            }
            return g(n);
          })(Pe);
          function Qe(t) {
            var e;
            return {
              c: function () {
                re((e = Qt("div")), "class", "shepherd-text"),
                  re(e, "id", t[1]);
              },
              m: function (n, o) {
                Gt(n, e, o), t[3](e);
              },
              p: function (t, n) {
                2 & p(n, 1)[0] && re(e, "id", t[1]);
              },
              i: Vt,
              o: Vt,
              d: function (n) {
                n && Jt(e), t[3](null);
              },
            };
          }
          function tn(t, e, n) {
            var o = e.descriptionId,
              r = e.element,
              i = e.step;
            return (
              le(function () {
                var t = i.options.text;
                v(t) && (t = t.call(i)),
                  h(t) ? r.appendChild(t) : n(0, (r.innerHTML = t), r);
              }),
              (t.$$set = function (t) {
                "descriptionId" in t && n(1, (o = t.descriptionId)),
                  "element" in t && n(0, (r = t.element)),
                  "step" in t && n(2, (i = t.step));
              }),
              [
                r,
                o,
                i,
                function (t) {
                  fe[t ? "unshift" : "push"](function () {
                    n(0, (r = t));
                  });
                },
              ]
            );
          }
          var en = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t) {
              var o;
              return (
                m(this, n),
                Ie(u((o = e.call(this))), t, tn, Qe, Zt, {
                  descriptionId: 1,
                  element: 0,
                  step: 2,
                }),
                o
              );
            }
            return g(n);
          })(Pe);
          function nn(t) {
            var e, n;
            return (
              (e = new Je({ props: { labelId: t[1], step: t[2] } })),
              {
                c: function () {
                  je(e.$$.fragment);
                },
                m: function (t, o) {
                  Te(e, t, o), (n = !0);
                },
                p: function (t, n) {
                  var o = {};
                  2 & n && (o.labelId = t[1]),
                    4 & n && (o.step = t[2]),
                    e.$set(o);
                },
                i: function (t) {
                  n || (Se(e.$$.fragment, t), (n = !0));
                },
                o: function (t) {
                  ke(e.$$.fragment, t), (n = !1);
                },
                d: function (t) {
                  _e(e, t);
                },
              }
            );
          }
          function on(t) {
            var e, n;
            return (
              (e = new en({ props: { descriptionId: t[0], step: t[2] } })),
              {
                c: function () {
                  je(e.$$.fragment);
                },
                m: function (t, o) {
                  Te(e, t, o), (n = !0);
                },
                p: function (t, n) {
                  var o = {};
                  1 & n && (o.descriptionId = t[0]),
                    4 & n && (o.step = t[2]),
                    e.$set(o);
                },
                i: function (t) {
                  n || (Se(e.$$.fragment, t), (n = !0));
                },
                o: function (t) {
                  ke(e.$$.fragment, t), (n = !1);
                },
                d: function (t) {
                  _e(e, t);
                },
              }
            );
          }
          function rn(t) {
            var e, n;
            return (
              (e = new Fe({ props: { step: t[2] } })),
              {
                c: function () {
                  je(e.$$.fragment);
                },
                m: function (t, o) {
                  Te(e, t, o), (n = !0);
                },
                p: function (t, n) {
                  var o = {};
                  4 & n && (o.step = t[2]), e.$set(o);
                },
                i: function (t) {
                  n || (Se(e.$$.fragment, t), (n = !0));
                },
                o: function (t) {
                  ke(e.$$.fragment, t), (n = !1);
                },
                d: function (t) {
                  _e(e, t);
                },
              }
            );
          }
          function sn(t) {
            var e,
              n,
              o,
              r,
              i =
                !x(t[2].options.title) ||
                (t[2].options.cancelIcon && t[2].options.cancelIcon.enabled),
              s = !x(t[2].options.text),
              a =
                Array.isArray(t[2].options.buttons) &&
                t[2].options.buttons.length,
              c = i && nn(t),
              l = s && on(t),
              u = a && rn(t);
            return {
              c: function () {
                (e = Qt("div")),
                  c && c.c(),
                  (n = ne()),
                  l && l.c(),
                  (o = ne()),
                  u && u.c(),
                  re(e, "class", "shepherd-content");
              },
              m: function (t, i) {
                Gt(t, e, i),
                  c && c.m(e, null),
                  Kt(e, n),
                  l && l.m(e, null),
                  Kt(e, o),
                  u && u.m(e, null),
                  (r = !0);
              },
              p: function (t, r) {
                var f = p(r, 1)[0];
                4 & f &&
                  (i =
                    !x(t[2].options.title) ||
                    (t[2].options.cancelIcon &&
                      t[2].options.cancelIcon.enabled)),
                  i
                    ? c
                      ? (c.p(t, f), 4 & f && Se(c, 1))
                      : ((c = nn(t)).c(), Se(c, 1), c.m(e, n))
                    : c &&
                      ($e(),
                      ke(c, 1, 1, function () {
                        c = null;
                      }),
                      Ee()),
                  4 & f && (s = !x(t[2].options.text)),
                  s
                    ? l
                      ? (l.p(t, f), 4 & f && Se(l, 1))
                      : ((l = on(t)).c(), Se(l, 1), l.m(e, o))
                    : l &&
                      ($e(),
                      ke(l, 1, 1, function () {
                        l = null;
                      }),
                      Ee()),
                  4 & f &&
                    (a =
                      Array.isArray(t[2].options.buttons) &&
                      t[2].options.buttons.length),
                  a
                    ? u
                      ? (u.p(t, f), 4 & f && Se(u, 1))
                      : ((u = rn(t)).c(), Se(u, 1), u.m(e, null))
                    : u &&
                      ($e(),
                      ke(u, 1, 1, function () {
                        u = null;
                      }),
                      Ee());
              },
              i: function (t) {
                r || (Se(c), Se(l), Se(u), (r = !0));
              },
              o: function (t) {
                ke(c), ke(l), ke(u), (r = !1);
              },
              d: function (t) {
                t && Jt(e), c && c.d(), l && l.d(), u && u.d();
              },
            };
          }
          function an(t, e, n) {
            var o = e.descriptionId,
              r = e.labelId,
              i = e.step;
            return (
              (t.$$set = function (t) {
                "descriptionId" in t && n(0, (o = t.descriptionId)),
                  "labelId" in t && n(1, (r = t.labelId)),
                  "step" in t && n(2, (i = t.step));
              }),
              [o, r, i]
            );
          }
          var cn = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t) {
              var o;
              return (
                m(this, n),
                Ie(u((o = e.call(this))), t, an, sn, Zt, {
                  descriptionId: 0,
                  labelId: 1,
                  step: 2,
                }),
                o
              );
            }
            return g(n);
          })(Pe);
          function ln(t) {
            var e;
            return {
              c: function () {
                re((e = Qt("div")), "class", "shepherd-arrow"),
                  re(e, "data-popper-arrow", "");
              },
              m: function (t, n) {
                Gt(t, e, n);
              },
              d: function (t) {
                t && Jt(e);
              },
            };
          }
          function un(t) {
            var e,
              n,
              o,
              r,
              i,
              s,
              a,
              c,
              l =
                t[4].options.arrow &&
                t[4].options.attachTo &&
                t[4].options.attachTo.element &&
                t[4].options.attachTo.on &&
                ln();
            o = new cn({
              props: { descriptionId: t[2], labelId: t[3], step: t[4] },
            });
            for (
              var u = [
                  {
                    "aria-describedby": (r = x(t[4].options.text)
                      ? null
                      : t[2]),
                  },
                  { "aria-labelledby": (i = t[4].options.title ? t[3] : null) },
                  t[1],
                  { role: "dialog" },
                  { tabindex: "0" },
                ],
                f = {},
                d = 0;
              d < u.length;
              d += 1
            )
              f = qt(f, u[d]);
            return {
              c: function () {
                (e = Qt("div")),
                  l && l.c(),
                  (n = ne()),
                  je(o.$$.fragment),
                  ie(e, f),
                  se(e, "shepherd-has-cancel-icon", t[5]),
                  se(e, "shepherd-has-title", t[6]),
                  se(e, "shepherd-element", !0);
              },
              m: function (r, i) {
                Gt(r, e, i),
                  l && l.m(e, null),
                  Kt(e, n),
                  Te(o, e, null),
                  t[13](e),
                  (s = !0),
                  a || ((c = oe(e, "keydown", t[7])), (a = !0));
              },
              p: function (t, a) {
                var c = p(a, 1)[0];
                t[4].options.arrow &&
                t[4].options.attachTo &&
                t[4].options.attachTo.element &&
                t[4].options.attachTo.on
                  ? l || ((l = ln()).c(), l.m(e, n))
                  : l && (l.d(1), (l = null));
                var d = {};
                4 & c && (d.descriptionId = t[2]),
                  8 & c && (d.labelId = t[3]),
                  16 & c && (d.step = t[4]),
                  o.$set(d),
                  ie(
                    e,
                    (f = (function (t, e) {
                      for (
                        var n = {}, o = {}, r = { $$scope: 1 }, i = t.length;
                        i--;

                      ) {
                        var s = t[i],
                          a = e[i];
                        if (a) {
                          for (var c in s) c in a || (o[c] = 1);
                          for (var l in a) r[l] || ((n[l] = a[l]), (r[l] = 1));
                          t[i] = a;
                        } else for (var u in s) r[u] = 1;
                      }
                      for (var f in o) f in n || (n[f] = void 0);
                      return n;
                    })(u, [
                      (!s ||
                        (20 & c &&
                          r !== (r = x(t[4].options.text) ? null : t[2]))) && {
                        "aria-describedby": r,
                      },
                      (!s ||
                        (24 & c &&
                          i !== (i = t[4].options.title ? t[3] : null))) && {
                        "aria-labelledby": i,
                      },
                      2 & c && t[1],
                      { role: "dialog" },
                      { tabindex: "0" },
                    ]))
                  ),
                  se(e, "shepherd-has-cancel-icon", t[5]),
                  se(e, "shepherd-has-title", t[6]),
                  se(e, "shepherd-element", !0);
              },
              i: function (t) {
                s || (Se(o.$$.fragment, t), (s = !0));
              },
              o: function (t) {
                ke(o.$$.fragment, t), (s = !1);
              },
              d: function (n) {
                n && Jt(e), l && l.d(), _e(o), t[13](null), (a = !1), c();
              },
            };
          }
          function fn(t) {
            return t.split(" ").filter(function (t) {
              return !!t.length;
            });
          }
          function pn(t, e, n) {
            var o,
              r,
              i,
              s,
              a = e.classPrefix,
              c = e.element,
              l = e.descriptionId,
              u = e.firstFocusableElement,
              f = e.focusableElements,
              p = e.labelId,
              h = e.lastFocusableElement,
              v = e.step,
              m = e.dataStepId;
            return (
              (s = function () {
                var t, e, o;
                n(
                  1,
                  ((t = {}),
                  (e = "data-".concat(a, "shepherd-step-id")),
                  (o = v.id),
                  (e = b(e)) in t
                    ? Object.defineProperty(t, e, {
                        value: o,
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                      })
                    : (t[e] = o),
                  (m = t))
                ),
                  n(
                    9,
                    (f = c.querySelectorAll(
                      'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]'
                    ))
                  ),
                  n(8, (u = f[0])),
                  n(10, (h = f[f.length - 1]));
              }),
              ce().$$.on_mount.push(s),
              le(function () {
                i !== v.options.classes &&
                  ((function (t) {
                    if (y(t)) {
                      var e,
                        n = fn(t);
                      n.length && (e = c.classList).remove.apply(e, d(n));
                    }
                  })(i),
                  (function (t) {
                    if (y(t)) {
                      var e,
                        n = fn(t);
                      n.length && (e = c.classList).add.apply(e, d(n));
                    }
                  })((i = v.options.classes)));
              }),
              (t.$$set = function (t) {
                "classPrefix" in t && n(11, (a = t.classPrefix)),
                  "element" in t && n(0, (c = t.element)),
                  "descriptionId" in t && n(2, (l = t.descriptionId)),
                  "firstFocusableElement" in t &&
                    n(8, (u = t.firstFocusableElement)),
                  "focusableElements" in t && n(9, (f = t.focusableElements)),
                  "labelId" in t && n(3, (p = t.labelId)),
                  "lastFocusableElement" in t &&
                    n(10, (h = t.lastFocusableElement)),
                  "step" in t && n(4, (v = t.step)),
                  "dataStepId" in t && n(1, (m = t.dataStepId));
              }),
              (t.$$.update = function () {
                16 & t.$$.dirty &&
                  (n(
                    5,
                    (o =
                      v.options &&
                      v.options.cancelIcon &&
                      v.options.cancelIcon.enabled)
                  ),
                  n(6, (r = v.options && v.options.title)));
              }),
              [
                c,
                m,
                l,
                p,
                v,
                o,
                r,
                function (t) {
                  var e = v.tour;
                  switch (t.keyCode) {
                    case 9:
                      if (0 === f.length) {
                        t.preventDefault();
                        break;
                      }
                      t.shiftKey
                        ? (document.activeElement === u ||
                            document.activeElement.classList.contains(
                              "shepherd-element"
                            )) &&
                          (t.preventDefault(), h.focus())
                        : document.activeElement === h &&
                          (t.preventDefault(), u.focus());
                      break;
                    case 27:
                      e.options.exitOnEsc && v.cancel();
                      break;
                    case 37:
                      e.options.keyboardNavigation && e.back();
                      break;
                    case 39:
                      e.options.keyboardNavigation && e.next();
                  }
                },
                u,
                f,
                h,
                a,
                function () {
                  return c;
                },
                function (t) {
                  fe[t ? "unshift" : "push"](function () {
                    n(0, (c = t));
                  });
                },
              ]
            );
          }
          var dn = (function (t) {
              s(n, t);
              var e = c(n);
              function n(t) {
                var o;
                return (
                  m(this, n),
                  Ie(u((o = e.call(this))), t, pn, un, Zt, {
                    classPrefix: 11,
                    element: 0,
                    descriptionId: 2,
                    firstFocusableElement: 8,
                    focusableElements: 9,
                    labelId: 3,
                    lastFocusableElement: 10,
                    step: 4,
                    dataStepId: 1,
                    getElement: 12,
                  }),
                  o
                );
              }
              return (
                g(n, [
                  {
                    key: "getElement",
                    get: function () {
                      return this.$$.ctx[12];
                    },
                  },
                ]),
                n
              );
            })(Pe),
            hn = (function (t, e) {
              return (
                (function (t, e) {
                  t.exports = {
                    polyfill: function () {
                      var t = window,
                        e = document;
                      if (
                        !("scrollBehavior" in e.documentElement.style) ||
                        !0 === t.__forceSmoothScrollPolyfill__
                      ) {
                        var n,
                          o = t.HTMLElement || t.Element,
                          r = {
                            scroll: t.scroll || t.scrollTo,
                            scrollBy: t.scrollBy,
                            elementScroll: o.prototype.scroll || a,
                            scrollIntoView: o.prototype.scrollIntoView,
                          },
                          i =
                            t.performance && t.performance.now
                              ? t.performance.now.bind(t.performance)
                              : Date.now,
                          s =
                            ((n = t.navigator.userAgent),
                            new RegExp(
                              ["MSIE ", "Trident/", "Edge/"].join("|")
                            ).test(n)
                              ? 1
                              : 0);
                        (t.scroll = t.scrollTo =
                          function () {
                            void 0 !== arguments[0] &&
                              (!0 !== c(arguments[0])
                                ? h.call(
                                    t,
                                    e.body,
                                    void 0 !== arguments[0].left
                                      ? ~~arguments[0].left
                                      : t.scrollX || t.pageXOffset,
                                    void 0 !== arguments[0].top
                                      ? ~~arguments[0].top
                                      : t.scrollY || t.pageYOffset
                                  )
                                : r.scroll.call(
                                    t,
                                    void 0 !== arguments[0].left
                                      ? arguments[0].left
                                      : "object" !== w(arguments[0])
                                      ? arguments[0]
                                      : t.scrollX || t.pageXOffset,
                                    void 0 !== arguments[0].top
                                      ? arguments[0].top
                                      : void 0 !== arguments[1]
                                      ? arguments[1]
                                      : t.scrollY || t.pageYOffset
                                  ));
                          }),
                          (t.scrollBy = function () {
                            void 0 !== arguments[0] &&
                              (c(arguments[0])
                                ? r.scrollBy.call(
                                    t,
                                    void 0 !== arguments[0].left
                                      ? arguments[0].left
                                      : "object" !== w(arguments[0])
                                      ? arguments[0]
                                      : 0,
                                    void 0 !== arguments[0].top
                                      ? arguments[0].top
                                      : void 0 !== arguments[1]
                                      ? arguments[1]
                                      : 0
                                  )
                                : h.call(
                                    t,
                                    e.body,
                                    ~~arguments[0].left +
                                      (t.scrollX || t.pageXOffset),
                                    ~~arguments[0].top +
                                      (t.scrollY || t.pageYOffset)
                                  ));
                          }),
                          (o.prototype.scroll = o.prototype.scrollTo =
                            function () {
                              if (void 0 !== arguments[0])
                                if (!0 !== c(arguments[0])) {
                                  var t = arguments[0].left,
                                    e = arguments[0].top;
                                  h.call(
                                    this,
                                    this,
                                    void 0 === t ? this.scrollLeft : ~~t,
                                    void 0 === e ? this.scrollTop : ~~e
                                  );
                                } else {
                                  if (
                                    "number" == typeof arguments[0] &&
                                    void 0 === arguments[1]
                                  )
                                    throw new SyntaxError(
                                      "Value could not be converted"
                                    );
                                  r.elementScroll.call(
                                    this,
                                    void 0 !== arguments[0].left
                                      ? ~~arguments[0].left
                                      : "object" !== w(arguments[0])
                                      ? ~~arguments[0]
                                      : this.scrollLeft,
                                    void 0 !== arguments[0].top
                                      ? ~~arguments[0].top
                                      : void 0 !== arguments[1]
                                      ? ~~arguments[1]
                                      : this.scrollTop
                                  );
                                }
                            }),
                          (o.prototype.scrollBy = function () {
                            void 0 !== arguments[0] &&
                              (!0 !== c(arguments[0])
                                ? this.scroll({
                                    left: ~~arguments[0].left + this.scrollLeft,
                                    top: ~~arguments[0].top + this.scrollTop,
                                    behavior: arguments[0].behavior,
                                  })
                                : r.elementScroll.call(
                                    this,
                                    void 0 !== arguments[0].left
                                      ? ~~arguments[0].left + this.scrollLeft
                                      : ~~arguments[0] + this.scrollLeft,
                                    void 0 !== arguments[0].top
                                      ? ~~arguments[0].top + this.scrollTop
                                      : ~~arguments[1] + this.scrollTop
                                  ));
                          }),
                          (o.prototype.scrollIntoView = function () {
                            if (!0 !== c(arguments[0])) {
                              var n = p(this),
                                o = n.getBoundingClientRect(),
                                i = this.getBoundingClientRect();
                              n !== e.body
                                ? (h.call(
                                    this,
                                    n,
                                    n.scrollLeft + i.left - o.left,
                                    n.scrollTop + i.top - o.top
                                  ),
                                  "fixed" !== t.getComputedStyle(n).position &&
                                    t.scrollBy({
                                      left: o.left,
                                      top: o.top,
                                      behavior: "smooth",
                                    }))
                                : t.scrollBy({
                                    left: i.left,
                                    top: i.top,
                                    behavior: "smooth",
                                  });
                            } else
                              r.scrollIntoView.call(
                                this,
                                void 0 === arguments[0] || arguments[0]
                              );
                          });
                      }
                      function a(t, e) {
                        (this.scrollLeft = t), (this.scrollTop = e);
                      }
                      function c(t) {
                        if (
                          null === t ||
                          "object" !== w(t) ||
                          void 0 === t.behavior ||
                          "auto" === t.behavior ||
                          "instant" === t.behavior
                        )
                          return !0;
                        if ("object" === w(t) && "smooth" === t.behavior)
                          return !1;
                        throw new TypeError(
                          "behavior member of ScrollOptions " +
                            t.behavior +
                            " is not a valid value for enumeration ScrollBehavior."
                        );
                      }
                      function l(t, e) {
                        return "Y" === e
                          ? t.clientHeight + s < t.scrollHeight
                          : "X" === e
                          ? t.clientWidth + s < t.scrollWidth
                          : void 0;
                      }
                      function u(e, n) {
                        var o = t.getComputedStyle(e, null)["overflow" + n];
                        return "auto" === o || "scroll" === o;
                      }
                      function f(t) {
                        var e = l(t, "Y") && u(t, "Y"),
                          n = l(t, "X") && u(t, "X");
                        return e || n;
                      }
                      function p(t) {
                        for (; t !== e.body && !1 === f(t); )
                          t = t.parentNode || t.host;
                        return t;
                      }
                      function d(e) {
                        var n,
                          o,
                          r,
                          s,
                          a = (i() - e.startTime) / 468;
                        (s = a = a > 1 ? 1 : a),
                          (n = 0.5 * (1 - Math.cos(Math.PI * s))),
                          (o = e.startX + (e.x - e.startX) * n),
                          (r = e.startY + (e.y - e.startY) * n),
                          e.method.call(e.scrollable, o, r),
                          (o === e.x && r === e.y) ||
                            t.requestAnimationFrame(d.bind(t, e));
                      }
                      function h(n, o, s) {
                        var c,
                          l,
                          u,
                          f,
                          p = i();
                        n === e.body
                          ? ((c = t),
                            (l = t.scrollX || t.pageXOffset),
                            (u = t.scrollY || t.pageYOffset),
                            (f = r.scroll))
                          : ((c = n),
                            (l = n.scrollLeft),
                            (u = n.scrollTop),
                            (f = a)),
                          d({
                            scrollable: c,
                            method: f,
                            startTime: p,
                            startX: l,
                            startY: u,
                            x: o,
                            y: s,
                          });
                      }
                    },
                  };
                })((e = { exports: {} })),
                e.exports
              );
            })();
          hn.polyfill, hn.polyfill();
          var vn = (function (t) {
            s(n, t);
            var e = c(n);
            function n(t, o) {
              var r;
              return (
                m(this, n),
                void 0 === o && (o = {}),
                ((r = e.call(this, t, o)).tour = t),
                (r.classPrefix = r.tour.options
                  ? Ht(r.tour.options.classPrefix)
                  : ""),
                (r.styles = t.styles),
                (r._resolvedAttachTo = null),
                $(u(r)),
                r._setOptions(o),
                l(r, u(r))
              );
            }
            return (
              g(n, [
                {
                  key: "cancel",
                  value: function () {
                    this.tour.cancel(), this.trigger("cancel");
                  },
                },
                {
                  key: "complete",
                  value: function () {
                    this.tour.complete(), this.trigger("complete");
                  },
                },
                {
                  key: "destroy",
                  value: function () {
                    this.tooltip &&
                      (this.tooltip.destroy(), (this.tooltip = null)),
                      h(this.el) &&
                        this.el.parentNode &&
                        (this.el.parentNode.removeChild(this.el),
                        (this.el = null)),
                      this._updateStepTargetOnHide(),
                      this.trigger("destroy");
                  },
                },
                {
                  key: "getTour",
                  value: function () {
                    return this.tour;
                  },
                },
                {
                  key: "hide",
                  value: function () {
                    this.tour.modal.hide(),
                      this.trigger("before-hide"),
                      this.el && (this.el.hidden = !0),
                      this._updateStepTargetOnHide(),
                      this.trigger("hide");
                  },
                },
                {
                  key: "_resolveAttachToOptions",
                  value: function () {
                    return (
                      (this._resolvedAttachTo = (function (t) {
                        var e = t.options.attachTo || {},
                          n = Object.assign({}, e);
                        if (
                          (v(n.element) && (n.element = n.element.call(t)),
                          y(n.element))
                        ) {
                          try {
                            n.element = document.querySelector(n.element);
                          } catch (t) {}
                          n.element ||
                            console.error(
                              "The element for this Shepherd step was not found ".concat(
                                e.element
                              )
                            );
                        }
                        return n;
                      })(this)),
                      this._resolvedAttachTo
                    );
                  },
                },
                {
                  key: "_getResolvedAttachToOptions",
                  value: function () {
                    return null === this._resolvedAttachTo
                      ? this._resolveAttachToOptions()
                      : this._resolvedAttachTo;
                  },
                },
                {
                  key: "isOpen",
                  value: function () {
                    return Boolean(this.el && !this.el.hidden);
                  },
                },
                {
                  key: "show",
                  value: function () {
                    var t = this;
                    if (v(this.options.beforeShowPromise)) {
                      var e = this.options.beforeShowPromise();
                      if (!x(e))
                        return e.then(function () {
                          return t._show();
                        });
                    }
                    this._show();
                  },
                },
                {
                  key: "updateStepOptions",
                  value: function (t) {
                    Object.assign(this.options, t),
                      this.shepherdElementComponent &&
                        this.shepherdElementComponent.$set({ step: this });
                  },
                },
                {
                  key: "getElement",
                  value: function () {
                    return this.el;
                  },
                },
                {
                  key: "getTarget",
                  value: function () {
                    return this.target;
                  },
                },
                {
                  key: "_createTooltipContent",
                  value: function () {
                    var t = "".concat(this.id, "-description"),
                      e = "".concat(this.id, "-label");
                    return (
                      (this.shepherdElementComponent = new dn({
                        target:
                          this.tour.options.stepsContainer || document.body,
                        props: {
                          classPrefix: this.classPrefix,
                          descriptionId: t,
                          labelId: e,
                          step: this,
                          styles: this.styles,
                        },
                      })),
                      this.shepherdElementComponent.getElement()
                    );
                  },
                },
                {
                  key: "_scrollTo",
                  value: function (t) {
                    var e = this._getResolvedAttachToOptions().element;
                    v(this.options.scrollToHandler)
                      ? this.options.scrollToHandler(e)
                      : e instanceof Element &&
                        "function" == typeof e.scrollIntoView &&
                        e.scrollIntoView(t);
                  },
                },
                {
                  key: "_getClassOptions",
                  value: function (t) {
                    var e =
                        this.tour &&
                        this.tour.options &&
                        this.tour.options.defaultStepOptions,
                      n = t.classes ? t.classes : "",
                      o = e && e.classes ? e.classes : "",
                      r = [].concat(d(n.split(" ")), d(o.split(" "))),
                      i = new Set(r);
                    return Array.from(i).join(" ").trim();
                  },
                },
                {
                  key: "_setOptions",
                  value: function (t) {
                    var e = this;
                    void 0 === t && (t = {});
                    var n =
                      this.tour &&
                      this.tour.options &&
                      this.tour.options.defaultStepOptions;
                    (n = f({}, n || {})),
                      (this.options = Object.assign({ arrow: !0 }, n, t));
                    var o = this.options.when;
                    (this.options.classes = this._getClassOptions(t)),
                      this.destroy(),
                      (this.id = this.options.id || "step-".concat(Ft())),
                      o &&
                        Object.keys(o).forEach(function (t) {
                          e.on(t, o[t], e);
                        });
                  },
                },
                {
                  key: "_setupElements",
                  value: function () {
                    x(this.el) || this.destroy(),
                      (this.el = this._createTooltipContent()),
                      this.options.advanceOn &&
                        (function (t) {
                          var e = t.options.advanceOn || {},
                            n = e.event,
                            o = e.selector;
                          if (!n)
                            return console.error(
                              "advanceOn was defined, but no event name was passed."
                            );
                          var r,
                            i = (function (t, e) {
                              return function (n) {
                                if (e.isOpen()) {
                                  var o = e.el && n.currentTarget === e.el;
                                  ((!x(t) && n.currentTarget.matches(t)) ||
                                    o) &&
                                    e.tour.next();
                                }
                              };
                            })(o, t);
                          try {
                            r = document.querySelector(o);
                          } catch (t) {}
                          if (!x(o) && !r)
                            return console.error(
                              "No element was found for the selector supplied to advanceOn: ".concat(
                                o
                              )
                            );
                          r
                            ? (r.addEventListener(n, i),
                              t.on("destroy", function () {
                                return r.removeEventListener(n, i);
                              }))
                            : (document.body.addEventListener(n, i, !0),
                              t.on("destroy", function () {
                                return document.body.removeEventListener(
                                  n,
                                  i,
                                  !0
                                );
                              }));
                        })(this),
                      Wt(this);
                  },
                },
                {
                  key: "_show",
                  value: function () {
                    var t = this;
                    this.trigger("before-show"),
                      this._resolveAttachToOptions(),
                      this._setupElements(),
                      this.tour.modal || this.tour._setupModal(),
                      this.tour.modal.setupForStep(this),
                      this._styleTargetElementForStep(this),
                      (this.el.hidden = !1),
                      this.options.scrollTo &&
                        setTimeout(function () {
                          t._scrollTo(t.options.scrollTo);
                        }),
                      (this.el.hidden = !1);
                    var e = this.shepherdElementComponent.getElement(),
                      n = this.target || document.body;
                    n.classList.add(
                      "".concat(this.classPrefix, "shepherd-enabled")
                    ),
                      n.classList.add(
                        "".concat(this.classPrefix, "shepherd-target")
                      ),
                      e.classList.add("shepherd-enabled"),
                      this.trigger("show");
                  },
                },
                {
                  key: "_styleTargetElementForStep",
                  value: function (t) {
                    var e = t.target;
                    e &&
                      (t.options.highlightClass &&
                        e.classList.add(t.options.highlightClass),
                      e.classList.remove("shepherd-target-click-disabled"),
                      !1 === t.options.canClickTarget &&
                        e.classList.add("shepherd-target-click-disabled"));
                  },
                },
                {
                  key: "_updateStepTargetOnHide",
                  value: function () {
                    var t = this.target || document.body;
                    this.options.highlightClass &&
                      t.classList.remove(this.options.highlightClass),
                      t.classList.remove(
                        "shepherd-target-click-disabled",
                        "".concat(this.classPrefix, "shepherd-enabled"),
                        "".concat(this.classPrefix, "shepherd-target")
                      );
                  },
                },
              ]),
              n
            );
          })(O);
          function mn(t) {
            var e, n, o, r, i;
            return {
              c: function () {
                (e = te("svg")),
                  re((n = te("path")), "d", t[2]),
                  re(
                    e,
                    "class",
                    (o = "".concat(
                      t[1] ? "shepherd-modal-is-visible" : "",
                      " shepherd-modal-overlay-container"
                    ))
                  );
              },
              m: function (o, s) {
                Gt(o, e, s),
                  Kt(e, n),
                  t[11](e),
                  r || ((i = oe(e, "touchmove", t[3])), (r = !0));
              },
              p: function (t, r) {
                var i = p(r, 1)[0];
                4 & i && re(n, "d", t[2]),
                  2 & i &&
                    o !==
                      (o = "".concat(
                        t[1] ? "shepherd-modal-is-visible" : "",
                        " shepherd-modal-overlay-container"
                      )) &&
                    re(e, "class", o);
              },
              i: Vt,
              o: Vt,
              d: function (n) {
                n && Jt(e), t[11](null), (r = !1), i();
              },
            };
          }
          function yn(t) {
            if (!t) return null;
            var e =
              t instanceof HTMLElement && window.getComputedStyle(t).overflowY;
            return "hidden" !== e &&
              "visible" !== e &&
              t.scrollHeight >= t.clientHeight
              ? t
              : yn(t.parentElement);
          }
          function gn(t, e, n) {
            var o = e.element,
              r = e.openingProperties;
            Ft();
            var i,
              s = !1,
              a = void 0;
            function c() {
              n(4, (r = { width: 0, height: 0, x: 0, y: 0, r: 0 }));
            }
            function l() {
              n(1, (s = !1)), d();
            }
            function u(t, e, o, i) {
              if ((void 0 === t && (t = 0), void 0 === e && (e = 0), i)) {
                var s = (function (t, e) {
                    var n = t.getBoundingClientRect(),
                      o = n.y || n.top,
                      r = n.bottom || o + n.height;
                    if (e) {
                      var i = e.getBoundingClientRect(),
                        s = i.y || i.top,
                        a = i.bottom || s + i.height;
                      (o = Math.max(o, s)), (r = Math.min(r, a));
                    }
                    return { y: o, height: Math.max(r - o, 0) };
                  })(i, o),
                  a = s.y,
                  l = s.height,
                  u = i.getBoundingClientRect(),
                  f = u.x,
                  p = u.width,
                  d = u.left;
                n(
                  4,
                  (r = {
                    width: p + 2 * t,
                    height: l + 2 * t,
                    x: (f || d) - t,
                    y: a - t,
                    r: e,
                  })
                );
              } else c();
            }
            function f() {
              n(1, (s = !0));
            }
            c();
            var p = function (t) {
              t.preventDefault();
            };
            function d() {
              a && (cancelAnimationFrame(a), (a = void 0)),
                window.removeEventListener("touchmove", p, { passive: !1 });
            }
            return (
              (t.$$set = function (t) {
                "element" in t && n(0, (o = t.element)),
                  "openingProperties" in t && n(4, (r = t.openingProperties));
              }),
              (t.$$.update = function () {
                var e, o, s, a, c, l, u, f, p, d, h, v;
                16 & t.$$.dirty &&
                  n(
                    2,
                    ((o = (e = r).width),
                    (s = e.height),
                    (c = void 0 === (a = e.x) ? 0 : a),
                    (u = void 0 === (l = e.y) ? 0 : l),
                    (p = void 0 === (f = e.r) ? 0 : f),
                    (h = (d = window).innerWidth),
                    (v = d.innerHeight),
                    (i = "M"
                      .concat(h, ",")
                      .concat(v, "H0V0H")
                      .concat(h, "V")
                      .concat(v, "ZM")
                      .concat(c + p, ",")
                      .concat(u, "a")
                      .concat(p, ",")
                      .concat(p, ",0,0,0-")
                      .concat(p, ",")
                      .concat(p, "V")
                      .concat(s + u - p, "a")
                      .concat(p, ",")
                      .concat(p, ",0,0,0,")
                      .concat(p, ",")
                      .concat(p, "H")
                      .concat(o + c - p, "a")
                      .concat(p, ",")
                      .concat(p, ",0,0,0,")
                      .concat(p, "-")
                      .concat(p, "V")
                      .concat(u + p, "a")
                      .concat(p, ",")
                      .concat(p, ",0,0,0-")
                      .concat(p, "-")
                      .concat(p, "Z")))
                  );
              }),
              [
                o,
                s,
                i,
                function (t) {
                  t.stopPropagation();
                },
                r,
                function () {
                  return o;
                },
                c,
                l,
                u,
                function (t) {
                  d(),
                    t.tour.options.useModalOverlay
                      ? ((function (t) {
                          var e = t.options,
                            n = e.modalOverlayOpeningPadding,
                            o = e.modalOverlayOpeningRadius,
                            r = yn(t.target);
                          (function e() {
                            (a = void 0),
                              u(n, o, r, t.target),
                              (a = requestAnimationFrame(e));
                          })(),
                            window.addEventListener("touchmove", p, {
                              passive: !1,
                            });
                        })(t),
                        f())
                      : l();
                },
                f,
                function (t) {
                  fe[t ? "unshift" : "push"](function () {
                    n(0, (o = t));
                  });
                },
              ]
            );
          }
          var bn = (function (t) {
              s(n, t);
              var e = c(n);
              function n(t) {
                var o;
                return (
                  m(this, n),
                  Ie(u((o = e.call(this))), t, gn, mn, Zt, {
                    element: 0,
                    openingProperties: 4,
                    getElement: 5,
                    closeModalOpening: 6,
                    hide: 7,
                    positionModal: 8,
                    setupForStep: 9,
                    show: 10,
                  }),
                  o
                );
              }
              return (
                g(n, [
                  {
                    key: "getElement",
                    get: function () {
                      return this.$$.ctx[5];
                    },
                  },
                  {
                    key: "closeModalOpening",
                    get: function () {
                      return this.$$.ctx[6];
                    },
                  },
                  {
                    key: "hide",
                    get: function () {
                      return this.$$.ctx[7];
                    },
                  },
                  {
                    key: "positionModal",
                    get: function () {
                      return this.$$.ctx[8];
                    },
                  },
                  {
                    key: "setupForStep",
                    get: function () {
                      return this.$$.ctx[9];
                    },
                  },
                  {
                    key: "show",
                    get: function () {
                      return this.$$.ctx[10];
                    },
                  },
                ]),
                n
              );
            })(Pe),
            wn = new O(),
            xn = (function (t) {
              s(n, t);
              var e = c(n);
              function n(t) {
                var o;
                return (
                  m(this, n),
                  void 0 === t && (t = {}),
                  $(u((o = e.call(this, t)))),
                  (o.options = Object.assign(
                    {},
                    { exitOnEsc: !0, keyboardNavigation: !0 },
                    t
                  )),
                  (o.classPrefix = Ht(o.options.classPrefix)),
                  (o.steps = []),
                  o.addSteps(o.options.steps),
                  [
                    "active",
                    "cancel",
                    "complete",
                    "inactive",
                    "show",
                    "start",
                  ].map(function (t) {
                    var e;
                    (e = t),
                      o.on(e, function (t) {
                        ((t = t || {}).tour = u(o)), wn.trigger(e, t);
                      });
                  }),
                  o._setTourID(),
                  l(o, u(o))
                );
              }
              return (
                g(n, [
                  {
                    key: "addStep",
                    value: function (t, e) {
                      var n = t;
                      return (
                        n instanceof vn
                          ? (n.tour = this)
                          : (n = new vn(this, n)),
                        x(e) ? this.steps.push(n) : this.steps.splice(e, 0, n),
                        n
                      );
                    },
                  },
                  {
                    key: "addSteps",
                    value: function (t) {
                      var e = this;
                      return (
                        Array.isArray(t) &&
                          t.forEach(function (t) {
                            e.addStep(t);
                          }),
                        this
                      );
                    },
                  },
                  {
                    key: "back",
                    value: function () {
                      var t = this.steps.indexOf(this.currentStep);
                      this.show(t - 1, !1);
                    },
                  },
                  {
                    key: "cancel",
                    value: function () {
                      if (this.options.confirmCancel) {
                        var t =
                          this.options.confirmCancelMessage ||
                          "Are you sure you want to stop the tour?";
                        window.confirm(t) && this._done("cancel");
                      } else this._done("cancel");
                    },
                  },
                  {
                    key: "complete",
                    value: function () {
                      this._done("complete");
                    },
                  },
                  {
                    key: "getById",
                    value: function (t) {
                      return this.steps.find(function (e) {
                        return e.id === t;
                      });
                    },
                  },
                  {
                    key: "getCurrentStep",
                    value: function () {
                      return this.currentStep;
                    },
                  },
                  {
                    key: "hide",
                    value: function () {
                      var t = this.getCurrentStep();
                      if (t) return t.hide();
                    },
                  },
                  {
                    key: "isActive",
                    value: function () {
                      return wn.activeTour === this;
                    },
                  },
                  {
                    key: "next",
                    value: function () {
                      var t = this.steps.indexOf(this.currentStep);
                      t === this.steps.length - 1
                        ? this.complete()
                        : this.show(t + 1, !0);
                    },
                  },
                  {
                    key: "removeStep",
                    value: function (t) {
                      var e = this,
                        n = this.getCurrentStep();
                      this.steps.some(function (n, o) {
                        if (n.id === t)
                          return (
                            n.isOpen() && n.hide(),
                            n.destroy(),
                            e.steps.splice(o, 1),
                            !0
                          );
                      }),
                        n &&
                          n.id === t &&
                          ((this.currentStep = void 0),
                          this.steps.length ? this.show(0) : this.cancel());
                    },
                  },
                  {
                    key: "show",
                    value: function (t, e) {
                      void 0 === t && (t = 0), void 0 === e && (e = !0);
                      var n = y(t) ? this.getById(t) : this.steps[t];
                      n &&
                        (this._updateStateBeforeShow(),
                        v(n.options.showOn) && !n.options.showOn()
                          ? this._skipStep(n, e)
                          : (this.trigger("show", {
                              step: n,
                              previous: this.currentStep,
                            }),
                            (this.currentStep = n),
                            n.show()));
                    },
                  },
                  {
                    key: "start",
                    value: function () {
                      this.trigger("start"),
                        (this.focusedElBeforeOpen = document.activeElement),
                        (this.currentStep = null),
                        this._setupModal(),
                        this._setupActiveTour(),
                        this.next();
                    },
                  },
                  {
                    key: "_done",
                    value: function (t) {
                      var e = this.steps.indexOf(this.currentStep);
                      if (
                        (Array.isArray(this.steps) &&
                          this.steps.forEach(function (t) {
                            return t.destroy();
                          }),
                        this &&
                          this.steps.forEach(function (t) {
                            t.options &&
                              !1 === t.options.canClickTarget &&
                              t.options.attachTo &&
                              t.target instanceof HTMLElement &&
                              t.target.classList.remove(
                                "shepherd-target-click-disabled"
                              );
                          }),
                        this.trigger(t, { index: e }),
                        (wn.activeTour = null),
                        this.trigger("inactive", { tour: this }),
                        this.modal && this.modal.hide(),
                        ("cancel" === t || "complete" === t) && this.modal)
                      ) {
                        var n = document.querySelector(
                          ".shepherd-modal-overlay-container"
                        );
                        n && n.remove();
                      }
                      h(this.focusedElBeforeOpen) &&
                        this.focusedElBeforeOpen.focus();
                    },
                  },
                  {
                    key: "_setupActiveTour",
                    value: function () {
                      this.trigger("active", { tour: this }),
                        (wn.activeTour = this);
                    },
                  },
                  {
                    key: "_setupModal",
                    value: function () {
                      this.modal = new bn({
                        target: this.options.modalContainer || document.body,
                        props: {
                          classPrefix: this.classPrefix,
                          styles: this.styles,
                        },
                      });
                    },
                  },
                  {
                    key: "_skipStep",
                    value: function (t, e) {
                      var n = this.steps.indexOf(t);
                      if (n === this.steps.length - 1) this.complete();
                      else {
                        var o = e ? n + 1 : n - 1;
                        this.show(o, e);
                      }
                    },
                  },
                  {
                    key: "_updateStateBeforeShow",
                    value: function () {
                      this.currentStep && this.currentStep.hide(),
                        this.isActive() || this._setupActiveTour();
                    },
                  },
                  {
                    key: "_setTourID",
                    value: function () {
                      var t = this.options.tourName || "tour";
                      this.id = "".concat(t, "--").concat(Ft());
                    },
                  },
                ]),
                n
              );
            })(O);
          return Object.assign(wn, { Tour: xn, Step: vn }), wn;
        }),
          "object" === w(e)
            ? (t.exports = i())
            : void 0 ===
                (r = "function" == typeof (o = i) ? o.call(e, n, e, t) : o) ||
              (t.exports = r);
      },
    },
    e = {};
  function n(o) {
    var r = e[o];
    if (void 0 !== r) return r.exports;
    var i = (e[o] = { exports: {} });
    return t[o].call(i.exports, i, i.exports, n), i.exports;
  }
  (n.n = function (t) {
    var e =
      t && t.__esModule
        ? function () {
            return t.default;
          }
        : function () {
            return t;
          };
    return n.d(e, { a: e }), e;
  }),
    (n.d = function (t, e) {
      for (var o in e)
        n.o(e, o) &&
          !n.o(t, o) &&
          Object.defineProperty(t, o, { enumerable: !0, get: e[o] });
    }),
    (n.o = function (t, e) {
      return Object.prototype.hasOwnProperty.call(t, e);
    }),
    (n.r = function (t) {
      "undefined" != typeof Symbol &&
        Symbol.toStringTag &&
        Object.defineProperty(t, Symbol.toStringTag, { value: "Module" }),
        Object.defineProperty(t, "__esModule", { value: !0 });
    });
  var o = {};
  !(function () {
    "use strict";
    n.r(o),
      n.d(o, {
        Shepherd: function () {
          return e.a;
        },
      });
    var t = n(4992),
      e = n.n(t);
  })();
  var r = window;
  for (var i in o) r[i] = o[i];
  o.__esModule && Object.defineProperty(r, "__esModule", { value: !0 });
})();
