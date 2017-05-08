<section class="hero is-primary is-medium">
    <div class="hero-head">
        <header class="nav">
            <div class="container">
                <div class="nav-left">
                    <router-link :to="`/about`" class="nav-item">
                        <!-- <img src="#" alt="Logo"> -->
                        Alec Divito
                    </router-link>
                </div>
                <span class="nav-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                <div class="nav-right nav-menu">
                    <a class="nav-item is-active">
                        Home
                    </a>
                    <a class="nav-item">
                        Other Projects
                    </a>
                    <span class="nav-item">
                            <a class="button is-primary is-inverted">
                                <span class="icon">
                                    <i class="fa fa-github"></i>
                                </span>
                                <span>Github Portfolio</span>
                            </a>
                        </span>
                </div>
            </div>
        </header>
    </div>

    <div class="hero-body">
        <div class="container">
            <h1 class="title">Alec Divito Vue Projects</h1>
            <h2 class="subtitle">Card Games</h2>
        </div>
    </div>

    <div class="hero-foot">
        @include('layouts.nav')
    </div>
</section>