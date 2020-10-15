const vm_tasks = new Vue({
    el:"#app",
    data:{
        search:"",
        newTask:"",
        tasks:[
            {
                id:1,
                name:"Task",
                completed:true,
                originalName:"Tasks",
                edit:false
            },
            {
                id:2,
                name:"Task",
                completed:false,
                originalName:"Tasks",
                edit:false
            },
            {
                id:3,
                name:"Task",
                completed:true,
                originalName:"Tasks",
                edit:false
            },
            {
                id:4,
                name:"Task",
                completed:false,
                originalName:"Tasks",
                edit:false
            }
        ]
    },
    methods: {
        toggleEdit(task)
        {
            task.edit = !task.edit;
        },
        toggleCompleted(task)
        {
            task.completed = !task.completed;
        },
        saveUpdateNome(task)
        {
            task.originalName = task.name;
            task.edit = false;
        },
        addTask()
        {
            if(this.newTask.trim() != "")
            {
                this.tasks.push({
                    id:2,
                    name:this.newTask.trim(),
                    completed:false,
                    originalName:this.newTask.trim(),
                    edit:false
                });

                this.newTask = "";
            }
        }
    },
});