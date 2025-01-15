<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-M7a/7i8F+IgeMTS2xHjQzU/q9N6FbOm69ckkF9eZ5JPR2Wq2TXMVAMNXjYJfI3u8" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div id="alert-container"></div>
        <form id="cadastrarTask" action="{{ url('api/tasks') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Step 1: User Information -->
            <div class="form-group">
                <label for="name">Titulo*</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <div id="name-error" class="text-danger"></div>
            </div>
            <div class="form-group">
                <label for="description">Descricao*</label>
                <input type="text" class="form-control" id="description" name="description" required>
                <div id="description-error" class="text-danger"></div>
            </div>
            <div class="form-group">
                <label for="category">Categoria*</label>
                <select class="form-control" id="category" name="category" required>
                    @foreach ($category as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                <div id="category-error" class="text-danger"></div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script>
        document.getElementById('cadastrarTask').addEventListener('submit', function(event) {
            event.preventDefault();

            // Clear previous error messages
            document.getElementById('alert-container').innerHTML = '';
            document.querySelectorAll('.text-danger').forEach((element) => element.textContent = '');

            // Gather form data
            const formData = new FormData(this);

            // Send data to the server using fetch
            fetch(this.action, {
                    method: 'POST', // Always POST for form submission
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Check if API response is successful
                    if (data.success) {
                        const alertContainer = document.getElementById('alert-container');
                        const successAlert = document.createElement('div');
                        successAlert.className = 'alert alert-success';
                        successAlert.textContent = 'Task cadastrada com sucesso!';
                        alertContainer.appendChild(successAlert);

                        // Redirect after a short delay
                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 2000);
                    } else {
                        // Show error messages if data.success is not true
                        const alertContainer = document.getElementById('alert-container');
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger';
                        errorAlert.textContent = 'Erro ao cadastrar a task. Tente novamente!';
                        alertContainer.appendChild(errorAlert);

                        // Handle field validation errors if they exist in the API response
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
    </script>
</body>

</html>
