<?php
include("config.php");
session_start();

if(isset($_GET['codigo'])){

  $codigoGato = $_GET['codigo'];
  $consultaDadosGato=$MYSQLi->query("SELECT * FROM TB_GATOS WHERE GAT_CODIGO = $codigoGato");
  $resultadoDadosGato=$consultaDadosGato->fetch_assoc();
}

$consultaSexo = $MYSQLi->query("SELECT * FROM TB_SEXOS");

if(isset($_GET['editar'])){

  $codEditar= $_GET['editar'];

  if(isset($_POST['nome'])) {
   
    $nome= $_POST['nome'];
    $sexo= $_POST['sexo'];
    $descricao=$_POST['descricao'];
    $idade=$_POST['idade'];

    if ($_FILES['arquivo']['size'] == 0){ /*verificar se algum arquivo foi selecionado */

      $consultaUpdate = $MYSQLi->query("UPDATE TB_GATOS SET GAT_NOME='$nome',GAT_SEX_CODIGO='$sexo',GAT_DESCRICAO='$descricao',GAT_IDADE='$idade' WHERE GAT_CODIGO=$codEditar;");
      
      header("Location:lista_gatos.php");

    }else{ 
      $extensao=substr($_FILES['arquivo']['name'], -4);
      $foto=md5(time()).$extensao;
      $diretorio="uploads/";
      move_uploaded_file($_FILES['arquivo']['tmp_name'],$diretorio.$foto);

      $consultaUpdate2 = $MYSQLi->query("UPDATE TB_GATOS SET GAT_NOME='$nome',GAT_SEX_CODIGO='$sexo',GAT_DESCRICAO='$descricao',GAT_FOTO = '$foto', GAT_IDADE='$idade' WHERE GAT_CODIGO=$codEditar;");
      header("Location:lista_gatos.php");
    }
    
  }
}

if(isset($_GET['excluir'])){

  $codExcluir= $_GET['excluir'];

    $consultaDrop = $MYSQLi->query("DELETE FROM TB_GATOS WHERE GAT_CODIGO=$codExcluir;");
    
    header("Location:lista_gatos.php");
  
}

?>
<?php include("design_cabecalho_user.php"); ?>

<div class="row">
  <div class="col-lg-10 col-ml-12">
    <div class="row">
      <!-- basic form start -->
      <div class="col-12 mt-5">
        <div class="card">
          <div class="card-body">
            <h4 class="header-title">Editar gato</h4>

            <form action="?editar=<?php echo $codigoGato ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
              <div class="form-group" style="margin-top: -45px;">
                <img style="width: 100px;height:100px; border-radius: 50%; float: right; margin-bottom: 8px;" src="uploads/<?php echo $resultadoDadosGato['GAT_FOTO'] ?>">
                <div class="input-group">
                  <input type="text" id="nome" name="nome" value="<?php echo $resultadoDadosGato['GAT_NOME']; ?>" placeholder="Bill borba gato" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-form-label">Idade do Gato:</label>
                <div class="input-group">
                                  <input type="number" id="idade" name="idade" value="<?php echo $resultadoDadosGato['GAT_IDADE']; ?>" placeholder="2" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-form-label">Sexo do gato:</label>
                
                <select class="custom-select" name="sexo">
                  <?php while($resultadoSexo = $consultaSexo->fetch_assoc()) { ?>
                    <option value="<?php echo $resultadoSexo['SEX_CODIGO']; ?>" <?php 
                      if($resultadoDadosGato['GAT_SEX_CODIGO'] == $resultadoSexo['SEX_CODIGO'])
                        echo "selected";
                      ?>>
                      <?php echo $resultadoSexo['SEX_SEXO']; ?>
                    </option>
                  <?php } ?>
                </select>

              </div>
              <div class="form-group">
                <label class="col-form-label">Descrição Fofinha do Gato:</label>
                <div class="input-group">
                  <input type="text" id="descricao" name="descricao" value="<?php echo $resultadoDadosGato['GAT_DESCRICAO']; ?>" placeholder="Ximbica é um gato muito fofinho, carinhoso, sempre me entende. Eu amo ele <3" class="form-control">
                </div>
              </div>
              <div class="form-group">          
              <label class="col-form-label">Foto do Gato:</label>
                <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="arquivo" name="arquivo">
                      <label class="custom-file-label" for="arquivo">Escolha a foto do gatinho</label>
                    </div>
                  </div>
              </div>  
              <div class="form-group text-center">
                <button type="button" class="btn btn-primary mb-3 mr-3">Voltar</button>
                <button type="submit" class="btn btn-primary mb-3 ml-3">Editar</button>
              </div>

            </form>
            <form action="?excluir=<?php echo $codigoGato ?>" method="POST">
                  <div class="form-group text-right">          
                  <button type="submit" style="background-color:transparent;border:none"><h6 class="col-form-label">excluir gato</h6></button>
                  </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include("design_rodape.php"); ?>