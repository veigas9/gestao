import './bootstrap';

/**
 * Lógica simples em JavaScript para o formulário de movimentação de estoque.
 * Mostra o estoque atual do material selecionado e calcula o estoque resultante.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('stock-movement-form');
    if (!form) return;

    const materials = JSON.parse(form.dataset.materials || '[]');
    const materialSelect = document.getElementById('material_id');
    const typeSelect = document.getElementById('movement_type');
    const quantityInput = document.getElementById('quantity');
    const currentStockInfo = document.getElementById('current-stock-info');
    const resultingStockInfo = document.getElementById('resulting-stock-info');

    const findMaterial = (id) => materials.find((m) => String(m.id) === String(id));

    function updateInfo() {
        const material = findMaterial(materialSelect.value);
        const type = typeSelect.value;
        const quantity = parseFloat(quantityInput.value.replace(',', '.')) || 0;

        if (!material) {
            currentStockInfo.textContent = '';
            resultingStockInfo.textContent = '';
            return;
        }

        currentStockInfo.textContent =
            `Estoque atual: ${material.current_stock.toFixed(3).replace('.', ',')} ${material.unit}`;

        let resulting = material.current_stock;
        if (quantity > 0) {
            if (type === 'in') {
                resulting += quantity;
            } else {
                resulting -= quantity;
            }
        }

        resultingStockInfo.textContent =
            `Estoque após a movimentação: ${resulting.toFixed(3).replace('.', ',')} ${material.unit}`;
    }

    materialSelect?.addEventListener('change', updateInfo);
    typeSelect?.addEventListener('change', updateInfo);
    quantityInput?.addEventListener('input', updateInfo);

    updateInfo();
});

