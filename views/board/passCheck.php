    <div class="input-group col-lg-offset-4">
        <form action="view" method="post" class="form-horizontal">
            <input type="hidden" name="no" value="<?=$this->no?>"/>
            <input type="hidden" name="page" value="<?=$this->page?>"/>
            <div class="form-group">
                <label for="title" class="col-md-3">비밀번호 : </label>
                <div class="col-md-6">
                    <input type="password" name="pass" class="form-control"/>
                </div>
                <input type="submit" name="submit" class="btn btn-default"/>
            </div>
        </form>
    </div>
</body>
</html>