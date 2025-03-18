
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
        document.getElementById('medicine_company').value = button.getAttribute(
            'data-medicine-company');
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

// إدارة نموذج تفاصيل الطلب
const orderDetailsButtons = document.querySelectorAll('.open-order-details-modal');
const orderDetailsModal = document.getElementById('order-details-modal');
const closeOrderDetailsModalButton = document.getElementById('close-order-details-modal');
const updateOrderStatusForm = document.getElementById('update-order-status-form');

orderDetailsButtons.forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('order-id').value = button.getAttribute('data-order-id');
        document.getElementById('order-number').value = button.getAttribute('data-order-number');
        document.getElementById('customer-name').value = button.getAttribute('data-customer-name');
        document.getElementById('order-date').value = button.getAttribute('data-order-date');
        document.getElementById('order-status').value = button.getAttribute('data-order-status');
        document.getElementById('new-status').value = button.getAttribute('data-order-status');
        orderDetailsModal.classList.remove('hidden');
    });
});

// إغلاق النموذج عند النقر على زر الإغلاق
closeOrderDetailsModalButton.addEventListener('click', () => {
    orderDetailsModal.classList.add('hidden');
});

// إغلاق النموذج عند النقر خارج النافذة
orderDetailsModal.addEventListener('click', (e) => {
    if (e.target === orderDetailsModal) {
        orderDetailsModal.classList.add('hidden');
    }
});

// تحديث حالة الطلب عبر AJAX
updateOrderStatusForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const orderId = document.getElementById('order-id').value;
    const newStatus = document.getElementById('new-status').value;

    fetch(`/pharmacy/orders/${orderId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content')
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // عرض رسالة نجاح باستخدام SweetAlert
                Swal.fire({
                    title: 'تم التحديث!',
                    text: data.message, // رسالة النجاح
                    icon: 'success',
                    confirmButtonText: 'موافق'
                }).then(() => {
                    location.reload(); // إعادة تحميل الصفحة لتحديث الجدول
                });
            } else {
                // عرض رسالة خطأ باستخدام SweetAlert
                Swal.fire({
                    title: 'خطأ',
                    text: data.message, // رسالة الخطأ
                    icon: 'error',
                    confirmButtonText: 'موافق'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // عرض رسالة خطأ باستخدام SweetAlert
            Swal.fire({
                title: 'حدث خطأ',
                text: 'حدث خطأ أثناء تحديث الحالة',
                icon: 'error',
                confirmButtonText: 'موافق'
            });
        });
});

