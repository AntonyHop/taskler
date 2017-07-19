<nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-inverse bg-inverse">
    <button class="navbar-toggler navbar-toggler-right hidden-xs" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-brand"><b>Taskler</b></div>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?=($this->title=="Home")?'active':''?>">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?=($this->title=="Tasks")?'active':''?>">
                <a class="nav-link" href="/task">Admin <span class="sr-only">(current)</span></a>
            </li>
            <?if(isAuth()){?>
                <li class="nav-item">
                    <a class="nav-link" href="/dayside/index.php">Dayside<span class="sr-only">(current)</span></a>
                </li>
            <?}?>
        </ul>
        <?if (isAuth()):?>
            <a href="/logout" class="my-2 my-lg-0 btn btn-outline-primary">Logout</a>
        <?endif;?>
    </div>
</nav>