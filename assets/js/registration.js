document.addEventListener('DOMContentLoaded', function () {
    var userTypeRadio = document.querySelectorAll('input[name="userType"]');
    var bloodTypeField = document.getElementById('bloodTypeField');

    userTypeRadio.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === 'receiver') {
                bloodTypeField.style.display = 'block';
            } else {
                bloodTypeField.style.display = 'none';
            }
        });
    });
});
