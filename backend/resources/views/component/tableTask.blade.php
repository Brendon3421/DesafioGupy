<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="tasks-table">
        <!-- As tarefas serão inseridas aqui -->
    </tbody>
</table>

<script>
    // Função para buscar as tarefas da API
    async function fetchTasks() {
        try {
            const response = await fetch('{{Servidor-API}}task');
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
                        <td>${new Date(task.created_at).toLocaleDateString()}</td>
                        <td>
                            <button onclick="editTask(${task.id})">Editar</button>
                            <button onclick="deleteTask(${task.id})">Excluir</button>
                        </td>
                    `;

                    tasksTable.appendChild(row); // Adiciona a linha à tabela
                });
            } else {
                console.error('Erro ao carregar tarefas');
            }
        } catch (error) {
            console.error('Erro ao fazer a requisição à API:', error);
        }
    }

    // Funções de edição e exclusão (a serem implementadas conforme necessidade)
    function editTask(taskId) {
        alert(`Editar tarefa com ID: ${taskId}`);
        // Lógica para editar a tarefa
    }

    function deleteTask(taskId) {
        alert(`Excluir tarefa com ID: ${taskId}`);
        // Lógica para excluir a tarefa
    }

    // Carregar as tarefas assim que a página for carregada
    window.onload = fetchTasks;
</script>
