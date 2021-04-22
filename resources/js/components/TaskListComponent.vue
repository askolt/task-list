<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="#" class="btn btn-success" v-on:click="addTaskBtn({})">Add</a>
                <task-edit-component v-bind:task="taskEdit"></task-edit-component>
            </div>
        </div>
        <div class="row justify-content-center" v-for="task in tasks">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ task.name }}
                    </div>
                    <div class="card-body">
                        <p>{{ task.description }}</p>
                        <a href="#" class="btn btn-primary" v-on:click="addTaskBtn(task)">Edit</a>
                        <a href="#" class="btn btn-danger" v-on:click="removeTask(task.uuid)">Delete</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [],
                taskEdit: {}
            }
        },
        methods: {
            loadTaskList () {
                let _this = this;
                axios.get('/public/task')
                    .then(function (response) {
                        _this.tasks = response.data;
                    }).catch(function (error) {
                        alert('Happened some error. Watch the error in Console Log (F12) for details.');
                        console.log(error);
                    })
            },
            addTaskBtn (oTask) {
                this.taskEdit = oTask;
                $('#editTaskModal').modal('show');
            },
            removeTask (uuid) {
                let _this = this;
                axios.get('/public/task/remove/' + uuid)
                    .then(function (response) {
                        _this.loadTaskList();
                    }).catch(function (error) {
                    alert('Happened some error. Watch the error in Console Log (F12) for details.');
                    console.log(error);
                })
            }
        },
        mounted () {
            console.log('Component task-list loaded')
            this.loadTaskList();
        }
    }
</script>
