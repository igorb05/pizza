import {watch} from 'vue';
import {usePage} from '@inertiajs/vue3';
import {useNotification} from '@/Composables/useNotification.js';

/**
 * Слушает flash уведомления
 */
export function useFlashMessage() {
    const page = usePage();
    const {showNotification} = useNotification();

    watch(
        () => page.props.flash,
        (flash) => {
            if (!flash) return;

            if (flash.success) {
                showNotification(flash.success, 'success');
            }

            if (flash.error) {
                showNotification(flash.error, 'error');
            }

            if (flash.info) {
                showNotification(flash.info, 'info');
            }
        },
        {immediate: true}
    );
}
