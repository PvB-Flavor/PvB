const registerForm = document.querySelector('.register-form');
const registerProgress = document.querySelector('.register-progress');
const registerSubmit = document.querySelector('.register-submit');
const registerPages = document.querySelector('.register-pages');

function getFullWidth(bool) {
    if (bool) return `
        style="width: 100%;"
    `;

    return '';
}

function getRequired(bool) {
    if (bool) return `required"`;
    return '';
}

const getFieldMarkup = {
    text: function(data) {
        return `
            <div class="register-question" ${ getFullWidth(data.fullwidth) }>
                <p>${ data.label }</p>
                <input ${ getRequired(data.required) } class="${ data.classname }" type="text" placeholder="${ data.placeholder || '' }">
            </div>
        `;
    },

    email: function(data) {
        return `
            <div class="register-question" ${ getFullWidth(data.fullwidth) }>
                <p>${ data.label }</p>
                <input ${ getRequired(data.required) } class="${ data.classname }" type="email" placeholder="${ data.placeholder || '' }">
            </div>
        `;
    },

    choice: function(data) {
        function getChoicesMarkup() {
            let markup = '';

            for (let i = 0; i < data.choices.length; i++) {
                markup += `
                    <div class="register-choice" >
                        <input type="radio" id="${ data.choices[i].id }" name="${ data.choices[i].name }" value="${ data.choices[i].value }" checked>
                        <label for="${ data.choices[i].id }">${ data.choices[i].label }</label>
                    </div>
                `;
            }

            return markup;
        }

        return `
            <div class="register-question">
                <p>${ data.label }</p>
                <div class="${ data.classname }" ${ getRequired(data.required) }>
                    ${ getChoicesMarkup() }
                </div>
            </div>
        `;
    },

    date: function(data) {
        return `
            <div class="register-question" ${ data.fullwidth }>
                <p>${ data.label }</p>
                <input ${ getRequired(data.required) } class="${ data.classname }" type="date">
            </div>
        `;
    },

    number: function(data) {
        return `
            <div class="register-question" ${ data.fullwidth }>
                <p>${ data.label }</p>
                <input ${ getRequired(data.required) } class="${ data.classname }" value="0" type="number">
            </div>
        `;
    }
}

class RegistrationForm {
    constructor() {
        this.formData = FORM_DATA;
        this.pages = [];
        this.currentPage = 0;

        if (this.formData.pages.length < 2) {
            registerProgress.remove();
        } else {
            this.updateProgress();
        }

        this.generateForm();

        registerSubmit.addEventListener('click', () => {
            if (this.currentPage + 1 !== this.pages.length) {
                this.toPage(this.currentPage + 1);
            } else if (this.currentPage + 1 === this.pages.length) {

            }
        })
    }

    generateForm() {
        for (let a = 0; a < this.formData.pages.length; a++) {
            const registerPage = document.createElement('div');
            this.pages[a] = registerPage;

            registerPage.className = 'register-page register-page-' + a;

            if (this.currentPage !== a) registerPage.style.display = 'none';

            for (let b = 0; b < this.formData.pages[a].fields.length; b++) {
                const targetField = this.formData.pages[a].fields[b];

                 registerPage.innerHTML += getFieldMarkup[ targetField.type ](this.formData.pages[a].fields[b]);
            }

            registerPages.appendChild(registerPage);
        }
    }

    toPage(index) {
        for (let i = 0; i < this.pages.length; i++) {
            this.pages[i].style.display = 'none';
        }

        this.currentPage = index;
        this.pages[index].style.display = 'flex';

        if (this.currentPage + 1 === this.pages.length) {
            registerSubmit.innerHTML = 'Verstuur inschrijving';
        } else {
            registerSubmit.innerHTML = 'Volgende stap';
        }

        this.updateProgress();
    }

    updateProgress() {
        function addLine(pageNumber) {
            registerProgress.innerHTML += `
                <div class="line line-${ pageNumber }"></div>
            `;
        }

        function addPoint(pageNumber) {
            registerProgress.innerHTML += `
                <div class="count count-${ pageNumber }">
                    <span>${ pageNumber }</span>
                </div>
            `;
        }

        if (registerProgress.querySelectorAll('.count').length < this.formData.pages.length) {
            registerProgress.innerHTML = '';

            for (let i = 0; i < this.formData.pages.length; i++) {
                addPoint(i + 1);

                if (i + 1 !== this.formData.pages.length) addLine(i + 1);
            }
        }

        for (let i = 0; i < this.formData.pages.length; i++) {
            const point = registerProgress.querySelector('.count-' + (i + 1));

            if (this.currentPage === i) {
                point.style.background = '#6EC5ED';
                point.querySelector('span').style.color = 'white';
            } else {
                point.style.background = 'transparent';
                point.querySelector('span').style.color = '#6EC5ED';
            }
        }
    }


}

window.addEventListener('load', () => {
   new RegistrationForm();
});