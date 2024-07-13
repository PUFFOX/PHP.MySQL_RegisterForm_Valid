document.addEventListener('DOMContentLoaded', function () {
    let inputs = document.querySelectorAll('#registrationForm input');

    inputs.forEach(input =>
    {
        input.addEventListener('keyup', function () {
            validateField(this.id);
        });
    });
});

function validateField(field)
{
    let value = document.getElementById(field).value.trim();
    let errorField = document.getElementById(field + 'Error');
    let isValid = true;
    let errorMessage = "";

    switch (field) {
        case 'login':
            if (value.length < 3 || value.length > 20)
            {
                isValid = false;
                errorMessage = "Username must be between 3 and 20 characters";
            }
            break;
        case 'password':
            if (value.length < 6)
            {
                isValid = false;
                errorMessage = "Password must be at least 6 characters";
            }
            break;
        case 'name':
        case 'surname':
        case 'country':
        case 'city':
            if (!/^[a-zA-Z]+$/.test(value))
            {
                isValid = false;
                errorMessage = "Invalid characters. Only letters allowed";
            }
            break;
        default:
            isValid = true;
    }

    if (!isValid) {
        errorField.textContent = errorMessage;
    } else {
        errorField.textContent = "";
    }

    validateForm();
}

function validateForm()
{
    let login = document.getElementById('login').value.trim();
    let password = document.getElementById('password').value.trim();
    let name = document.getElementById('name').value.trim();
    let surname = document.getElementById('surname').value.trim();
    let country = document.getElementById('country').value.trim();
    let city = document.getElementById('city').value.trim();

    let isFormValid = login.length >= 3 && login.length <= 20 &&
        password.length >= 6 &&
        /^[a-zA-Z]+$/.test(name) &&
        /^[a-zA-Z]+$/.test(surname) &&
        /^[a-zA-Z]+$/.test(country) &&
        /^[a-zA-Z]+$/.test(city);

    document.getElementById('submitButton').disabled = !isFormValid;
}