async function postFormData(route, formData, callBackSuccess = null, callBackError = null, method = 'POST') {
    // Transform method to POST if method is DELETE, PATCH, PUT
    const otherMethod = ['DELETE', 'PATCH', 'PUT'];
    if (otherMethod.includes(method.toUpperCase())) {
        formData.set('_method', method);
        method = 'POST';
    }

    loading().on();
    try {
        const response = await fetch(route, {
            headers: {
                'Accept': 'application/json',
            },
            method,
            body: formData,
        });
        const result = await response.json();
        if (result.success) {
            ToastCustom(result.success);
            callBackSuccess && callBackSuccess(result.data);
        } else throw new Error(JSON.stringify(result));
    } catch (error) {
        const response = JSON.parse(error.message);
        console.log('Error:', response);
        callBackError && callBackError(response.data);
        ToastCustom(response.error || 'Something went wrong', 'error');
    } finally {
        loading().off();
    }
}

function setErrorValidate(fieldsNeedValid, errors = {}) {
    for (const field in fieldsNeedValid) {
        const error = fieldsNeedValid[field].closest('.group').querySelector('.error');
        let errorText = '';
        if (errors[field]) {
            errorText = errors[field][0].replace(/\d+\./g, '')
        }
        error.innerHTML = errorText;
    }
}

function confirmDelete(event) {
    event.preventDefault();
    if (confirm('Are you sure to DELETE this item?')) {
        event.target.submit();
        loading().on();
    }
}

function onChangeSort(target) {
    if (target.value) target.form.submit();
}


// Theme switcher
(() => {
    'use strict'

    const getStoredTheme = () => localStorage.getItem('theme')
    const setStoredTheme = theme => localStorage.setItem('theme', theme)

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme()
        if (storedTheme) {
            return storedTheme
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = theme => {
        if (theme === 'auto') {
            document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme)
        }
    }

    setTheme(getPreferredTheme())

    const showActiveTheme = (theme, focus = false) => {
        const themeSwitcher = document.querySelector('#bd-theme')

        if (!themeSwitcher) {
            return
        }

        const themeSwitcherText = document.querySelector('#bd-theme-text')
        const activeThemeIcon = document.querySelector('.theme-icon-active use')
        const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
        const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

        document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
            element.classList.remove('active')
            element.setAttribute('aria-pressed', 'false')
        })

        btnToActive.classList.add('active')
        btnToActive.setAttribute('aria-pressed', 'true')
        activeThemeIcon.setAttribute('href', svgOfActiveBtn)
        const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
        themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

        if (focus) {
            themeSwitcher.focus()
        }
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedTheme = getStoredTheme()
        if (storedTheme !== 'light' && storedTheme !== 'dark') {
            setTheme(getPreferredTheme())
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme())

        document.querySelectorAll('[data-bs-theme-value]')
            .forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const theme = toggle.getAttribute('data-bs-theme-value')
                    setStoredTheme(theme)
                    setTheme(theme)
                    showActiveTheme(theme, true)
                })
            })
    })
})();