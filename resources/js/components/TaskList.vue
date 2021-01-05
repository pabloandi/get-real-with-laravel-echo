<template>
  <div class="box">
        <div class="field">
            <label class="label">New Task</label>
            <div class="control">
                <input type="text" class="input" v-model="newTask" @keyup.enter="addTask" placeholder="add your new task here">
            </div>
        </div>
        <div class="media" :key="index" v-for="(task, index) in tasks">
            <div class="media-content" v-text="task"></div>
        </div>

  </div>
</template>

<script>

import axios from 'axios';

export default {
    props: {
        project: {
            type: Object
        }
    },
    data(){
        return {
            newTask: '',
            tasks: []
        }
    },
    async created(){
        try {
            let { data } = await axios.get(`/api/projects/${this.project.id}`);
            this.tasks = data;

        } catch (error) {
            console.log('error in fetching tasks');
            console.log(error);
        }

        window.Echo.private(`tasks.${this.project.id}`)
            .listen('TaskCreated', ({ task }) => {
                this.tasks.push(task.body);
            });
    },
    methods: {
        addTask(){
            axios.post(`/api/projects/${this.project.id}/tasks`, {
                body: this.newTask
            });

            this.tasks.push(this.newTask);

            this.newTask = '';
        }
    }
}
</script>

<style>

</style>
