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
    <div class="login" id="app">
        <h1>Lista de Tarefas</h1>
        <div class="left">
            <h2>Login</h2>
            <p class="error" v-if="errorLogin">*Email ou senha incorretos</p>
            <form action="">
                <input type="email" placeholder="email@email.com" v-model="login.email" v-on:keyup.enter="makeLogin()">
                <input type="password" placeholder="********" v-model="login.pass" v-on:keyup.enter="makeLogin()">
                <div class="alignRight">
                    <p @click="resetPass = true">Esqueci minha senha</p>
                </div>
                <button
                    type="button"
                    class="button"
                    @click="makeLogin()"
                >Entrar</button>
            </form>
        </div>
        <div class="right">
            <h2>Criar Conta</h2>
            <p class="error" v-if="errorCadastro != ''">*{{errorCadastro}}</p>
            <form action="">
                <input type="text" placeholder="Nome e Sobrenome" v-model="newAccount.name" v-on:keyup.enter="createUser()">
                <input type="email" placeholder="email@email.com" v-model="newAccount.email" v-on:keyup.enter="createUser()">
                <input type="password" placeholder="********" class="marginBottom" v-model="newAccount.pass" v-on:keyup.enter="createUser()">
                <button
                    type="button"
                    class="button"
                    @click="createUser()"
                >Criar conta</button>
            </form>
        </div>
        <p class="copy"><a href="https://gustavo-carvalho.com" target="_blank">@ 2020 - Gustavo Carvalho</a></p>
        <div class="resetPass" v-if="resetPass" @click.self.prevent="resetPass = false">
            <div class="center">
                <p class="descricao">Digite seu email para trocar sua senha</p>
                <input type="email" v-model="login.email" v-on:keyup.enter="resetPass()">
                <button
                    type="button"
                    class="button"
                    @click="resetPass()"
                >Enviar</button>
            </div>
        </div>
    </div>
    <script src="/js/login.js"></script>
</body>
</html>