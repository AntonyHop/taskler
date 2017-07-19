<div class="card login container col-md-6">
    <div class="card-header">
        <b>Sign In</b>
    </div>
    <div class="card-block">
        <form>
            <?if (isset($this->err)){?>
                <div class="alert alert-danger" role="alert">
                    <strong>Oh snap!</strong> <?=$this->err?>
                </div>
            <?}?>
            <div class="form-group row">
                <label for="inputLogin" class="col-sm-3 col-form-label">Login</label>
                <div class="col-sm-9">
                    <input type="login" class="form-control" id="inputLogin" placeholder="Login">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                </div>
            </div>
            <button type="button" class="btn btn-primary signIn">Sign In</button>
            <script>
                $('.signIn').click(function () {
                    var user = {};
                    user.name = $('#inputLogin').val();
                    user.pass = $('#inputPassword').val();
                    $.ajax({
                        url: '/login_ajax',
                        type: "POST",
                        data: {'user':user},
                        success: function (data) {
                            if (data != '{}'){
                                obj = $.parseJSON(data);
                                $('body').append('<div id="err"></div>');
                                for(i in obj){
                                    $('#err').append('<div class="alert alert-danger flying" data-fly = '+i+' role="alert">'+obj[i]+'</div>');
                                    setTimeout(function () {
                                        $('[data-fly='+i+']').detach();
                                        },6000);
                                    };
                                }else{
                                    location.href = '/task';
                                }
                            }
                        });
                    });
            </script>
        </form>
    </div>
</div>