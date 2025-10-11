import { createApp } from 'vue';

const app = createApp({
    data() {
        return {
            showDropdown:false,
            total: '',
            read: '',
            unread:'0',
            notifications: [],

        };
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
            this.unread=0;
        },
        addNotification(message, route, time) {
            this.notifications.unshift({ message, route, time: new Date().toLocaleTimeString(), });
        },
        async fetchNotifications() {
            // const res = await fetch('/notifications');
            // const data = await res.json();
            // this.notifications = data;
        }
    },
    async mounted() {
       // await this.fetchNotifications();
        const adminId = document.querySelector('meta[name="user-id"]').content;
        window.Echo.private(`admin.notifications`)
            .listen('AdminNotification', (event) => {
                console.log("hello", event.message);
                this.unread=parseInt(this.unread)+1
                this.addNotification(`${event.message} : ${event.name} `, event.route);
            });
    }
});

app.mount('#notificationBell');
