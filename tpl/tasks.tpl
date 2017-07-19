<?include 'header.tpl'?>
<div class="container">
    <?if (!isset($this->tasks)){?>
        <form class="form-inline justify-content-end bg-faded mt-2 mb-2 p-2 rounded">
            <strong class="sortBy align-content-around">Sort by:</strong>
            <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                <label class="form-check-label">
                    <input name="filter" class="form-check-input" onchange="javascript:location.href = '?page=0&filter=`id`'" type="radio" <?=($_GET['filter'] == '`id`' || empty($_GET['filter']))?'checked':''?>> Id
                </label>
            </div>
            <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                <label class="form-check-label">
                    <input name="filter" class="form-check-input"  onchange="javascript:location.href = '?page=0&filter=`sucess`'" type="radio" <?=($_GET['filter'] == '`sucess`')?'checked':''?> > Status
                </label>
            </div>
            <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                <label class="form-check-label">
                    <input name="filter" class="form-check-input"  onchange="javascript:location.href = '?page=0&filter=`Username`'" type="radio" <?=($_GET['filter'] == '`Username`')?'checked':''?> > Username
                </label>
            </div>
            <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                <label class="form-check-label">
                    <input name="filter" class="form-check-input"  onchange="javascript:location.href = '?page=0&filter=`E-mail`'" type="radio" <?=($_GET['filter'] == '`E-mail`')?'checked':''?> > E-Mail
                </label>
            </div>
        </form>
        <?foreach ($this->tasks as $task){?>
            <?include "elements/one_task.tpl"?>
        <?}?>
        <ul class="pagination mt-2 float-md-right">
            <?for ($p=0;$p<$this->task_count;$p++){?>
                <li class="page-item <?=($_GET["page"]== $p)?'active':""?>"><a class="page-link" href="?page=<?=$p?><?=(isset($_GET['filter'])?'&filter='.$_GET['filter']:'')?>"><?=$p+1?></a></li>
            <?}?>
        </ul>
        <script>
            $(document).ready(function () {
                $('.task #success').change(function (elem) {
                    var check;
                    var id = $(this).val();
                    if($(this).prop("checked")){check='1'}else{check='0'}
                    $.get('/task/complete/'+id+"?check="+check,function () {
                        console.log($('button[value='+id+'][id=edit_task]'));
                        if (check == '1'){
                            $('[data-task-id='+id+']').addClass("success");
                            $('button[value='+id+'][id=edit_task]').addClass('hidden-xl-down');
                        }else {
                            $('[data-task-id='+id+']').removeClass("success");
                            $('button[value='+id+'][id=edit_task]').removeClass('hidden-xl-down');
                        }
                    });
                });

                $(".task #delete_task").click(function () {
                    var id = $(this).val();
                    $.get('/task/delete/'+id,function () {
                        $('[data-task-id='+id+']').detach();
                    });
                });
            });
        </script>
    <?}?>
</div>
<?include 'footer.tpl'?>
