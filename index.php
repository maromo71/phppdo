<?php
require_once 'init.php';
// abre a conexão
$PDO = db_connect();

// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), 
// mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM users ORDER BY name ASC";

// SQL para selecionar os registros
$sql = "SELECT id, name, email, gender, birthdate "
        . "FROM users ORDER BY name ASC";

// conta o total de registros
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();
$total = $stmt_count->fetchColumn();

// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Cadastro</title>
    </head>
    <body>
        <h1>Sistema de Cadastro</h1>
        <p><a href="form-add.php">Adicionar Usuário</a></p>
        <h2>Lista de Usuários</h2>
        <p>Total de usuários: <?php echo $total ?></p>
        <?php if ($total > 0): ?>
            <table width="50%" border="1">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Gênero</th>
                        <th>Data de Nascimento</th>
                        <th>Idade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo ($user['gender'] == 'm') ? 'Masculino' : 'Feminino' ?></td>
                            <td><?php echo dateConvert($user['birthdate']) ?></td>
                            <td><?php echo calculateAge($user['birthdate']) ?> anos</td>
                            <td>
                                <a href="form-edit.php?id=<?php echo $user['id'] ?>">Editar</a>
                                <a href="delete.php?id=<?php echo $user['id'] ?>" 
                                   onclick="return confirm('Tem certeza de que deseja remover?');">
                                    Remover
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum usuário registrado</p>
        <?php endif; ?>
    </body>
</html>