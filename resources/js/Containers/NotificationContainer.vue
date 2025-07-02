<script setup>
import { useNotification } from '@/Composables/useNotification.js'
import NotificationItem from '@/Components/NotificationItem.vue'

/**
 * Контейнер для отображения всех уведомлений
 * Использует Teleport для рендера в body
 */
const { notifications, removeNotification } = useNotification()
</script>

<template>
    <Teleport to="body">
        <div class="fixed bottom-4 right-2 z-50 space-y-2 max-w-sm">
            <div class="space-y-2">
                <NotificationItem
                    v-for="notification in notifications"
                    :key="notification.id"
                    :notification="notification"
                    @close="removeNotification"
                />
            </div>
        </div>
    </Teleport>
</template>
