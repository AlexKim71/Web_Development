document.addEventListener('DOMContentLoaded', function() {
    const fetchBtn = document.getElementById('fetchBtn');
    const response = document.getElementById('response');

    fetchBtn.addEventListener('click', async function() {
        try {
            const res = await fetch('/api/hello');
            const data = await res.json();
            response.textContent = `✅ ${data.message}`;
        } catch (error) {
            response.textContent = '❌ Помилка при завантаженні!';
            console.error('Error:', error);
        }
    });

    console.log('🎉 Додаток завантажений успішно!');
});

