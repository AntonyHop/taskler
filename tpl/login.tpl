<?include 'header.tpl'?>
<div class="container">
    <?if (!isAuth()):?>
        <?include 'elements/login_form.tpl'?>
    <?endif;?>
</div>
<?include 'footer.tpl'?>

