const adminNotice = document.querySelector('.admin-notice');
const adminNoticeToggle = adminNotice.querySelector('.admin-notice-toggle');
const storedState = window.localStorage.getItem('adminNoticeState');

let currentState = storedState;

console.log(currentState);

function setAdminNoticeState(newState) {
    if (newState === 'open') {
        adminNotice.style.bottom = '';
        adminNoticeToggle.innerHTML = `
            <svg viewBox="0 0 384 512"><path d="M352 352c-8.188 0-16.38-3.125-22.62-9.375L192 205.3l-137.4 137.4c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25C368.4 348.9 360.2 352 352 352z"/></svg>
        `;
    } else {
        console.log('close')
        adminNotice.style.bottom = '-' + (adminNotice.clientHeight - 35) + 'px';
        adminNoticeToggle.innerHTML = `
            <svg viewBox="0 0 384 512"><path d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/></svg>
        `;
    }
}

window.addEventListener('load', () => {
    setAdminNoticeState(currentState);

    adminNoticeToggle.addEventListener('click', () => {
        (currentState === 'open') ? currentState = 'closed' : currentState = 'open';

        window.localStorage.setItem('adminNoticeState', currentState);

        setAdminNoticeState(currentState);
    });
});