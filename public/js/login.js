let mode = 'login';

const form = document.getElementById('auth-form');
const errorEl = document.getElementById('auth-error');
const toggleBtn = document.getElementById('toggle-mode');
const submitBtn = document.getElementById('submit-btn');
const titleEl = document.getElementById('auth-title');
const repeatGroup = document.getElementById('repeat-group');
const repeatInput = document.getElementById('password-repeat');

toggleBtn.addEventListener('click', () => {
    mode = mode === 'login' ? 'register' : 'login';
    titleEl.textContent = mode === 'login' ? 'Sign in' : 'Create account';
    submitBtn.textContent = mode === 'login' ? 'Sign in' : 'Register';
    toggleBtn.textContent = mode === 'login' ? 'Create account' : 'Back to sign in';
    repeatGroup.hidden = mode === 'login';
    repeatInput.required = mode === 'register';
    errorEl.hidden = true;
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    errorEl.hidden = true;

    const payload = {
        username: document.getElementById('username').value.trim(),
        password: document.getElementById('password').value,
    };

    if (mode === 'register' && payload.password !== repeatInput.value) {
        errorEl.textContent = 'Passwords do not match';
        errorEl.hidden = false;
        return;
    }

    const res = await fetch(`/api/auth/${mode}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
    });
    const json = await res.json().catch(() => ({}));

    if (!res.ok) {
        errorEl.textContent = json.error || 'Something went wrong';
        errorEl.hidden = false;
        return;
    }

    if (mode === 'register') {
        const loginRes = await fetch('/api/auth/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });
        if (!loginRes.ok) { mode = 'login'; toggleBtn.click(); return; }
    }

    window.location.href = '/';
});