// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyB5RhrwR_xWN3HSLPP3zNUFIp4jhk4kwOM",
    authDomain: "zimahome-24721.firebaseapp.com",
    projectId: "zimahome-24721",
    storageBucket: "zimahome-24721.appspot.com",
    messagingSenderId: "744416914452",
    appId: "1:744416914452:web:8fa13e1e7d9f5df4a28b01",
    measurementId: "G-KLL45E3616"
});


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);

    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };

    return self.registration.showNotification(
        title,
        options,
    );
});