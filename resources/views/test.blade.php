<html>
<head>
    
</head>

<body>
    <h1>FCM test</h1>
    
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyB5RhrwR_xWN3HSLPP3zNUFIp4jhk4kwOM",
            authDomain: "zimahome-24721.firebaseapp.com",
            projectId: "zimahome-24721",
            storageBucket: "zimahome-24721.appspot.com",
            messagingSenderId: "744416914452",
            appId: "1:744416914452:web:8fa13e1e7d9f5df4a28b01",
            measurementId: "G-KLL45E3616"
        };
        var token ="";
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        
        function startFCM() {
            messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                this.token = response;
                console.log(token);
            }).catch(function (error) {
                console.log(error);
            });
        }
        
        startFCM();
        messaging.onMessage(function (payload) {
            console.log(payload);
            const title = payload.notification.title;
            const options = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(title, options);
        });
        
        $(document).ready(function(){
            $("#title").keyup(function(){
                $("input:text#token").val(token);
            });
        });
        
        
    </script>
    
    
    <form method="post" action="{{route('send-fcm-test')}}">
        @csrf
        title: <input name="title" type="text" id="title"/> <br>
        message: <input name="message" type="text"> 
        <br>
        token:<input name="token" type="text" id="token" /><br>
        
        <input type="submit">
    </form>
</body>
</html>