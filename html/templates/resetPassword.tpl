<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <title>Lista Tarefas - Login</title>
</head>
<body>
    <div class="pageResetPass" id="app">
        <h1>Lista de Tarefas</h1>
        <div class="center">
            <h2>Nova senha</h2>
            <p class="error" v-if="error != ''">*{{error}}</p>
            <input type="password" placeholder="Nova senha" v-model="senha" v-on:keyup.enter="buttonSend()">
            <input type="password" placeholder="Repita a senha" v-model="confirm_senha" v-on:keyup.enter="buttonSend()">
            <button
                class="button"
                @click="buttonSend()"
            >Salvar</button>
        </div>
    </div>
    <script src="/js/resetPass.js"></script>
</body>
</html>