import {onMounted, onBeforeUnmount, nextTick} from 'vue';

/**
 * Навешивает глобальный слушатель, вызывающий callback, если клик вне targetRef
 */
export function useClickOutside(targetRef, callback, ignoreFirstClick = false) {
    let shouldIgnore = ignoreFirstClick;

    const handler = (event) => {
        if (shouldIgnore) {
            shouldIgnore = false;
            return;
        }

        const el = targetRef.value?.$el ?? targetRef.value;
        if (el?.contains && !el.contains(event.target)) {
            callback(event);
        }
    };

    onMounted(() => {
        nextTick(() => document.addEventListener('click', handler));
    });

    onBeforeUnmount(() => {
        document.removeEventListener('click', handler);
    });
}

