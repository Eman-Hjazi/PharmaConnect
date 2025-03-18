
        // البحث والتصفية
        const searchInput = document.getElementById('searchInput');
        const companyFilter = document.getElementById('companyFilter');
        const grid = document.getElementById('medicinesGrid');
        const cards = grid.getElementsByTagName('div');

        function filterGrid() {
            const searchTerm = searchInput.value.toLowerCase();
            const companyId = companyFilter.value;

            for (let card of cards) {
                const medicineName = card.querySelector('h2').textContent.toLowerCase();
                const rowCompanyId = card.getAttribute('data-company-id');
                const matchesSearch = medicineName.includes(searchTerm);
                const matchesCompany = !companyId || rowCompanyId === companyId;
                card.style.display = matchesSearch && matchesCompany ? '' : 'none';
            }
        }
        searchInput.addEventListener('input', filterGrid);
        companyFilter.addEventListener('change', filterGrid);

        // إدارة نموذج الطلب
        const addNewOrderButtons = document.querySelectorAll('.open-order-modal');
        const addNewOrderModel = document.getElementById('add-new-order');
        const closeModalButton = document.getElementById('close-modal');
        const quantityInput = document.getElementById('quantity');
        const totalPriceInput = document.getElementById('totalPrice');
        let pricePerUnit = 0; // متغير لحفظ السعر للوحدة

        function calculateTotalPrice() {
            const quantity = parseInt(quantityInput.value) || 0;
            const totalPrice = pricePerUnit * quantity;
            totalPriceInput.value = totalPrice.toFixed(2);
        }

        addNewOrderButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('medicine_id').value = button.getAttribute('data-medicine-id');
                document.getElementById('medicine_name').value = button.getAttribute('data-medicine-name');
                document.getElementById('medicine_company').value = button.getAttribute('data-medicine-company');
                pricePerUnit = parseFloat(button.getAttribute('data-medicine-price'));
                document.getElementById('medicine_price').value = pricePerUnit.toFixed(2);
                quantityInput.value = 1;
                calculateTotalPrice();
                addNewOrderModel.classList.remove('hidden');
            });
        });

        // تحديث السعر الإجمالي عند تغيير الكمية
        quantityInput.addEventListener('input', calculateTotalPrice);

        // إغلاق النموذج عند النقر على زر الإغلاق
        closeModalButton.addEventListener('click', () => {
            addNewOrderModel.classList.add('hidden');
        });

        // إغلاق النموذج عند النقر خارج النافذة
        addNewOrderModel.addEventListener('click', (e) => {
            if (e.target === addNewOrderModel) {
                addNewOrderModel.classList.add('hidden');
            }
        });
