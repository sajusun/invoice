import {createApp} from 'vue';

const app = createApp({
    data() {
        return {
            showDropdown: false,
            total: '',
            read: '',
            unread: '0',
            notifications: [],

        };
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
            this.unread = 0;
        },
        addNotification(title, message, created_at, is_read, route) {
            this.notifications.unshift({title,message, created_at,is_read,route,});
        },
        async fetchNotifications() {
            const res = await axios.get('/api/admin/notifications');
            const data = await res.data.notifications;
            console.log(data)
            this.notifications = data;
        }
    },
    async mounted() {
        await this.fetchNotifications();
        const adminId = document.querySelector('meta[name="user-id"]').content;
        window.Echo.private(`admin.notifications`)
            .listen('AdminNotification', (event) => {
                console.log("hello", event.message);
                this.unread = parseInt(this.unread) + 1
                this.addNotification(event.title, event.message, event.created_at, event.is_read, event.route);
            });
    }
});

app.mount('#notificationBell');
