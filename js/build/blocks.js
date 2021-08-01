/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 757:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__(666);


/***/ }),

/***/ 666:
/***/ ((module) => {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : 0
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ 804:
/***/ ((module) => {

module.exports = (function() { return this["lodash"]; }());

/***/ }),

/***/ 839:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["apiFetch"]; }());

/***/ }),

/***/ 599:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["blockEditor"]; }());

/***/ }),

/***/ 677:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["blocks"]; }());

/***/ }),

/***/ 587:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["components"]; }());

/***/ }),

/***/ 390:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["compose"]; }());

/***/ }),

/***/ 197:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["data"]; }());

/***/ }),

/***/ 2:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["element"]; }());

/***/ }),

/***/ 501:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["hooks"]; }());

/***/ }),

/***/ 57:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["i18n"]; }());

/***/ }),

/***/ 684:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["primitives"]; }());

/***/ }),

/***/ 173:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["serverSideRender"]; }());

/***/ }),

/***/ 696:
/***/ ((module) => {

module.exports = (function() { return this["wp"]["url"]; }());

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"this":["wp","element"]}
var external_this_wp_element_ = __webpack_require__(2);
// EXTERNAL MODULE: external {"this":["wp","i18n"]}
var external_this_wp_i18n_ = __webpack_require__(57);
// EXTERNAL MODULE: external "lodash"
var external_lodash_ = __webpack_require__(804);
// EXTERNAL MODULE: external {"this":["wp","compose"]}
var external_this_wp_compose_ = __webpack_require__(390);
// EXTERNAL MODULE: external {"this":["wp","hooks"]}
var external_this_wp_hooks_ = __webpack_require__(501);
// EXTERNAL MODULE: external {"this":["wp","data"]}
var external_this_wp_data_ = __webpack_require__(197);
// EXTERNAL MODULE: external {"this":["wp","blockEditor"]}
var external_this_wp_blockEditor_ = __webpack_require__(599);
// EXTERNAL MODULE: external {"this":["wp","components"]}
var external_this_wp_components_ = __webpack_require__(587);
// EXTERNAL MODULE: external {"this":["wp","primitives"]}
var external_this_wp_primitives_ = __webpack_require__(684);
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/duplication.js


/**
 * Duplication icon - admin-page Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


var isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
var duplication = isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M6 15v-13h10v13h-10zM5 16h8v2h-10v-13h2v11z"
})) : 'admin-page';
/* harmony default export */ const library_duplication = ((/* unused pure expression or super */ null && (duplication)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/pencil.js


/**
 * Pencil icon - edit Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


var pencil_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
var pencil = pencil_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M13.89 3.39l2.71 2.72c0.46 0.46 0.42 1.24 0.030 1.64l-8.010 8.020-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.030c0.39-0.39 1.22-0.39 1.68 0.070zM11.16 6.18l-5.59 5.61 1.11 1.11 5.54-5.65zM8.19 14.41l5.58-5.6-1.070-1.080-5.59 5.6z"
})) : 'edit';
/* harmony default export */ const library_pencil = ((/* unused pure expression or super */ null && (pencil)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/plus.js


/**
 * Plus icon - plus Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


var plus_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
var plus = plus_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M17 7v3h-5v5h-3v-5h-5v-3h5v-5h3v5h5z"
})) : 'plus';
/* harmony default export */ const library_plus = ((/* unused pure expression or super */ null && (plus)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/synchronization.js


/**
 * Synchronization icon - controls-repeat Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


var synchronization_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
var synchronization = synchronization_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M5 7v3l-2 1.5v-6.5h11v-2l4 3.010-4 2.99v-2h-9zM15 13v-3l2-1.5v6.5h-11v2l-4-3.010 4-2.99v2h9z"
})) : 'controls-repeat';
/* harmony default export */ const library_synchronization = ((/* unused pure expression or super */ null && (synchronization)));
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/library/translation.js


/**
 * Translation icon - translation Dashicon.
 *
 * @package Polylang-Pro
 */

/**
 * WordPress dependencies
 */


var translation_isPrimitivesComponents = !(0,external_lodash_.isUndefined)(wp.primitives);
var translation = translation_isPrimitivesComponents ? (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.SVG, {
  width: "20",
  height: "20",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 20 20"
}, (0,external_this_wp_element_.createElement)(external_this_wp_primitives_.Path, {
  d: "M11 7H9.49c-.63 0-1.25.3-1.59.7L7 5H4.13l-2.39 7h1.69l.74-2H7v4H2c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h7c1.1 0 2 .9 2 2v2zM6.51 9H4.49l1-2.93zM10 8h7c1.1 0 2 .9 2 2v7c0 1.1-.9 2-2 2h-7c-1.1 0-2-.9-2-2v-7c0-1.1.9-2 2-2zm7.25 5v-1.08h-3.17V9.75h-1.16v2.17H9.75V13h1.28c.11.85.56 1.85 1.28 2.62-.87.36-1.89.62-2.31.62-.01.02.22.97.2 1.46.84 0 2.21-.5 3.28-1.15 1.09.65 2.48 1.15 3.34 1.15-.02-.49.2-1.44.2-1.46-.43 0-1.49-.27-2.38-.63.7-.77 1.14-1.77 1.25-2.61h1.36zm-3.81 1.93c-.5-.46-.85-1.13-1.01-1.93h2.09c-.17.8-.51 1.47-1 1.93l-.04.03s-.03-.02-.04-.03z"
})) : 'translation';
/* harmony default export */ const library_translation = (translation);
;// CONCATENATED MODULE: ./modules/block-editor/js/icons/index.js
/**
 * Icons library
 *
 * @package Polylang-Pro
 */





;// CONCATENATED MODULE: ./modules/block-editor/js/components/language-dropdown.js


/**
 * @package Polylang-Pro
 */
// External dependencies


/**
 * Displays a dropdown to select a language.
 *
 * @since 3.1
 *
 * @param {Function} handleChange Callback to be executed when language changes.
 * @param {mixed} children Child components to be used as select options.
 * @param {Object} selectedLanguage An object representing a Polylang Language. Default to null.
 * @param {string} Default value to be selected if the selected language is not provided. Default to an empty string.
 *
 * @return {Object} A dropdown selector for languages.
 */

function LanguageDropdown(_ref) {
  var handleChange = _ref.handleChange,
      children = _ref.children,
      _ref$selectedLanguage = _ref.selectedLanguage,
      selectedLanguage = _ref$selectedLanguage === void 0 ? null : _ref$selectedLanguage,
      _ref$defaultValue = _ref.defaultValue,
      defaultValue = _ref$defaultValue === void 0 ? '' : _ref$defaultValue;
  var selectedLanguageSlug = selectedLanguage !== null && selectedLanguage !== void 0 && selectedLanguage.slug ? selectedLanguage.slug : defaultValue;
  return (0,external_this_wp_element_.createElement)("div", {
    id: "select-post-language"
  }, (0,external_this_wp_element_.createElement)(LanguageFlag, {
    language: selectedLanguage
  }), children && (0,external_this_wp_element_.createElement)("select", {
    value: selectedLanguageSlug,
    onChange: function onChange(event) {
      return handleChange(event);
    },
    id: "pll_post_lang_choice",
    name: "pll_post_lang_choice",
    className: "post_lang_choice"
  }, children));
}
/**
 * Map languages objects as options for a <select> tag.
 *
 * @since 3.1
 *
 * @param {mixed} languages An iterable object containing languages objects.
 *
 * @return {Object} A list of <option> tags to be used in a <select> tag.
 */


function LanguagesOptionsList(_ref2) {
  var languages = _ref2.languages;
  return Array.from(languages.values()).map(function (_ref3) {
    var slug = _ref3.slug,
        name = _ref3.name,
        w3c = _ref3.w3c;
    return (0,external_this_wp_element_.createElement)("option", {
      value: slug,
      lang: w3c,
      key: slug
    }, name);
  });
}
/**
 * Display a flag icon for a given language.
 *
 * @since 3.1
 *
 *  @param {Object} A language object.
 *
 *  @return {Object}
 */


function LanguageFlag(_ref4) {
  var language = _ref4.language;
  return !(0,external_lodash_.isNil)(language) ? !(0,external_lodash_.isEmpty)(language.flag_url) ? (0,external_this_wp_element_.createElement)("span", {
    className: "pll-select-flag"
  }, (0,external_this_wp_element_.createElement)("img", {
    src: language.flag_url,
    alt: language.name,
    title: language.name,
    className: "flag"
  })) : (0,external_this_wp_element_.createElement)("abbr", null, language.slug, (0,external_this_wp_element_.createElement)("span", {
    className: "screen-reader-text"
  }, language.name)) : (0,external_this_wp_element_.createElement)("span", {
    className: "pll-translation-icon"
  }, library_translation);
}


;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/settings.js
/**
 * Module Constants
 *
 * @package Polylang-Pro
 */
var settings_MODULE_KEY = 'pll/metabox';
var settings_MODULE_CORE_EDITOR_KEY = 'core/editor';
var MODULE_CORE_KEY = 'core';
var DEFAULT_STATE = {
  languages: [],
  selectedLanguage: {},
  translatedPosts: {},
  fromPost: null
};

;// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/defineProperty.js
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}
// EXTERNAL MODULE: ./node_modules/@babel/runtime/regenerator/index.js
var regenerator = __webpack_require__(757);
var regenerator_default = /*#__PURE__*/__webpack_require__.n(regenerator);
// EXTERNAL MODULE: external {"this":["wp","apiFetch"]}
var external_this_wp_apiFetch_ = __webpack_require__(839);
var external_this_wp_apiFetch_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_apiFetch_);
// EXTERNAL MODULE: external {"this":["wp","url"]}
var external_this_wp_url_ = __webpack_require__(696);
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/utils.js
/**
 * WordPress Dependencies
 *
 * @package Polylang-Pro
 */




/**
 * Convert array of object to a map
 *
 * @param {type} array to convert
 * @param {type} key in the object used as key to build map
 * @returns {Map}
 */

function convertArrayToMap(array, key) {
  var map = new Map();
  array.reduce(function (accumulator, currentValue) {
    accumulator.set(currentValue[key], currentValue);
    return accumulator;
  }, map);
  return map;
}
/**
 * Convert map to an associative array
 *
 * @param {Map} map to convert
 * @returns {Object}
 */

function utils_convertMapToObject(map) {
  var object = {};
  map.forEach(function (value, key, map) {
    var obj = this;
    this[key] = isBoolean(value) ? value.toString() : value;
  }, object);
  return object;
}
/**
 * Return if a block-based editor is for post type.
 *
 * @returns {boolean} True if block editor for post type; false otherwise.
 */

function isPostTypeBlockEditor() {
  return !!document.getElementById('editor');
}
/**
 * Return the post type URL for REST API calls
 *
 * @param {string} post type name
 * @returns {string}
 */

function getPostsUrl(name) {
  var postTypes = select('core').getEntitiesByKind('postType');
  var postType = find(postTypes, {
    name: name
  });
  return postType.baseURL;
}
/**
 * Get all query string parameters and convert them in a URLSearchParams object
 *
 * @returns {object}
 */

function utils_getSearchParams() {
  // Variable window.location.search is just read for creating and returning a URLSearchParams object to be able to manipulate it more easily
  if (!isEmpty(window.location.search)) {
    // phpcs:ignore WordPressVIPMinimum.JS.Window.location
    return new URLSearchParams(window.location.search); // phpcs:ignore WordPressVIPMinimum.JS.Window.location
  } else {
    return null;
  }
}
/**
 * Get selected language
 *
 * @param string Post language code
 * @returns {Object} Selected Language
 */

function getSelectedLanguage(lang) {
  var languages = select(MODULE_KEY).getLanguages(); // Pick up this language as selected in languages list

  return languages.get(lang);
}
/**
 * Get translated posts
 *
 * @param array ids of translated posts
 * @returns {Map}
 */

function utils_getTranslatedPosts(translations, translations_table, lang) {
  var translationsTable = getTranslationsTable(translations_table, lang);
  var fromPost = select(MODULE_KEY).getFromPost();
  var translatedPosts = new Map(Object.entries([]));

  if (!isUndefined(translations)) {
    translatedPosts = new Map(Object.entries(translations));
  } // phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
  // If we come from another post for creating a new one, we have to update translated posts from the original post
  // to be able to update translations attribute of the post


  if (!isNil(fromPost) && !isNil(fromPost.id)) {
    translationsTable.forEach(function (translationData, lang) {
      if (!isNil(translationData.translated_post) && !isNil(translationData.translated_post.id)) {
        translatedPosts.set(lang, translationData.translated_post.id);
      }
    });
  } // phpcs:enable PEAR.Functions.FunctionCallSignature.Indent


  return translatedPosts;
}
/**
 * Get synchronized posts
 *
 * @param array ids of synchronized posts
 * @returns {Map}
 */

function getSynchronizedPosts(pll_sync_post) {
  var synchronizedPosts = new Map(Object.entries([]));

  if (!isUndefined(pll_sync_post)) {
    synchronizedPosts = new Map(Object.entries(pll_sync_post));
  }

  return synchronizedPosts;
}
/**
 * Get translations table
 *
 * @param object translations table datas
 * @param string language code
 * @returns {Map}
 */

function getTranslationsTable(translationsTableDatas, lang) {
  var translationsTable = new Map(Object.entries([])); // get translations table datas from post

  if (!isUndefined(translationsTableDatas)) {
    // Build translations table map with language slug as key
    translationsTable = new Map(Object.entries(translationsTableDatas));
  }

  return translationsTable;
}
/**
 * Is the request for saving ?
 *
 * @param {type} options the initial request
 * @returns {Boolean}
 */

function isSaveRequest(options) {
  // If data is defined we are in a PUT or POST request method otherwise a GET request method
  // Test options.method property isn't efficient because most of REST request which use fetch API doesn't pass this property.
  // So, test options.data is necessary to know if the REST request is to save datas.
  // However test if options.data is undefined isn't sufficient because some REST request pass a null value as the ServerSideRender Gutenberg component.
  if (!isNil(options.data)) {
    return true;
  } else {
    return false;
  }
}
/**
 * Add is_block_editor parameter to the request in a block editor context
 *
 * @param {type} options the initial request
 * @returns {undefined}
 */

function addIsBlockEditorToRequest(options) {
  options.path = addQueryArgs(options.path, {
    is_block_editor: true
  });
}
/**
 * Is the request concerned the current post type ?
 *
 * Useful when saving a reusable block contained in another post type.
 * Indeed a reusable block is also a post, but its saving request doesn't concern the post currently edited.
 * As we don't know the language of the reusable block when the user triggers the reusable block saving action,
 * we need to pass the current post language to be sure that the reusable block will have a language.
 *
 * @see https://github.com/polylang/polylang/issues/437 - Reusable block has no language when it's saved from another post type editing.
 *
 * @param {type} options the initial request
 * @returns {Boolean}
 */

function isCurrentPostRequest(options) {
  // Save translation datas is needed for all post types only
  // it's done by verifying options.path matches with one of baseURL of all post types
  // and compare current post id with this sent in the request
  // List of post type baseURLs.
  var postTypeURLs = map(select('core').getEntitiesByKind('postType'), property('baseURL')); // Id from the post currently edited.

  var postId = select('core/editor').getCurrentPostId(); // Id from the REST request.
  // options.data never isNil here because it's already verified before in isSaveRequest() function

  var id = options.data.id; // Return true
  // if REST request baseURL matches with one of the known post type baseURLs
  // and the id from the post currently edited corresponds on the id passed to the REST request
  // Return false otherwise

  return -1 !== postTypeURLs.findIndex(function (element) {
    return new RegExp("".concat(escapeRegExp(element))).test(options.path); // phpcs:ignore WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore, WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
  }) && postId === id;
}
/**
 * Add language to the request
 *
 * @param {type} options the initial request
 * @param {string} currentLanguage A language code.
 * @returns {undefined}
 */

function addLanguageToRequest(options, currentLanguage) {
  var filterLang = isUndefined(options.filterLang) || options.filterLang;

  if (filterLang) {
    options.path = addQueryArgs(options.path, {
      lang: currentLanguage
    });
  }
}
;// CONCATENATED MODULE: ./modules/block-editor/js/sidebar/store/index.js



function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

/**
 * WordPress Dependencies
 *
 * @package Polylang-Pro
 */



/**
 * Internal dependencies
 */



var actions = {
  setLanguages: function setLanguages(languages) {
    return {
      type: 'SET_LANGUAGES',
      languages: languages
    };
  },
  setCurrentUser: function setCurrentUser(currentUser) {
    var save = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    return {
      type: 'SET_CURRENT_USER',
      currentUser: currentUser,
      save: save
    };
  },
  setFromPost: function setFromPost(fromPost) {
    return {
      type: 'SET_FROM_POST',
      fromPost: fromPost
    };
  },
  fetchFromAPI: function fetchFromAPI(options) {
    return {
      type: 'FETCH_FROM_API',
      options: options
    };
  }
};
var store = (0,external_this_wp_data_.registerStore)(settings_MODULE_KEY, {
  reducer: function reducer() {
    var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : DEFAULT_STATE;
    var action = arguments.length > 1 ? arguments[1] : undefined;

    switch (action.type) {
      case 'SET_LANGUAGES':
        return _objectSpread(_objectSpread({}, state), {}, {
          languages: action.languages
        });

      case 'SET_CURRENT_USER':
        if (action.save) {
          updateCurrentUser(action.currentUser);
        }

        return _objectSpread(_objectSpread({}, state), {}, {
          currentUser: action.currentUser
        });

      case 'SET_FROM_POST':
        return _objectSpread(_objectSpread({}, state), {}, {
          fromPost: action.fromPost
        });

      default:
        return state;
    }
  },
  selectors: {
    getLanguages: function getLanguages(state) {
      return state.languages;
    },
    getCurrentUser: function getCurrentUser(state) {
      return state.currentUser;
    },
    getFromPost: function getFromPost(state) {
      return state.fromPost;
    }
  },
  actions: actions,
  controls: {
    FETCH_FROM_API: function FETCH_FROM_API(action) {
      return external_this_wp_apiFetch_default()(_objectSpread({}, action.options));
    }
  },
  resolvers: {
    getLanguages: /*#__PURE__*/regenerator_default().mark(function getLanguages() {
      var path, languages;
      return regenerator_default().wrap(function getLanguages$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              path = '/pll/v1/languages';
              _context.next = 3;
              return actions.fetchFromAPI({
                path: path,
                filterLang: false
              });

            case 3:
              languages = _context.sent;
              return _context.abrupt("return", actions.setLanguages(convertArrayToMap(languages, 'slug')));

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, getLanguages);
    }),
    getCurrentUser: /*#__PURE__*/regenerator_default().mark(function getCurrentUser() {
      var path, currentUser;
      return regenerator_default().wrap(function getCurrentUser$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              path = '/wp/v2/users/me';
              _context2.next = 3;
              return actions.fetchFromAPI({
                path: path,
                filterLang: true
              });

            case 3:
              currentUser = _context2.sent;
              return _context2.abrupt("return", actions.setCurrentUser(currentUser));

            case 5:
            case "end":
              return _context2.stop();
          }
        }
      }, getCurrentUser);
    })
  }
});
/**
 * Wait for the whole post block editor context has been initialized: current post loaded and languages list initialized.
 */

var isBlockPostEditorContextInitialized = function isBlockPostEditorContextInitialized() {
  // save url params espacially when a new translation is creating
  saveURLParams(); // call to getCurrentUser to force call to resolvers and initialize state

  var currentUser = select(MODULE_KEY).getCurrentUser();
  /**
   * Set a promise for waiting for the current post has been fully loaded before making other processes.
   */

  var isCurrentPostLoaded = new Promise(function (resolve) {
    var unsubscribe = subscribe(function () {
      var currentPost = select(MODULE_CORE_EDITOR_KEY).getCurrentPost();

      if (!isEmpty(currentPost)) {
        unsubscribe();
        resolve();
      }
    });
  }); // Wait for current post has been loaded and languages list initialized.

  return Promise.all([isCurrentPostLoaded, isLanguagesinitialized]).then(function () {
    // If we come from another post for creating a new one, we have to update translations from the original post.
    var fromPost = select(MODULE_KEY).getFromPost();

    if (!isNil(fromPost) && !isNil(fromPost.id)) {
      var lang = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('lang');
      var translations = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations');
      var translations_table = select(MODULE_CORE_EDITOR_KEY).getEditedPostAttribute('translations_table');
      var translatedPosts = getTranslatedPosts(translations, translations_table, lang);
      dispatch(MODULE_CORE_EDITOR_KEY).editPost({
        translations: convertMapToObject(translatedPosts)
      });
    }
  });
};
/**
 * Set a promise for waiting for the languages list is correctly initialized before making other processes.
 */

var isLanguagesinitialized = new Promise(function (resolve) {
  var unsubscribe = (0,external_this_wp_data_.subscribe)(function () {
    var languages = (0,external_this_wp_data_.select)(settings_MODULE_KEY).getLanguages();

    if (languages.size > 0) {
      unsubscribe();
      resolve();
    }
  });
});
/**
 * Save query string parameters from URL. They could be needed after
 * They could be null if they does not exist
 */

function saveURLParams() {
  // Variable window.location.search isn't use directly
  // Function getSearchParams return an URLSearchParams object for manipulating each parameter
  // Each of them are sanitized below
  var searchParams = getSearchParams(window.location.search); // phpcs:ignore WordPressVIPMinimum.JS.Window.location

  if (null !== searchParams) {
    dispatch(MODULE_KEY).setFromPost({
      id: wp.sanitize.stripTagsAndEncodeText(searchParams.get('from_post')),
      postType: wp.sanitize.stripTagsAndEncodeText(searchParams.get('post_type')),
      newLanguage: wp.sanitize.stripTagsAndEncodeText(searchParams.get('new_lang'))
    });
  }
}
/**
 * Save current user when it is wondered
 *
 * @param {object} currentUser
 */


function updateCurrentUser(currentUser) {
  external_this_wp_apiFetch_default()({
    path: '/wp/v2/users/me',
    data: currentUser,
    method: 'POST'
  });
}

/* harmony default export */ const sidebar_store = ((/* unused pure expression or super */ null && (store)));
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/attributes.js


/**
 * Add blocks attributes
 *
 *  @package Polylang-Pro
 */

/**
 * WordPress Dependencies
 */








/**
 * Internal dependencies
 */





var LanguageAttribute = {
  type: 'string',
  default: 'every'
};

var addLangChoiceAttribute = function addLangChoiceAttribute(settings, name) {
  var unallowedBlockNames = ['core/widget-area', 'core/legacy-widget'];

  if (unallowedBlockNames.find(function (element) {
    return element === name;
  }) || isPostTypeBlockEditor()) {
    return settings;
  }

  settings.attributes = (0,external_lodash_.assign)(settings.attributes, {
    pll_lang: LanguageAttribute
  });
  return settings;
};

(0,external_this_wp_hooks_.addFilter)('blocks.registerBlockType', 'pll/lang-choice', addLangChoiceAttribute);
var withInspectorControls = (0,external_this_wp_compose_.createHigherOrderComponent)(function (BlockEdit) {
  return function (props) {
    if (isPostTypeBlockEditor()) {
      return (0,external_this_wp_element_.createElement)(BlockEdit, props);
    }

    var languages = (0,external_this_wp_data_.select)(settings_MODULE_KEY).getLanguages();
    var pll_lang = props.attributes.pll_lang;
    var isLanguageFilterable = !(0,external_lodash_.isNil)(pll_lang);
    var selectedLanguage = languages.get(pll_lang);
    return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(BlockEdit, props), isLanguageFilterable && (0,external_this_wp_element_.createElement)(external_this_wp_blockEditor_.InspectorControls, null, (0,external_this_wp_element_.createElement)(external_this_wp_components_.PanelBody, {
      title: (0,external_this_wp_i18n_.__)('Languages', 'polylang-pro')
    }, (0,external_this_wp_element_.createElement)("label", null, (0,external_this_wp_i18n_.__)('The block is displayed for:', 'polylang-pro')), (0,external_this_wp_element_.createElement)(LanguageDropdown, {
      selectedLanguage: selectedLanguage,
      handleChange: function handleChange(langChoiceEvent) {
        var langChoice = langChoiceEvent.currentTarget.value;
        props.setAttributes({
          pll_lang: langChoice
        });
      },
      defaultValue: LanguageAttribute.default
    }, (0,external_this_wp_element_.createElement)("option", {
      value: LanguageAttribute.default
    }, (0,external_this_wp_i18n_.__)('All languages', 'polylang-pro'), " "), (0,external_this_wp_element_.createElement)(LanguagesOptionsList, {
      languages: languages
    })))));
  };
}, "withInspectorControl");
isLanguagesinitialized.then(function () {
  (0,external_this_wp_hooks_.addFilter)('editor.BlockEdit', 'pll/lang-choice-with-inspector-controls', withInspectorControls);
});
// EXTERNAL MODULE: external {"this":["wp","blocks"]}
var external_this_wp_blocks_ = __webpack_require__(677);
// EXTERNAL MODULE: external {"this":["wp","serverSideRender"]}
var external_this_wp_serverSideRender_ = __webpack_require__(173);
var external_this_wp_serverSideRender_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_serverSideRender_);
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/language-switcher-edit.js



