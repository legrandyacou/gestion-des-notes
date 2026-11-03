 <link rel="manifest" href="./manifest.json">
 <meta name="theme-color" content="#17233b">
 <script>
   if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("./sw.js", { scope: "./" });
   }
 </script>