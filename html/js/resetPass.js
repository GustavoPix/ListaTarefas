const vm_resetPass = new Vue({
    el:"#app",
    data:{
        senha:"",
        confirm_senha:"",
        error:""
    },
    methods: {
        buttonSend()
        {
            if(this.senha.length < 6)
            {
                this.error = "Senha deve ter pelo menos 6 caracteres";
                return;
            }
            else if(this.senha != this.confirm_senha)
            {
                this.error = "Senhas não são iguais";
                return
            }
            else
            {
                let aux = new URLSearchParams(window.location.search);
                if(aux.get("token"))
                {
                    alert("Send Pass no token " + aux.get("token"));
                }
            }
        }
    },
});