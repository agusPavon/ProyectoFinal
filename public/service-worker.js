self.addEventListener("install", event => {
  event.waitUntil(
    caches.open("bunaster-cache").then(cache => {
    //   return cache.addAll(["/", "/css/bunaster.css", "/js/bunaster-map.js"]);
    })
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
