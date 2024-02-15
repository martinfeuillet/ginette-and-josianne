<!DOCTYPE html>
<html>

<head>
    <title>Vanilla JS - Inline Embed Cal.com</title>
    <meta charset="UTF-8" />
</head>

<body>
    <!-- Cal inline embed code begins -->
    <div style="width: 100%; height: 100%; overflow: scroll;" id="my-cal-inline"></div>
    <script type="text/javascript">
    (function(C, A, L) {
        let p = function(a, ar) {
            a.q.push(ar);
        };
        let d = C.document;
        C.Cal =
            C.Cal ||
            function() {
                let cal = C.Cal;
                let ar = arguments;
                if (!cal.loaded) {
                    cal.ns = {};
                    cal.q = cal.q || [];
                    d.head.appendChild(d.createElement("script")).src = A;
                    cal.loaded = true;
                }
                if (ar[0] === L) {
                    const api = function() {
                        p(api, arguments);
                    };
                    const namespace = ar[1];
                    api.q = api.q || [];
                    typeof namespace === "string" ?
                        (cal.ns[namespace] = api) && p(api, ar) :
                        p(cal, ar);
                    return;
                }
                p(cal, ar);
            };
    })(window, "https://app.cal.com/embed/embed.js", "init");
    Cal("init", {
        origin: "https://app.cal.com"
    });

    Cal("inline", {
        elementOrSelector: "#my-cal-inline",
        calLink: "rick/get-rick-rolled"
    });
    </script>
    <!-- Cal inline embed code ends -->
</body>

</html>
<!-- cal_live_5443c7dc48030b404c4e24db6db052f3 -->