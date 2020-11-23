require('./bootstrap');
window.Vue = require('vue');
window.moment = require('moment');
import welcomeComponent from './components/WelcomeComponent.vue';
import liveComponents from './components/LiveComponent.vue';
import UpcomingComponents from './components/UpcomingComponent.vue';
import CompleteComponents from './components/CompleteComponent.vue';



var components={
    'welcome-component':welcomeComponent,
    'upcoming-components':UpcomingComponents,
    'live-components':liveComponents,
    'complete-components':CompleteComponents,
}
const app = new Vue({
    el: '#app',
    components: components
});
