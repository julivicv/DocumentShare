<?

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

header("location: ./create_user_page.php");

$isError = validar_dados($name, $email, $password);

if ($isError[0]) {
    // header("")
}


function validar_dados($name, $email, $password)
{
    $erros = array(); // Array para armazenar erros de validação

    // Validar nome
    if (empty($name)) {
        $erros[] = "Por favor, digite o seu nome.";
    } elseif (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
        $erros[] = "O seu nome só pode conter letras, números e espaços.";
    }

    // Validar e-mail
    if (empty($email)) {
        $erros[] = "Por favor, digite o seu e-mail.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "Por favor, digite um endereço de e-mail válido.";
    }

    // Validar senha
    if (empty($password)) {
        $erros[] = "Por favor, digite a sua senha.";
    } elseif (strlen($password) < 8) {
        $erros[] = "A sua senha deve ter pelo menos 8 caracteres.";
    }

    return $erros; // Retorna o array de erros (se houver)
}