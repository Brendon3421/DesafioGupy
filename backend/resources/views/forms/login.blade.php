<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div id="alert-container"></div>
        <!-- Formulário de Login (login.blade.php) -->
        <form id="login-form">
            @csrf
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" class="form-control" id="login-email" name="email" required>
                <span class="text-danger" id="login-email-error"></span>
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" class="form-control" id="login-password" name="password" required>
                <span class="text-danger" id="login-password-error"></span>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            // Limpar mensagens de erro anteriores
            document.getElementById('login-email-error').textContent = '';
            document.getElementById('login-password-error').textContent = '';

            // Obter dados do formulário
            const formData = new FormData(this);

            try {
                // Enviar dados para o servidor usando fetch
                const response = await fetch("{{ route('login/auth') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                // Processar resposta do servidor
                const data = await response.json();

                if (response.ok) {
                    // Sucesso - Armazenar o token no localStorage ou cookies
                    localStorage.setItem('token', data.token); // Supondo que a API retorne um token
                    console.log(localStorage)
                    const alertContainer = document.getElementById('alert-container');
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success';
                    successAlert.textContent = data.message || 'Login bem-sucedido!';
                    alertContainer.appendChild(successAlert);

                    // Redirecionar após alguns segundos
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 2000);
                } else {
                    if (data.errors) {
                        // Se houver erros de validação
                        for (const key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                document.getElementById(`login-${key}-error`).textContent = data.errors[key][0];
                            }
                        }
                    } else {
                        // Caso a resposta tenha outros erros
                        const alertContainer = document.getElementById('alert-container');
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger';
                        errorAlert.textContent = data.message || 'Erro ao fazer login';
                        alertContainer.appendChild(errorAlert);
                    }
                }
            } catch (error) {
                console.error('Erro:', error);
                const alertContainer = document.getElementById('alert-container');
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger';
                errorAlert.textContent = 'Ocorreu um erro ao tentar fazer login';
                alertContainer.appendChild(errorAlert);
            }
        });
    </script>
</body>

</html>
