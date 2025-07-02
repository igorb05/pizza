import {ref, readonly} from 'vue';

// глобальное состояние уведомлений
const notifications = ref([]);
let notificationId = 0;

// хранилище таймеров
const timers = new Map();

const MAX_NOTIFICATIONS = 3;

/**
 * Управление уведомлениями в проекте
 */
export function useNotification() {

    const showNotification = (message, duration = 10000) => {

        if (!message) {
            console.error('В уведомлении отсутствует сообщение!');
            return null;
        }

        if (notifications.value.length >= MAX_NOTIFICATIONS) {
            removeNotification(notifications.value[0].id);
        }

        const id = ++notificationId;
        const notification = {
            id,
            message,
            createdAt: new Date()
        };

        notifications.value.push(notification);

        if (duration > 0) {
            const timerId = setTimeout(() => {
                removeNotification(id);
                timers.delete(id);
            }, duration);
            timers.set(id, timerId);
        }

        return id;
    };

    const removeNotification = (id) => {
        const index = notifications.value.findIndex(n => n.id === id);
        if (index > -1) {
            notifications.value.splice(index, 1);

            if (timers.has(id)) {
                clearTimeout(timers.get(id));
                timers.delete(id);
            }
        }
    };

    const clearAll = () => {
        // чистим все активные таймеры
        timers.forEach(timerId => clearTimeout(timerId));
        timers.clear();

        notifications.value = [];
    };

    return {
        notifications: readonly(notifications),
        showNotification,
        removeNotification,
        clearAll
    }
}
