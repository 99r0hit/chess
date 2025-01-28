// Basic form validation (optional)
document.querySelector('form').addEventListener('submit', function (e) {
    const attendance = document.getElementById('attendance').value;
    if (!attendance.includes(',')) {
        alert('Attendance must be comma-separated.');
        e.preventDefault();
    }
});