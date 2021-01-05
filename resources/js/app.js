require('./bootstrap');

import TaskList from './components/TaskList.vue';

const app = new Vue({
    el: '#app',
    components: {
        TaskList
    }
})