/**
 * @package Polylang-Pro
 */

/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */


/**
 * Call initialization of pll/metabox store for getting ready some datas
 */

var i18nAttributeStrings = pll_block_editor_blocks_settings;
function createLanguageSwitcherEdit(props) {
  var createToggleAttribute = function createToggleAttribute(propName) {
    return function () {
      var value = props.attributes[propName];
      var setAttributes = props.setAttributes;

      var updatedAttributes = _defineProperty({}, propName, !value);

      var forcedAttributeName;
      var forcedAttributeUnchecked; // Both show_names and show_flags attributes can't be unchecked together.

      switch (propName) {
        case 'show_names':
          forcedAttributeName = 'show_flags';
          forcedAttributeUnchecked = !props.attributes[forcedAttributeName];
          break;

        case 'show_flags':
          forcedAttributeName = 'show_names';
          forcedAttributeUnchecked = !props.attributes[forcedAttributeName];
          break;
      }

      if ('show_names' === propName || 'show_flags' === propName) {
        if (value && forcedAttributeUnchecked) {
          updatedAttributes = (0,external_lodash_.assign)(updatedAttributes, _defineProperty({}, forcedAttributeName, forcedAttributeUnchecked));
        }
      }

      setAttributes(updatedAttributes);
    };
  };

  var toggleDropdown = createToggleAttribute('dropdown');
  var toggleShowNames = createToggleAttribute('show_names');
  var toggleShowFlags = createToggleAttribute('show_flags');
  var toggleForceHome = createToggleAttribute('force_home');
  var toggleHideCurrent = createToggleAttribute('hide_current');
  var toggleHideIfNoTranslation = createToggleAttribute('hide_if_no_translation');
  var _props$attributes = props.attributes,
      dropdown = _props$attributes.dropdown,
      show_names = _props$attributes.show_names,
      show_flags = _props$attributes.show_flags,
      force_home = _props$attributes.force_home,
      hide_current = _props$attributes.hide_current,
      hide_if_no_translation = _props$attributes.hide_if_no_translation;

  function ToggleControlDropdown() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.dropdown,
      checked: dropdown,
      onChange: toggleDropdown
    });
  }

  function ToggleControlShowNames() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.show_names,
      checked: show_names,
      onChange: toggleShowNames
    });
  }

  function ToggleControlShowFlags() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.show_flags,
      checked: show_flags,
      onChange: toggleShowFlags
    });
  }

  function ToggleControlForceHome() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.force_home,
      checked: force_home,
      onChange: toggleForceHome
    });
  }

  function ToggleControlHideCurrent() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.hide_current,
      checked: hide_current,
      onChange: toggleHideCurrent
    });
  }

  function ToggleControlHideIfNoTranslations() {
    return (0,external_this_wp_element_.createElement)(external_this_wp_components_.ToggleControl, {
      label: i18nAttributeStrings.hide_if_no_translation,
      checked: hide_if_no_translation,
      onChange: toggleHideIfNoTranslation
    });
  }

  return {
    ToggleControlDropdown: ToggleControlDropdown,
    ToggleControlShowNames: ToggleControlShowNames,
    ToggleControlShowFlags: ToggleControlShowFlags,
    ToggleControlForceHome: ToggleControlForceHome,
    ToggleControlHideCurrent: ToggleControlHideCurrent,
    ToggleControlHideIfNoTranslations: ToggleControlHideIfNoTranslations
  };
}
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/block.js


