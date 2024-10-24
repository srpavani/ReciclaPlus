
const API = process.env.REACT_APP_API_URL 

export const login = async (email: string, password: string) => {
    try {
        const API = process.env.REACT_APP_API_URL; // Garanta que a URL da API está corretamente configurada
        const response = await fetch(`${API}/user/login.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include', // Para cookies, se você estiver usando
            body: JSON.stringify({ email, password }),
        });

        if (!response.ok) {
            // Pode adicionar mais detalhes do erro baseado na resposta do servidor
            throw new Error(`Erro ao fazer login. Status: ${response.status}`);
        }

        const data = await response.json();
        if (data.token) {
            // Considere o contexto de segurança ao usar localStorage
            localStorage.setItem('sessionToken', data.token);
        }

        return data; // Retorna dados para serem possivelmente usados na UI
    } catch (error) {
        console.error('Erro na requisição:', error);
        throw error; // Lançar erro permite que chamadas de função manipulem o erro adicionalmente
    }
};



export const register = async (name:string, email: string, password: string) => {
    const response = await fetch(`${API}/user/register.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        credentials: 'include',
        body: JSON.stringify({ name, email, password }),
    });

    if (!response.ok) {
        const errorDetail = await response.text();
        throw new Error(`Erro ao fazer registro: ${response.status} - ${errorDetail}`);
    }

    return await response.json();
};
