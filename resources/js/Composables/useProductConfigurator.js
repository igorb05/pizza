import {ref, computed} from 'vue';

/**
 * Composable для настройки параметров продукта (пиццы)
 * Управляет выбором размера, теста, добавок и расчетом цены
 */
export function useProductConfigurator(product) {

    if (!product) {
        console.error('Продукт не передан!');
        return null;
    }

    const sizes = computed(() => product.config?.sizes || []);
    const crusts = computed(() => product.config?.crusts || []);
    const addons = computed(() => product.config?.addons || []);

    const selectedSize = ref(sizes.value[0]?.key || 'small');
    const selectedCrust = ref(crusts.value[0]?.key || 'traditional');
    const selectedAddons = ref([]);

    const sizeMultipliers = computed(() => {
        const multipliers = {};
        for (const size of sizes.value) {
            multipliers[size.key] = size.multiplier || 1;
        }
        return multipliers;
    });

    const currentSize = computed(() =>
        sizes.value.find(size => size.key === selectedSize.value)
    );

    const currentCrust = computed(() =>
        crusts.value.find(crust => crust.key === selectedCrust.value)
    );

    const sizeDescription = computed(() => {
        const size = currentSize.value;
        const crust = currentCrust.value;

        if (!size || !crust) return '';

        return `${crust.label} тесто, ${size.diameter} см, ${size.weight} грамм`;
    });

    const calculatedPrice = computed(() => {
        // базовая цена
        const basePrice = product.price * (sizeMultipliers.value[selectedSize.value] || 1);

        // сумма добавок
        let addonsPrice = 0;
        for (const addonLabel of selectedAddons.value) {
            const addon = addons.value.find(a => a.label === addonLabel);
            if (addon?.price) {
                addonsPrice += addon.price;
            }
        }

        return Math.round(basePrice + addonsPrice);
    });

    const selectSize = (sizeKey) => {
        if (sizes.value.some(s => s.key === sizeKey)) {
            selectedSize.value = sizeKey;
        }
    };

    const selectCrust = (crustKey) => {
        if (crusts.value.some(c => c.key === crustKey)) {
            selectedCrust.value = crustKey;
        }
    };

    const toggleAddon = (addonLabel) => {
        const index = selectedAddons.value.indexOf(addonLabel);
        if (index === -1) {
            if (addons.value.some(a => a.label === addonLabel)) {
                selectedAddons.value.push(addonLabel);
            }
        } else {
            selectedAddons.value.splice(index, 1);
        }
    };

    // конфигурация для корзины
    const getCartConfiguration = () => ({
        pizza_id: product.pizzaId,
        name: product.name,
        description: product.description,
        image: product.image,
        price: calculatedPrice.value,
        size: currentSize.value?.label || '',
        crust: currentCrust.value?.label || '',
        addons: [...selectedAddons.value],
        quantity: 1
    });

    return {
        sizes,
        crusts,
        addons,
        selectedSize,
        selectedCrust,
        selectedAddons,
        currentSize,
        currentCrust,
        sizeDescription,
        calculatedPrice,
        selectSize,
        selectCrust,
        toggleAddon,
        getCartConfiguration
    };
}
