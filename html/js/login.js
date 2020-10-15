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
            var formData = new FormData();
            formData.append("email",this.login.email);
            formData.append("pass",this.login.pass);

            axios.post(`/login`,formData)
            .then(r => {
                if(r.data.success)
                {
                    localStorage.setItem("token",r.data.token);
                }
                else
                {
                    this.errorLogin = true;
                }
            })
            .catch(r => {
                debugger;
            });
        }
    }
});