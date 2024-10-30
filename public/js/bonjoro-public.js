(() => {
  "use strict";
  (() => {
    var o;
    const n = function () {
      n.q.push(arguments);
    };
    (n.q = []),
      (null !== (o = window.bonjoro) && void 0 !== o) || (window.bonjoro = n);
  })();
})();

bonjoro("create", window.bonjoroSettings.appId);
bonjoro("identify", window.bonjoroSettings.email, {
  userHash: window.bonjoroSettings.userHash,
});
