<template>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="addTaskLabel" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskLabel">Add a task</h5>
<!--                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert"  v-for="error in errors">
                            {{error[0]}}
                        </div>
                        <form action="">
                            <div  class="mb-3">
                                <label for="form-edit-name">Name task</label>
                                <input type="text" placeholder="test@example.ru" class="form-control" id="form-edit-name" v-model="task.name">
                            </div>
                            <div  class="mb-3">
                                <label for="form-edit-description">Description</label>
                                <textarea placeholder="Description" class="form-control" id="form-edit-description" v-model="task.description"></textarea>
                            </div>
                            <!-- Status -->
                            <div  class="mb-3">
                                <label>Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="form-radio-status" id="form-edit-status-1" value="1" v-model="task.status">
                                    <label class="form-check-label" for="form-edit-status-1">
                                        Draft
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="form-radio-status" id="form-edit-status-2" value="2" v-model="task.status">
                                    <label class="form-check-label" for="form-edit-status-2">
                                        At work
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="form-radio-status" id="form-edit-status-3" value="3" v-model="task.status">
                                    <label class="form-check-label" for="form-edit-status-3">
                                        Done
                                    </label>
                                </div>
                            </div>
                            <!-- Priority -->
                            <div  class="mb-3">
                                <label>Priority</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="form-radio-priority" id="form-edit-priority-1" value="1" v-model="task.priority">
                                    <label class="form-check-label" for=form-edit-priority-1>
                                        Mild
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="form-radio-priority" id="form-edit-priority-2" value="2" v-model="task.priority">
                                    <label class="form-check-label" for="form-edit-priority-2">
                                        Moderate
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="form-radio-priority" id="form-edit-priority-3" value="3" v-model="task.priority">
                                    <label class="form-check-label" for="form-edit-priority-3">
                                        Crucial
                                    </label>
                                </div>
                            </div>
                            <!-- Tags -->
                            <div>
                                <div class="input-group mb-3" v-for="(tag,i) in task.tags" v-bind:key="tag.id">
                                    <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="form-edit-tag-1" v-model="task.tags[i]">
                                    <span class="input-group-append" id="form-edit-tag-1">
                                        <button type="button" class="btn btn-danger" v-on:click="removeTag(i)">X</button>
                                    </span>
                                </div>
                                <button type="button" class="btn btn-warning" v-on:click="addTag()">Add tag</button>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-on:click="closeModalBtn">Close</button>
                        <button type="button" class="btn btn-success" v-on:click="saveTask">
                            <template v-if="task.uuid == ''">Add</template>
                            <template v-else>Save</template>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['task'],
        data () {
            return {
                errors: []
            }
        },
        methods: {
            saveTask () {
                let _this = this;
                axios.post('/public/task/save', this.task)
                    .then(function (response) {
                }).catch(function (error) {
                    if (error.response.status === 422) {
                        _this.errors = error.response.data.errors;
                    } else {
                        alert('Happened some error. Watch the error in Console Log (F12) for details.');
                        console.log(error);
                    }
                })
            },
            closeModalBtn () {
                $('#editTaskModal').modal('hide');
            },
            removeTag (index) {
                this.task.tags.splice(index, 1);
            },
            addTag () {
                if (this.task.hasOwnProperty('tags') == false) {
                    this.$set(this.task, 'tags', []);
                }
                this.task.tags.push('');
            }
        },
        mounted () {
            console.log('Component task-list loaded')
        }
    }
</script>
