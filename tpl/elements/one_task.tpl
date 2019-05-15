<div class="col-md-12 task <?=($task['sucess']==1)?'success':''?> row" data-task-id="<?=$task['id']?>">
    <div class="col-md-5">
        <img class="align-self-start img_preview" src="/<?=$task['Img_url']?>" alt="Generic placeholder image">
    </div>
    <div class="col-md-7">
        <div class="col-md-12 row">
            <div class="col-md-6 ta-md-left">
                <strong>User: </strong>@<span class="username"><?=$task['Username']?></span>
            </div>
            <div class="col-md-6 ta-md-left">
                <strong>Email: </strong><span class="email"><?=$task['E-mail']?></span>
            </div>
        </div>
        <p id="taskText" class="col-md-12 mt-2"><?=$task['Text']?></p>
        <div class="form-check float-md-right col-md-4">
            <label class="form-check-label text-success ta-md-right">
                <input type="checkbox" id="success" class="form-check-input" <?=(isset($task['sucess']) && $task['sucess']==1)?'checked':''?> value="<?=$task['id']?>">
                Task complete!
            </label>
        </div>
        <?if (isAuth()){?>
        <div class="col-md-7 col-md-float-right">
            <div class="btn-group options">
                <?if (isset($task['sucess']) && $task['sucess']==0){?>
                    <button class="btn btn-secondary" onclick="location.href='/task/edit/<?=$task['id']?>'" id="edit_task" value="<?=$task['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                <?}else{?>
                    <button class="btn btn-secondary hidden-xl-down" onclick="location.href='/task/edit/<?=$task['id']?>'" id="edit_task" value="<?=$task['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                <?}?>
                <button class="btn btn-danger" id="delete_task" value="<?=$task['id']?>"><i class="fa fa-eraser" aria-hidden="true"></i></button>
            </div>
        </div>
        <?}?>
    </div>
</div>