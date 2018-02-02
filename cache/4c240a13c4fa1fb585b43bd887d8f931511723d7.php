<header class="header">
    <div class="container">
        <a class="header__logo" href="/">PP<span>CMS</span></a>
        <nav class="header__main-nav">
            <ul>
                <?php if($user): ?>
                    <li class="header__main-nav-item"><a class="header__main-nav-item-link" href="/logout">Logout</a></li>
                <?php else: ?>
                    <li class="header__main-nav-item"><a class="header__main-nav-item-link" href="/login">Login</a></li>
                    <li class="header__main-nav-item"><a class="header__main-nav-item-link" href="/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>