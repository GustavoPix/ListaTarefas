const vm_login = new Vue({
    el:"#app",
    data:{
        login:{
            email:"",
            pass:""
        },
        errorLogin: false,
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