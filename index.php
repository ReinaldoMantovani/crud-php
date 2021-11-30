<?php
  require_once 'Pessoa.class.php';
  $p = new Pessoa("register","localhost","root","");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Style/main.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Register Client</title>
  </head>
  <body>
    <?php
    //CLICK THE BUTTON REGISTER OR EDIT
    if(isset($_POST['name'])) {

          if(isset($_GET["id_up"]) && !empty($_GET['id_up'])) {
              //EDIT USER
              $id_upd = addslashes($_GET["id_up"]);

              $name = addslashes($_POST['name']);
              $telephone = addslashes($_POST['telephone']);
              $email = addslashes($_POST['email']);
              
               if(!empty($name) && !empty($telephone) && !empty($email)) {
                    //UPDATE USER 
                     $p->updateUser($id_upd,$name,$telephone,$email); 
                       
                        echo "<p><i class='fas fa-user-check' style='font-size:24px;color:#7fff00;'></i>Usúario Atualizado!</p>";
                        
        
                      }  else {
                          echo "<p><i class='fa fa-exclamation-triangle' style='font-size:24px;color:yellow;'></i>Preencha todos os campos!</p>";
                        
                      }
            
          } else {
          
            $name = addslashes($_POST['name']);
            $telephone = addslashes($_POST['telephone']);
            $email = addslashes($_POST['email']);
             if(!empty($name) && !empty($telephone) && !empty($email)) {
                  //register
                   if($p->registerUser($name,$telephone,$email)) {
                    
                      echo "<p><i class='fas fa-user-check' style='font-size:24px;color:#7fff00;'></i>Usúario cadastrado!</p>";
                     
                    } else {
                      echo "<p><i class='fas fa-skull-crossbones' style='font-size:24px;'></i></i>E-mail já cadastrado!</p>";
                    
                   }
      
                    }  else {
                        echo "<p><i class='fa fa-exclamation-triangle' style='font-size:24px;color:yellow;'></i>Preencha todos os campos!</p>"; 
                   }
                

          }
  }
        
    ?>
    <?php
    //IF USER CLICK TO REGISTER OR EDIT
        if(isset($_GET['id_up'])) {
           $id_update = addslashes($_GET['id_up']);
           $res = $p->getdatesUser($id_update);
           
        }
    
    ?>

     <div class="container">
         <form method="POST" >
            <h2>Register Client</h2>
               <label for="name" >Name:</label>
                 <input name="name" type="text" id="name" value="<?php if(isset($res)){echo $res['name'];} ?>" require>
               <label for="telephone" >Telephone:</label>
                 <input name="telephone" type="text" id="telephone" require value="<?php if(isset($res)){echo $res['telephone'];} ?> ">
               <label for="email" >E-mail:</label>
                 <input name="email" type="email" require id="email" value="<?php if(isset($res)){echo $res['email'];} ?> ">
                 <input type="submit"
                  value=" <?php if(isset($res)){echo "Atualizar";} else {echo "Cadastrar";} ?>">
         </form>
        
      </div>
     <div id="bottom">
     <table>
            <tr class="title">
               <td> Name</td>
               <td>Telephone</td>
               <td> Email</td>
               <td>Configurar</td>
       <?php 
        $dates = $p->getDate();
        if(count($dates) > 0) {
            for($i = 0; $i < count($dates); $i++ ) {
              echo "<tr>";
                foreach ($dates[$i] as $key => $value) {
                  # code...
                    if($key != "id") {
                       echo "<td>".$value."</td>";
                    }

                }
                ?>  
                <td colspan="0.5">
                  <a class="edit" href="index.php?id_up=<?php echo $dates[$i]['id'];  ?>">Editar</a>
                  <a class="delete" href="index.php?id=<?php echo $dates[$i]['id'];  ?>">Excluir</a></td>
                <?php
                echo "</tr>"; 
            }
         
        } else {
            echo "<div>";
            echo "<p><i class='fas fa-user-alt-slash' style='font-size:24px;color:#ccc;'></i>Nenhum usúario registrado!</p>";
            echo "</div>";
        }
       ?>       
        </table>
      </div>


  </body>
</html>

<?php
  if(isset($_GET['id'])) {
    $user_id = addslashes($_GET['id']);
    $p->deleteUser($user_id);
    header("location: index.php");
  }


?>