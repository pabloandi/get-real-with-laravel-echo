<template>
  <div class="box">
        <div class="field">
            <label class="label">New Task</label>
            <div class="control">
                <input
                    type="text"
                    class="input"
                    v-model="newTask"
                    @keyup.enter="addTask"
                    @keydown="tagPeers"
                    placeholder="add your new task here">
                    <span v-if="activePeer" v-text="peerTyping"></span>
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
            tasks: [],
            activePeer: false,
            typingTimer: false,
        }
    },
    computed: {
        peerTyping(){
            return this.activePeer.name + ' is typing ...';
        },
        channel(){
            return Echo.private(`tasks.${this.project.id}`);
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

        this.channel
            .listen('TaskCreated', ({ task }) => this.tasks.push(task.body))
            .listenForWhisper('typing', this.flashActivePeer);

    },
    methods: {
        flashActivePeer(e){
                this.activePeer = e;

                if(this.typingTimer) clearTimeout(this.typingTimer);

                this.typingTimer = setTimeout(() => this.activePeer = false, 500);
        },
        tagPeers(){

            this.channel
                .whisper('typing', window.currentuser);
        },
        addTask(){
            this.activePeer = false;

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
