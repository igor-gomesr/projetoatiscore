<?php
require_once('../factory/conexao.php');


if (isset($_POST['Cadastrar'])) {

	$conn = new caminho();
	$query = "INSERT INTO tbprodutos (produto, preco, modelo, genero, foto) VALUES (:produto, :preco, :modelo, :genero, :nome_imagem)";
	$foto = $_FILES["foto"];

	if (!empty($foto["name"])) {


		$largura = 1500;
		$altura = 1800;
		$tamanho = 2048000;
		$error = array();


		if (!preg_match("/^image\/(jpg|jpeg|png|gif|bmp)$/", $foto["type"])) {


			$error[0] = "Isso não é uma imagem.";
		}

		$dimensoes = getimagesize($foto["tmp_name"]);

		if ($dimensoes[0] > $largura) {


			$error[1] = "A largura da imagem não deve ultrapassar " . $largura . " pixels";
		}

		if ($dimensoes[1] > $altura) {


			$error[2] = "Altura da imagem não deve ultrapassar " . $altura . " pixels";
		}

		if ($foto["size"] > $tamanho) {


			$error[3] = "A imagem deve ter no máximo " . $tamanho . " bytes";
		}

		if (count($error) == 0) {


			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

			$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
			$caminho_imagem = "../img/" . $nome_imagem;

			move_uploaded_file($foto["tmp_name"], $caminho_imagem);





			$cadastrar = $conn->getConn()->prepare($query);

			$cadastrar->bindParam(':produto', $_POST['produto'], PDO::PARAM_STR);
			$cadastrar->bindParam(':preco', $_POST['preco'], PDO::PARAM_STR);
			$cadastrar->bindParam(':modelo', $_POST['modelo'], PDO::PARAM_STR);
			$cadastrar->bindParam(':genero', $_POST['genero'], PDO::PARAM_STR);
			$cadastrar->bindParam(':nome_imagem', $nome_imagem, PDO::PARAM_STR);

			$cadastrar->execute();



			if ($cadastrar->rowCount()) {
				echo "
                    <script> alert('Produto cadastrado com sucesso') 
                    location.href = '../view/admin.php';
                    
                    </script>";

			} else {
				echo ('<script>Produto não foi cadastrado com sucesso.</script>');
			}

		}

		$totalerro = "";

		if (count($error) != 0) {


			for ($cont = 0; $cont <= sizeof($error); $cont++) {


				if (!empty($error[$cont]))
					$totalerro = $totalerro . $error[$cont] . '\n';

			}

			echo ('<script>window.alert("' . $totalerro . '");window.location="cadastro.php";</script>');
		}
	} else {


		echo ('<script>window.alert("Você não selecionou nenhuma arquivo!");window.location="../index.php";</script>');
	}
}


?>