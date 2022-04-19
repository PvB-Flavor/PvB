const registerForm = document.querySelector('.register-form');
const registerProgress = document.querySelector('.register-progress');
const registerSubmit = document.querySelector('.register-submit');

class RegistrationForm {
    constructor() {
        this.formData = FORM_DATA;

        if (this.formData.pages.length < 2) {
            registerProgress.remove();
        } else {
            this.updateProgress();
        }
    }

    updateProgress() {
        function addLine(pageNumber) {

        }

        function addPoint(pageNumber) {
            registerProgress.innerHTML += `
                <div class="count count-${pageNumber}">
                    <span>${ pageNumber }</span>
                </div>
            `;
        }

        if (registerProgress.querySelectorAll('.count').length < this.formData.pages.length) {
            registerProgress.innerHTML = '';

            for (let i = 0; i < this.formData.pages.length; i++) {
                addPoint(i + 1);
                addLine(i + 1);
            }
        }


    }
}

window.addEventListener('load', () => {
   new RegistrationForm();
});