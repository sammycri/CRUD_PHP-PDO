<?php
require_once 'classe-pessoa.php';
$p = new Pessoa("bd_pdo", "localhost", "root", "");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Cadastro Pessoa</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php
    if(isset($_POST['nome']))//clicou para cadastrar ou editar
    {
        //EDITAR
        if(isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                //AATUALIZAR DADOS
                $p->atualizarDados($id_upd, $nome, $telefone, $email);                
            }
            else
            {
                echo "Preencha TODOS OS CAMPOS!";
            }
        }
        //CADASTRAR
        else
        {
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                //CADASTRAR
                if(!$p -> cadastrarPessoa($nome, $telefone, $email))
                {
                    echo "Email já está cadastrado!";
                }
            }

            else
            {
                echo "Preencha TODOS OS CAMPOS!";
            }
        }
        
    }
    ?>
    <?php
    if(isset($_GET['id_up']))
    {
        $id_update = addslashes($_GET['id_up']);
        $receber = $p->buscarDadosPessoa($id_update);
    }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>Cadastrar Pessoa</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php
            if(isset($receber))
            {
                echo $receber['nome'];
            } 
            ?>">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php
            if(isset($receber))
            {
                echo $receber['telefone'];
            } 
            ?>">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php
            if(isset($receber))
            {
                echo $receber['email'];
            } 
            ?>">
            <input type="submit" value="<?php
            if(isset($receber))
            {
                echo "Atualizar";
            } 
            else
            {
                echo "Cadastrar";
            }
            ?>">
        </form>
    </section>
    <section id="direita">
    <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>Telefone</td>
                <td colspan="2">Email</td>
            </tr>
        <?php
        $dados = $p->buscarDados();
        if(count($dados) > 0)
        {
            for ($i=0; $i < count($dados); $i++)
            {
                echo "<tr>";
                foreach($dados[$i] as $key => $value)
                {
                    
                    if($key != "id")
                    {
                        echo "<td>". $value . "</td>";
                    }                    
                }
                ?>
            <td><a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar </a> <a href="index.php?id=<?php echo $dados[$i]['id'];?>"> Excluir</a></td>
        <?php
                echo "</tr>";
            }
            
        }
        else
        {
            echo "Ainda não há pessoas cadastradas!";
        }

        ?>
        
            
                
                
            </tr>
        </table>
    </section>
</body>
</html>

<?php

if(isset($_GET['id']))
{
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("location: index.php");
}



?>