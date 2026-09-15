import {createApp} from "vue";

const notification = createApp({
    data() {
        return {
            showDropdown: false,
            total: '',
            read: '',
            unread: '0',
            notifications: [],
            user_id: null,
        };
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
            this.unread = 0;
        },
        addNotification(title, message, created_at, is_read, route) {
            this.notifications.unshift({title, message, created_at, is_read, route});
        },
        async fetchNotifications() {
            try {
                if (!this.user_id) return;
                const res = await axios.get(`/api/user/notifications?user_id=${this.user_id}`);
                const data = await res.data.notifications;
                this.notifications = Array.isArray(data) ? data : [];
            } catch (e) {
                console.warn('Could not fetch notifications:', e);
            }
        },
        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('en-US', {
                dateStyle: 'medium',
                timeStyle: 'short'
            }).format(date);
        }
    },
    async mounted() {
        try {
            const userMeta = document.querySelector('meta[name="user-id"]');
            const userId = userMeta ? userMeta.content : null;
            if (!userId) return;
            this.user_id = userId;
            await this.fetchNotifications();

            if (window.Echo && typeof window.Echo.private === 'function') {
                window.Echo.private(`user.notifications.${userId}`)
                    .listen('UserNotificationEvent', (event) => {
                        this.unread = parseInt(this.unread || 0) + 1;
                        this.addNotification(event.title, event.message, event.created_at, event.is_read, event.route);
                    });
            }
        } catch (e) {
            console.warn('Notification init error:', e);
        }
    }
});

const mountEl = document.querySelector('#notificationBell');
if (mountEl) {
    notification.mount('#notificationBell');
}


