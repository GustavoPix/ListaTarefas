const vm_tasks = new Vue({
    el:"#app",
    data:{
        search:"",
        newTask:"",
        token:"",
        id_user:"",
        tasks:[]
    },
    methods: {
        toggleEdit(task)
        {
            task.edit = !task.edit;
        },
        toggleCompleted(task)
        {
            task.completed = !task.completed;

            let formData = new FormData();
            formData.append("id",task.id);
            formData.append("id_user",this.id_user);
            formData.append("token",this.token);

            if(task.completed)
            {
                axios.post(`/api/task/complete`,formData)
                .then(r => {
                    if(r.data.success)
                    {
                        
                    }
                    else
                    {

                    }
                })
                .catch(r => {
                    debugger;
                });
            }
            else
            {
                axios.post(`/api/task/incomplete`,formData)
                .then(r => {
                    if(r.data.success)
                    {
                        
                    }
                    else
                    {

                    }
                })
                .catch(r => {
                    debugger;
                });
            }
        },
        saveUpdateNome(task)
        {
            task.originalName = task.name;
            task.edit = false;

            axios.put(`/api/task?id_user=${this.id_user}&token=${this.token}&id=${task.id}&task=${task.name}`)
            .then(r => {
                if(r.data.success)
                {
                    
                }
                else
                {
                    
                }
            })
            .catch(r => {
                debugger;
            });
        },
        addTask(name,id = 0,completed = false)
        {
            if(name != "")
            {
                let aux = this.tasks.push({
                    id:id,
                    name:name,
                    completed:completed,
                    originalName:name,
                    edit:false
                });

                return this.tasks[aux-1];

                this.newTask = "";
            }

            return null;
        },
        addTaskButton()
        {
            let task = this.addTask(this.newTask);
            this.newTask = "";

            let formData = new FormData();
            formData.append("task",task.originalName);
            formData.append("id_user",this.id_user);
            formData.append("token",this.token);

            axios.post(`/api/task`,formData)
            .then(r => {
                if(r.data.success)
                {
                    task.id = r.data.task.id;
                }
                else
                {
                    
                }
            })
            .catch(r => {
                debugger;
            });
            
        },
        getTasks()
        {
            axios.get(`/api/tasks?id_user=${this.id_user}&token=${this.token}`)
            .then(r => {
                if(r.data.success)
                {
                    r.data.tasks.forEach(task => {
                        this.addTask(task.task,task.id,task.data_conclusao != "2000-01-01 00:00:00");
                    });
                }
                else
                {
                    
                }
            })
            .catch(r => {
                debugger;
            });
        },
        deleteTask(index)
        {
            let id = this.tasks[index].id;
            this.tasks.splice(index,1);

            axios.delete(`/api/task?id_user=${this.id_user}&token=${this.token}&id=${id}`)
            .then(r => {
                debugger
                if(r.data.success)
                {
                    
                }
                else
                {
                    
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
                    this.token = token;
                    this.id_user = id;
                    this.getTasks();
                }
                else
                {
                    localStorage.removeItem("token");
                    window.location = "/";
                }
            })
            .catch(r => {
                debugger;
            });
        },
        logout()
        {
            axios.get(`/login/token?id_user=${this.id_user}&token=${this.token}`)
            .then(r => {
                localStorage.removeItem("token");
                window.location = "/";
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