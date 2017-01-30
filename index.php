<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PHP AJAX CRUD</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </head>
  <body>
    <div class="row">
      <div class="container">
        <h1>PHP AJAX CRUD</h1>
      </div>
    </div>
    <div class="row">
      <div class="container">
        <form method="POST" role="form" id="form_action">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="nama" class="form-control" id="nama" name="nama" placeholder="Nama">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
          </div>
          <input type="hidden" id="action" name="action" value="add">
          <input type="hidden" id="id" name="id" value="">
          <button type="button" id="submit" class="btn btn-default">Submit</button>
        </form>
      </div>
    </div>
    <div class="row">
      &nbsp;
    </div>
    <div class="row">
      <div class="container">
        <table class="table table-striped table-responsive" id="usersdata"> 
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Action</th>
            </tr>
            <?php 
            include 'config.php';
            $sql = "SELECT * FROM biodata";
            $query =  mysqli_query($conn, $sql);
            $rows = mysqli_num_rows($query);
            if($rows>0)
            {
                while($data = mysqli_fetch_array($query))
                {
            ?>
                <tr class="user_<?php echo $data['id']; ?>">
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td>
                        <a href="javascript:void(0);" onclick="edit_user('<?php echo $data['id']; ?>')"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0);" onclick="delete_user('<?php echo $data['id']; ?>')"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
        </table>
      </div>
    </div>    
    <script type="text/javascript">
      $("#submit").click(function(){
        
        var action = $("#action").val();
        
        $.ajax({
          url       : "insert.php",
          type      : "POST",
          data      : $('#form_action').serialize(),
          dataType  : "json",
          success   : function(response){
              if(action == "add"){
                var html = "";
                html += "<tr class=user_"+response['id']+">";
                html +=   "<td>"+response['nama']+"</td>";
                html +=   "<td>"+response['email']+"</td>";
                html +=   "<td>"+response['alamat']+"</td>";
                html +=   "<td><a href='javascript:void(0);' onclick='edit_user("+response['id']+");'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' onclick='delete_user("+response['id']+");'><i class='glyphicon glyphicon-trash'></i></a></td>";
                html += "</tr>";
                $("#usersdata").append(html);
              } else {
                window.location.reload();
              }           
          }
        });
      });

      function edit_user(id) {
            $.ajax({
                url : "edit.php",
                method : "POST",
                data : {'id':id},
                dataType : "json",
                success : function(response) {
                    $('#nama').val(response['nama']).css("background","lightblue");
                    $('#email').val(response['email']).css("background","lightblue");
                    $('#alamat').val(response['alamat']).css("background","lightblue");
                    $("#id").val(response['id']);
                    $("#action").val("edit");
                }
            });
        }

      function delete_user(id) {
            
          $.ajax({
              url : "delete.php",
              method : "POST",
              data : {'id':id},
              success : function(response) {
                  $(".user_"+id).remove();
              }
          });
      }

    </script>  
  </body>
</html>