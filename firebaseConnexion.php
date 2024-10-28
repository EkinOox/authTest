<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion avec FirebaseUI</title>
    <!-- Import Firebase 8 et FirebaseUI -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/ui/4.8.0/firebase-ui-auth.js"></script>
    <link rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.8.0/firebase-ui-auth.css" />
    <base href="http://localhost:8888/S7-ProtocoleAuth/">
</head>

<body>
    <h2>Connexion / Inscription</h2>
    <div id="firebaseui-auth-container"></div>
    <div id="loader">Chargement...</div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const firebaseConfig = {
                apiKey: "AIzaSyDeKLxoBsSWkYc9uAu9yqBceUyAoGCYYwA",
                authDomain: "aixauthtest.firebaseapp.com",
                projectId: "aixauthtest",
                storageBucket: "aixauthtest.appspot.com",
                messagingSenderId: "497479268683",
                appId: "1:497479268683:web:8e9b6f1b53498beffe50ce"
            };

            firebase.initializeAppx(firebaseConfig);

            const uiConfig = {
                signInSuccessUrl: 'success.php',
                signInOptions: [
                    firebase.auth.EmailAuthProvider.PROVIDER_ID,
                    firebase.auth.PhoneAuthProvider.PROVIDER_ID,
                ],
                callbacks: {
                    signInSuccessWithAuthResult: function(authResult, redirectUrl) {
                        document.getElementById('loader').style.display = 'none';
                        if (authResult.user) {
                            authResult.user.getIdToken().then((token) => {
                                fetch('success.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: 'token=' + token
                                }).then(() => {
                                    window.location.href = redirectUrl;
                                });
                            });
                        }
                        return true;
                    },
                    uiShown: function() {
                        document.getElementById('loader').style.display = 'none';
                    }
                },
                tosUrl: 'terms.php',
                privacyPolicyUrl: 'privacy.php'
            };

            const ui = new firebaseui.auth.AuthUI(firebase.auth());
            ui.start('#firebaseui-auth-container', uiConfig);
        });
    </script>
</body>
</html>