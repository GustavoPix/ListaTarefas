const vm_login = new Vue({
    el:"#app",
    data:{
        login:{
            email:"",
            pass:""
        },
        errorLogin: false,
        errorCadastro:"",
        resetPass:false,
        newAccount:{
            name:"",
            email:"",
            pass:""
        }
    },
    methods: {
        makeLogin() {
            let formData = new FormData();
            formData.append("email",this.login.email);
            formData.append("pass",this.login.pass);

            axios.post(`/login`,formData)
            .then(r => {
                if(r.data.success)
                {
                    localStorage.setItem("token",r.data.token);
                    window.location = "/tarefas";
                }
                else
                {
                    this.errorLogin = true;
                }
            })
            .catch(r => {
                debugger;
            });
        },
        createUser()
        {
            this.errorCadastro = "";
            if(this.newAccount.name.trim().split(' ').length < 1)
            {
                this.errorCadastro = "Preencha com seu completo";
                return null;
            }
            else if(!this.newAccount.email.includes("@")) 
            {
                this.errorCadastro = "Digite um email válido";
                return null;
            }
            else if(this.newAccount.pass.length < 6) 
            {
                this.errorCadastro = "Senha deve conter ao menos 6 caracteres";
                return null;
            }
            let formData = new FormData();
            formData.append("email",this.newAccount.email);
            formData.append("pass",this.newAccount.pass);
            formData.append("name",this.newAccount.name);

            axios.post(`/api/user`,formData)
            .then(r => {
                if(r.data.success)
                {
                    this.login.email = this.newAccount.email;
                    this.login.pass = this.newAccount.pass;
                    this.makeLogin();
                }
                else
                {
                    this.errorCadastro = "Email já cadastrado";
                }
            })
            .catch(r => {
                debugger;
            });
        },
        sendResetPass()
        {
            let formData = new FormData();
            formData.append("email",this.login.email);

            axios.post(`/resetpassword`,formData)
            .then(r => {
                if(r.data.success)
                {
                    
                }
                else
                {
                    debugger;
                }

                alert("Em alguns minutos, você receberá um email para trocar sua senha.");
                window.location.reload();

            })
            .catch(r => {
                debugger;
            });
        },
        checkToken(str)
        {
            let aux = str.split('_');
            let id = aux[0];
            let token = aux[1];

            axios.get(`/login/token?id_user=${id}&token=${token}`)
            .then(r => {
                if(r.data.success)
                {
                    window.location = "/tarefas";
                }
                else
                {
                    localStorage.removeItem("token");
                }
            })
            .catch(r => {
                debugger;
            });
        }
    },
    created() {
        let token = localStorage.getItem("token");
        if(token)
        {
            this.checkToken(token);
        }
    },
});