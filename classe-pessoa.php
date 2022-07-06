<?php
Class Pessoa
{
    private $pdo;

    public function __construct($dbname, $host, $usuario, $senha)
    {
        try
        {
            $this->pdo = new PDO("mysql:dbname=". $dbname .";host=".$host, $usuario, $senha);
        }
        catch (PDOException $e)
        {
            echo "Erro relacionado ao banco de dados ". $e;
            exit();
        }
        catch (Exception $e)
        {
            echo "Erro genérico ". $e;
            exit();
        }
    }
    //FUNCAO PARA BUSCAR DADOS e colocar do lado direito
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    //funcao para cadastrar pessoas
    public function cadastrarPessoa ($nome, $telefone, $email)
    {
        //ANTES DE CADASTRAR VERIFICAR SE USUARIO JÁ ESTA CADASTRADO
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if($cmd->rowCount() > 0) //EMAIL JA EXISTE NO BANCO!?
        {
            return false;
        }
        else//nao existe o email no banco
        {
              $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUE (:n, :t, :e)");
              $cmd->bindValue(":n", $nome);
              $cmd->bindValue(":t", $telefone);
              $cmd->bindValue(":e", $email);
              $cmd->execute();
              return true;
        }

    }   
    
    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function excluirPessoa2($id)
    {
        $this->pdo->query("DELETE FROM pessoa WHERE id = '".$id."'");
    }


    public function buscarDadosPessoa($id)
    {
        $receber = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $receber = $cmd->fetch(PDO::FETCH_ASSOC);//fetch_assoc para economia de memoria
        return $receber;
    }

    public function atualizarDados($id, $nome, $telefone, $email)
    {        
        $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email); 
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }


}



?>