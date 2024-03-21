const login = document.getElementById('Login');
const logout = document.getElementById('Logout');
const requestbtn = document.querySelectorAll('.requestbtn');
const bloodAddViewbtn = document.getElementById('bloodAddViewbtn');
const forms = document.querySelectorAll('.requestForm');

function getSessionValue() {
       
    fetch('assets/setSession.php')
        .then(response => response.text())
        .then(data => {
            data = JSON.parse(data);
            if('username' in data ){

                login.classList.add('d-none');
                logout.classList.remove('d-none');

                if(data.userType == 'hospital'){
                    bloodAddViewbtn.classList.remove('d-none');
                    requestbtn.forEach(button => {
                        button.disabled = true;
                    });
                }
            }
        })
        .catch(error => {
            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                });
            });
            requestbtn.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.location.href = 'assets/login/login.php';
                });
            });
        });
}

getSessionValue();

function clearSessionData() {
    fetch('../clearSession.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message); 
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}



logout.addEventListener('click',function() {
    login.classList.remove('d-none');
    clearSessionData();
    logout.classList.add('d-none');
    // location.reload(true);
})


