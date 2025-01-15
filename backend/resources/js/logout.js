async function logoutUser(event) {
    event.preventDefault();

    try {
        // Obtem informações do usuário logado via API
        const userResponse = await fetch('{{Servidor-API}}/me', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
        });

        if (userResponse.ok) {
            const userData = await userResponse.json();
            const apiUrl = `{{Servidor-API}}logout/${userData.id}`;

            // Faz o logout
            const logoutResponse = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                },
            });

            if (logoutResponse.ok) {
                localStorage.clear();
                window.location.href = '/login';
            } else {
                console.error('Erro ao fazer logout');
            }
        } else {
            console.error('Erro ao obter usuário logado');
        }
    } catch (error) {
        console.error('Erro de rede:', error);
    }
}