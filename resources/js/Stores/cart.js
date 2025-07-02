import {defineStore} from 'pinia';
import {ref, computed} from 'vue';

/**
 * Store для управления корзиной
 * Хранит товары, управляет их количеством и отображением Drawer
 */
export const useCartStore = defineStore('cart', () => {

    const items = ref([]);
    const drawerOpen = ref(false);

    const MAX_QUANTITY = 5;

    const closeDrawer = () => {
        drawerOpen.value = false;
    };

    const openDrawer = () => {
        drawerOpen.value = true;
    };

    const getItemKey = (item) => {
        const addKey = item.addons ? [...item.addons].sort().join(',') : '';
        return `${item.name}_${item.size}_${item.crust}_${addKey}`;
    };

    const addToCart = (newItem) => {

        if (!newItem || !newItem.name || !newItem.price) {
            console.error('Некорректные данные товара');
            return;
        }

        const newItemKey = getItemKey(newItem);
        const existingIndex = items.value.findIndex(item =>
            getItemKey(item) === newItemKey
        );

        if (existingIndex !== -1) {
            // проверяем на кол-во
            const newQuantity = items.value[existingIndex].quantity + (newItem.quantity || 1);
            items.value[existingIndex].quantity = Math.min(newQuantity, MAX_QUANTITY);
        } else {
            // добавляем товар
            items.value.push({
                ...newItem,
                quantity: newItem.quantity || 1
            });
        }
    };

    const incrementQuantity = (index) => {
        if (items.value[index] && items.value[index].quantity < MAX_QUANTITY) {
            items.value[index].quantity++;
        }
    };

    const decrementQuantity = (index) => {
        if (!items.value[index]) return;

        if (items.value[index].quantity > 1) {
            items.value[index].quantity--;
        } else {
            removeItem(index);
        }
    };

    const removeItem = (index) => {
        if (index >= 0 && index < items.value.length) {
            items.value.splice(index, 1);
        }
    };

    const clearCart = () => {
        items.value = [];
    };

    const totalPrice = computed(() => {
        return items.value.reduce((acc, item) => {
            return acc + item.price * (item.quantity ?? 1);
        }, 0);
    });

    const totalQuantity = computed(() => {
        return items.value.reduce((total, item) => {
            return total + (item.quantity ?? 1);
        }, 0);
    });

    return {
        items,
        drawerOpen,
        openDrawer,
        closeDrawer,
        addToCart,
        incrementQuantity,
        decrementQuantity,
        removeItem,
        clearCart,
        totalPrice,
        totalQuantity
    };
}, {
    persist: true
});