/**
 * Register language switcher block.
 *
 *  @package Polylang-Pro
 */

/**
 * WordPress Dependencies
 */






/**
 * Internal dependencies
 */




var blocktitle = (0,external_this_wp_i18n_.__)('Language switcher', 'polylang-pro');

var descriptionTitle = (0,external_this_wp_i18n_.__)('Add a language switcher to allow your visitors to select their preferred language.', 'polylang-pro');

var panelTitle = (0,external_this_wp_i18n_.__)('Language switcher Settings', 'polylang-pro'); // Register the Language Switcher block as first level block in Block Editor.


(0,external_this_wp_blocks_.registerBlockType)('polylang/language-switcher', {
  title: blocktitle,
  description: descriptionTitle,
  icon: library_translation,
  category: 'widgets',
  example: {},
  edit: function edit(props) {
    var dropdown = props.attributes.dropdown;

    var _createLanguageSwitch = createLanguageSwitcherEdit(props),
        ToggleControlDropdown = _createLanguageSwitch.ToggleControlDropdown,
        ToggleControlShowNames = _createLanguageSwitch.ToggleControlShowNames,
        ToggleControlShowFlags = _createLanguageSwitch.ToggleControlShowFlags,
        ToggleControlForceHome = _createLanguageSwitch.ToggleControlForceHome,
        ToggleControlHideCurrent = _createLanguageSwitch.ToggleControlHideCurrent,
        ToggleControlHideIfNoTranslations = _createLanguageSwitch.ToggleControlHideIfNoTranslations;

    return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(external_this_wp_blockEditor_.InspectorControls, null, (0,external_this_wp_element_.createElement)(external_this_wp_components_.PanelBody, {
      title: panelTitle
    }, (0,external_this_wp_element_.createElement)(ToggleControlDropdown, null), !dropdown && (0,external_this_wp_element_.createElement)(ToggleControlShowNames, null), !dropdown && (0,external_this_wp_element_.createElement)(ToggleControlShowFlags, null), (0,external_this_wp_element_.createElement)(ToggleControlForceHome, null), !dropdown && (0,external_this_wp_element_.createElement)(ToggleControlHideCurrent, null), (0,external_this_wp_element_.createElement)(ToggleControlHideIfNoTranslations, null))), (0,external_this_wp_element_.createElement)(external_this_wp_components_.Disabled, null, (0,external_this_wp_element_.createElement)((external_this_wp_serverSideRender_default()), {
      block: "polylang/language-switcher",
      attributes: props.attributes
    })));
  }
}); // Register the Language Switcher block as child block of other blocks (see the 'parent' property).

