import './bootstrap';

function initGestaoScripts() {
    // Formulário de movimentação de estoque existente
    (function () {
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
            const quantity = parseFloat((quantityInput.value || '0').replace(',', '.')) || 0;

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
    })();

    // Formulário de venda com múltiplos itens
    (function () {
        const form = document.getElementById('sale-form');
        if (!form) return;

        const materials = JSON.parse(form.dataset.materials || '[]');
        const itemsBody = document.getElementById('sale-items-body');
        const addItemBtn = document.getElementById('add-sale-item');
        const discountInput = document.getElementById('discount_percent');
        const subtotalDisplay = document.getElementById('sale-subtotal-display');
        const discountDisplay = document.getElementById('sale-discount-display');
        const totalDisplay = document.getElementById('sale-total-display');

        let rowIndex = 0;

        const findMaterial = (id) => materials.find((m) => String(m.id) === String(id));

        function formatMoney(value) {
            return `R$ ${value.toFixed(2).replace('.', ',')}`;
        }

        function recalcTotals() {
            let subtotal = 0;

            itemsBody.querySelectorAll('tr').forEach((row) => {
                const qtyInput = row.querySelector('.sale-item-qty');
                const priceInput = row.querySelector('.sale-item-price');
                const totalCell = row.querySelector('.sale-item-total');

                const qty = parseFloat((qtyInput.value || '0').replace(',', '.')) || 0;
                const price = parseFloat((priceInput.value || '0').replace(',', '.')) || 0;
                const lineTotal = qty * price;

                subtotal += lineTotal;
                totalCell.textContent = formatMoney(lineTotal || 0);
            });

            const discountPercent = parseFloat((discountInput.value || '0').replace(',', '.')) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const total = subtotal - discountAmount;

            subtotalDisplay.textContent = formatMoney(subtotal || 0);
            discountDisplay.textContent = formatMoney(discountAmount || 0);
            totalDisplay.textContent = formatMoney(total || 0);
        }

        function addRow() {
            const row = document.createElement('tr');
            row.className = 'border-b';

            const currentIndex = rowIndex++;

            row.innerHTML = `
                <td class="px-3 py-2">
                    <select name="items[${currentIndex}][material_id]" class="form-select sale-item-material" required>
                        <option value="">Selecione...</option>
                        ${materials.map(m =>
                            `<option value="${m.id}">${m.name} (${m.unit})</option>`
                        ).join('')}
                    </select>
                </td>
                <td class="px-3 py-2 text-right sale-item-stock">-</td>
                <td class="px-3 py-2 text-right">
                    <input type="number" min="0.001" step="0.001"
                           name="items[${currentIndex}][quantity]"
                           class="form-input sale-item-qty" required>
                </td>
                <td class="px-3 py-2 text-right">
                    <input type="number" min="0" step="0.01"
                           name="items[${currentIndex}][unit_price]"
                           class="form-input sale-item-price" required>
                </td>
                <td class="px-3 py-2 text-right sale-item-total">R$ 0,00</td>
                <td class="px-3 py-2 text-center">
                    <button type="button" class="btn-chip btn-chip--danger sale-item-remove">
                        Remover
                    </button>
                </td>
            `;

            itemsBody.appendChild(row);

            const materialSelect = row.querySelector('.sale-item-material');
            const stockCell = row.querySelector('.sale-item-stock');
            const qtyInput = row.querySelector('.sale-item-qty');
            const priceInput = row.querySelector('.sale-item-price');
            const removeBtn = row.querySelector('.sale-item-remove');

            materialSelect.addEventListener('change', () => {
                const material = findMaterial(materialSelect.value);
                if (material) {
                    stockCell.textContent =
                        `${material.current_stock.toFixed(3).replace('.', ',')} ${material.unit}`;

                    if (material.sale_price !== null && !priceInput.value) {
                        // Prefill com preço padrão de venda do material
                        priceInput.value = material.sale_price.toFixed(2);
                    }
                } else {
                    stockCell.textContent = '-';
                }
                recalcTotals();
            });

            qtyInput.addEventListener('input', recalcTotals);
            priceInput.addEventListener('input', recalcTotals);
            removeBtn.addEventListener('click', () => {
                row.remove();
                recalcTotals();
            });

            recalcTotals();
        }

        addItemBtn?.addEventListener('click', addRow);
        discountInput?.addEventListener('input', recalcTotals);

        // Começa com uma linha
        addRow();
    })();
}

// Garante inicialização mesmo quando o script é carregado depois do DOM pronto (AdminLTE)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGestaoScripts);
} else {
    initGestaoScripts();
}
