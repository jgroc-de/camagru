'use strict';

const CACHE_NAME = 'camagru-static-cache-1.0.3';

const FILES_TO_CACHE = [
  '/',
  '/offline.html',
  '/public/js/app.js',
  '/public/img/2_1709494041.png',
  '/public/img/screen_bg.png',

];

self.addEventListener('install', (evt) => {
  console.log('[ServiceWorker] Install');
  // CODELAB: Precache static resources here.
  evt.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('[ServiceWorker] Pre-caching offline page');
      return cache.addAll(FILES_TO_CACHE);
    })
  );

  self.skipWaiting();
});

self.addEventListener('activate', (evt) => {
  console.log('[ServiceWorker] Activate');
  // CODELAB: Remove previous cached data from disk.
  evt.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(keyList.map((key) => {
        if (key !== CACHE_NAME && key !== DATA_CACHE_NAME) {
          console.log('[ServiceWorker] Removing old cache', key);
          return caches.delete(key);
        }
      }));
    })
  );

  self.clients.claim();
});

self.addEventListener('fetch', (evt) => {
  console.log('[ServiceWorker] Fetch', evt.request.url);
  // CODELAB: Add fetch event handler here.
  evt.respondWith(
    fetch(evt.request)
    .catch(() => {
      return caches.open(CACHE_NAME)
        .then((cache) => {
          return cache.match('offline.html');
        });
    })
  );
});