(0,external_this_wp_blocks_.registerBlockType)('polylang/language-switcher-inner-block', {
  title: blocktitle,
  description: descriptionTitle,
  icon: library_translation,
  category: 'widgets',
  parent: ['core/navigation'],
  example: {},
  edit: function edit(props) {
    var dropdown = props.attributes.dropdown;

    var _createLanguageSwitch2 = createLanguageSwitcherEdit(props),
        ToggleControlDropdown = _createLanguageSwitch2.ToggleControlDropdown,
        ToggleControlShowNames = _createLanguageSwitch2.ToggleControlShowNames,
        ToggleControlShowFlags = _createLanguageSwitch2.ToggleControlShowFlags,
        ToggleControlForceHome = _createLanguageSwitch2.ToggleControlForceHome,
        ToggleControlHideCurrent = _createLanguageSwitch2.ToggleControlHideCurrent,
        ToggleControlHideIfNoTranslations = _createLanguageSwitch2.ToggleControlHideIfNoTranslations;

    return (0,external_this_wp_element_.createElement)(external_this_wp_element_.Fragment, null, (0,external_this_wp_element_.createElement)(external_this_wp_blockEditor_.InspectorControls, null, (0,external_this_wp_element_.createElement)(external_this_wp_components_.PanelBody, {
      title: panelTitle
    }, (0,external_this_wp_element_.createElement)(ToggleControlDropdown, null), (0,external_this_wp_element_.createElement)(ToggleControlShowNames, null), (0,external_this_wp_element_.createElement)(ToggleControlShowFlags, null), (0,external_this_wp_element_.createElement)(ToggleControlForceHome, null), !dropdown && (0,external_this_wp_element_.createElement)(ToggleControlHideCurrent, null), (0,external_this_wp_element_.createElement)(ToggleControlHideIfNoTranslations, null))), (0,external_this_wp_element_.createElement)(external_this_wp_components_.Disabled, null, (0,external_this_wp_element_.createElement)((external_this_wp_serverSideRender_default()), {
      block: "polylang/language-switcher-inner-block",
      attributes: props.attributes
    })));
  }
});
;// CONCATENATED MODULE: ./modules/block-editor/js/blocks/index.js
/**
 * Handles language switcher block and attributes.
 *
 *  @package Polylang-Pro
 */

/**
 * Internal dependencies
 */


})();

this["polylang-pro"] = __webpack_exports__;
/******/ })()
;