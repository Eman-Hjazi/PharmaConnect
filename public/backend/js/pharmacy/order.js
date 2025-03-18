function updateOrderStatus(selectElement, orderId) {
    const newStatus = selectElement.value;
    const originalStatus = selectElement.getAttribute('data-original-status') || selectElement.options[selectElement.selectedIndex].value;

    fetch(`/pharmacy/orders/${orderId}/update-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(errorData => {
                throw new Error(errorData.message || 'Network response was not ok');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'نجاح',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            selectElement.classList.add('bg-green-100');
            setTimeout(() => selectElement.classList.remove('bg-green-100'), 2000);

            if (newStatus === 'completed' || newStatus === 'canceled') {
                selectElement.disabled = true;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        selectElement.value = originalStatus;
        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: error.message, // عرض رسالة الخطأ من السيرفر
        });
    });

    selectElement.setAttribute('data-original-status', newStatus);
}

// Add responsiveness for mobile
document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('table');
    if (window.innerWidth < 768) {
        table.classList.add('table-responsive');
    }
});

