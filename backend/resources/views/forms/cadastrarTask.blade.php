<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-M7a/7i8F+IgeMTS2xHjQzU/q9N6FbOm69ckkF9eZ5JPR2Wq2TXMVAMNXjYJfI3u8" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/cadastratTask.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/nice-forms.css/nice-forms.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Cadastrar uma Task</h1>
        <div id="alert-container"></div>
        <form id="cadastrarTask" action="{{ url('api/task') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Step 1: Task Information -->
            <div class="form-group">
                <label for="title">Titulo*</label>
                <input type="text" class="form-control" id="title" name="title" required>
                <div id="title-error" class="text-danger"></div>
            </div>

            <label>Textarea</label>
            <div class="form-group">
                <textarea rows="5" id="description" name="description" style="height: 194px; width: 213px;" required>
                </textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Selecione uma Categoria*</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <i class="arrow ph-bold ph-caret-down"></i>

                    @foreach ($category as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                <div id="category-error" class="text-danger"></div>
            </div>

            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">

            <button type="submit" class="btn-primary">Cadastrar</button>
        </form>
    </div>

    <section>
        <main>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Situacao</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tasks-table">
                    <!-- As tarefas serão inseridas aqui -->
                </tbody>
            </table>
        </main>
    </section>

    <script>
        document.getElementById('cadastrarTask').addEventListener('submit', function(event) {
            event.preventDefault();

            // Limpar mensagens de erro anteriores
            document.getElementById('alert-container').innerHTML = '';
            document.querySelectorAll('.text-danger').forEach((element) => element.textContent = '');

            // Coletar dados do formulário
            const formData = new FormData(this);
            console.log([...formData]); // Isso irá imprimir os dados do formulário para depuração.

            // Verificar se o token de autenticação está armazenado
            const token = localStorage.getItem('token');
            console.log("Bearer Token:", token); // Log para verificar se o token está correto

            if (!token) {
                const alertContainer = document.getElementById('alert-container');
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger';
                errorAlert.textContent = 'Token de autenticação não encontrado.';
                alertContainer.appendChild(errorAlert);
                return;
            }

            // Enviar dados para o servidor usando fetch
            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, // CSRF Token
                        'Authorization': 'Bearer ' + token, // Bearer Token
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Verifique a resposta da API
                    if (data.success) {
                        const alertContainer = document.getElementById('alert-container');
                        const successAlert = document.createElement('div');
                        successAlert.className = 'alert alert-success';
                        successAlert.textContent = 'Task cadastrada com sucesso!';
                        alertContainer.appendChild(successAlert);

                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 2000);
                    } else {
                        const alertContainer = document.getElementById('alert-container');
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger';
                        errorAlert.textContent = 'Erro ao cadastrar a task. Tente novamente!';
                        alertContainer.appendChild(errorAlert);

                        if (data.errors) {
                            for (const field in data.errors) {
                                const errorElement = document.getElementById(field + '-error');
                                if (errorElement) {
                                    errorElement.textContent = data.errors[field].join(', ');
                                }
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    const alertContainer = document.getElementById('alert-container');
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger';
                    errorAlert.textContent = 'Ocorreu um erro ao tentar cadastrar a task. Tente novamente.';
                    alertContainer.appendChild(errorAlert);
                });
        });

        async function fetchTasks() {
            try {
                // Verificar se o token de autenticação está armazenado
                const token = localStorage.getItem('token');
                console.log("Bearer Token:", token); // Log para verificar se o token está correto

                if (!token) {
                    const alertContainer = document.getElementById('alert-container');
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger';
                    errorAlert.textContent = 'Token de autenticação não encontrado.';
                    alertContainer.appendChild(errorAlert);
                    return;
                }

                const response = await fetch('{{ url('api') }}/task', {
                    method: 'GET', // Método GET
                    headers: {
                        'Authorization': 'Bearer ' + token, // Enviar o Bearer Token no cabeçalho
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.status) {
                    const tasks = data.task; // Array de tarefas

                    const tasksTable = document.getElementById('tasks-table');
                    tasksTable.innerHTML = ''; // Limpa o conteúdo da tabela antes de preencher

                    tasks.forEach(task => {
                        const row = document.createElement('tr');

                        // Adiciona as células da tabela
                        row.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.title}</td>
                    <td>${task.description}</td>
                    <td>${task.category_id}</td>
                    <td>${task.situacao_id}</td>
                    <td>${new Date(task.created_at).toLocaleDateString()}</td>
                    <td>
                        <button onclick="editTask(${task.id})">Editar</button>
                        <button onclick="deleteTask(${task.id})">Excluir</button>
                    </td>
                `;

                        tasksTable.appendChild(row); // Adiciona a linha à tabela
                    });
                } else {
                    console.log('Erro ao carregar tarefas');
                }
            } catch (error) {
                console.log('Erro ao fazer a requisição à API:', error);
            }
        }

        function editTask(taskId) {
            // Limpar mensagens de erro anteriores
            document.getElementById('alert-container').innerHTML = '';
            document.querySelectorAll('.text-danger').forEach((element) => element.textContent = '');

            // Fazer a requisição para buscar os dados da task pelo ID
            fetch(`{{ url('api/task') }}/${taskId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        'Accept': 'application/json'
                    }
                })

                .then(response => response.json())

                .then(data => {
                    console.log('data', data)
                    if (data.status) {
                        const task = data.task;

                        // Preencher o formulário com os dados da task
                        document.getElementById('title').value = task.title;
                        document.getElementById('description').value = task.description;
                        document.getElementById('category_id').value = task.category_id;
                        document.getElementById('user_id').value = task.user_id;

                        // Alterar o método do formulário para PUT
                        const form = document.getElementById('cadastrarTask');
                        form.setAttribute('action', `{{ url('api/task') }}/${taskId}`);
                        form.setAttribute('method', 'POST'); // Usando POST para enviar com o método PUT via header

                        // Adicionar um campo hidden para indicar que é uma atualização
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT'; // Indica que é uma atualização
                        form.appendChild(methodInput);

                        // Alterar o botão de cadastrar para 'Atualizar'
                        const submitButton = form.querySelector('button');
                        submitButton.textContent = 'Atualizar';
                    } else {
                        console.log('Erro ao carregar os dados da task.');
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar a task:', error);
                });
        }

        // Carregar as tarefas assim que a página for carregada
        window.onload = fetchTasks;
    </script>
</body>

</html>
