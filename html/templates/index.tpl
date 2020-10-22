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
        <div class="copy">
            <a href="https://gustavo-carvalho.com" target="_blank">
                <p>Feito com</p>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.3666 3.84172C16.941 3.41589 16.4356 3.0781 15.8794 2.84763C15.3232 2.61716 14.727 2.49854 14.1249 2.49854C13.5229 2.49854 12.9267 2.61716 12.3705 2.84763C11.8143 3.0781 11.3089 3.41589 10.8833 3.84172L9.99994 4.72506L9.1166 3.84172C8.25686 2.98198 7.0908 2.49898 5.87494 2.49898C4.65908 2.49898 3.49301 2.98198 2.63327 3.84172C1.77353 4.70147 1.29053 5.86753 1.29053 7.08339C1.29053 8.29925 1.77353 9.46531 2.63327 10.3251L3.5166 11.2084L9.99994 17.6917L16.4833 11.2084L17.3666 10.3251C17.7924 9.89943 18.1302 9.39407 18.3607 8.83785C18.5912 8.28164 18.7098 7.68546 18.7098 7.08339C18.7098 6.48132 18.5912 5.88514 18.3607 5.32893C18.1302 4.77271 17.7924 4.26735 17.3666 3.84172Z" fill="white"/>
                </svg>
                <p>por Gustavo Carvalho</p>
            </a>
        </div>
        <div class="resetPass" v-if="resetPass" @click.self.prevent="resetPass = false">
            <div class="center">
                <p class="descricao">Digite seu email para trocar sua senha</p>
                <input type="email" v-model="login.email" v-on:keyup.enter="sendResetPass()">
                <button
                    type="button"
                    class="button"
                    @click="sendResetPass()"
                >Enviar</button>
            </div>
        </div>
    </div>
    <script src="/js/login.js"></script>
</body>
</html>