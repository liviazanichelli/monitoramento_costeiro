<?php
include '../config.php';
include '../header.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $assunto = trim($_POST['assunto'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if (!empty($nome) && !empty($email) && !empty($assunto) && !empty($mensagem)) {
        
        $stmt = $conn->prepare("INSERT INTO contato (nome, email, mensagem) VALUES (?, ?, ?)");
        $texto_final = "Assunto: $assunto\n\n$mensagem"; // salva junto
        $stmt->bind_param("sss", $nome, $email, $texto_final);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Mensagem enviada com sucesso!');</script>";
        } else {
            echo "<script>alert('❌ Erro ao enviar mensagem.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('⚠️ Preencha todos os campos antes de enviar.');</script>";
    }
}
?>

<main style="display:flex; flex-direction:column; align-items:center; justify-content:flex-start; min-height:90vh; font-family: Arial, sans-serif; padding:60px 20px; background:#f6f9fc;">
   
    <h1 style="font-size: 36px; margin-bottom: 15px; color:#0b4560; text-shadow:1px 1px 2px rgba(0,0,0,0.2);">
        Contato e Sugestões
    </h1>

    <p style="font-size: 18px; margin-bottom: 40px; max-width:700px; text-align:center; color:#333;">
        Utilize o formulário abaixo para enviar dúvidas, sugestões ou feedback sobre o sistema.
    </p>

    <div style="background:#fff; padding:40px 30px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.1); display:flex; flex-direction:column; align-items:center; gap:25px; width:100%; max-width:500px;">

        <form method="post" action="" style="display:flex; flex-direction:column; gap:20px; width:100%;">

            <input type="text" name="nome" placeholder="Nome" required style="padding:12px; font-size:16px; border-radius:6px; border:1px solid #ccc; width:100%;">

            <input type="email" name="email" placeholder="E-mail" required style="padding:12px; font-size:16px; border-radius:6px; border:1px solid #ccc; width:100%;">

            <input type="text" name="assunto" placeholder="Assunto" required style="padding:12px; font-size:16px; border-radius:6px; border:1px solid #ccc; width:100%;">

            <textarea name="mensagem" placeholder="Mensagem" required style="padding:12px; font-size:16px; border-radius:6px; border:1px solid #ccc; width:100%; min-height:120px; resize:none;"></textarea>

            <button type="submit" style="padding:15px; font-size:18px; background:#0b4560; color:#fff; border:none; border-radius:8px; cursor:pointer; box-shadow:0 4px 10px rgba(0,0,0,0.15); transition: background 0.2s;">
                Enviar Mensagem
            </button>

        </form>
    </div>
</main>
