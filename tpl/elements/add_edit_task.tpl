<?if (!$this->editMode){
    $this->task = null;
}?>
<div class="card login container col-md-7">
    <div class="card-header">
        <strong><?=($this->editMode)?'Edit task':'Add task'?></strong>
    </div>
    <form enctype="multipart/form-data" method="post" action="<?=($this->editMode)?'/task/edit/'.$this->task["id"]:'/task/add'?>">
        <div class="card-block">
            <?if (isset($this->err)){?>
                <div class="alert alert-danger" role="alert">
                    <strong>Oh snap!</strong> <?=$this->err?>
                </div>
            <?}?>
            <div class="form-group row">
                <label for="inputLogin" class="col-sm-2 col-form-label">Login</label>
                <div class="col-sm-10">
                    <input name="login" type="login" class="form-control" id="inputLogin" placeholder="Login" value="<?=(isset($this->task["Username"]))?$this->task["Username"]:''?>" required >
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-10">
                    <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email" value="<?=(isset($this->task["E-mail"]))?$this->task["E-mail"]:''?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputTextarea">Task text</label>
                <textarea name="text" class="form-control" id="inputTextarea" rows="3"><?=(isset($this->task["Text"]))?$this->task["Text"]:''?></textarea>
            </div>
            <div class="form-group">
                <label for="InputFile">Task Img</label>
                <input type="file" name="uploadfile" class="form-control-file" id="InputFile" aria-describedby="fileHelp" accept="image/jpeg,image/png" <?if(!$this->editMode):?>required<?endif;?>>
                <small id="fileHelp" class="form-text text-muted">
                    Format must be JPG/GIF/PNG. The image will be compressed
                </small>
            </div>
        </div>
        <div class="card-footer pb-5">
            <div class="btn-group float-md-right" role="group">
                <?if (!$this->editMode):?>
                    <button type="button" class="btn btn-info" data-toggle="modal" id="preview">Preview</button>
                <?endif;?>
                <button type="submit" class="btn btn-primary"><?=( $this->editMode)?'Edit task':'Add task'?></button>
            </div>
        </div>
    </form>
</div>

<!--MODAL SHOW Preview-->

<div class="modal fade" id="showPreview">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?include "one_task.tpl"?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#preview").click(function () {
            if($('#inputLogin').val() != "" && $('#inputLogin').val() != "" && $('#inputTextarea').val() != "" && $('#InputFile').val() != ""){
                $('.form-group').removeClass('has-danger');
                $('.username').html($('#inputLogin').val());
                $('.email').html($('#inputLogin').val());
                $('#taskText').text($('#inputTextarea').val());
                $('#showPreview').modal('show');
            }else{
                $('.form-group').addClass('has-danger');
            }
        });
        $("#InputFile").change(function(){
            reader = new FileReader();
            $('#preview').attr('disabled');
            input = document.getElementById("InputFile");
            reader.readAsDataURL(input.files[0]);
            reader.onloadend = function () {
                $('.img_preview').attr('src',reader.result);
                $('#preview').removeAttr('disabled');
            }
        });
    })
</script>
