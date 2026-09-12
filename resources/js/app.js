const validationMessages = {
    title: 'Informe o título do livro.',
    author: 'Informe o autor do livro.',
    category: 'Informe a categoria do livro.',
    status: 'Selecione o status do livro.',
};

const showFieldFeedback = (field) => {
    const feedback = document.getElementById(`${field.id}-feedback`);

    field.setCustomValidity('');

    if (field.matches('input') && field.value.trim() === '') {
        field.setCustomValidity(validationMessages[field.name]);
    }

    if (!feedback) {
        return field.validity.valid;
    }

    const isValid = field.validity.valid;
    feedback.textContent = isValid ? '' : validationMessages[field.name];
    field.setAttribute('aria-invalid', String(!isValid));

    return isValid;
};

document.querySelectorAll('form[data-validate]').forEach((form) => {
    const fields = [...form.querySelectorAll('input[required], select[required]')];

    fields.forEach((field) => {
        field.addEventListener('input', () => showFieldFeedback(field));
        field.addEventListener('blur', () => showFieldFeedback(field));
    });

    form.addEventListener('submit', (event) => {
        fields.forEach(showFieldFeedback);
        const firstInvalidField = fields.find((field) => !field.validity.valid);

        if (firstInvalidField) {
            event.preventDefault();
            firstInvalidField.focus();
        }
    });
});
