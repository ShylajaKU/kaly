<style>
    .try{
        /* border: 1px black solid; */
        width: 300px;
        margin: auto;
        align-items: center;
        padding-top: 5px;
    }

</style>
<div class="try">
    <?= form_open() ?>
        <input class="form-control" id="email" type="text" name="email" placeholder="Email">
<br>
        <input class="form-control" type="password" name="password" id="pass" placeholder="Password">
    <br>
    <button type="submit" class="btn btn-primary vip-center">Login</button>
    <a style="margin-left:15px ;" href="<?= base_url('register') ?>">Register Here</a>
    <br>
    <?= form_close() ?>
</div>
<hr>