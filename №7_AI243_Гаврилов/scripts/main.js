const form = document.getElementById('subscriptionForm');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');

const nameError = document.getElementById('nameError');
const emailError = document.getElementById('emailError');
const passwordError = document.getElementById('passwordError');
const formStatus = document.getElementById('formStatus');

function setFieldState(input, errorElement, isValid, message) {
  input.classList.remove('valid', 'invalid');
  errorElement.textContent = '';

  if (isValid) {
    input.classList.add('valid');
  } else {
    input.classList.add('invalid');
    errorElement.textContent = message;
  }

  return isValid;
}

function validateName() {
  const value = nameInput.value.trim();

  if (value.length < 2) {
    return setFieldState(nameInput, nameError, false, 'Ім\'я має містити щонайменше 2 символи.');
  }

  const namePattern = /^[A-Za-zА-Яа-яІіЇїЄєҐґ'`\-\s]+$/;
  if (!namePattern.test(value)) {
    return setFieldState(nameInput, nameError, false, 'Ім\'я може містити лише літери, пробіли, апостроф або дефіс.');
  }

  return setFieldState(nameInput, nameError, true, '');
}

function validateEmail() {
  const value = emailInput.value.trim();
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (!emailPattern.test(value)) {
    return setFieldState(emailInput, emailError, false, 'Введіть коректну електронну адресу.');
  }

  return setFieldState(emailInput, emailError, true, '');
}

function validatePassword() {
  const value = passwordInput.value;
  const hasDigit = /\d/.test(value);
  const hasLetter = /[A-Za-zА-Яа-яІіЇїЄєҐґ]/.test(value);

  if (value.length < 8) {
    return setFieldState(passwordInput, passwordError, false, 'Пароль має містити щонайменше 8 символів.');
  }

  if (!hasDigit || !hasLetter) {
    return setFieldState(passwordInput, passwordError, false, 'Пароль має містити хоча б одну літеру та одну цифру.');
  }

  return setFieldState(passwordInput, passwordError, true, '');
}

nameInput.addEventListener('input', validateName);
emailInput.addEventListener('input', validateEmail);
passwordInput.addEventListener('input', validatePassword);

form.addEventListener('submit', function (event) {
  event.preventDefault();

  const nameIsValid = validateName();
  const emailIsValid = validateEmail();
  const passwordIsValid = validatePassword();
  const isFormValid = nameIsValid && emailIsValid && passwordIsValid;

  formStatus.classList.remove('ok', 'bad');

  if (isFormValid) {
    formStatus.classList.add('ok');
    formStatus.textContent = 'Форму успішно перевірено. Підписка оформлена!';
    form.reset();
    [nameInput, emailInput, passwordInput].forEach(function (input) {
      input.classList.remove('valid', 'invalid');
    });
  } else {
    formStatus.classList.add('bad');
    formStatus.textContent = 'Є помилки у формі. Виправте поля, позначені червоним.';
  }
});

