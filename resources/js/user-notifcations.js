 // import {createApp} from 'vue';

  import {createApp} from "vue";

 const notification = createApp({
    data() {
        return {
            showDropdown: false,
            total: '',
            read: '',
            unread: '0',
            notifications: [],
            user_id:null,

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
            const res = await axios.get(`/api/user/notifications?user_id=${this.user_id}`);
            const data = await res.data.notifications;
            console.log(data)
            this.notifications = data;
        },
        formatDate(dateString) {
            const date = new Date(dateString)
            return new Intl.DateTimeFormat('en-US', {
                dateStyle: 'medium',
                timeStyle: 'short'
            }).format(date)
        }
    },
    async mounted() {
        const userId = document.querySelector('meta[name="user-id"]').content;
        this.user_id=userId;
        await this.fetchNotifications();

        window.Echo.private(`user.notifications.${userId}`)
            .listen('UserNotificationEvent', (event) => {
                console.log("hello", event.message);
                this.unread = parseInt(this.unread) + 1
                this.addNotification(event.title, event.message, event.created_at, event.is_read, event.route);
            });
    }
});

notification.mount('#notificationBell');

