<nav>
    <a href="index.php">Home</a>
    <?php

    if ($loggedIn) {
        echo '<a href="jokes.php">Jokes</a>';
        echo '<a href="addJoke.php">Add Joke</a>';
    }
    if ($loggedIn && $isAdmin) {
        echo '<a href="admin.php">Admin</a>';
    }

    ?>
    <div id="loginbox">
        <div id="currentUser">
            <?php
            if ($loggedIn) {
                echo $_SESSION['username'];
            } else {
                echo 'Not Logged In';
            }
            ?>
        </div>
        <div id="loginForm">
            <?php
            if ($loggedIn) {
                echo <<<LOGGEDIN
        <form action="server.php" method="POST">
          <input name="action" value="logout" type="hidden" />
          <button>Logout</button>
        </form>
        LOGGEDIN;
            } else {
                echo <<<NOTLOGGEDIN
        <form action="server.php" method="POST">
          <input name="username" value="username" />
          <input name="password" type="password" value="password" />
          <input name="action" value="login" type="hidden" />
          <button onclick="login()">Login</button>
          <button onclick="register()">Register</button>
        </form>
        NOTLOGGEDIN;
            }
            ?>
            <div id="loginStatus"></div>
        </div>
    </div>
</nav>
<script>
    document.querySelector('#currentUser').addEventListener('click', ev => {
        document.querySelector('#loginForm').classList.toggle('visible')
    })

    function register() {
        document.querySelector("input[name=action]").value = "register"
    }

    function login() {
        document.querySelector("input[name=action]").value = "login"
    }

    function loginSuccess(user) {
        $('#currentUser').text(user.username)
        $('.notLoggedIn').hide()
        $('.loggedIn').show()
    }

    var cookies = {}

    function getCookies() {
        var cookieParts = document.cookie.split(';')
        for (const p of cookieParts) {
            let subParts = p.trim().split('=')
            let k = subParts[0]
            let v = decodeURI(subParts[1])
            cookies[k] = v
        }
    }
    getCookies()

    if (cookies.authError) {
        document.getElementById('loginStatus').innerText = cookies.authError
    }
</script>