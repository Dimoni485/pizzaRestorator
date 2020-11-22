<?php require_once "../header.php"; ?>
    <style type="text/css">
        .razdelitel{
            height:50px;
        }
    </style>
    <div class="razdelitel">
        <a href="#" onclick="adduser();" class="btn btn-success">Добавить</a>
    </div>
    <table class="table table-hover table-sm">
        <thead>
        <tr class="zagolovok">
            <th>Имя</th><th>Пароль</th><th></th><th></th>
        </tr>
        </thead>
        <?php
        require_once("../connect.php");
        $Q=mysqli_query($dbm,'select * FROM USERS ORDER BY LOGIN');
        while ($Row=mysqli_fetch_assoc($Q)) {
            echo "<tr>";
            echo "<td>";
            echo $Row['LOGIN'];
            echo "</td>";
            echo "<td>";
            echo $Row['PASSWORD'];
            echo "</td>";
            echo "<td>";
            if ($Row['LOGIN']!=='admin') {

                echo "<a href='#' onclick='deluser(".$Row['ID'].");'><img src='/images/error.png' width='25px' height='25px' alt='Удалить'></a>";
            }
            echo "</td>";
            echo "<td>";
            echo "<a href='#' onclick='setnewpassword(".$Row['ID'].");'>Сменить пароль</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <div class="modal fade" id="adduser">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Добавление категории</div>
                </div>
                <div class="modal-body">
                    Пользователь:
                    <input type="text" class="form-control" id=username>
                    Пароль:
                    <input type="text" class="form-control" id=password>
                    <div class="modal-footer">
                        <a href="#" onclick="saveuser();" class='btn btn-success'>Добавить</a><a href="#" class='btn btn-default' onclick="$('#adduser').modal('hide');">Закрыть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="setpassword">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Изменить пароль</div>
                </div>
                <div class="modal-body">
                    Новый пароль:
                    <input type="text" class="form-control" id=newpassword>
                    Подтвердить пароль:
                    <input type="text" class="form-control" id=newpasswordcon>
                    <div class="modal-footer">
                        <a href="#" onclick="savepassword();" class='btn btn-success'>Сохранить</a><a href="#" class='btn btn-default' onclick="$('#setpassword').modal('hide');">Закрыть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function adduser()
        {
            $("#adduser").modal('show');
        }
        function saveuser()
        {
            $.ajax({
                type:'POST',
                url:'/user/adduser.php',
                data:'login='+$("#username").val()+'&password='+$("#password").val(),
                success:function(){
                    location.reload();
                }
            });
        }
        function deluser($iduser)
        {
            if (confirm("Удалить запись ?")) {
                $.ajax({
                    type: 'POST',
                    url: '/user/deluser.php',
                    data: 'iduser=' + $iduser,
                    success: function () {
                        location.reload();
                    }
                });
            }
        }

        var $idusers;

      function setnewpassword($iduser)
        {
            $idusers = $iduser;
            $("#setpassword").modal('show');
            return $iduser;
        }

        function savepassword() {
          if ($('#newpassword').val() == $('#newpasswordcon').val() && $('#newpasswordcon').val()!=='')
        {
            $.ajax({
                type: 'POST',
                url: '/user/newpassword.php',
                data: 'iduser=' + $idusers + '&password=' + $("#newpassword").val(),
                success: function () {
                    location.reload();
                }
            });
            console.log($idusers);
        }else {
              alert('Пароли не совпадают');
          }
        }
    </script>
<?php require_once "../footer.php"; ?>